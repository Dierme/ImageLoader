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
     * Returns validation errors.
     * If key is set, returns errors by key
     * @param $key
     * @return array
     */
    public function getErrors($key = false);

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

    /**
     * Sets model attribute
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function setAttribute($attribute, $value);

    /**
     * Gets model attribute
     * @param $attribute
     * @return mixed
     */
    public function getAttribute($attribute);

}