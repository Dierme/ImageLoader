<?php

namespace ImageLoader\exceptions;

/**
 * Class UrlException
 * Custom exception which signalize that there is a problem with a url
 *
 * @package ImageLoader\exceptions
 */
class UrlException extends \Exception{
    /**
    * Image url
    * @var $url
    */
    private $url;

    /**
     * UrlException constructor.
     * @param string $message       Exception message
     * @param int $url              Image url
     */
    public function __construct($message, $url){
        \Exception::__construct($message.' '.$url);
        $this->url = $url;
    }
    /**
     * Returns image url
     *
    * @return $url
    */
    public function getUrl()
    {
        return $this->url;
    }
}