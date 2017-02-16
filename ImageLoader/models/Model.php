<?php
/**
 * Created by PhpStorm.
 * User: kalim_000
 * Date: 2/15/2017
 * Time: 3:16 PM
 */

namespace dierme\loader\models;


use dierme\loader\exceptions\ModelException;

abstract class Model implements IModel
{
    /**
     * Model errors
     * @var array
     */
    public $errors;

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @param $attribute
     * @param $value
     * @throws ModelException
     */
    public function setAttribute($attribute, $value)
    {
        if (!property_exists($this, $attribute)) {
            throw new ModelException($attribute . ' attribute is not found');
        }

        $this->$attribute = $value;
    }

    /**
     * @inheritdoc
     */
    public function hasErrors()
    {
        if (empty($this->errors)) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @inheritdoc
     */
    public function addError($key, $message)
    {
        $this->errors[$key] = $message;
        return true;
    }

    /**
     * @inheritdoc
     */
    public function validate()
    {
        foreach ($this->rules() as $attribute => $validator) {
            $validator = new $validator();
            $validator->validateAttribute($this, $attribute);
        }

        return !$this->hasErrors();
    }

}