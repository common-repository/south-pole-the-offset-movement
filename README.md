[![Build Status](https://travis-ci.org/Mil0dV/co2ok-plugin-woocommerce.svg?branch=master)](https://travis-ci.org/Mil0dV/co2ok-plugin-woocommerce)

# WooCommerce Plugin for CO2ok

A WooCommerce plugin to integrate CO2ok

## Installation

Some prose detailing installation

NB: Docker: if MySQL isn't working properly, this should fix it:

chmod 400 db-conf/local.cnf

Also, to upload themes:

(it could be these are needed:

@ini_set( 'upload_max_size' , '30M' );
@ini_set( 'post_max_size', '30M');

in wp-config.php)

### Gulp & scss

#### Currently, this is out out of date. To alter styling, alter .css file directly.

To power up the development process we decided to use gulp for our task
which is currently just converting SCSS to css and minify it.

How to start with gulp and SCSS

SCSS is something on it's own, it's quite close to how css but on steroids
You can more learn about scss [here](https://sass-lang.com/).

To get Gulp working you follow the following steps:

1. Have Node.js and NPM installed on your OS.
2. Open your Terminal
3. Navigate into the plugin directory.
4. run `npm install gulp -g` to install Gulp globally.
5. Run `npm install` in the root folder.
6. after all packages are installed run `gulp`
7. Gulp should be starting now and automatic converting SCSS to css every time a `.scss` file is changed

- if you run into problems/errors with step 4. or 5. on Windows, these might be possible solutions (still in the root directory):
1. run `npm install --global --production windows-build-tools`
2. run `npm install -g which`
3. run `which node`
4. run `npm install node-gyp@latest`


### Docker, WordPress and WooCommerce
If desired, install Docker Desktop. Else/then clone the repo and, from repo directory, run:
```
docker-compose up
```

Open repo in browser from Docker Dashboard and follow the instructions to setup a WordPress page. Or, if you are not using Docker Dashboard, open browser and go to localhost:8080

Next, WooCommerce must be added: search, download, and activate WooCommerce in Plugin by selecting add new from the plugin menu and searching for WooCommerce.

Once WooCommerce is activated, follow the steps to setup a store. The most important information during set up is setting the country of the shop to Netherlands. On the follow page, select any industry and product. On Tell us about your business: select you are selling 1-10 products.
At Enhace your store with Jetpack and WooCommerce Services, select Yes Please. Once initial setup is complete, continue the Jetpack/WooCommerce menu and add a product. The product can say or be anything, but it must have a price in order to add it to basket.

Next, add and activate co2ok plugin. To test, add the product you made to your cart and go to checkout. The co2ok plugin should be visible on these pages.

If you see this: 
```
 mysqld: [Warning] World-writable config file '/etc/mysql/conf.d/local.cnf' is ignored.
```
run (not in the docker container)
```
chmod 644 db-conf/local.cnf
```


### Testing changes to plugin on co2ok test server
To test plugin in test server ask Milo for credentials for access to wc-test.co2ok.eco. Once you have access, first deactivate and delete plugin from Plugins in WordPress.
Create a zip of the plugin by running the following command in the repo directory on the branch you want to test:
```
zip -x db/\* node_modules/\* .git/\* @ -r co2ok-plugin-woocommerce.zip *
```
In Wordpress, select Add New in plugin menu and select Upload Plugin at top of page. Upload .zip file just created and activate. Now plugin will be active for
testing.

### .po & .mo files for languages

To get a .mo file you can use for languages, you need to convert a .po file to .mo,
either using 'msgfmt' if provided by your OS, like so: 
```
msgfmt languages/co2ok-for-woocommerce-nl_NL.po  -o languages/co2ok-for-woocommerce-nl_NL.mo
msgfmt languages/co2ok-for-woocommerce-de_DE.po -o languages/co2ok-for-woocommerce-de_DE.mo
```
Or go to the following website, upload your .po file and press convert:
https://po2mo.net/

## Contributing

 1. **Fork** the repo on GitHub
 2. **Clone** the project to your own machine
 3. **Commit** changes to your own branch
 4. **Push** your work back up to your fork
 5. Submit a **Pull request** so that we can review your changes

### Branches will have the following structure

  **{Fix/Feature}/{What-your-doing}**

### Commit messages

  Commit messages will need be written in present tense like this:

  ❌ "Fix error messages"

  And not like this:

  ✅ "Fixed error messages"

## License

This Plugin is licensed under the GPL v2 or later.

> This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

> This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

> You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA

A copy of the license is included in the root of the plugin’s directory. The file is named `LICENSE`.
