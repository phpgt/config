<?php
namespace Gt\Config\Test;

use Gt\Config\Config;
use Gt\Config\Test\Helper\Helper;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase {
	public function setUp() {
		Helper::removeTmpDir();
		mkdir(Helper::getTmpDir(), 0775, true);
	}

	public function tearDown() {
		Helper::removeTmpDir();
	}

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
}