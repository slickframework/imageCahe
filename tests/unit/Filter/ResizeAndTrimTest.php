<?php

/**
 * Resize and trim filter test case
 *
 * @package Test\Slick\ImageCache\Filter\Resize
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Filter;

use CodeGuy;
use Codeception\Util\Stub;
use Codeception\TestCase\Test;
use Slick\ImageCache\Filter\ResizeAndTrim;
use Slick\ImageCache\Image;

/**
 * Resize and trim filter test case
 *
 * @package Test\Slick\ImageCache\Filter\Resize
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class ResizeAndTrimTest extends Test
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
     * Runs before each test
     */
    protected function _before()
    {
        parent::_before();
        $path = dirname(dirname(__DIR__));
        $file = $path .'/_data/portrait.jpg';
        $this->image = new Image($file);
    }

    /**
     * Cleans everything for the next test
     */
    protected function _after()
    {
        unset($this->image);
        parent::_after();
    }

    /**
     * Resize and trim an image
     * @test
     */
    public function resizeAndTrimAnImage()
    {
        $resize = new ResizeAndTrim([
            'image' => $this->image,
            'height' => 400,
            'width' => 400,
            'proportional' => true
        ]);
        $image = $resize->applyFilter();
        $box = $image->getResourceImage()->getSize();
        $this->assertEquals(400, $box->getHeight());
        $this->assertEquals(400, $box->getWidth());
    }

    /**
     * Resize and trim an image
     * @test
     */
    public function resizeAndTrimAnImageLandscape()
    {
        $path = dirname(dirname(__DIR__));
        $file = $path .'/_data/test.jpg';
        $this->image = new Image($file);
        $resize = new ResizeAndTrim([
            'image' => $this->image,
            'height' => 100,
            'width' => 100,
            'proportional' => true
        ]);
        $image = $resize->applyFilter();
        $box = $image->getResourceImage()->getSize();
        $this->assertEquals(100, $box->getHeight());
        $this->assertEquals(100, $box->getWidth());
    }

}