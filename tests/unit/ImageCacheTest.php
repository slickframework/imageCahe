<?php

/**
 * ImageCache test case
 *
 * @package Test\ImageCache\Image
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

use Slick\ImageCache\Image;
use Slick\ImageCache\Profile;
use Codeception\TestCase\Test;
use Slick\ImageCache\ImageCache;
use Slick\ImageCache\Filter\Crop;

/**
 * ImageCache test case
 *
 * @package Test\ImageCache\Image
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class ImageCacheTest extends Test
{
   /**
    * @var CodeGuy
    */
    protected $codeGuy;

    /**
     * @var Image
     */
    protected $image;

    /**
     * @var ImageCache
     */
    protected $imageCache;

    /**
     * Runs before each test
     */
    protected function _before()
    {
        parent::_before();
        $config = [
            'path' => dirname(__DIR__).'/_data',
            'profiles' => [
                'thumb' => [
                    'filters' => [
                        'ResizeAndTrim' => [
                            'width' => 32,
                            'height' => 32
                        ],
                    ],
                    'imageType' => Profile::TYPE_PNG,
                    'quality' => 8
                ],
                'video' => [
                    'filters' => [
                        'Resize' => [
                            'width' => 680,
                            'height' => 300,
                            'proportional' => true
                        ],
                        'Crop' => [
                            'width' => 680,
                            'height' => 300,
                            'verticalAlign' => Crop::TOP,
                            'horizontalAlign' => Crop::CENTER
                        ]
                    ],
                    'imageType' => Profile::TYPE_PNG,
                    'quality' => 8
                ]
            ]
        ];
        $this->imageCache = new ImageCache($config);
        $this->image = new Image(dirname(__DIR__).'/_data/portrait.jpg');
    }

    /**
     * Cleanup before each test
     */
    protected function _after()
    {
        unset($this->imageCache);
        unset($this->image);
        parent::_after();
    }

    /**
     * Create an image from profile
     * @test
     */
    public function createImageFromProfile()
    {
        $this->assertSame($this->image, $this->imageCache->get('test', $this->image));
        $this->assertEquals('jpg', $this->image->getExtension());
        /** @var Image $image */
        $image = $this->imageCache->get('thumb', $this->image);
        $this->assertEquals('jpg', $image->getExtension());
        $this->assertEquals('image/png', $image->getContentType());
        $box = $image->getResourceImage()->getSize();
        $this->assertEquals(32, $box->getHeight());
        $this->assertEquals(32, $box->getWidth());
        $this->codeGuy->seeFileFound('portrait.png', dirname(__DIR__).'/_data/thumb');
        $this->codeGuy->deleteDir(dirname(__DIR__).'/_data/thumb');
    }

    /**
     * Creates full profile stack for an image
     * @test
     */
    public function createFullProfileStackForAnImage()
    {
        $this->imageCache->processImage($this->image);
        $this->codeGuy->seeFileFound('portrait.png', dirname(__DIR__).'/_data/thumb');
        $this->codeGuy->seeFileFound('portrait.png', dirname(__DIR__).'/_data/video');
        $this->codeGuy->deleteDir(dirname(__DIR__).'/_data/thumb');
        $this->codeGuy->deleteDir(dirname(__DIR__).'/_data/video');
    }
}
