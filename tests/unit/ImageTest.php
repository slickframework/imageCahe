<?php

/**
 * Image test case
 *
 * @package Test\ImageCache\Image
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

use Slick\ImageCache\Image;
use Codeception\TestCase\Test;

/**
 * Image test case
 *
 * @package Test\ImageCache\Image
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class ImageTest extends Test
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy;

    /**
     * Trying to create an image from source file
     * @test
     */
    public function createAnImageFromFile()
    {
        $path = dirname(__DIR__);
        $file = $path .'/_data/test.png';
        $image = new Image($file);
        $this->assertInstanceOf('Slick\ImageCache\ImageInterface', $image);
        $this->assertInstanceOf(
            'Imagine\Image\ImageInterface',
            $image->getResourceImage()
        );
    }

}