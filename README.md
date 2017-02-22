# Load configuration from ini files or environment variables.

Manage your project configuration by defining defaults, which are overridden by ini files, which are overridden by and exposed as environment variables.

Documentation: https://php.gt/docs/config

***

<a href="https://circleci.com/gh/phpgt/config" target="_blank">
    <img src="https://img.shields.io/circleci/project/phpgt/config.svg?style=flat-square" alt="Build status" />
</a>
<a href="https://scrutinizer-ci.com/g/phpgt/config" target="_blank">
    <img src="https://img.shields.io/scrutinizer/g/phpgt/config.svg?style=flat-square" alt="Code quality" />
</a>
<a href="https://scrutinizer-ci.com/g/phpgt/config" target="_blank">
    <img src="https://img.shields.io/scrutinizer/coverage/g/phpgt/config.svg?style=flat-square" alt="Code coverage" />
</a>

## Example usage:

nginx.conf:

```
location ~ \.php$ {
	fastcgi_pass	unix:/var/run/php/php7.0-fpm.sock;
	fastcgi_param	database_password		super-secret-passw0rd;
	include			fastcgi_params;
}

```

config.ini:

```ini
[app]
namespace = MyApp
debug = true
logging = verbose

[database]
host = db.example.com
schema = local_shop
username = admin
password = admin_pass

[shopapi]
key = jungfnyyguvffubhgvat
secret = guvfvfnybpnyfubcgurerfabguvatsbelbhurer
```

example.php:

```php
// Load config.ini
$config = new Config("config.ini", [
	"database" => [
		"host" => "localhost",
		"port" => 6612
	]
]);

echo $config["database"]->host;		// db.example.com
echo $config["database"]->port;		// 6612
echo $config["database"]->password;	// super-secret-passw0rd
```

## Features at a glance

TODO: List out features, such as parsing abilities.
