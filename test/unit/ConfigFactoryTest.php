<?php
namespace Gt\Config\Test;

use Gt\Config\ConfigFactory;
use Gt\Config\Test\Helper\Helper;

class ConfigFactoryTest extends TestCase {
	public function testCreateForProject():void {
		$filePath = implode(DIRECTORY_SEPARATOR, [
			$this->tmp,
			"config.ini",
		]);
		$filePathDefault = implode(DIRECTORY_SEPARATOR, [
			$this->tmp,
			"config.default.ini",
		]);
		$filePathDev = implode(DIRECTORY_SEPARATOR, [
			$this->tmp,
			"config.dev.ini",
		]);
		$filePathProduction = implode(DIRECTORY_SEPARATOR, [
			$this->tmp,
			"config.production.ini",
		]);

		file_put_contents($filePathDefault, Helper::INI_DEFAULT);
		file_put_contents($filePath, Helper::INI_SIMPLE);
		file_put_contents($filePathDev, Helper::INI_OVERRIDE_DEV);
		file_put_contents($filePathProduction, Helper::INI_OVERRIDE_PROD);

		$config = ConfigFactory::createForProject($this->tmp);
	}

	public function testCreateFromPathName():void {
		$filePath = implode(DIRECTORY_SEPARATOR, [
			$this->tmp,
			"config.ini",
		]);

		file_put_contents($filePath, Helper::INI_SIMPLE);

		$config = ConfigFactory::createFromPathName($filePath);

		$sectionNames = $config->getSectionNames();
		self::assertContains("app", $sectionNames);
		self::assertContains("block1", $sectionNames);
		self::assertContains("database", $sectionNames);
		self::assertNotContains("extra", $sectionNames);
	}
}