<?php
use amoeba\Exception,
	amoeba\Field\Definition;

class amoeba_Field_DefinitionTest extends PHPUnit_Framework_TestCase
{
	protected $def = null;

	public function setUp()
	{
		$this->def = new Definition();
	}
	
	public function testSetName_NameGiven_SetsName()
	{
		$name = 'my_name';
		$this->def->setName($name);
		self::assertEquals($name, $this->def->getName());
	}
	
	public function testSetDisplay_DisplayGiven_SetsDisplay()
	{
		$display = 'My Label';
		$this->def->setDisplay($display);
		self::assertEquals($display, $this->def->getDisplay());
	}
	
	public function testGetDisplay_NoDisplayGiven_ReturnsFormattedName()
	{
		$name = 'my_name';
		$this->def->setName($name);
		self::assertEquals('My Name', $this->def->getDisplay());
	}
	
	public function testSetGetProperty_PropertyNotSet_ReturnsNull()
	{
		self::assertNull($this->def->foo);
		self::assertFalse($this->def->isFoo());
	}
	
	public function testSetGetProperty_DynamicProperty_SetsAndReturnsPropertyValue()
	{
		$value = "bar";
		$this->def->foo = $value;
		self::assertEquals($value, $this->def->foo);
		self::assertTrue($this->def->isFoo());
	}
	
	public function testUnknownMethod_MethodDoesNotExist_ThrowsException()
	{
		self::setExpectedException('Exception');
		$this->def->wtf();
	}

	public function testCustomGet_GetMethodDefined_ReturnsValueFromCustomGetMethod()
	{
		$def = new amoeba_Field_DefinitionTest_TestDefinition();
		self::assertEquals(123, $def->tester);
	}

	public function testCustomSet_SetMethodDefined_ReturnsValueFromCustomSetMethod()
	{
		$def = new amoeba_Field_DefinitionTest_TestDefinition();
		$def->adder = 1;
		self::assertEquals(3, $def->adder);
	}
}


class amoeba_Field_DefinitionTest_TestDefinition extends Definition
{
	public function getTester()
	{
		return 123;
	}

	public function setAdder($i)
	{
		$this->properties['adder'] = $i+2;
	}
}
