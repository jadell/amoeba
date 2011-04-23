<?php
use amoeba\Field,
	amoeba\Object,
	amoeba\Field\Definition;

class amoeba_FieldTest extends PHPUnit_Framework_TestCase
{
	protected $def = null;
	protected $field = null;

	public function setUp()
	{
		$this->def = new Definition();
		$this->field = new Field($this->def);
	}

	public function testPassthroughProperties_SetGetDefinitionProperties_ReturnsCorrectValues()
	{
		$name = "fieldName";
		$display = "fieldDisplay";
		$type = Definition::TypeInteger;
		$this->def->setName($name);
		$this->def->setDisplay($display);
		$this->def->setType($type);
		
		self::assertSame($this->def, $this->field->getDefinition());
		self::assertEquals($name, $this->field->getName());
		self::assertEquals($display, $this->field->getDisplay());
		self::assertEquals($type, $this->field->getType());
	}
	
	public function testGetSet_DynamicProperties_ReturnsCorrectValues()
	{
		$this->def->foo = "bar";
	
		self::assertNull($this->field->getBaz());
		self::assertFalse($this->field->isBaz());
		self::assertEquals("bar", $this->field->getFoo());
		self::assertTrue($this->field->isFoo());
	}
	
	public function testGetSetValue_ValueNotSet_ReturnsNull()
	{
		self::assertNull($this->field->getValue());
	}
	
	public function testGetSetValue_ValueSet_ReturnsValue()
	{
		$this->field->setValue("foo");
		self::assertEquals("foo", $this->field->getValue());
	}
	
	public function testSetObject_SetsObjectToAttach_ReturnsObject()
	{
		$obj = new Object();
		$this->field->setObject($obj);
		self::assertSame($obj, $this->field->getObject());
	}
}
