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
		$this->def->setName($name);
		$this->def->setDisplay($display);
		
		self::assertSame($this->def, $this->field->getDefinition());
		self::assertEquals($name, $this->field->getName());
		self::assertEquals($display, $this->field->getDisplay());
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
	
	public function testGetSetValue_ValueOnMultipleFields_ReturnsValueUniqueToField()
	{
		$this->def->value = "baz";
		$field2 = new Field($this->def);

		$this->field->setValue("foo");
		$field2->setValue("bar");

		self::assertEquals("foo", $this->field->getValue());
		self::assertEquals("bar", $field2->getValue());
		self::assertEquals("baz", $this->def->value);
	}
	
	public function testGetSetValue_ValueIsAnArray_SetsAsArrayObject()
	{
		$value = array('a','b','c');
		$this->field->setValue($value);
		self::assertEquals($value, (array)$this->field->getValue());
		self::assertInstanceOf('ArrayObject', $this->field->getValue());
	}

	public function testSetObject_SetsObjectToAttach_ReturnsObject()
	{
		$obj = new Object();
		$this->field->setObject($obj);
		self::assertSame($obj, $this->field->getObject());
	}
}
