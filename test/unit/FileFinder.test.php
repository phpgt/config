<?php
namespace phpgt\config;

class FileFinderTest extends \PHPUnit_Framework_TestCase {

private $tmp;
private $file;
private $ext;
private $filePath;
private $filePathBase;

public function setUp() {
	test\Helper::setUpTmpDir();

	$dir = test\Helper::getTmpDir();
	$this->tmp = $dir;

	$this->filePath = test\Helper::createConfigFile($dir);
	$this->filePathBase = pathinfo($this->filePath, PATHINFO_BASENAME);
}

public function tearDown() {
	test\Helper::removeTmpDir();
}

public function testFindFilePathWithExtensionWithoutTree() {
	$fileFinder = new FileFinder(
		false,
		$this->tmp,
		$this->filePathBase);

	$this->assertEquals($this->filePath, $fileFinder->getFilePath());
}

}#