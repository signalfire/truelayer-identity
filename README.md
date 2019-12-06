# TrueLayer Identity Package

Allows retrieving identity and address information from banks via FinTech API provided by [TrueLayer](https://truelayer.com/)

## Generate AuthLink

1.  Create an instance of the credentials class passing in the clientId and clientSecret from TrueLayer

```php
$credentials = new Signalfire\TrueIdentity\Credentials($clientId, $clientSecret);
```

2.  Create an instance of AuthLink class passing in $credentials (as above), $redirectUri to send to after authentication, $state opaque value, $enableMock to enable or disable mock bank (and therefore sandbox).

```php
$link = new Signalfire\TrueIdentity\AuthLink($credentials, $redirectUri, $state, $enableMock);
```

3.  Generate the auth link URI

```php
$uri = $link->getAuthLinkUri();
```

4.  Redirect the user to this address

```php
header('location: ....');
```

## Code Exchange Callback Redirect URI

1.  Posted back to the callback redirectUri you provided will a POST payload with a ```code``` param. Other params will include state, scope and error. You should check state matches that passed and there is no error message.

2.  Create a instance of the request class.

```php
$request = new Signalfire\TrueIdentity\Request([
  'base_uri' => 'https://auth.truelayer-sandbox.com',
  'timeout'  => 60,
]);
```

3.  Create an instance of the auth class passing the $request. You will also need a $credentials instance as created earlier.

```php
$auth = new Signalfire\TrueIdentity\Auth($request, $credentials);
```

4.  Call getAccessToken($code, $redirect). You will need to pass the $code posted value just obtained and the $redirect param matching the $redirectUri used when creating the auth link earlier. An array containing an access_token as a child of the body parent will be returned.

5. Create a new instance of the request class.

```php
$request = new Signalfire\TrueIdentity\Request([
  'base_uri' => 'https://api.truelayer-sandbox.com',
  'timeout'  => 60,
]);
```

6.  Create an instance of the Info class, passing in the new $request and earlier obtained access_token $token arguments

```php
$info = new Signalfire\TrueIdentity\Info($request, $token);
```

7.  Call the getInfo() method on $info

```php
$info->getInfo();
```

8.  User information will be returned in an array similar to that below...

```php
Array
(
    [statusCode] => 200
    [reason] => OK
    [body] => Array
        (
            [results] => Array
                (
                    [0] => Array
                        (
                            [update_timestamp] => 2019-11-29T12:48:53.3016968Z
                            [full_name] => John Doe
                            [addresses] => Array
                                (
                                    [0] => Array
                                        (
                                            [address] => 1 Market Street
                                            [city] => San Francisco
                                            [zip] => 94103
                                            [country] => USA
                                        )

                                )

                            [emails] => Array
                                (
                                    [0] => john@doe.com
                                )

                            [phones] => Array
                                (
                                    [0] => 02079460581
                                    [1] => +14151234567
                                )

                        )

                )

            [status] => Succeeded
        )
)
```
