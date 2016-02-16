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

public function testIni() {
	$this->filePath = test\Helper::createConfigFile(
		$this->tmp, Config::TYPE_INI);
	$baseName = pathinfo($this->filePath, PATHINFO_BASENAME);

	$this->assertEmpty(getenv("key"));
	$this->assertEmpty(getenv("another_key"));
	$config = new Config(false, $baseName, $this->tmp);

	$this->assertEquals("value", getenv("key"));
	$this->assertEquals("another value", getenv("another_key"));
}

public function testPrefix() {
	$this->filePath = test\Helper::createConfigFile(
		$this->tmp, Config::TYPE_INI);
	$baseName = pathinfo($this->filePath, PATHINFO_BASENAME);

	$config = new Config(false, $baseName, $this->tmp);
	$config->setPrefix("testprefix");

	$this->assertEquals("value", getenv("testprefix.key"));
	$this->assertEquals("another value", getenv("testprefix.another_key"));

	// Have the non-prefixed keys been removed?
	$this->assertEmpty(getenv("key"));
	$this->assertEmpty(getenv("another_key"));
}

public function testSeparator() {
	$this->filePath = test\Helper::createConfigFile(
		$this->tmp, Config::TYPE_INI);
	$baseName = pathinfo($this->filePath, PATHINFO_BASENAME);

	$config = new Config(false, $baseName, $this->tmp);
	$config->setPrefix("testprefix");
	$config->setSeparator(":");

	$this->assertEquals("value", getenv("testprefix:key"));
	$this->assertEquals("another value", getenv("testprefix:another_key"));

	$config->setSeparator("/");
	$this->assertEquals("value", getenv("testprefix/key"));
	$this->assertEquals("another value", getenv("testprefix/another_key"));

	$config->setSeparator("__");
	$this->assertEquals("value", getenv("testprefix__key"));
	$this->assertEquals("another value", getenv("testprefix__another_key"));

	// Have the non-prefixed keys been removed?
	$this->assertEmpty(getenv("key"));
	$this->assertEmpty(getenv("another_key"));
	$this->assertEmpty(getenv("testprefix.key"));
	$this->assertEmpty(getenv("testprefix.another_key"));
	$this->assertEmpty(getenv("testprefix:key"));
	$this->assertEmpty(getenv("testprefix:another_key"));
}

}#