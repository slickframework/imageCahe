<?php

/**
 * Crop filter test case
 *
 * @package   Test\Slick\ImageCache\Filter\Resize
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Filter;

use CodeGuy;
use Codeception\Util\Stub;
use Imagine\Image\Color;
use Imagine\Image\Point;
use Slick\ImageCache\Filter\Crop;
use Slick\ImageCache\Image;
use Codeception\TestCase\Test;

/**
 * Crop filter test case
 *
 * @package   Test\Slick\ImageCache\Filter\Resize
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class CropTest extends Test
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
        $file = $path .'/_data/crop-master.png';
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
     * Crop image in bottom right position
     *
     * @test
     */
    public function cropBottomRight()
    {
        $crop = new Crop([
            'image' => $this->image,
            'width' => 100,
            'height' => 100,
            'horizontalAlign' => Crop::RIGHT,
            'verticalAlign' => Crop::BOTTOM
        ]);
        $image = $crop->applyFilter();
        $size = $image->getResourceImage()->getSize();
        $this->assertEquals(100, $size->getHeight());
        $this->assertEquals(100, $size->getWidth());
        $color = new Color([255, 255, 255], 0);
        $this->assertEquals(
            $color,
            $image->getResourceImage()->getColorAt(new Point(10, 10))
        );
    }

    /**
     * Crop image in bottom right position
     *
     * @test
     */
    public function cropTopLeft()
    {
        $crop = new Crop([
            'image' => $this->image,
            'width' => 100,
            'height' => 100,
            'horizontalAlign' => Crop::LEFT,
            'verticalAlign' => Crop::TOP
        ]);
        $image = $crop->applyFilter();
        $size = $image->getResourceImage()->getSize();
        $this->assertEquals(100, $size->getHeight());
        $this->assertEquals(100, $size->getWidth());
        $color = new Color([0, 0, 0], 0);
        $this->assertEquals(
            $color,
            $image->getResourceImage()->getColorAt(new Point(10, 10))
        );
    }

    /**
     * Crop image in top center position
     *
     * @test
     */
    public function cropTopCenter()
    {
        $crop = new Crop([
            'image' => $this->image,
            'width' => 100,
            'height' => 100,
            'horizontalAlign' => Crop::CENTER,
            'verticalAlign' => Crop::TOP
        ]);
        $image = $crop->applyFilter();
        $size = $image->getResourceImage()->getSize();
        $this->assertEquals(100, $size->getHeight());
        $this->assertEquals(100, $size->getWidth());
        $color = new Color('e52d15', 0);
        $this->assertEquals(
            $color,
            $image->getResourceImage()->getColorAt(new Point(10, 10))
        );
    }

    /**
     * Crop image in top right position
     *
     * @test
     */
    public function cropTopRight()
    {
        $crop = new Crop([
            'image' => $this->image,
            'width' => 100,
            'height' => 100,
            'horizontalAlign' => Crop::RIGHT,
            'verticalAlign' => Crop::TOP
        ]);
        $image = $crop->applyFilter();
        $size = $image->getResourceImage()->getSize();
        $this->assertEquals(100, $size->getHeight());
        $this->assertEquals(100, $size->getWidth());
        $color = new Color('f7ed79', 0);
        $this->assertEquals(
            $color,
            $image->getResourceImage()->getColorAt(new Point(10, 10))
        );
    }

    /**
     * Crop image in middle left position
     *
     * @test
     */
    public function cropMiddleLeft()
    {
        $crop = new Crop([
            'image' => $this->image,
            'width' => 100,
            'height' => 100,
            'horizontalAlign' => Crop::LEFT,
            'verticalAlign' => Crop::MIDDLE
        ]);
        $image = $crop->applyFilter();
        $size = $image->getResourceImage()->getSize();
        $this->assertEquals(100, $size->getHeight());
        $this->assertEquals(100, $size->getWidth());
        $color = new Color('4ea052', 0);
        $this->assertEquals(
            $color,
            $image->getResourceImage()->getColorAt(new Point(10, 10))
        );
    }

    /**
     * Crop image in center middle position
     *
     * @test
     */
    public function cropCenterMiddle()
    {
        $crop = new Crop([
            'image' => $this->image,
            'width' => 100,
            'height' => 100,
            'horizontalAlign' => Crop::CENTER,
            'verticalAlign' => Crop::MIDDLE
        ]);
        $image = $crop->applyFilter();
        $size = $image->getResourceImage()->getSize();
        $this->assertEquals(100, $size->getHeight());
        $this->assertEquals(100, $size->getWidth());
        $color = new Color('17ece4', 0);
        $this->assertEquals(
            $color,
            $image->getResourceImage()->getColorAt(new Point(10, 10))
        );
    }

    /**
     * Crop image in right middle position
     *
     * @test
     */
    public function cropRightMiddle()
    {
        $crop = new Crop([
            'image' => $this->image,
            'width' => 100,
            'height' => 100,
            'horizontalAlign' => Crop::RIGHT,
            'verticalAlign' => Crop::MIDDLE
        ]);
        $image = $crop->applyFilter();
        $size = $image->getResourceImage()->getSize();
        $this->assertEquals(100, $size->getHeight());
        $this->assertEquals(100, $size->getWidth());
        $color = new Color('034ed7', 0);
        $this->assertEquals(
            $color,
            $image->getResourceImage()->getColorAt(new Point(10, 10))
        );
    }

    /**
     * Crop image in right bottom position
     *
     * @test
     */
    public function cropLeftBottom()
    {
        $crop = new Crop([
            'image' => $this->image,
            'width' => 100,
            'height' => 100,
            'horizontalAlign' => Crop::LEFT,
            'verticalAlign' => Crop::BOTTOM
        ]);
        $image = $crop->applyFilter();
        $size = $image->getResourceImage()->getSize();
        $this->assertEquals(100, $size->getHeight());
        $this->assertEquals(100, $size->getWidth());
        $color = new Color('6e1aec', 0);
        $this->assertEquals(
            $color,
            $image->getResourceImage()->getColorAt(new Point(10, 10))
        );
    }

    /**
     * Crop image in center bottom position
     *
     * @test
     */
    public function cropCenterBottom()
    {
        $crop = new Crop([
            'image' => $this->image,
            'width' => 100,
            'height' => 100,
            'horizontalAlign' => Crop::CENTER,
            'verticalAlign' => Crop::BOTTOM
        ]);
        $image = $crop->applyFilter();
        $size = $image->getResourceImage()->getSize();
        $this->assertEquals(100, $size->getHeight());
        $this->assertEquals(100, $size->getWidth());
        $color = new Color('d70caa', 0);
        $this->assertEquals(
            $color,
            $image->getResourceImage()->getColorAt(new Point(10, 10))
        );
    }

    /**
     * Crop bigger then the real image
     *
     * @test
     */
    public function cropBiggerCrop()
    {
        $crop = new Crop([
            'image' => $this->image,
            'width' => 400,
            'height' => 400,
            'horizontalAlign' => Crop::CENTER,
            'verticalAlign' => Crop::BOTTOM
        ]);
        $image = $crop->applyFilter();
        $size = $image->getResourceImage()->getSize();
        $this->assertEquals(300, $size->getHeight());
        $this->assertEquals(300, $size->getWidth());
        $color = new Color('000000', 0);
        $this->assertEquals(
            $color,
            $image->getResourceImage()->getColorAt(new Point(10, 10))
        );
    }

    /**
     * Crop by given a start point
     *
     * @test
     */
    public function cropWithStartPoint()
    {
        $crop = new Crop([
            'image' => $this->image,
            'width' => 150,
            'height' => 150,
            'point' => [150, 150]
        ]);
        $image = $crop->applyFilter();
        $size = $image->getResourceImage()->getSize();
        $this->assertEquals(150, $size->getHeight());
        $this->assertEquals(150, $size->getWidth());
        $color = new Color('17ece4', 0);
        $this->assertEquals(
            $color,
            $image->getResourceImage()->getColorAt(new Point(10, 10))
        );
    }
}