# Load configuration from ini files or environment variables.

Manage your project configuration by defining defaults, which are overridden by ini files, which are overridden by and exposed as environment variables.

Documentation: https://php.gt/docs/config

***

<a href="https://circleci.com/gh/PhpGt/Config" target="_blank">
	<img src="https://badge.status.php.gt/config-build.svg" alt="Build status" />
</a>
<a href="https://scrutinizer-ci.com/g/PhpGt/Config" target="_blank">
	<img src="https://badge.status.php.gt/config-quality.svg" alt="Code quality" />
</a>
<a href="https://scrutinizer-ci.com/g/PhpGt/Config" target="_blank">
	<img src="https://badge.status.php.gt/config-coverage.svg" alt="Code coverage" />
</a>
<a href="https://packagist.org/packages/PhpGt/Config" target="_blank">
	<img src="https://badge.status.php.gt/config-version.svg" alt="Current version" />
</a>
<a href="http://www.php.gt/config" target="_blank">
	<img src="https://badge.status.php.gt/config-docs.svg" alt="PHP.Gt/Config documentation" />
</a>

## Example usage:

nginx.conf:

```
location ~ \.php$ {
	fastcgi_pass	unix:/var/run/php/php7.0-fpm.sock;
	fastcgi_param	database_password	super-secret-passw0rd;
	include		fastcgi_params;
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
$config = new Config("/path/to/project");

// Note that the database password is overriden in the environment (from nginx).
echo $config->get("database.host");		// db.example.com
echo $config->get("database.port");		// 6612
echo $config->get("database.password");		// super-secret-passw0rd
```

## Features at a glance

TODO: List out features, such as parsing abilities.
