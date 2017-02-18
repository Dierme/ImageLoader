<?php

/**
 * Created by PhpStorm.
 * User: kalim_000
 * Date: 2/16/2017
 * Time: 8:10 PM
 */

use PHPUnit\Framework\TestCase;

use dierme\loader\models\Model;
use dierme\loader\validators\UrlValidator;

class UrlValidatorTest extends TestCase
{
    private $model;

    private $validator;

    private $attribute;

    public function setUp()
    {
        $stubModel = $this->getMockBuilder(Model::class)
            ->setMethods(array('rules', 'getAttribute'))
            ->getMockForAbstractClass();

        $this->model = $stubModel;
        $this->validator = new UrlValidator();
        $this->attribute = 'url';
    }

    public function testValidatorReturnsFalseAndAddsErrorOnInvalidUrl()
    {
        $this->model->expects($this->any())
            ->method('getAttribute')
            ->willReturn([
                'Http::WHATSUP'
            ]);

        $result = $this->validator->validateAttribute($this->model, $this->attribute);

        $this->assertFalse($result);

        $this->assertTrue(
            !empty($this->model->getErrors($this->attribute))
        );
    }

    public function testValidatorReturnsFalseAndAddsErrorOnUnavailableUrl()
    {
        $this->model->expects($this->any())
            ->method('getAttribute')
            ->willReturn([
                'http://this-url-will-never-be-available.com'
            ]);

        $result = $this->validator->validateAttribute($this->model, $this->attribute);

        $this->assertFalse($result);

        $this->assertTrue(
            !empty($this->model->getErrors($this->attribute))
        );
    }

}