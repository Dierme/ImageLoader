<?php
/**
 * Created by PhpStorm.
 * User: kalim_000
 * Date: 2/18/2017
 * Time: 12:28 AM
 */

namespace dierme\loader\validators;

use dierme\loader\models\Model;

class ContentImageValidator implements IValidator
{
    /**
     * @inheritdoc
     */
    public function validateAttribute(Model $model, $attribute)
    {
        $imageInfo = getimagesize($model->getAttribute($attribute));

        if (!$imageInfo) {
            $model->addError($attribute, 'Url content is not an image');
            return false;
        }

        return true;
    }
}