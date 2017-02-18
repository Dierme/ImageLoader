<?php

namespace dierme\loader;

use dierme\loader\exceptions\ConfigurationException;
use dierme\loader\exceptions\FileException;
use dierme\loader\models\ImageModel;
use dierme\loader\models\UrlModel;
use dierme\loader\generators\SecureSrtGenerator;

/**
 * Class Loader
 * @package ImageLoader
 */
class Loader
{
    /**
     * @var array $params contains main configs
     */
    protected $params;

    function __construct()
    {
        $this->params = require(__DIR__ . '/config/params.php');

        $this->validateParams();
    }

    public function download($url)
    {
        $urlModel = new UrlModel();

        $urlModel->setAttribute('url', $url);

        if (!$urlModel->validate()) {
            return $urlModel->getErrors();
        }

        $generator = new SecureSrtGenerator();

        $imageModel = new ImageModel();

        $extension = $urlModel->getResourceExtension();

        do {
            $name = $generator->generateFileName(15);
        } while (!$this->nameIsUnique($this->params['path'], $name, $extension));

        $imageModel->setAttribute('name', $name);

        $imageModel->setAttribute('extension', $extension);

        if (!$imageModel->validate()) {
            return $imageModel->getErrors();
        }

        $imageModel->uploadFromUrl($urlModel, $this->params);

        return [
            'success' => true,
            'image' => $imageModel->name . '.' . $imageModel->extension
        ];
    }

    /**
     * Checks if folder contains file with $name.$extension
     * @param $dirPath
     * @param $name
     * @param $extension
     * @return bool
     * @throws FileException
     */
    public function nameIsUnique($dirPath, $name, $extension)
    {
        if (!file_exists($dirPath)) {
            $message = 'Folder for saving images does not exist :';
            throw new FileException($message, $dirPath);
        }

        $folderContent = scandir($dirPath);

        $fullName = $name . '.' . $extension;
        if (in_array($fullName, $folderContent)) {
            return false;
        }
        return true;
    }

    /**
     * Checks that all params are set properly
     * @throws ConfigurationException Thrown if an error in params is found
     */
    private function validateParams()
    {
        if (!isset($this->params['path']) || $this->params['path'] == '' || !file_exists($this->params['path'])) {
            throw new ConfigurationException('Path to store folder is not set');
        } elseif (!isset($this->params['allowedExtensions']) || !is_array($this->params['allowedExtensions'])) {
            throw new ConfigurationException('params[allowedExtensions] should be set as array');
        }
        return true;
    }
}

?>