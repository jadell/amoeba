<?php
namespace amoeba;
use amoeba\Exception,
	amoeba\Field;

class Object
{
	protected $type = null;
	protected $display = null;

	protected $fields = array();
	
	//////////////////////////////////////////////////////////////////////
	// MAGIC ////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////
	
	/**
	 * If the property being retrieved is a known field,
	 * return the field object
	 *
	 * @param string $methodName
	 * @param array $args
	 * @return DW_Asset_Field
	 * @throws DW_Asset_Exception if the property is unknown
	 */
	public function __call($methodName, $args)
	{
		$field = $this->getField($methodName);
		return $field;
	}
	
	/**
	 * If the property being retrieved is a known field,
	 * return the value of that field
	 *
	 * @param string $propertyName
	 * @return mixed
	 * @throws DW_Asset_Exception if the property is unknown
	 */
	public function __get($propertyName)
	{
		$field = $this->getField($propertyName);
		return $field ? $field->getValue() : null;
	}
	
	/**
	 * If the property being retrieved is a known field,
	 * set the value of that field
	 *
	 * @param string $propertyName
	 * @param mixed $value
	 * @throws DW_Asset_Exception if the property is unknown
	 */
	public function __set($propertyName, $value)
	{
		$field = $this->getField($propertyName);
		$field ? $field->setValue($value) : null;
	}
	
	//////////////////////////////////////////////////////////////////////
	// PUBLIC ///////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////
	
	/**
	 * Add a field to this asset
	 *
	 * @param Field $field
	 * @return Object
	 */
	public function addField(Field $field)
	{
		$name = $field->getName();
		$this->fields[$name] = $field;
		$field->setObject($this);
		return $this;
	}
		
	/**
	 * List the fields attached to this asset
	 *
	 * @return array each element is field object indexed by field name
	 */
	public function listFields()
	{
		return $this->fields;
	}
	
	/**
	 * Get the named field
	 *
	 * @param string $name
	 * @return DW_Asset_Field
	 */
	public function getField($name)
	{
		if(!isset($this->fields[$name])){
			return null;
		}
		return $this->fields[$name];
	}
	
	/**
	 * Return the asset type
	 *
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}
	
	/**
	 * Return the asset display string
	 *
	 * @return string
	 */
	public function getDisplay()
	{
		return $this->display;
	}

	/**
	 * Set the asset type
	 *
	 * @param string $type
	 */
	public function setType($type)
	{
		$this->type = $type;
		return $this;
	}
	
	/**
	 * Set the asset type display string
	 *
	 * @param string $display
	 */
	public function setDisplay($display)
	{
		$this->display = $display;
		return $this;
	}
}
