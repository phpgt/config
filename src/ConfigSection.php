<?php
namespace Gt\Config;

use ArrayAccess;
use Iterator;

class ConfigSection implements ArrayAccess, Iterator {
	protected $name;
	protected $data;
	protected $iteratorIndex;

	public function __construct(string $name, array $data) {
		$this->name = $name;
		$this->data = $data;
	}

	public function get(string $key):?string {
		return $this->data[$key] ?? null;
	}

	/**
	 * @link http://php.net/manual/en/iterator.current.php
	 */
	public function current():array {
		$key = $this->getIteratorKey();
		return $this->data[$key];
	}

	/**
	 * @link http://php.net/manual/en/iterator.next.php
	 */
	public function next():void {
		$this->iteratorIndex++;
	}

	/**
	 * @link http://php.net/manual/en/iterator.key.php
	 */
	public function key():?string {
		return $this->getIteratorKey();
	}

	/**
	 * @link http://php.net/manual/en/iterator.valid.php
	 */
	public function valid():bool {
		$key = $this->getIteratorKey();
		return isset($this->data[$key]);
	}

	/**
	 * @link http://php.net/manual/en/iterator.rewind.php
	 */
	public function rewind():void {
		$this->iteratorIndex = 0;
	}

	/**
	 * @link http://php.net/manual/en/arrayaccess.offsetexists.php
	 */
	public function offsetExists($offset):bool {
		return isset($this->data[$offset]);
	}

	/**
	 * @link http://php.net/manual/en/arrayaccess.offsetget.php
	 */
	public function offsetGet($offset):?string {
		return $this->get($offset);
	}

	/**
	 * @link http://php.net/manual/en/arrayaccess.offsetset.php
	 */
	public function offsetSet($offset, $value):void {
		$this->data[$offset] = $value;
	}

	/**
	 * @link http://php.net/manual/en/arrayaccess.offsetunset.php
	 */
	public function offsetUnset($offset):void {
		unset($this->data[$offset]);
	}

	protected function getIteratorKey():?string {
		$keys = array_keys($this->data);
		return $keys[$this->iteratorIndex] ?? null;
	}

	public function getName():string {
		return $this->name;
	}
}