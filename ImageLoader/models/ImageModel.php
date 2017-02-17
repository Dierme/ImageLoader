<?php

/**
 * Created by PhpStorm.
 * User: kalim_000
 * Date: 2/15/2017
 * Time: 3:01 PM
 */
namespace dierme\loader\models;

use dierme\loader\exceptions\ModelException;
use dierme\loader\validators\ExtensionValidator;


class ImageModel extends Model
{
    /**
     * Image extension
     * @string $extension
     */
    public $extension;

    /**
     * @string $name
     */
    public $name;

    public function rules()
    {
        return [
            'extension' => ExtensionValidator::class
        ];
    }


    public function uploadFromUrl(UrlModel $urlModel, array $params)
    {
        if (empty($this->name) || empty($this->extension)) {
            throw new ModelException('Properties name , extension should be set');
        }

        $imagePath = $params['path'] . '/' . $this->name . '.' . $this->extension;
        $file = fopen($imagePath, 'wb');

        $acceptStr = 'Accept: ';

        foreach ($params['allowedExtensions'] as $extension) {
            $acceptStr .= 'image/' . $extension . ', ';

        }
        rtrim($acceptStr, ', ');

        $headers[] = $acceptStr;
        $headers[] = 'Connection: close';
        $headers[] = 'Content-type: image;charset=UTF-8';
        $userAgent = 'php';
        $process = curl_init($urlModel->url);
        curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($process, CURLOPT_HEADER, 0);
        curl_setopt($process, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($process, CURLOPT_FILE, $file);

        curl_exec($process);
        curl_close($process);
        fclose($file);

        return true;
    }


}