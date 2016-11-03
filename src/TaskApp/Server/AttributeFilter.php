<?php
namespace TaskApp\Server;
use TaskApp\Interfaces\IFilter;

class AttributeFilter implements IFilter
{
	protected $name = null;
	protected $value = null;

	/**
	 * Set name
	 * @param string $name 
	 * @return AttributeFilter
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * Set value
	 * @param string $value 
	 * @return AttributeFilter
	 */
	public function setValue($value)
	{
		$this->value = $value;
		return $this;
	}

	/**
	 * Filter input array
	 * @param array $data 
	 * @return array
	 */
	public function execute($data)
	{
		$tmpList = array();
		
		foreach ($data as $connectionWrapper) {
			if (
				$connectionWrapper->getAttribute($this->name)
				&& 
					(
					$this->value == null
					|| $connectionWrapper->getAttribute($this->name) == $this->value
					)
			) {
				$tmpList[] = $connectionWrapper;
			}
		}
		return $tmpList;
	}
}