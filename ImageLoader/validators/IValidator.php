<?php

/**
 * Created by PhpStorm.
 * User: kalim_000
 * Date: 2/15/2017
 * Time: 3:04 PM
 */

namespace dierme\loader\validators;

use dierme\loader\models\Model;

interface IValidator
{
    /**
     * Validates model attribute
     *
     * @param $model
     * @param $attribute
     * @return boolean
     */
    public function validateAttribute(Model $model, $attribute);

}