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
		$config = new Config([], "");
		$this->assertNull($config->get("OS"));
	}

	public function testEnvVarPresentWithEnv() {
		$config = new Config($_ENV, "");
		$this->assertNotNull($config->get("OS"));
	}
}