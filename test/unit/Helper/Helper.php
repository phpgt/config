<?php
namespace Gt\Config\Test\Helper;

class Helper {
	const INI_SIMPLE = <<<INI
[app]
namespace=ExampleApp

[block1]
; This is a comment
value = 123
; Another comment
valueNoSpaces=456
value.nested = 789
value.nested.again = 0123456789
INI;

	public static function getBaseTmpDir() {
		return implode(DIRECTORY_SEPARATOR, [
			sys_get_temp_dir(),
			"phpgt",
			"config"
		]);
	}

	public static function getTmpDir() {
		return implode(DIRECTORY_SEPARATOR, [
			self::getBaseTmpDir(),
			uniqid(),
		]);
	}

	public static function removeTmpDir() {
		self::recursiveRemove(self::getBaseTmpDir());
	}

	public static function recursiveRemove(string $dir) {
		if(!file_exists($dir)) {
			return;
		}

		$scanDir = array_diff(scandir($dir), array('.', '..'));

		foreach($scanDir as $file) {
			if(is_dir("$dir/$file")) {
				self::recursiveRemove("$dir/$file");
			}
			else {
				unlink("$dir/$file");
			}
		}

		rmdir($dir);
	}
}