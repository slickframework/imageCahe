<?php

/**
 * Sign author name filter test case
 *
 * @package   Test\Slick\ImageCache\Filter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Filter;

use CodeGuy;
use Codeception\TestCase\Test;
use Imagine\Image\Color;
use Imagine\Image\Point;
use Slick\ImageCache\Filter\Resize;
use Slick\ImageCache\Filter\ResizeAndTrim;
use Slick\ImageCache\Filter\Sign;
use Slick\ImageCache\Image;

/**
 * Sign author name filter test case
 *
 * @package    Test\Slick\ImageCache\Filter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class SignTest extends Test
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
     * Sign an image
     * @test
     */
    public function SignAnImage()
    {
        $this->image->setAuthor('Slick framework image cache');
        $resize = new Resize([
            'image' => $this->image,
            'height' => 400
        ]);
        $image = $resize->applyFilter();
        $sign = new Sign([
            'image' => $image,
            'horizontalAlign' => Sign::LEFT,
            'verticalAlign' => Sign::TOP
        ]);
        $image = $sign->applyFilter();
        $color = new Color([255, 255, 255], 0);
        $this->assertEquals(
            $color,
            $image->getResourceImage()->getColorAt(new Point(44, 10))
        );
    }
}