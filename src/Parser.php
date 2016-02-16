<?php
namespace phpgt\config;

use SplFileInfo as FileInfo;
use IniParser;

class Parser {

private $fileInfo;
private $valueArray = [];

public function __construct(string $filePath) {
	$this->fileInfo = new FileInfo($filePath);
}

public function parse() {
	$ext = $this->fileInfo->getExtension();

	switch ($ext) {
	case Config::TYPE_INI:
		$parser = new IniParser($this->fileInfo->getPathname());
		$this->valueArray = $parser->parse();
		break;

	default:
		throw new ParserException("Unable to parse filetype $ext");
		break;
	}
}

public function getValueArray() {
	return $this->valueArray;
}

}#