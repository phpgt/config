<?php
namespace Gt\Config\Test;

use Gt\Config\Config;
use Gt\Config\Test\Helper\Helper;

class ConfigTest extends TestCase {
	public function testNotPresentByDefault() {
		$config = new Config();
		$this->assertNull($config->get(uniqid()));
	}

	public function testEnvVarPresentWithEnv() {
		putenv("my-env-var=example");

		$config = new Config();
		$this->assertNotNull($config->get("my-env-var"));
	}

	public function testGet() {
		$key = uniqid();
		$value = uniqid();
		putenv("$key=$value");

		$config = new Config();
		self::assertEquals($value, $config->get($key));
	}

	public function testLoadFromIni() {
		$filePath = implode(DIRECTORY_SEPARATOR, [
			$this->tmp,
			"config.ini",
		]);
		file_put_contents($filePath, Helper::INI_SIMPLE);
		$config = new Config($this->tmp);
		self::assertEquals("ExampleApp", $config->get("app.namespace"));
		self::assertNull($config->get("app.nothing"));
		self::assertNull($config->get("app"));
	}

	public function testLoadWithDefaults() {
		$filePath = implode(DIRECTORY_SEPARATOR, [
			$this->tmp,
			"config.ini",
		]);
		file_put_contents($filePath, Helper::INI_SIMPLE);

		$filePathDefault = implode(DIRECTORY_SEPARATOR, [
			$this->tmp,
			"config.default.ini",
		]);
		file_put_contents($filePathDefault, Helper::INI_DEFAULT);

		$config = new Config($this->tmp);
		$config->mergeDefaults();

		self::assertEquals("ExampleApp", $config->get("app.namespace"));
		self::assertEquals("789", $config->get("block1.value.nested"));
		self::assertEquals("this appears by default", $config->get("block1.value.existsByDefault"));
	}

	public function testEnvOverride() {
		putenv("app_namespace=ExampleAppChanged");
		putenv("app_nothing=Something");

		$filePath = implode(DIRECTORY_SEPARATOR, [
			$this->tmp,
			"config.ini",
		]);
		file_put_contents($filePath, Helper::INI_SIMPLE);
		$config = new Config($this->tmp);
		self::assertEquals("ExampleAppChanged", $config->get("app.namespace"));
		self::assertEquals("Something", $config->get("app.nothing"));
	}

	public function testFileOverride() {
		$filePath = implode(DIRECTORY_SEPARATOR, [
			$this->tmp,
			"config.ini",
		]);
		file_put_contents($filePath, Helper::INI_SIMPLE);
		$filePathDev = implode(DIRECTORY_SEPARATOR, [
			$this->tmp,
			"config.dev.ini",
		]);
		file_put_contents($filePathDev, Helper::INI_OVERRIDE_DEV);
		$filePathProd = implode(DIRECTORY_SEPARATOR, [
			$this->tmp,
			"config.production.ini",
		]);
		file_put_contents($filePathProd, Helper::INI_OVERRIDE_PROD);

		$config = new Config($this->tmp);
		$config->loadOverrides();
		self::assertEquals("dev789override", $config->get("block1.value.nested"));
		self::assertEquals("my.production.database", $config->get("database.host"));
		self::assertEquals("secret-key-only-on-production", $config->get("exampleapi.key"));
		self::assertEquals("example", $config->get("database.schema"));
	}
}