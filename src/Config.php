<?php
namespace Gt\Config;

class Config {
	protected $kvp = [];

	public function __construct(
		string $projectRoot = "",
		string $filename = "config.ini"
	) {
		$iniConfig = $this->loadIni($projectRoot, $filename);
		$iniConfig = array_change_key_case($iniConfig, CASE_UPPER);
		$this->kvp = $iniConfig;
	}

	public function get(string $name):?string {
		$env = getenv($name);
		if($env) {
			return $env;
		}

		return $this->kvp[$name] ?? null;
	}

	protected function loadIni(string $projectRoot, string $filename):array {
		$kvp = [];

		$iniPath = $projectRoot . DIRECTORY_SEPARATOR . $filename;

		if(is_file($iniPath)) {
			$kvp = parse_ini_file($iniPath, true);
		}

		return $kvp;
	}
}