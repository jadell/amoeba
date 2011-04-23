<?php
namespace amoeba\Field;
use amoeba\Exception;

class Definition
{
	const TypeString   = 'string';
	const TypeText 	   = 'text';
	const TypeInteger  = 'int';
	const TypeBoolean  = 'boolean';
	const TypeDateTime = 'datetime';
	const TypeDate     = 'date';
	const TypeFloat    = 'float';

	protected static $types = array(
		self::TypeString,
		self::TypeText,
		self::TypeInteger,
		self::TypeBoolean,
		self::TypeDateTime,
		self::TypeDate,
		self::TypeFloat,
	);

	protected $name = null;
	protected $display = null;
	protected $type = self::TypeString;
	
	protected $properties = array();

	//////////////////////////////////////////////////////////////////////
	// MAGIC ////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////
	
	/**
	 * Is a property set and truthy?
	 *
	 * @param string $method
	 * @param array  $args
	 * @return boolean
	 */
	public function __call($method, $args)
	{
		$is = strtolower(substr($method, 0,2));
		$key = strtolower(substr($method, 2));
		if ($is == 'is') {
			return isset($this->properties[$key]) ? (bool)$this->properties[$key] : false;
		}
		throw new Exception("Unknown property '{$key}'");
	}
	
	/**
	 * Get a dynamic property
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function __get($key)
	{
		$key = strtolower($key);
		return isset($this->properties[$key]) ? $this->properties[$key] : null;
	}
	
	/**
	 * Set a dynamic property
	 *
	 * @param string $key
	 * @param mixed  $value
	 */
	public function __set($key, $value)
	{
		$key = strtolower($key);
		$this->properties[$key] = $value;
	}

	//////////////////////////////////////////////////////////////////////
	// PUBLIC ///////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////

	/**
	 * Return this field's name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * Set this field's name
	 *
	 * @param string $name
	 * @return DW_Asset_Field
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * Return this field's display string
	 *
	 * @return string
	 */
	public function getDisplay()
	{
		if (!$this->display) {
			$display = $this->name;
			$display = str_replace('_', ' ', $display);
			$display = ucwords($display);
			
			$this->display = $display;
		}
	
		return $this->display;
	}
	
	/**
	 * Set this field's display string
	 *
	 * @param string $display
	 * @return DW_Asset_Field
	 */
	public function setDisplay($display)
	{
		$this->display = $display;
		return $this;
	}

	/**
	 * Return this field's type
	 *
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}
	
	/**
	 * Set this field's type
	 *
	 * @param string $type
	 * @return DW_Asset_Field
	 */
	public function setType($type)
	{
		if (!in_array($type, self::$types)) {
			throw new Exception("Unknown field type '{$type}'");
		}
		
		$this->type = $type;
		return $this;
	}
}