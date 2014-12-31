<?php

/**
 * Add image filter test case
 *
 * @package   Test\Slick\ImageCache\Filter\AddImage
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Filter;

use CodeGuy;
use Imagine\Image\Color;
use Imagine\Image\Point;
use Slick\ImageCache\Image;
use Codeception\TestCase\Test;
use Slick\ImageCache\Filter\AddImage;
use Slick\ImageCache\Filter\ResizeAndTrim;

/**
 * Add image filter test case
 *
 * @package   Test\Slick\ImageCache\Filter\AddImage
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class AddImageTest extends Test
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
     * Add image in center right middle
     *
     * @test
     */
    public function addCenterMiddle()
    {
        $crop = new ResizeAndTrim([
            'image' => $this->image,
            'width' => 267,
            'height' => 150
        ]);
        $image = $crop->applyFilter();
        $path = dirname(dirname(__DIR__));
        $file = $path .'/_data/play_normal.png';

        $addImage = new AddImage([
            'path' => $file,
            'image' => $image,
            'verticalAlign' => AddImage::MIDDLE,
            'horizontalAlign' => AddImage::CENTER
        ]);
        $destination = $addImage->applyFilter();
        $color = new Color([200, 206, 209], 0);
        $this->assertEquals(
            $color,
            $destination->getResourceImage()
                ->getColorAt(new Point(133, 76))
        );
    }
}