<?php
namespace Gt\Config\Test;

use Gt\Config\Config;
use Gt\Config\ConfigSection;
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

	public function testLoadSection() {
		$section = self::createMock(ConfigSection::class);
		$section->method("getName")
			->willReturn("test");
		$section->method("get")
			->willReturn("value123");

		$config = new Config($section);
		self::assertEquals("value123", $config->get("test.example"));
	}

	public function testEnvOverride() {
		putenv("app_namespace=ExampleAppChanged");
		putenv("app_nothing=Something");

		$section = self::createMock(ConfigSection::class);
		$section->method("getName")
			->willReturn("app");
		$section->method("get")
			->willReturn("exampleApp");

		$config = new Config($section);
		self::assertEquals("ExampleAppChanged", $config->get("app.namespace"));
		self::assertEquals("Something", $config->get("app.nothing"));
	}
}