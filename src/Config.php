<?php

namespace phpgt\config;

class Config {

const TYPE_INI = "ini";

const FILE_TYPES = [
	TYPE_INI,
	"yaml",
	"json",
	"xml",
];

private $variableArray;

private $findInTree;
private $fileName;
private $dirPath;
private $filePath;

private $prefix = "";
private $separator = ".";

public function __construct(
bool $findInTree = false, string $fileName = "config", string $dirPath = "") {
	if(empty($dirPath)) {
		$dirPath = getcwd();
	}

	$this->findInTree = $findInTree;
	$this->fileName = $fileName;
	$this->dirPath = $dirPath;

	$this->findFilePath();
	$this->parse();
	$this->setEnvironmentVariables();
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
 * Perform the parsing of the current filePath;
 */
private function parse() {

}

/**
 * Called after parsing, sets the environment variables. All variables set are
 * stored in the variable array, so they can be unset later.
 */
private function setEnvironmentVariables() {

}

/**
 * Removes all environment variables that have been set by the current object.
 */
public function unset() {

}

/**
 * Prefixes all environment variables with the provided string. Unsets any
 * environment variables that have already been set, replacing with the
 * prefixed versions.
 *
 * @param string $prefix
 */
public function setPrefix(string $prefix) {

}

/**
 * Sets the string that separates the prefix and any nested properties.
 *
 * @param string $separator
 */
public function setSeparator(string $separator) {

}

}#