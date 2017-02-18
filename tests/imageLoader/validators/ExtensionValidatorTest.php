<?php

/**
 * Created by PhpStorm.
 * User: kalim_000
 * Date: 2/18/2017
 * Time: 3:16 AM
 */

use \PHPUnit\Framework\TestCase;
use dierme\loader\validators\ExtensionValidator;
use dierme\loader\models\Model;

class ExtensionValidatorTest extends TestCase
{
    public $model;

    public $validator;

    public $attribute;

    public function setUp()
    {
        $stubModel = $this->getMockBuilder(Model::class)
            ->setMethods(array('rules', 'getAttribute'))
            ->getMockForAbstractClass();

        $this->model = $stubModel;
        $this->validator = new ExtensionValidator(['png']);
        $this->attribute = 'extension';
    }

    public function testExtensionValidatorReturnsFalseAndAddsErrorOnFail()
    {
        $this->model->expects($this->any())
            ->method('getAttribute')
            ->willReturn([
                'jpeg'
            ]);

        $result = $this->validator->validateAttribute($this->model, $this->attribute);

        $this->assertFalse($result);

        $this->assertTrue(
            !empty($this->model->getErrors($this->attribute))
        );
    }
}