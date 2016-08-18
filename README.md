# Roundcube VeximAccountAdmin plugin #

## About ##

A RoundCube plugin allowing users to manage non-administrative settings
of Vexim, without the need to login again in its web interface.

Possible future versions will be posted to:
https://github.com/vexim/Roundcube-Plugin-VeximAccountAdmin/

## Install ##

* Place plugin folder into plugins directory of Roundcube
* Enable the plugin by adding it to the Roundcube configuration file 
  Example: 
  
        $rcmail_config['plugins'] = array("veximaccountadmin", "otherplugin")

## Configuration ##

* Copy config.inc.php.dist to config.inc.php in the plugin folder
  It is recommended to keep the dist file.
* You should make sure config.inc.php is not public-readable, as it
  will contain the password to your Vexim database
* Open config.inc.php
* Add your Vexim database info
* Check that the cryptscheme setting is the same as in your Vexim config 
* Check that the Vexim URL is correct if you want to provide a Vexim link
  to admin users

## Credits ##

This plugin was originally written by [Axel Sjøstedt](http://axel.sjostedt.no/), and has since been improved by several contributors on GitHub.
