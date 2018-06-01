<?php
namespace Gt\Config;

class Config {
	/** @var ConfigSection[] */
	protected $sectionList = [];

	public function __construct(ConfigSection...$sectionList) {
		foreach($sectionList as $section) {
			$this->sectionList[$section->getName()] = $section;
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
		return $this->sectionList[$sectionName] ?? null;
	}

	protected function getSectionValue(string $name):?string {
		$parts = explode(".", $name, 2);
		$section = $this->getSection($parts[0]);

		if(is_null($section)
		|| empty($parts[1])) {
			return null;
		}

		return $section->get($parts[1]);
	}

	public function getSectionNames():array {
		$names = [];

		foreach($this->sectionList as $section) {
			$names []= $section->getName();
		}

		return $names;
	}

	public function merge(Config $configToOverride):void {
		foreach($configToOverride->getSectionNames() as $sectionName) {
			if(isset($this->sectionList[$sectionName])) {
				foreach($configToOverride->getSection($sectionName)
				as $key => $value) {
					if(empty($this->sectionList[$sectionName][$key])) {
						$this->sectionList[$sectionName][$key] = $value;
					}
				}
			}
			else {
				$this->sectionList[$sectionName] = $configToOverride->getSection(
					$sectionName
				);
			}
		}
	}
}