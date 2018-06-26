Cagoi screenshots v1.0
=================

Library for an easy screenshots making


Quick structure description
---------------------------

### "Root directory"

**Cagoi\Screenshots\Client** 			- this class manages all process;

**Cagoi\Screenshots\ImageCreator** 		- helps create images by response from server;

**Cagoi\Screenshots\Exception** 		- library exception;

### "Adapter" directory

In this directory you can find predefined adapters. Now available adapter for MongoDb, but you can define new adapter
for your own purposes. 

It needs for handle such operations:
- Make screenshot;
- Get screenshot;
- Callback processing.
	
### "Logger" directory
Classes for log work process. You can define new logger for your own purposes. Cagoi\Screenshots\Logger\FileLogger - log in file
	
### "Params" directory
Classes in this directory helps prepare request parameters:

**Cagoi\Screenshots\Params\GetParams** - helps with parameters for get screenshot request

**Cagoi\Screenshots\Params\MakeParams** - helps with parameters for make screenshot request

	
Usage
-----------

```php
// Add script that will manage callback from server
$client = new Cagoi\Screenshots\Client('http://server.com', 'clientKey');
$adapter = new Cagoi\Screenshots\MongoAdapter();
$client->onCallback($_POST, $adapter);
```

```php
// Make full page screenshot
$client = new Cagoi\Screenshots\Client('http://server.com', 'clientKey');
$adapter = new Cagoi\Screenshots\Adapter\MongoAdapter();
$params = new Cagoi\Screenshots\Params\MakeParams('https://google.com');
// Callback url setter
$params->setCallback("http://my.site.com/callback");
$creator = Cagoi\Screenshots\ImageCreator();
$creator->add('full', '<path to save>', '<filename>');
// Send the task
$client->makeScreenshot($params, $adapter, $creator);
```

```php
// Make dom element screenshot
$client = new Cagoi\Screenshots\Client('http://server.com', 'clientKey');
$adapter = new Cagoi\Screenshots\Adapter\MongoAdapter();
$params = new Cagoi\Screenshots\Params\MakeParams('https://google.com');
// Callback url setter
$params->setCallback("http://my.site.com/callback");
// Element id setter
$params->setElementId("<element id>");
// Saver for ready files
$creator = Cagoi\Screenshots\ImageCreator();
$creator->add('full', '<path to save>', '<filename>');
// Send the task
$client->makeScreenshot($params, $adapter, $creator);
```

```php
// Make dom element screenshot with delay and scales
$client = new Cagoi\Screenshots\Client('http://server.com', 'clientKey');
$adapter = new Cagoi\Screenshots\Adapter\AdapterMongo();
		
$params = new Cagoi\Screenshots\Params\MakeParams('https://google.com');
// Callback url setter
$params->setCallback("http://my.site.com/callback");
// Element id setter
$params->setElementId("<element id>");
// Delay in milliseconds
$params->setDelay(1000);
// Set scale width = 300px, height = 0 (auto scale)
$params->addWidthScale(300);
// Set scale width = 0 (auto scale), height = 300px
$params->addHeightScale(300);
// Set scale width = 300px, height = 300px
$params->addScale(300, 300);
// Set scale width = 300px, height = 900px + turn 'smart' resizing on (last parameter)
$paramsObj->addScale(300, 900, true);

$creator = Cagoi\Screenshots\ImageCreator();
// Create full image
$creator->add('full', '<path to save>', '<filename>');
// Create image with width = 300px, height = 0 (auto scale)
$creator->add('300x0', '<path to save>', '<filename>');
// Create image with width = 0 (auto scale), height = 300px
$creator->add('0x300', '<path to save>', '<filename>');
// Create image with width = 300px, height = 300px
$creator->add('300x300', '<path to save>', '<filename>');
// Create image with width = 300px, height = 900px + 'smart' resizing turned on
$imageCreatorObj->add('smartx300x900', $params['filePath'], '<filename>');
// Send the task
$client->makeScreenshot($params, $adapter, $creator);
```

```php
// Logger usage
$client = new Cagoi\Screenshots\Client('http://server.com', 'clientKey');
$client->setLogger(new Cagoi\Screenshots\Logger\FileLogger("<path to logs directory>"));
...
```
