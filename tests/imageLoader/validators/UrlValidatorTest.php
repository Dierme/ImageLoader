<?php

/**
 * Created by PhpStorm.
 * User: kalim_000
 * Date: 2/16/2017
 * Time: 8:10 PM
 */
use PHPUnit\Framework\TestCase;

use dierme\loader\models\UrlModel;
use dierme\loader\validators\UrlValidator;

class UrlValidatorTest extends TestCase
{
    private $model;

    private $validator;

    private $attribute;

    public function setUp()
    {
        $this->model = new UrlModel();
        $this->validator = new UrlValidator();
        $this->attribute = 'url';
    }

    public function testValidatorReturnsFalseOnInvalidUrl()
    {
        $invalidUrl = 'Http::WHATSUP';

        $this->model->setAttribute($this->attribute, $invalidUrl);

        $result = $this->validator->validateAttribute($this->model, $this->attribute);

        $this->assertFalse($result);
    }

    public function testValidatorReturnsFalseOnUnavailableUrl()
    {
        $unavailableUrl = 'http://this-url-will-never-be-available.com';

        $this->model->setAttribute($this->attribute, $unavailableUrl);

        $result = $this->validator->validateAttribute($this->model, $this->attribute);

        $this->assertFalse($result);
    }

}