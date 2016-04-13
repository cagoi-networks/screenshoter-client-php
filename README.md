Cagoi screenshots
=================

Library for easy screenshots making


Quick structure description
---------------------------

Client 			- this class manages all process;

ImageCreator 	- helps create images by response from server;

Exception 		- library exception;

"Adapter" directory

In this directory you can find predefined adapters.
Now available adapter for MongoDb, but you can define new adapter for your own purposes.
It needs for handle such operations:
- Make screenshot;
- Get screenshot;
- Callback processing.
	
"Logger" directory

Classes for log work process
You can define new logger for your own purposes.
Cagoi\Screenshots\Logger\FileLogger - log in file
	
"Params" directory

Classes in this directory helps prepare request parameters
Cagoi\Screenshots\Params\GetParams - helps with parameters for get screenshot request
Cagoi\Screenshots\Params\MakeParams - helps with parameters for make screenshot request

	
Quick start
-----------

Add script that will manage callback from server
------------------------------------------------
Url example: http://my.site.com/callback
Script code:

```php
$client = new Cagoi\Screenshots\Client('http://server.com', 'clientKey');
$adapter = new Cagoi\Screenshots\MongoAdapter();
$client->onCallback($_POST, $adapter);
```

Make full page screenshot
-------------------------

```php
$client = new Cagoi\Screenshots\Client('http://server.com', 'clientKey');
$adapter = new Cagoi\Screenshots\Adapter\MongoAdapter();
$params = new Cagoi\Screenshots\Params\MakeParams('https://google.com');
// Callback url setter
$params->setCallback("http://my.site.com/callback");
$creator = Cagoi\Screenshots\ImageCreator();
$creator->add('full', '<path to save>', '<filename>');
$client->makeScreenshot($params, $adapter, $creator);
```
		
Make dom element screenshot
---------------------------

```php
$client = new Cagoi\Screenshots\Client('http://server.com', 'clientKey');
$adapter = new Cagoi\Screenshots\Adapter\MongoAdapter();
$params = new Cagoi\Screenshots\Params\MakeParams('https://google.com');
// Callback url setter
$params->setCallback("http://my.site.com/callback");
// Element id setter
$params->setElementId("<element id>");
$creator = Cagoi\Screenshots\ImageCreator();
$creator->add('full', '<path to save>', '<filename>');
$client->makeScreenshot($params, $adapter, $creator);
```
		
Make dom element screenshot with delay and scales
-------------------------------------------------

```php
$client = new Cagoi\Screenshots\Client('http://server.com', 'clientKey');
$adapter = new Cagoi\Screenshots\Adapter\AdapterMongo();
		
$params = new Cagoi\Screenshots\Params\MakeParams('https://google.com');
// Callback url setter
$params->setCallback("http://my.site.com/callback");
// Element id setter
$params->setElementId("<element id>");
// Delay in milliseconds
$params->setDelay(1000);
// Set scale width = 300px, height = auto scale
$params->addWidthScale(300);
// Set scale width = auto scale, height = 300px
$params->addHeightScale(300);
// Set scale width = 300px, height = 300px
$params->addScale(300, 300);

$creator = Cagoi\Screenshots\ImageCreator();
// Create full image
$creator->add('full', '<path to save>', '<filename>');
// Create image with width = 300px, height = auto scale
$creator->add('300x0', '<path to save>', '<filename>');
// Create image with width = auto scale, height = 300px
$creator->add('0x300', '<path to save>', '<filename>');
// Create image with width = 300px, height = 300px
$creator->add('300x300', '<path to save>', '<filename>');
$client->makeScreenshot($params, $adapter, $creator);
```
	
Logger using
------------

```php
$client = new Cagoi\Screenshots\Client('http://server.com', 'clientKey');
$client->setLogger(new Cagoi\Screenshots\Logger\FileLogger("<path to logs directory>"));
...
```
		

