<?php
use amoeba\Field,
	amoeba\Object;

class amoeba_ObjectTest extends PHPUnit_Framework_TestCase
{
	protected $obj = null;

	public function setUp()
	{
		$this->obj = new Object();
	}
	
	public function testSetup_SetMetadata_MetadataRetrievable()
	{
		$type = 'my_type';
		$display = 'My Display';
		
		$this->obj->setType($type);
		$this->obj->setDisplay($display);
		
		self::assertEquals($type, $this->obj->getType());
		self::assertEquals($display, $this->obj->getDisplay());
	}
	
	public function testAccessField_FieldDoesNotExist_ReturnsNull()
	{
		self::assertNull($this->obj->badfield());
	}
	
	public function testAddField_FieldGiven_FieldCanBeAccessedThroughObject()
	{
		$originalValue = 'original';
		$newValue = 'extra crispy';
		
		$def = new Field\Definition();
		$def->setName('flavor')
			->setType(Field\Definition::TypeString);
		$field = new Field($def);
		$field->setValue($originalValue);
			
		$this->obj->addField($field);
		self::assertEquals($originalValue, $this->obj->flavor);
		
		$this->obj->flavor = $newValue;
		self::assertEquals($newValue, $this->obj->flavor);
		
		self::assertEquals(Field\Definition::TypeString, $this->obj->flavor()->getType());
		self::assertSame($this->obj, $this->obj->flavor()->getObject());
	}

	public function testAddField_FieldValueIsArray_FieldCanBeAccessedAsArray()
	{
		$def = new Field\Definition();
		$def->setName('flavor')
			->setType(Field\Definition::TypeString);
		$field = new Field($def);
		$field->setValue(new ArrayObject());

		$this->obj->addField($field);
		self::assertEquals(0, count($this->obj->flavor));
		
		$this->obj->flavor[] = 'extra crispy';

		self::assertEquals(1, count($this->obj->flavor));
		self::assertEquals('extra crispy', $this->obj->flavor[0]);
		
		$fieldName = 'flavor';
		$this->obj->{$fieldName}[] = 'original';
		self::assertEquals(2, count($this->obj->$fieldName));
		self::assertEquals('original', $this->obj->{$fieldName}[1]);
	}
	
	public function testListFields_FieldsAdded_ReturnsArrayOfFields()
	{
		$def = new Field\Definition();
		$def->setName('flavor')->setType(Field\Definition::TypeString);
		$field1 = new Field($def);
		$this->obj->addField($field1);

		$def = new Field\Definition();
		$def->setName('spicy')->setType(Field\Definition::TypeBoolean);
		$field2 = new Field($def);
		$this->obj->addField($field2);

		$fields = $this->obj->listFields();
		self::assertEquals(array('flavor'=>$field1,'spicy'=>$field2), $fields);
	}
}