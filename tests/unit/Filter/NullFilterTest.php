<?php

/**
 * Null filter test case
 *
 * @package   Test\Slick\ImageCache\Filter\ConditionalFilter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Filter;

use CodeGuy;
use Codeception\TestCase\Test;
use Slick\ImageCache\Filter\NullFilter;
use Slick\ImageCache\Image;

/**
 * Null filter test case
 *
 * @package   Test\Slick\ImageCache\Filter\ConditionalFilter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class NullFilterTest extends Test
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
     * Filter with null filter: no changes
     * @test
     */
    public function filterWithNullFilter()
    {
        $nullFilter = new NullFilter([
            'image' => $this->image
        ]);
        $image = $nullFilter->applyFilter();
        $this->assertEquals(
            $this->image->getResourceImage()->getSize(),
            $image->getResourceImage()->getSize()
        );
    }
}