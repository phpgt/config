<?php
namespace Gt\Config;

class FileWriter {
	private $config;

	public function __construct(Config $config) {
		$this->config = $config;
	}

	public function writeIni(string $filePath):void {
		$buffer = [];

		foreach($this->config->getSectionNames() as $sectionName) {
			foreach($this->config->getSection($sectionName)
			as $key => $value) {

			}
		}

		file_put_contents($filePath, implode(
			"\n",
			$buffer
		));
	}
}