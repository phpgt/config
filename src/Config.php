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

		foreach($defaults as $section => $data) {
			foreach($data as $key => $value) {
				if(!isset($this->kvp[$section])) {
					$this->kvp[$section] = [];
				}

				if(!isset($this->kvp[$section][$key])) {
					$this->kvp[$section][$key] = $value;
				}
			}
		}
	}

	public function get(string $name):?string {
		$env = getenv(str_replace(".", "_", $name));
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
		$parts = explode($this->delimeter, $name, 2);
		$section = $this->getSection($parts[0]);

		if(is_null($section)
		|| empty($parts[1])) {
			return null;
		}

		return $section->get($parts[1]);
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