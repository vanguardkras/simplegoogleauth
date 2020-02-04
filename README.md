## Description
Small package to easily generate google auth link and retrieve users' information (email, name, etc.).

### Installation
#### Composer
For automatic installation using composer input in your terminal:
```
composer require vanguardkras/simplegoogleauth
```

Don't forget to include autoloader to your application:
```php
require __DIR__ . '/vendor/autoload.php';
```

#### Manual
You can also download the package directly and include a file to your script.
```php
require_once './simplegoogleauth/src/SimpleGoogleAuth.php';
```

Also, you need to install Google API PHP client.
Follow the instructions here:

[https://github.com/googleapis/google-api-php-client](https://github.com/googleapis/google-api-php-client)

### Usage

#### Configuration
At first you need to create authorization credentials. Follow google instruction here:

[Create Authorization credentials](https://github.com/googleapis/google-api-php-client/blob/master/docs/oauth-web.md#create-authorization-credentials)

Then download client_secret_*.json.

#### Code

Create new SimpleGoogleAuth instance and input path to the json config file from the previous step:
```php
use Vanguardkras\SimpleGoogleAuth;

$google = new SimpleGoogleAuth('client_secret.json');
```
---
Use ``` $google->getUrl() ``` anywhere in your code to insert google_auth link. For example:
```php
echo '<a href="' . $google->getUrl() . '">Google Login</a>';
```
On your redirect URI page use the next function:
```php
$data = $google->getProfileInfo();
```

It will return you a class with user info as it's properties.

---

In case you want to receive an array use ``` false ``` for ``` $object ``` parameter:
```php
$data = $google->getProfileInfo(false);
```

---

Now you can use the received data for your application authorization and registration logic.