<?php
namespace Gt\Config;

class Config {
	protected $kvp = [];
	protected $delimeter;

	public function __construct(
		string $projectRoot = "",
		string $filename = "config.ini",
		string $delimeter = "."
	) {
		$iniConfig = $this->loadIni($projectRoot, $filename);
		$this->kvp = $iniConfig;
		$this->delimeter = $delimeter;
	}

	public function setDefault(
		string $defaultDirectoryPath,
		string $filename = "config.default.ini"
	):void {
		$defaults = $this->loadIni(
			$defaultDirectoryPath,
			$filename
		);

		$this->kvp = array_merge($defaults, $this->kvp);
	}

	public function get(string $name):?string {
		$env = getenv($name);
		if($env) {
			return $env;
		}

		return $this->getSectionValue($name);
	}

	public function getSection(string $sectionName):?ConfigSection {
		if(!isset($this->kvp[$sectionName])) {
			return null;
		}

		return new ConfigSection($this->kvp[$sectionName]);
	}

	protected function getSectionValue(string $name):?string {
		$parts = explode($this->delimeter, $name);
		$current = $this->kvp;

		foreach($parts as $part) {
			$current = $current[$part];
			if(!$current) {
				return null;
			}
		}

		if(is_array($current)) {
			return null;
		}

		return $current;
	}

	protected function loadIni(string $directoryPath, string $filename):array {
		$kvp = [];

		$iniPath = $directoryPath . DIRECTORY_SEPARATOR . $filename;

		if(is_file($iniPath)) {
			$kvp = parse_ini_file($iniPath, true);
		}

		return $kvp;
	}
}