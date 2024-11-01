<?php
namespace south_pole_plugin_woocommerce\Components;

use cbschuld\LogEntries;

class Co2ok_BewustBezorgd {

	private $token;
	private $client;

	function __construct($shop, $shopPostCode, $destPostCode, $shippingMethod, $weight) {
		//constructs shop and destination postcode and shipping method
		$this->shopPostCode = $shopPostCode;
		$this->destPostCode = $destPostCode;
		$this->shippingMethod = $shippingMethod;
		$this->weight = $weight;

		// array that holds id and password to access BB api
		$token = array(
			'id' => $shop['bbApiId'],
			'password' => $shop['bbApiPass']
		);
		$this->token = wp_json_encode( $token );

		//base url for BB requests
		$this->baseUrl = 'https://emission.azurewebsites.net/';
	}

	public function store_order_to_bb_api($orderId) {

		//setup http requests
		$http = _wp_http_get_object();
		//get tokens of store for BB
		$shopBbApiToken = get_option('co2ok_bbApi_token', false);
		$shopBbApiTokenRefresh = get_option('co2ok_bbApi_token_refresh', false);
		$shopBbApiTokenExpire = get_option('co2ok_bbApi_token_expire', false);

		// if shop has token, refresh (if refresh needed) and store new token, else create new token for shop and store
		if ($shopBbApiToken) {
			if($this->checkExpireToken($shopBbApiTokenRefresh, $shopBbApiTokenExpire)) {
				if (!$this->refreshToken($shopBbApiTokenRefresh, $http)) {
					return ;
				}
			}
		} else {
			try {
				$result = $http->post($this->baseUrl . "api/Account/Token", array(
					'headers'     => [
							'Accept' => 'application/json',
							'Content-Type' => 'application/json'
					],
					'body'        => $this->token,
					'data_format' => 'body',
					));

				//if no errors, tokens are retrieved and saved into shop
				$responseToken = json_decode($result['body'], true);
				if (!count($responseToken['errors'])) {
         			add_option('co2ok_bbApi_token', (string)$responseToken['accessToken']);
					add_option('co2ok_bbApi_token_refresh', (string)$responseToken['refreshToken']);
					add_option('co2ok_bbApi_token_expire', (string)$responseToken['expireDateTimeAccesToken']);
					$shopBbApiToken = get_option('co2ok_bbApi_token', false);
				} else {
					\south_pole_plugin_woocommerce\South_Pole_Plugin::remoteLogging(json_encode(["Logging BB Api error response token: " . $responseToken['errors']]));
					return ;
				}
			} catch (RequestException $e) {
				$this->catchException($e);
				return ;
			}
		}

		//check shipping method selected is accepted by BB api, corrects if needed
		$shippingChoice = $this->correctShipping($this->shippingMethod);

		// Q&D PC cleanup -> sometimes postcode does not have letter, this attaches JS if that is the case for shop and destination postcodes
		if (!preg_match("/[a-zA-Z]+$/", substr($this->shopPostCode, -2)))
			$this->shopPostCode .= 'JS';

		if (!preg_match("/[a-zA-Z]+$/", substr($this->destPostCode, -2)))
			$this->destPostCode .= 'JS';

		//create query including all necessary info
		$query = '?FromPostalCode='.$this->shopPostCode;
		$query .= '&FromCountry=NL';
		$query .= '&ToPostalCode='.$this->destPostCode;
		$query .= '&ToCountry=NL';
		$query .= '&Weight='.$this->weight;
		$query .= '&ServiceType='.$shippingChoice;

		//calculate emissions, diesel and gas
		try {
			$result = $http->get($this->baseUrl . 'api/emission-calculation/two-legs' . $query, array(
				'headers'     => [
					'Authorization' => 'Bearer ' . $shopBbApiToken
				],
				'body'        => $this->token,
				'data_format' => 'body',
			));

			$responseTwoLegs = json_decode($result['body'], true);
			if (count($responseTwoLegs['errors'])) {
				$emissionsGrams = $responseTwoLegs['emission'];
				$diesel = $responseTwoLegs['metersDiesel'];
				$gasoline = $responseTwoLegs['metersGasoline'];
				\south_pole_plugin_woocommerce\South_Pole_Plugin::remoteLogging(json_encode(["Logging BB Api two-legs error response: " . $responseTwoLegs['errors'], " Emissions(g): " . $emissionsGrams, "Diesel: " . $diesel . " Gasoline: ".  $gasoline]));
				return ;
			}
		} catch (RequestException $e) {
			$this->catchException($e);
			return ;
		}

		//store the shipment details in the BB api
		try {
			$result = $http->get($this->baseUrl . 'api/emission-calculation/two-legs-checkout' . $query, array(
				'headers'     => [
					'Authorization' => 'Bearer ' . $shopBbApiToken
				],
				'body'        => $this->token,
				'data_format' => 'body',
			));
			if ( ! wp_remote_retrieve_response_code($result) == 204 ) {
				\south_pole_plugin_woocommerce\South_Pole_Plugin::remoteLogging(json_encode(["Logging BB API emissions predictions storing error"]));
				return ;
			}
		} catch (RequestException $e) {
			$this->catchException($e);
			return ;
		}
	}


	//checks if token is expired by date
	public function checkExpireToken($refreshToken, $expireDate) {
		$currentDate = new \DateTime(date('d-m-Y h:i:s a', time()));
		$expire = new \DateTime($expireDate);
		if ($currentDate > $expire) {
			return true;
		}
		return false;
	}


	//refreshes and returns new token to access BB API
	public function refreshToken($refreshAccessToken, $http) {
		try {
			$refreshArray = array(
				'refreshToken' => $refreshAccessToken
			);
			$result = $http->post($this->baseUrl . 'api/Account/Refresh', array(
				'headers'     => [
				'Accept' => 'application/json',
				'Content-Type' => 'application/json'
				],
				'body'        => json_encode($refreshArray),
				'data_format' => 'body',
			));
			$responseRefresh = json_decode($result['body'], true);
			if (count($responseRefresh['errors'])) {
				return false;
			}
		} catch (RequestException $e) {
			$this->catchException($e);
			return false;
		}

		update_option('co2ok_bbApi_token', $responseRefresh['accessToken']);
		update_option('co2ok_bbApi_token_refresh', $responseRefresh['refreshToken']);
		update_option('co2ok_bbApi_token_expire', $responseRefresh['expireDateTimeAccesToken']);

		return true;
	}

	//corrects shipping method if its not accepted by BB API
	public function correctShipping($shipping) {
		$shippingCategory = array (
			'NextDay',
			'SmallTimeframe',
			'MediumTimeframe',
			'EveningDelivery',
			'SameDay',
			'SundayDelivery'
		);
		if (in_array($shipping, $shippingCategory)) {
				return $shipping;
		}
		\south_pole_plugin_woocommerce\South_Pole_Plugin::remoteLogging(json_encode(["Logging BB API shipping method updated to NextDay from " . $shipping]));
		return 'NextDay';
	}

	//catch exception for http requests
	public function catchException($e) {
		$error['error'] = $e->getMessage();
		$error['request'] = $e->getRequest();
		if($e->hasResponse()){
		  $error['response'] = $e->getResponse();
		}
		\south_pole_plugin_woocommerce\South_Pole_Plugin::remoteLogging(json_encode(["Error occurred in BB API request " . $error]));
	}

}
