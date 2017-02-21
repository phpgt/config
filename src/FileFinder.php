<?php
namespace Gt\Config;

/**
 * The FileFinder searches the provided path for config files that match a
 * criteria, in case a specific file path isn't provided.
 */
class FileFinder {

private $findInTree;
private $dirPath;
private $fileName;

private $filePath;

public function __construct(
bool $findInTree, string $dirPath, string $fileName) {
	// The dirPath *must* exist to continue.
	if(!is_dir($dirPath)) {
		throw new FileFinderException("Path does not exist: $dirPath");
	}

	$this->dirPath = $dirPath;
	$this->fileName = $fileName;

	// ... but the fileName may not contain an extension at this point.
	if(strstr($fileName, ".")) {
		$this->filePath = $this->dirPath . "/" . $this->fileName;

		if(!file_exists($this->filePath)) {
			throw new FileFinderException("File does not exist: "
				. $this->filePath);
		}
	}
}

/**
 * Attempts to find the config file, setting the $filePath property on success,
 * throwing a FileFinderException on failure.
 * @throws FileFinderException
 */
private function findFilePath() {
	if(isset($this->filePath)) {
		return;
	}

	// At this point, $fileName does NOT contain an extension.

	// If $findInTree is true, the do loop will look up the tree until
	// $stopDir is reached.
	$stopDirectory = $this->dirPath;
	if($this->findInTree) {
		$stopDir = "/";
	}
	$dir = $this->dirPath;

	do {

		$dir = dirname($dir);
	} while($dir !== $stopDir);
}

/**
 * Returns the filePath that has been found by this class. If no filePath has
 * yet been found, it will attempt to find it. Note that the findFilePath
 * method can throw a FileFinderException.
 */
public function getFilePath():string {
	if(empty($this->filePath)) {
		$this->findFilePath();
	}

	return $this->filePath;
}

}#