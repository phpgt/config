<?php
namespace Gt\Config\Test;

use Gt\Config\Test\Helper\Helper;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase {
	protected $tmp;

	public function setUp():void {
		Helper::removeTmpDir();
		$this->tmp = Helper::getTmpDir();
		mkdir($this->tmp, 0775, true);
		chdir($this->tmp);
	}

	public function tearDown():void {
		Helper::removeTmpDir();
	}
}