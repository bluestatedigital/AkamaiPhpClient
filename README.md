# Akamai PHP Client

## Install
```php
composer install bluestatedigital/akamai-php-client
```

## Usage
```php

$curl = new Curl;

$client = new Client($curl, $clientToken, $clientSecret, $accessToken, $baseUrl);
$resp = $client->checkQueueLength();
echo $resp->queueLength;
```

## Supported methods
- checkQueueLength()
- getPurgeStatus($id)
- purgeRequest($object)


## Akamai Documentation
https://api.ccu.akamai.com/ccu/v2/docs/index.html


## Differences From Original
This fork of the library simply adds a helper function for parsing credentials out of an .edgerc file, which we currently have on our servers already for other reasons.


## Forked With Love
This library was originally developed by [Jeremy Marc](https://github.com/jeremymarc).  Thanks for the sweet, sweet code.  This got us off the ground quickly.
