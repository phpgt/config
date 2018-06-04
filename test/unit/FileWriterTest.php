<?php
namespace Gt\Config\Test;

use Gt\Config\Config;
use Gt\Config\ConfigSection;
use Gt\Config\FileWriter;
use Gt\Config\Test\Helper\Helper;

class FileWriterTest extends TestCase {
	public function testWrite():void {
		$section = self::createMock(ConfigSection::class);
		$section->method("current")
			->willReturnOnConsecutiveCalls(
				"oneValue",
				"twoValue",
				"threeValue"
		);
		$config = self::createMock(Config::class);
		$config->method("getSectionNames")
			->willReturn(["one", "two", "three"]);
		$config->method("getSection")
			->willReturn($section);

		$writer = new FileWriter($config);
		$tmpFilePath = Helper::getTmpDir("output.ini");
		$writer->writeIni($tmpFilePath);
		var_dump($section->current());
		var_dump($section->current());
		var_dump($section->current());
	}
}