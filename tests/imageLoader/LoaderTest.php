<?php

use PHPUnit\Framework\TestCase;

/**
 * Class LoaderTest
 *
 * Test functionality if Loader class
 */
class LoaderTest extends TestCase{

    /**
     * False should be returned in $response['success'] if url is invalid
     */
    public function testGetImgReturnsFalseOnInvalidUrl()
    {
        $loader = new dierme\loader\Loader();
        $url = "123ssaa";

        $response = $loader->getimg($url, 'test');

        $this->assertFalse($response['success']);
    }


    /**
     * False should be returned in $response['success'] if url is unavailable
     */
    public function testGetImgReturnsFalseOnUnavailableUrl()
    {
        $loader = new dierme\loader\Loader();
        $url = "https://en.wikipedia.org/static/images/project-logos/";

        $response = $loader->getimg($url, 'test');

        $this->assertFalse($response['success']);
    }


    /**
     * False should be returned in $response['success'] if url does not contain only image
     */
    public function testGetImgReturnsFalseOnInvalidUrlContent()
    {
        $loader = new \dierme\loader\Loader();
        $url = "https://www.facebook.com/";

        $response = $loader->getimg($url, 'test');

        $this->assertFalse($response['success']);
    }


    /**
     * False should be returned in $response['success']
     * if an image with similar name already exists in folder
     */
    public function testGetImgReturnsFalseIfImgNameExists()
    {
        $path = __DIR__.'/images';
        $fileName = 'LongHardNameNoOneEverGoingToUse';
        mkdir($path, 777);
        fopen("$path/$fileName.png", "w");


        $loader = new \dierme\loader\Loader();
        $loader->setPath($path);

        $url = "https://en.wikipedia.org/static/images/project-logos/enwiki.png";

        $response = $loader->getimg($url, $fileName);

        $this->assertFalse($response['success']);

        unlink("$path/$fileName.png");
        rmdir($path);
    }


    /**
     * True should be returned in $response['success'] and file should exist in FS
     * if url is valid
     */
    public function testGetImgReturnsTrueOnValidUrl()
    {
        $path = __DIR__.'/images';
        $fileName = 'LongHardNameNoOneEverGoingToUse';
        mkdir($path, 777);

        $loader = new \dierme\loader\Loader();
        $loader->setPath($path);
        $url = "https://en.wikipedia.org/static/images/project-logos/enwiki.png";

        $response = $loader->getimg($url, $fileName);

        $this->assertTrue($response['success']);
        $this->assertTrue(file_exists($response['imgPath']));

        unlink("$path/$fileName.png");
        rmdir($path);
    }

}