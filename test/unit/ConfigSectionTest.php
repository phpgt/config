<?php
namespace Gt\Config\Test;

use Gt\Config\ConfigSection;
use PHPUnit\Framework\TestCase;

class ConfigSectionTest extends TestCase {
	const DATA = [
		"app" => [
			"namespace" => "ExampleApp",
		],
		"database" => [
			"host" => "localhost",
			"schema" => "example",
			"port" => "3306",
		],
	];

	public function testIterator():void {
		$section = new ConfigSection(self::DATA);

		foreach($section as $key => $value) {
			self::assertArrayHasKey($key, self::DATA);
			self::assertEquals($value, self::DATA[$key]);
		}
	}

	public function testOffsetExists():void {
		$section = new ConfigSection(self::DATA);

		foreach(self::DATA as $key => $value) {
			self::assertArrayHasKey($key, $section);
		}
	}

	public function testOffsetNotExists():void {
		$section = new ConfigSection(self::DATA);
		for($i = 0; $i < 10; $i++) {
			self::assertArrayNotHasKey(uniqid(), $section);
		}
	}
}