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
        $loader = new \imageLoader\Loader();
        $url = "123ssaa";

        $response = $loader->getimg($url, 'test');

        $this->assertFalse($response['success']);
    }


    /**
     * False should be returned in $response['success'] if url is unavailable
     */
    public function testGetImgReturnsFalseOnUnavailableUrl()
    {
        $loader = new \imageLoader\Loader();
        $url = "https://en.wikipedia.org/static/images/project-logos/";

        $response = $loader->getimg($url, 'test');

        $this->assertFalse($response['success']);
    }


    /**
     * False should be returned in $response['success'] if url does not contain only image
     */
    public function testGetImgReturnsFalseOnInvalidUrlContent()
    {
        $loader = new \imageLoader\Loader();
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
        fopen("images/LongHardNameNoOneEverGoingToUse.png", "w");

        $loader = new \imageLoader\Loader();

        $url = "https://en.wikipedia.org/static/images/project-logos/enwiki.png";

        $response = $loader->getimg($url, 'LongHardNameNoOneEverGoingToUse');

        $this->assertFalse($response['success']);

        unlink('images/LongHardNameNoOneEverGoingToUse.png');
    }


    /**
     * True should be returned in $response['success']
     * if url is valid
     */
    public function testGetImgReturnsTrueOnValidUrl()
    {
        $loader = new \imageLoader\Loader();
        $url = "https://en.wikipedia.org/static/images/project-logos/enwiki.png";

        $response = $loader->getimg($url, 'LongHardNameNoOneEverGoingToUse2');

        $this->assertTrue($response['success']);

        unlink('images/LongHardNameNoOneEverGoingToUse2.png');
    }


    /**
     * Image should exist in file system after downloading
     */
    public function testGetImgSavesImageOnFileSystem()
    {

        $loader = new \imageLoader\Loader();

        $url = "https://en.wikipedia.org/static/images/project-logos/enwiki.png";

        $response = $loader->getimg($url, 'LongHardNameNoOneEverGoingToUse');

        $this->assertTrue(file_exists($response['imgPath']));

        unlink('images/LongHardNameNoOneEverGoingToUse.png');
    }

}