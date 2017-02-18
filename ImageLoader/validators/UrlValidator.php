<?php
/**
 * Created by PhpStorm.
 * User: kalim_000
 * Date: 2/16/2017
 * Time: 6:57 PM
 */

namespace dierme\loader\validators;


use dierme\loader\models\Model;

class UrlValidator implements IValidator
{

    /**
     * @inheritdoc
     */
    public function validateAttribute(Model $model, $attribute)
    {
        if (!$this->urlIsValid($model->getAttribute($attribute))) {
            $model->addError($attribute, 'Url is not valid');
            return false;
        } elseif (!$this->urlIsAvailable($model->getAttribute($attribute))) {
            $model->addError($attribute, 'Url is not available');
            return false;
        }

        return true;
    }

    /**
     * @param $url
     * @return bool
     */
    private function urlIsValid($url)
    {
        if ((bool)filter_var($url, FILTER_VALIDATE_URL) === true) {
            return true;
        }
        return false;
    }

    /**
     * @param $url
     * @return bool
     */
    private function urlIsAvailable($url)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($retcode != 200) {
            return false;
        }
        return true;
    }

}