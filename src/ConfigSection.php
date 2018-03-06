<?php
namespace Gt\Config;

use ArrayAccess;
use Iterator;

class ConfigSection implements ArrayAccess, Iterator {
	protected $data;
	protected $iteratorIndex;

	public function __construct(array $data) {
		$this->data = $data;
	}

	/**
	 * @link http://php.net/manual/en/iterator.current.php
	 */
	public function current() {
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
	 * @param string $offset
	 */
	public function offsetExists($offset):bool {
		return isset($this->data[$offset]);
	}

	/**
	 * @link http://php.net/manual/en/arrayaccess.offsetget.php
	 * @param string $offset
	 */
	public function offsetGet($offset):?string {
		return $this->data[$offset];
	}

	/**
	 * @link http://php.net/manual/en/arrayaccess.offsetset.php
	 */
	public function offsetSet($offset, $value):void {
		// TODO: Config should be immutable
		// TODO: Implement offsetSet() method.
	}

	/**
	 * @link http://php.net/manual/en/arrayaccess.offsetunset.php
	 */
	public function offsetUnset($offset):void {
		// TODO: Config should be immutable
		// TODO: Implement offsetUnset() method.
	}

	protected function getIteratorKey():?string {
		$keys = array_keys($this->data);
		return $keys[$this->iteratorIndex] ?? null;
	}
}