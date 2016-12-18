<?php

namespace imageLoader\exceptions;

/**
 * Class FileException
 * Custom exceptions which signalize that there is an issue with specific file
 *
 * @package imageLoader\exceptions
 */
class FileException extends \Exception{
    /**
     * File name
     * @var $name
     */
    private $name;

    /**
     * NameException constructor.
     * @param string $message       The exception message
     * @param int $name             File name
     */
    public function __construct($message, $name){
        \Exception::__construct($message.' '.$name);
        $this->$name = $name;
    }
    /**
     * Returns file name
     *
     * @return $name
     */
    public function getName()
    {
        return $this->name;
    }
}