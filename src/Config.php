<?php
namespace Gt\Config;

class Config {
	const INI_EXTENSION = "ini";
	const FILE_OVERRIDE_DEV = "dev";
	const FILE_OVERRIDE_DEPLOY = "deploy";
	const FILE_OVERRIDE_PRODUCTION = "production";
	const FILE_OVERRIDE_ORDER = [
		self::FILE_OVERRIDE_DEV,
		self::FILE_OVERRIDE_DEPLOY,
		self::FILE_OVERRIDE_PRODUCTION,
	];

	protected $projectRoot;
	protected $kvp = [];
	protected $delimeter;

	public function __construct(
		string $projectRoot = "",
		string $filename = "config",
		string $delimeter = "."
	) {
		$this->projectRoot = $projectRoot;
		$iniConfig = $this->loadIni($projectRoot, $filename);
		$this->kvp = $iniConfig;
		$this->delimeter = $delimeter;
	}

	public function mergeDefaults(
		string $defaultDirectoryPath = null,
		string $filename = "config.default",
		bool $override = false
	):void {
		if(is_null($defaultDirectoryPath)) {
			$defaultDirectoryPath = $this->projectRoot;
		}

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

				if($override) {
					$this->kvp[$section][$key] = $value;
				}
			}
		}
	}

	public function loadOverrides():void {
		foreach(self::FILE_OVERRIDE_ORDER as $override) {
			$this->mergeDefaults(
				$this->projectRoot,
				"config.$override",
				true
			);
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

		return $section[$parts[1]];
	}

	protected function loadIni(string $directoryPath, string $filename):array {
		$kvp = [];

		$iniPath = $directoryPath
			. DIRECTORY_SEPARATOR
			. $filename
			. "."
			. self::INI_EXTENSION;

		if(is_file($iniPath)) {
			$kvp = parse_ini_file($iniPath, true);
		}

		return $kvp;
	}
}