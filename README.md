# Akamai PHP Client

## Install
```php
composer install bluestatedigital/akamai-php-client
```

## Usage
If you already have your credentials on hand:

```php

$curl = new Curl;

$client = new Client($curl, $clientToken, $clientSecret, $accessToken, $baseUrl);
$resp = $client->checkQueueLength();
echo $resp->queueLength;
```

If you want to parse your .edgerc file to get your credentials:

```php

$credentials = new Edgerc('default', '/path/to/my/.edgerc');

// You can now use $credentials->getHost(), $credentials->getClientToken(), $credentials->getClientSecret() and $credentials->getAccessToken().
```


## Supported API methods/actions
- checkQueueLength()
- getPurgeStatus($id)
- purgeRequest($object)


## Akamai Documentation
https://api.ccu.akamai.com/ccu/v2/docs/index.html


## Differences From Original
This fork of the library simply adds a helper function for parsing credentials out of an .edgerc file, which we currently have on our servers already for other reasons.


## Forked With Love
This library was originally developed by [Jeremy Marc](https://github.com/jeremymarc).  Thanks for the sweet, sweet code.  This got us off the ground quickly.
