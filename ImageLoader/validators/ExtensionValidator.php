<?php
/**
 * Created by PhpStorm.
 * User: kalim_000
 * Date: 2/15/2017
 * Time: 3:06 PM
 */

namespace dierme\loader\validators;

use dierme\loader\models\Model;
use dierme\loader\exceptions\ConfigurationException;

class ExtensionValidator implements IValidator
{
    /**
     * Allowed Extensions.
     * pass ['*'] to allow all extensions.
     * @var
     */
    public $allowedExtensions;

    public function __construct(array $allowedExtensions = [])
    {
        if (empty($allowedExtensions)) {
            $params = require(__DIR__ . '/../config/params.php');

            if (empty($params['allowedExtensions'])) {
                throw new  ConfigurationException('property allowedExtensions is not set in config');
            }

            $this->allowedExtensions = $params['allowedExtensions'];
        }
        else{
            $this->allowedExtensions = $allowedExtensions;
        }
    }


    /**
     * @inheritdoc
     */
    public function validateAttribute(Model $model, $attribute)
    {
        if ($this->allowedExtensions[0] == '*') {
            return true;
        }

        if (in_array($model->getAttribute($attribute), $this->allowedExtensions)) {
            return true;
        }

        $model->addError($attribute, 'Extension not allowed');

        return false;
    }
}