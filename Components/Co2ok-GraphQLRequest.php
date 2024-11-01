<?php
namespace south_pole_plugin_woocommerce\Components;

Class Co2ok_GraphQLRequest
{
    private $mutationFunctionName;
    private $mutationFunctionParams;
    private $mutationFunctionReturnTypes;

    public $mutationQuery;

    public function __construct()
    {
        $this->mutationQuery = "mutation { ";
    }

    public function setFunctionName($functionName)
    {
        $this->mutationFunctionName = $functionName;
    }

    public function setFunctionParams($functionParams)
    {
        $this->mutationFunctionParams = $functionParams;
    }

    public function setFunctionReturnTypes($functionReturnTypes)
    {
        $this->mutationFunctionReturnTypes = $functionReturnTypes;
    }

    public function ProcessRequest($requestType)
    {
        $this->requestQuery = $requestType . " { ";
        $this->requestQuery .= $this->mutationFunctionName.'(';

        $paramCount = count($this->mutationFunctionParams);
        $paramIndex = 0;
        foreach($this->mutationFunctionParams as $key => $param)
        {
            if(!is_numeric($param))
                $this->requestQuery .= $key.': "'.$param.'"';
            else
                $this->requestQuery .= $key.': '.$param.'';
            $paramIndex++;

            if($paramIndex < $paramCount)
                $this->requestQuery .= ", ";
        }

        $this->requestQuery .= ') { ';

        $returnTypeCount = count($this->mutationFunctionParams);
        $returnTypeIndex = 0;
        foreach($this->mutationFunctionReturnTypes as $key => $param)
        {
            if(is_array($param))
            {
                $returnFunc = preg_replace('/"/', '',  json_encode($param) );
                $returnFunc = preg_replace('/\[/', '{',  $returnFunc );
                $returnFunc = preg_replace('/\]/', '}',  $returnFunc );

                $this->requestQuery .= $key .  $returnFunc;
            }
            else
            {
                $this->requestQuery .= $param;
            }

            $returnTypeIndex++;
            if($returnTypeIndex < $returnTypeCount) {
                $this->requestQuery .= ", ";
            }
        }
        $this->requestQuery .= '}'; //Closes function
        $this->requestQuery .= '}'; // Closes mutation
    }

}