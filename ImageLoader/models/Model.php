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
     * @inheritdoc
     */
    public function setAttribute($attribute, $value)
    {
        if (!property_exists($this, $attribute)) {
            throw new ModelException($attribute . ' attribute is not found');
        }

        $this->$attribute = $value;

        return true;
    }

    public function getAttribute($attribute)
    {
        if (!isset($this->$attribute)) {
            throw new ModelException($attribute . ' attribute is not found');
        }

        return $this->$attribute;
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
    public function getErrors($key = false)
    {
        if ($key && !empty($this->errors[$key])) {
            return $this->errors[$key];
        }

        return $this->errors;
    }

    /**
     * @inheritdoc
     */
    public function addError($key, $message)
    {
        $this->errors[$key][] = $message;
        return true;
    }

    /**
     * @inheritdoc
     */
    public function validate()
    {
        foreach ($this->rules() as $attribute => $validator) {
            if (is_array($validator)) {
                foreach ($validator as $className) {
                    $validatorObject = new $className();
                    $validatorObject->validateAttribute($this, $attribute);
                }
            } else {
                $validatorObject = new $validator();
                $validatorObject->validateAttribute($this, $attribute);
            }
        }
        return !$this->hasErrors();
    }

}