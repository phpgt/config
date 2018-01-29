<?php
namespace Gt\Config;

class Config {
	protected $kvp = [];

	public function __construct(
		array $env = [],
		string $projectRoot = "",
		string $filename = "config.ini"
	) {
		$iniConfig = $this->loadIni($projectRoot, $filename);
		$iniConfig = array_change_key_case($iniConfig, CASE_UPPER);
		$env = array_change_key_case($env, CASE_UPPER);
		$this->kvp = array_merge($iniConfig, $env);
	}

	public function get(string $name):?string {
		$name = strtoupper($name);
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