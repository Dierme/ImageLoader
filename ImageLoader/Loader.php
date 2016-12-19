<?php

namespace dierme\loader\ImageLoader;

use dierme\loader\ImageLoader\exceptions\UrlException;
use dierme\loader\ImageLoader\exceptions\FileException;

/**
 * Class Loader
 * @package ImageLoader
 *
 * Encapsulates main logic of the project.
 * Contains filters for Url, downloads image, saves image.
 */
class Loader{
    /**
     * @var array $params        contains main configs
     */
    protected $params;

    function __construct(){
        $this->params = require(__DIR__ . '/config/params.php');
    }


    /**
     * Applies url filters, downloads and saves image
     *
     * @param string $url          An image url
     * @param string $fileName     Name, with which downloaded file will be saved
     * @return array
     *             ['success']     True, if downloaded and saved successfully
     *             ['message']     Contains exception description if it occurs.
     *             ['imagePath']   Path in file system to saved image
     */
    public function getimg($url, $fileName){
        $response = array();
        try{
            $this->urlValid($url);
            $this->urlAvailable($url);
            $this->urlContentValid($url);
            $this->imageNameNotExists($fileName, $this->getImgExtension($url));
        }
        catch (UrlException $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
            $response['imagePath'] = '';
            return $response;
        }
        catch (FileException $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
            $response['imagePath'] = '';
            return $response;
        }

        $imagePath = $this->params['path'].'/'.$fileName.'.'.$this->getImgExtension($url);
        $file = fopen($imagePath, 'wb');

        $headers[] = 'Accept: image/gif, image/png, image/jpeg';
        $headers[] = 'Connection: close';
        $headers[] = 'Content-type: image;charset=UTF-8';
        $userAgent = 'php';
        $process = curl_init($url);
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

        try{
            $this->checkImageSavedInFileSystem($imagePath);
        }
        catch (FileException $e){
            $response['success'] = false;
            $response['message'] = $e->getMessage();
            $response['imagePath'] = '';
            return $response;
        }

        $response['success'] = true;
        $response['message'] = '';
        $response['imgPath'] = $imagePath;
        return $response;
    }


    /**
     * Checks if given Url is accessible and responds with code 200.
     *
     * @param $url              An image url
     * @return bool             returned if response code
     * @throws UrlException     throws exception is url response is not 200
     */
    private function urlAvailable($url){
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($retcode != 200){
            $message = 'Url is not available';
            throw new UrlException($message, $url);
        }

        return true;
    }


    /**
     * Checks if Url syntax is valid
     *
     * @param $url              An image url
     * @return bool             returned if syntax is OK
     * @throws UrlException     thrown if syntax is not valid
     */
    private function urlValid($url){
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            $message = 'Url is not valid';
            throw new UrlException($message,$url);
        }
        return true;
    }


    /**
     * Checks is content of specified url is an image
     *
     * @param $url              An image url
     * @return bool             returned if content is image of determined extensions
     * @throws UrlException     thrown if content did not pass validation
     */
    private function urlContentValid($url){
        $imageInfo = getimagesize($url);

        if(!$imageInfo){
            $message = 'Url does not contain an image';
            throw new UrlException($message, $url);
        }

        if(!in_array($imageInfo['mime'], $this->params['allowedExtensions'])){
            $message = 'Url extension is not allowed';
            throw new UrlException($message, $url);
        }
        return true;
    }


    /**
     * Checks if folder contains file with $name.$extension
     *
     * @param $name                 A name for a new image file
     * @param $extension            An extension for a new image file
     * @return bool                 true, if file name does not exist
     * @throws FileException        throw, if file name exists
     */
    private function imageNameNotExists($name, $extension){
        $folderContent = scandir($this->params['path']);
        $fullName = $name.'.'.$extension;
        if(in_array($fullName, $folderContent)){
            $message = 'File already exists :';
            throw new FileException($message, $fullName);
        }
        return true;
    }


    /**
     * Checks if after download image exists in file system
     *
     * @param $imgPath          Path to the image
     * @return bool             true, if image exists
     * @throws FileException    thrown if image does not exist
     */
    private function checkImageSavedInFileSystem($imgPath){
        if(!file_exists($imgPath)){
            $message = 'File was not saved';
            throw new FileException($message, $imgPath);
        }
        return true;
    }

    /**
     * Gets extension of file using specified $path
     *
     * @param $path         Location of a file
     * @return string       Extension of a file
     */
    private function getImgExtension($path){
        $imageInfo = getimagesize($path);
        $stringPieces = explode('/', $imageInfo['mime']);
        return $stringPieces[1];
    }
}
?>