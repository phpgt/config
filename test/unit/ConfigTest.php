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

	public function testEnvVarNotPresentByDefault() {
		$config = new Config();
		$this->assertNull($config->get("OS"));
	}

	public function testEnvVarPresentWithEnv() {
		$config = new Config($_ENV);
		$this->assertNotNull($config->get("OS"));
	}

	public function testGet() {
		$key = uniqid();
		$value = uniqid();
		$config = new Config([$key => $value]);
		self::assertEquals($value, $config->get($key));
	}

	public function testGetCaseInsensitive() {
		$key = "aAaAaAaA";
		$value = 12345;
		$config = new Config([$key => $value]);
		self::assertEquals($value, $config->get(strtolower($key)));
	}
}