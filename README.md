ClouDNS API Library
===============================

This is a wrapper library for the ClouDNS API to be used by PHP applications. It tries to ease the integration of the API into your applications by handling all interactions with API and providing a simple interface to interact with.



Installation
-------------------------------
Add this requirement to your `composer.json` file and run `composer.phar install`:

    {
        "require": {
            "tvorwachs/cloudns-api-php": "v0.1.0"
        }
    }

or

run `composer require tvorwachs/cloudns-api-php`

Getting Started
-------------------------------
To begin using the Library, the cloudns.php must be included in your application.

```
use \tvorwachs\ClouDNS;
```

An instance of the ClouDNS must be created to interact with the library. This Object is the gateway to all interactions with the library. The API password obtained from the [ClouDNS](https://www.cloudns.net/api-settings/) must be passed into the ClouDNS by calling set_options.

```php
$cloudns = new ClouDNS();
$cloudns->setOptions(array('authId' => '999','authPassword' => 'some_password'));
```

Functions
-------------------------------

<table width="100%">
	<tr>
		<th valign="top" width="120px" align="left">Function</th>
		<th valign="top" align="left">Description</th>
	</tr>
	<tr>
		<td valign="top"><code>detectIp()</code></td>
		<td valign="top">Determine our IP address</td>
	</tr>
	<tr>
		<td valign="top"><code>listNameServers()</code></td>
		<td valign="top">Get a list with available domain name servers.</td>
	</tr>
	<tr>
		<td valign="top"><code>listZones(page,rows,search[optional])</code></td>
		<td valign="top">Gets a paginated list with zones you have or zone names matching a keyword.</td>
	</tr>
	<tr>
		<td valign="top"><code>listZoneStats()</code></td>
		<td valign="top">Gets the number of the zones you have and the zone limit of your customer plan. Reverse zones are included.</td>
	</tr>
	<tr>
		<td valign="top"><code>deleteDomainZone(domain)</code></td>
		<td valign="top">This function is available only for slave zones, master zones and cloud/bulk domains. Works with reverse zones too.</td>
	</tr>
</table>

Reporting Issues/Contributing
-------------------------------
If you find an issue with the library, please report the issue to us by using the repository's issue tracker and we will try to resolve the issue. If you resolve the issue or make other improvements feel free to create a pull request so we can merge it into a future release.