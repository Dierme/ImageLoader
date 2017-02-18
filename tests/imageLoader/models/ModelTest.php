<?php

/**
 * Created by PhpStorm.
 * User: kalim_000
 * Date: 2/16/2017
 * Time: 8:23 PM
 */

use PHPUnit\Framework\TestCase;
use dierme\loader\models\Model;
use dierme\loader\validators\UrlValidator;

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

    /**
     * @expectedException \dierme\loader\exceptions\ModelException
     */
    public function testGetAttributeThrowsExceptionWhenAttrNotFound()
    {
        $this->model->getAttribute('notExistingAttribute');
    }

    public function testAddError()
    {
        $this->model->addError('key', 'value');

        $this->assertEquals($this->model->errors['key'][0], 'value');
    }

    public function testGetErrorsByKey()
    {
        $this->model->addError('key', 'value');

        $this->assertTrue(
            !empty($this->model->getErrors('key'))
        );
    }

    public function testHasErrors()
    {
        $this->model->addError('key', 'value');

        $this->assertTrue($this->model->hasErrors());
    }

    public function testValidate()
    {
        $stubModel = $this->getMockBuilder(Model::class)
            ->setMethods(array('rules', 'getAttribute'))
            ->getMockForAbstractClass();

        $stubModel->expects($this->any())
            ->method('rules')
            ->will($this->returnValue([
                'url' => UrlValidator::class
            ]));

        $stubModel->expects($this->any())
            ->method('rules')
            ->willReturn([
                'url' => UrlValidator::class
            ]);

        $stubModel->expects($this->any())
            ->method('getAttribute')
            ->willReturn([
                'invalidUrl'
            ]);

        $stubModel->validate();

        $this->assertTrue(
            !empty($stubModel->getErrors('url'))
        );
    }


}