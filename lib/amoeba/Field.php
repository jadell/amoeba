<?php
namespace amoeba;
use amoeba\Exception,
	amoeba\Field\Definition;

class Field
{
	protected $def = null;
	protected $value = null;

	protected $obj = null;
	
	/**
	 * Create a new field
	 *
	 * @param Definition $def
	 */
	public function __construct(Definition $def)
	{
		$this->def = $def;
	}
	
	//////////////////////////////////////////////////////////////////////
	// MAGIC ////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////
	
	/**
	 * Get a property from the definition
	 *
	 * @param string $method
	 * @param array  $args
	 * @return boolean
	 */
	public function __call($method, $args)
	{
		$get = strtolower(substr($method, 0,3));
		$key = strtolower(substr($method, 3));
		if ($get == 'get') {
			return $this->def->$key;
		}
		return $this->def->$method();
	}

	//////////////////////////////////////////////////////////////////////
	// PUBLIC ///////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////

	/**
	 * Return this field's definition
	 *
	 * @return Definition
	 */
	public function getDefinition()
	{
		return $this->def;
	}

	/**
	 * Return the object this field thinks it is attached to 
	 *
	 * @return Object
	 */
	public function getObject()
	{
		return $this->obj;
	}

	/**
	 * Return this field's value
	 *
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}
	
	/**
	 * Set the object this field thinks it is attached to 
	 *
	 * @param Object $obj
	 */
	public function setObject(Object $obj)
	{
		$this->obj = $obj;
	}
	
	/**
	 * Set this field's value
	 *
	 * @param mixed $value
	 */
	public function setValue($value)
	{
		if (is_array($value)) {
			$value = new \ArrayObject($value);
		}
		$this->value = $value;
	}
}