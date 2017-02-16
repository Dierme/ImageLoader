<?php

/**
 * Created by PhpStorm.
 * User: kalim_000
 * Date: 2/15/2017
 * Time: 3:09 PM
 */

namespace dierme\loader\models;


interface IModel
{
    /**
     * Validates model
     * @return bool
     */
    public function validate();

    /**
     * Returns validation errors
     * @return array
     */
    public function getErrors();

    /**
     * Adds error to Model
     * @param $key
     * @param $message
     * @return bool
     */
    public function addError($key, $message);

    /**
     * Checks if errors exist
     * @return bool
     */
    public function hasErrors();

    public function setAttribute($attribute, $value);

}