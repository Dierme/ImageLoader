<?php

/**
 * Created by PhpStorm.
 * User: kalim_000
 * Date: 2/15/2017
 * Time: 3:01 PM
 */

namespace dierme\loader\models;

use dierme\loader\validators\UrlValidator;

class UrlModel extends Model
{
    public $url;

    public function rules()
    {
        return [
            'url'   =>  UrlValidator::class
        ];
    }



}