<?php
namespace Gt\Config;

use Exception;
use WriteiniFile\WriteiniFile;

class FileWriter {
	private $config;

	public function __construct(Config $config) {
		$this->config = $config;
	}

	public function writeIni(string $filePath):void {
		if(!is_dir(dirname($filePath))) {
			mkdir(dirname($filePath), 0775, true);
		}

		$writer = new WriteiniFile($filePath);

		foreach($this->config->getSectionNames() as $sectionName) {
			foreach($this->config->getSection($sectionName)
			as $key => $value) {
				$writer->add([
					$sectionName => [
						$key => $value,
					]
				]);
			}
		}

		try {
			$writer->write();
		}
		catch(Exception $exception) {
			throw new ConfigException("Unable to write to file: $filePath");
		}
	}
}