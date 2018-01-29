<?php
namespace Gt\Config\Test;

use Gt\Config\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase {
	public function testEnvVarNotPresentByDefault() {
		$config = new Config([], "");
		$this->assertNull($config->get("OS"));
	}
}