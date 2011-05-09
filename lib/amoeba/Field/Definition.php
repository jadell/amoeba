<?php
namespace amoeba\Field;
use amoeba\Exception;

class Definition
{
	protected $name = null;
	protected $display = null;
	
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
		$first3 = strtolower(substr($method, 0,3));
		$key = strtolower(substr($method, 3));
		if ($first3 == 'get') {
			return $this->$key;
		} else if ($first3 == 'set') {
			$this->$key = $args[0];
			return $this;
		}
		
		$is = strtolower(substr($method, 0,2));
		$key = strtolower(substr($method, 2));
		if ($is == 'is') {
			return isset($this->properties[$key]) ? (bool)$this->properties[$key] : false;
		}
		throw new Exception("Unknown method '{$method}'");
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
		$getter = 'get'.$key;
		if (method_exists($this, $getter)) {
			return $this->$getter();
		}

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
		$setter = 'set'.$key;
		if (method_exists($this, $setter)) {
			$this->$setter($value);
		} else {
			$this->properties[$key] = $value;
		}
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
}