<?php

/**
 * Created by PhpStorm.
 * User: kalim_000
 * Date: 2/16/2017
 * Time: 8:23 PM
 */

use PHPUnit\Framework\TestCase;
use dierme\loader\models\Model;

class ModelTest extends TestCase
{
    private $model;

    public function setUp()
    {
        $this->model = $this->getMockForAbstractClass(Model::class);
    }

    /**
     * @expectedException \dierme\loader\exceptions\ModelException
     */
    public function testSetAttributeThrowsExceptionWhenAttrNotFound()
    {
        $this->model->setAttribute('notExistingAttribute', 'zero');
    }

    public function testAddError()
    {
        $this->model->addError('key', 'value');

        $this->assertEquals($this->model->errors['key'], 'value');
    }

    public function testHasErrors()
    {
        $this->model->addError('key', 'value');

        $this->assertTrue($this->model->hasErrors());
    }

}