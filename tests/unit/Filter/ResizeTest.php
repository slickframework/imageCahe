<?php

/**
 * Resize filter test case
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
use Slick\ImageCache\Image;
use Codeception\TestCase\Test;
use Slick\ImageCache\Filter\Resize;

/**
 * Resize filter test case
 *
 * @package Test\Slick\ImageCache\Filter\Resize
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class ResizeTest extends Test
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
     * Try to crate a resize filter
     * @test
     */
    public function crateResizeFilter()
    {
        $resize = new Resize();
        $this->assertInstanceOf('Slick\ImageCache\FilterInterface', $resize);
        $this->assertInstanceOf(
            'Slick\ImageCache\Filter\Resize',
            $resize->setImage($this->image)
        );
    }

    /**
     * Resizing with width only
     * @test
     */
    public function resizeImageWithWidth()
    {
        $resize = new Resize([
            'image' => $this->image,
            'width' => 45
        ]);
        $image = $resize->applyFilter();
        $box = $image->getResourceImage()->getSize();
        $this->assertEquals(45, $box->getWidth());
        $this->assertEquals(52, $box->getHeight());
    }

    /**
     * Resizing with height only
     * @test
     */
    public function resizeImageWithHeight()
    {
        $resize = new Resize([
            'image' => $this->image,
            'height' => 100
        ]);
        $image = $resize->applyFilter();
        $box = $image->getResourceImage()->getSize();
        $this->assertEquals(100, $box->getHeight());
        $this->assertEquals(86, $box->getWidth());
    }

    /**
     * Resizing without proportional calculation
     * @test
     */
    public function resizeWithoutProportionalCalculation()
    {
        $resize = new Resize([
            'image' => $this->image,
            'height' => 100,
            'width' => 100,
            'proportional' => false
        ]);
        $image = $resize->applyFilter();
        $box = $image->getResourceImage()->getSize();
        $this->assertEquals(100, $box->getHeight());
        $this->assertEquals(100, $box->getWidth());
    }

    /**
     * Resizing proportional portrait image
     * @test
     */
    public function resizingProportionalPortrait()
    {
        $resize = new Resize([
            'image' => $this->image,
            'height' => 400,
            'width' => 300,
            'proportional' => true
        ]);
        $image = $resize->applyFilter();
        $box = $image->getResourceImage()->getSize();
        $this->assertEquals(400, $box->getHeight());
        $this->assertEquals(344, $box->getWidth());
    }

    /**
     * Resizing proportional landscape image
     * @test
     */
    public function resizingProportionalLandscape()
    {
        $path = dirname(dirname(__DIR__));
        $file = $path .'/_data/test.jpg';
        $this->image = new Image($file);
        $resize = new Resize([
            'image' => $this->image,
            'height' => 100,
            'width' => 70,
            'proportional' => true
        ]);
        $image = $resize->applyFilter();
        $box = $image->getResourceImage()->getSize();
        $this->assertEquals(100, $box->getHeight());
        $this->assertEquals(177, $box->getWidth());
    }
}