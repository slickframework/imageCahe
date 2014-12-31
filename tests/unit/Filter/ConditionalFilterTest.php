<?php

/**
 * Conditional filter test case
 *
 * @package   Test\Slick\ImageCache\Filter\ConditionalFilter
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
use Slick\ImageCache\Filter\Crop;
use Slick\ImageCache\Filter\NullFilter;
use Slick\ImageCache\Filter\ConditionalFilter;

/**
 * Conditional filter test case
 *
 * @package   Test\Slick\ImageCache\Filter\ConditionalFilter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class ConditionalFilterTest extends Test
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
        $file = $path .'/_data/test.jpg';
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
     * Conditional chain validation
     * @test
     */
    public function validateConditionsChain()
    {
        $conditional = new ConditionalFilter([
            'image' => $this->image,
            'condition' => [
                ConditionalFilter::IS_EQUAL => [
                    ConditionalFilter::COND_ORIENTATION,
                    ConditionalFilter::ORIENTATION_LANDSCAPE
                ],
                ConditionalFilter::IS_NOT_EQUAL => [
                    ConditionalFilter::COND_WIDTH,
                    0
                ],
                ConditionalFilter::IS_EQUAL => [
                    ConditionalFilter::COND_HEIGHT,
                    $this->image->getResourceImage()->getSize()->getHeight()
                ]
            ]
        ]);
        $this->assertTrue($conditional->checkCondition());
        $this->assertTrue($conditional->getPositiveFilter() instanceof NullFilter);
        $this->assertTrue($conditional->getNegativeFilter() instanceof NullFilter);
        $this->assertEquals(
            ConditionalFilter::ORIENTATION_LANDSCAPE,
            $conditional->get(ConditionalFilter::COND_ORIENTATION)
        );
    }

    /**
     * Try to apply the negative filter to the image
     * @test
     */
    public function useNegativeFilter()
    {
        $path = dirname(dirname(__DIR__));
        $file = $path .'/_data/crop-master.png';
        $this->image = new Image($file);

        $conditional = new ConditionalFilter([
            'image' => $this->image,
            'condition' => [
                ConditionalFilter::IS_EQUAL => [
                    ConditionalFilter::COND_ORIENTATION,
                    ConditionalFilter::ORIENTATION_LANDSCAPE
                ]
            ],
            'filters' => [
                'positive' => [
                    'class' => 'NullFilter',
                ],
                'negative' => [
                    'class' => 'Crop',
                    'image' => $this->image,
                    'width' => 100,
                    'height' => 100,
                    'horizontalAlign' => Crop::RIGHT,
                    'verticalAlign' => Crop::BOTTOM
                ]
            ]
        ]);
        $this->assertFalse($conditional->checkCondition());
        $image = $conditional->applyFilter();
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
     * Try to apply the positive filter to the image
     * @test
     */
    public function usePositiveFilter()
    {
        $path = dirname(dirname(__DIR__));
        $file = $path .'/_data/crop-master.png';
        $this->image = new Image($file);

        $conditional = new ConditionalFilter([
            'image' => $this->image,
            'condition' => [
                ConditionalFilter::IS_NOT_EQUAL => [
                    ConditionalFilter::COND_ORIENTATION,
                    ConditionalFilter::ORIENTATION_LANDSCAPE
                ]
            ],
            'filters' => [

                'positive' => [
                    'class' => 'Crop',
                    'image' => $this->image,
                    'width' => 100,
                    'height' => 100,
                    'horizontalAlign' => Crop::RIGHT,
                    'verticalAlign' => Crop::BOTTOM
                ],
                'negative' => [
                    'class' => 'NullFilter',
                ],
            ]
        ]);
        $this->assertTrue($conditional->checkCondition());
        $image = $conditional->applyFilter();
        $size = $image->getResourceImage()->getSize();
        $this->assertEquals(100, $size->getHeight());
        $this->assertEquals(100, $size->getWidth());
        $color = new Color([255, 255, 255], 0);
        $this->assertEquals(
            $color,
            $image->getResourceImage()->getColorAt(new Point(10, 10))
        );
    }
}