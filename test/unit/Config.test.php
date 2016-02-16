<?php
namespace phpgt\config;

class ConfigTest extends \PHPUnit_Framework_TestCase {

private $tmp;

public function setUp() {
	test\Helper::setUpTmpDir();

	$dir = test\Helper::getTmpDir();
	$this->tmp = $dir;
}

public function tearDown() {
	test\Helper::removeTmpDir();
}

public function testIniWithPath() {
	$this->filePath = test\Helper::createConfigFile(
		$this->tmp, Config::TYPE_INI);
	$baseName = pathinfo($this->filePath, PATHINFO_BASENAME);

	$this->assertEmpty(getenv("another_key"));
	$config = new Config(false, $baseName, $this->tmp);

	$this->assertEquals("another value", getenv("another_key"));
}

}#