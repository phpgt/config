<?php

namespace phpgt\config;

class Config {

private $variableArray;
private $path;
private $fileName;

private $prefix = "";
private $separator = ".";

public function __construct(string $fileName = "config", string $path = "") {
	if(empty($path)) {
		$path = getcwd();
	}

	$this->path = $path;
	$this->fileName = $fileName;

	$this->findFile();
}

/**
 * Uses the FileFinder class to attempt to find a config file to parse.
 */
private function findFile() {
	$fileFinder = new FileFinder($this->path, $this->fileName);
	$this->filePath = $fileFinder->getFilePath();
}

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