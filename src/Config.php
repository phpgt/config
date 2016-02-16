<?php
namespace phpgt\config;

use ArrayObject;

class Config {

const TYPE_INI = "ini";
const TYPE_YAML = "yml";
const TYPE_JSON = "json";
const TYPE_XML = "xml";

// Allow iteration:
const FILE_TYPES = [
	self::TYPE_INI,
	self::TYPE_YAML,
	self::TYPE_JSON,
	self::TYPE_XML,
];

private $kvp;
private $originalKvp;

private $findInTree;
private $fileName;
private $dirPath;
private $filePath;

private $parser;

private $prefix = "";
private $separator = ".";

public function __construct(
bool $findInTree = false, string $fileName = "config", string $dirPath = "") {
	if(empty($dirPath)) {
		$dirPath = getcwd();
	}

	$this->kvp = new ArrayObject();

	$this->findInTree = $findInTree;
	$this->fileName = $fileName;
	$this->dirPath = $dirPath;

	$this->findFilePath();
	$parser = new Parser($this->filePath);
	$parser->parse();
	$this->originalKvp = $parser->getValueArray();
	$this->setEnvironmentVariables($this->originalKvp);
}

/**
 * Uses the FileFinder class to attempt to find a config file to parse.
 */
private function findFilePath() {
	$fileFinder = new FileFinder(
		$this->findInTree, $this->dirPath, $this->fileName);
	$this->filePath = $fileFinder->getFilePath();
}

/**
 * Called after parsing, sets the environment variables. All variables that are
 * set are stored in the variable array, so they can be unset later.
 */
private function setEnvironmentVariables(ArrayObject $valueArray) {
	$this->unset();

	foreach ($valueArray as $key => $value) {
		if(!empty($this->prefix)) {
			$key = implode($this->separator, [
				$this->prefix,
				$key,
			]);
		}
		// TODO: Recursively iterate over nested array: issue #12
		if(!is_string($value)) {
			// Currently skips non-string values until #12 is implemented.
			continue;
		}
		$this->kvp[$key] = $value;
		if(!putenv("$key=$value")) {
			throw new ConfigException(
				"Error setting environment variable $key");
		}
	}
}

/**
 * Removes all environment variables that have been set by the current object.
 */
public function unset() {
	if(empty($this->kvp)) {
		return;
	}

	foreach ($this->kvp as $key => $value) {
		// TODO: Recursively iterate over nested array: issue #12
		if(!is_string($value)) {
			// Currently skips non-string values until #12 is implemented.
			continue;
		}

		if(!putenv($key)) {
			throw new ConfigException(
				"Error removing environment variable $key");
		}
	}

	$this->kvp = new ArrayObject();
}

/**
 * Prefixes all environment variables with the provided string. Unsets any
 * environment variables that have already been set, replacing with the
 * prefixed versions.
 *
 * @param string $prefix
 */
public function setPrefix(string $prefix) {
	$this->prefix = $prefix;
	$this->setEnvironmentVariables($this->originalKvp);
}

/**
 * Sets the string that separates the prefix and any nested properties.
 *
 * @param string $separator
 */
public function setSeparator(string $separator) {
	$this->separator = $separator;
	$this->setEnvironmentVariables($this->originalKvp);
}

}#