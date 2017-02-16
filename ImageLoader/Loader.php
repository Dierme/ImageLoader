<?php

namespace dierme\loader;

use dierme\loader\exceptions\UrlException;
use dierme\loader\exceptions\FileException;
use dierme\loader\models\UrlModel;

/**
 * Class Loader
 * @package ImageLoader
 *
 * Encapsulates main logic of the project.
 * Contains filters for Url, downloads image, saves image.
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
        if ($urlModel->validate()) {
            print ('validated');
        }
        else{
            print ('not validated');
        }
    }

//
//    /**
//     * Applies url filters, downloads and saves image
//     *
//     * @param string $url An image url
//     * @param string $fileName Name, with which downloaded file will be saved
//     * @return array
//     *             ['success']     True, if downloaded and saved successfully
//     *             ['message']     Contains exception description if it occurs.
//     *             ['imagePath']   Path in file system to saved image
//     */
//    public function getimg($url, $fileName)
//    {
//        $response = array();
//        try {
//            $this->urlValid($url);
//            $this->urlAvailable($url);
//            $this->urlContentValid($url);
//            $this->imageNameNotExists($fileName, $this->getImgExtension($url));
//        } catch (UrlException $e) {
//            $response['success'] = false;
//            $response['message'] = $e->getMessage();
//            $response['imagePath'] = '';
//            return $response;
//        } catch (FileException $e) {
//            $response['success'] = false;
//            $response['message'] = $e->getMessage();
//            $response['imagePath'] = '';
//            return $response;
//        }
//
//        $imagePath = $this->params['path'] . '/' . $fileName . '.' . $this->getImgExtension($url);
//        $file = fopen($imagePath, 'wb');
//
//        $headers[] = 'Accept: image/gif, image/png, image/jpeg';
//        $headers[] = 'Connection: close';
//        $headers[] = 'Content-type: image;charset=UTF-8';
//        $userAgent = 'php';
//        $process = curl_init($url);
//        curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($process, CURLOPT_HEADER, 0);
//        curl_setopt($process, CURLOPT_USERAGENT, $userAgent);
//        curl_setopt($process, CURLOPT_TIMEOUT, 30);
//        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
//        curl_setopt($process, CURLOPT_FILE, $file);
//
//        curl_exec($process);
//        curl_close($process);
//        fclose($file);
//
//        try {
//            $this->checkImageSavedInFileSystem($imagePath);
//        } catch (FileException $e) {
//            $response['success'] = false;
//            $response['message'] = $e->getMessage();
//            $response['imagePath'] = '';
//            return $response;
//        }
//
//        $response['success'] = true;
//        $response['message'] = '';
//        $response['imgPath'] = $imagePath;
//        return $response;
//    }
//
//
//    /**
//     * Checks is content of specified url is an image
//     *
//     * @param $url              An image url
//     * @return bool             returned if content is image of determined extensions
//     * @throws UrlException     thrown if content did not pass validation
//     */
//    private function urlContentValid($url)
//    {
//        $imageInfo = getimagesize($url);
//
//        if (!$imageInfo) {
//            $message = 'Url does not contain an image';
//            throw new UrlException($message, $url);
//        }
//
//        if (!in_array($imageInfo['mime'], $this->params['allowedExtensions'])) {
//            $message = 'Url extension is not allowed';
//            throw new UrlException($message, $url);
//        }
//        return true;
//    }
//
//
//    /**
//     * Checks if folder contains file with $name.$extension
//     *
//     * @param $name                 A name for a new image file
//     * @param $extension            An extension for a new image file
//     * @return bool                 true, if file name does not exist
//     * @throws FileException        throw, if file name exists
//     */
//    private function imageNameNotExists($name, $extension)
//    {
//        if (!file_exists($this->params['path'])) {
//            $message = 'Folder for saving images does not exist :';
//            throw new FileException($message, $this->params['path']);
//        }
//
//        $folderContent = scandir($this->params['path']);
//
//        $fullName = $name . '.' . $extension;
//        if (in_array($fullName, $folderContent)) {
//            $message = 'File already exists :';
//            throw new FileException($message, $fullName);
//        }
//        return true;
//    }
//
//
//    /**
//     * Checks if after download image exists in file system
//     *
//     * @param $imgPath          Path to the image
//     * @return bool             true, if image exists
//     * @throws FileException    thrown if image does not exist
//     */
//    private function checkImageSavedInFileSystem($imgPath)
//    {
//        if (!file_exists($imgPath)) {
//            $message = 'File was not saved';
//            throw new FileException($message, $imgPath);
//        }
//        return true;
//    }
//
//    /**
//     * Gets extension of file using specified $path
//     *
//     * @param $path         Location of a file
//     * @return string       Extension of a file
//     */
//    private function getImgExtension($path)
//    {
//        $imageInfo = getimagesize($path);
//        $stringPieces = explode('/', $imageInfo['mime']);
//        return $stringPieces[1];
//    }
//
//
//    /**
//     * Sets path to folder, where images are saved
//     * Mainly for tests purposes
//     *
//     * @return string
//     */
//    public function setPath($path)
//    {
//        $this->params['path'] = $path;
//        return $this->validateParams();
//    }
//
//    /**
//     * Checks that all params are set properly
//     *
//     * @throws \Exception       Thrown if an error in params is found
//     */
//    private function validateParams()
//    {
//        if (!isset($this->params['path']) || $this->params['path'] == '' || !file_exists($this->params['path'])) {
//            throw new \Exception('Path to store folder is not set');
//        } elseif (!isset($this->params['allowedExtensions']) || !is_array($this->params['allowedExtensions'])) {
//            throw new \Exception('params[allowedExtensions] should be set as array');
//        }
//        return true;
//    }
}

?>