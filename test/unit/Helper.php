<?php
namespace phpgt\config\test;

use phpgt\config\Config;

class Helper {

const TMP_DIR_PREFIX = "phpgt-config-dir-";

const EXAMPLE_INI = <<<ini
key = value
another_key = another value

[section_name]
a_sub_key = yet another value
ini;

private static $tmp;
private static $tmpDirParts;

public static function setUpTmpDir($nesting = 5) {
	self::$tmp = sys_get_temp_dir();
	self::$tmpDirParts = [];

	for($i = 0; $i < $nesting; $i++) {
		self::$tmpDirParts []= uniqid(self::TMP_DIR_PREFIX);
	}

	mkdir(self::getTmpDir(), 0775, true);
}

public static function removeTmpDir() {
	$cmd = "rm -rf " . self::$tmp . "/" . self::TMP_DIR_PREFIX . "*";
	exec($cmd);
}

public static function getTmpDir($level = null) {
	if(is_null($level)) {
		$level = count(self::$tmpDirParts);
	}

	$dir = [self::$tmp];

	for($i = 0; $i < $level; $i++) {
		$dir []= self::$tmpDirParts[$i];
	}

	return implode(DIRECTORY_SEPARATOR, $dir);
}

public static function createConfigFile($dir, $ext = Config::TYPE_INI) {
	$fileName = uniqid("configFile-");
	$filePath = "$dir/$fileName.$ext";

	file_put_contents($filePath, self::EXAMPLE_INI);
	return $filePath;
}

}#phpinfo()