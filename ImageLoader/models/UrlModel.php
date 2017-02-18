<?php

/**
 * Created by PhpStorm.
 * User: kalim_000
 * Date: 2/15/2017
 * Time: 3:01 PM
 */

namespace dierme\loader\models;

use dierme\loader\exceptions\ModelException;
use dierme\loader\exceptions\UrlException;
use dierme\loader\validators\UrlValidator;
use dierme\loader\validators\ContentImageValidator;

class UrlModel extends Model
{
    /**
     * @var $url
     */
    public $url;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'url' => [UrlValidator::class, ContentImageValidator::class]
        ];
    }

    /**
     * @return mixed string, if extension is set, false otherwise
     * @throws ModelException
     * @throws UrlException
     */
    public function getResourceExtension()
    {
        if (empty($this->url)) {
            throw new ModelException('Property url is not set');
        }

        $imageInfo = getimagesize($this->url);

        $stringPieces = explode('/', $imageInfo['mime']);

        if(empty($stringPieces[1])){
            throw new UrlException('Can not determine extension of the url', $this->url);
        }

        return $stringPieces[1];
    }


}