<?php
namespace Gt\Config\Test;

use Gt\Config\ConfigSection;
use Gt\Config\ImmutableObjectMutationException;
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

	public function testOffsetGet():void {
		$section = new ConfigSection(self::DATA["app"]);

		foreach(self::DATA["app"] as $key => $value) {
			self::assertArrayHasKey($key, $section);
			self::assertEquals($value, $section[$key]);
		}
	}

	public function testOffsetSet():void {
		self::expectException(ImmutableObjectMutationException::class);
		$section = new ConfigSection(self::DATA);
		$section["example"] = "something";
	}

	public function testOffsetUnset():void {
		self::expectException(ImmutableObjectMutationException::class);
		$section = new ConfigSection(self::DATA);
		unset($section["example"]);
	}
}