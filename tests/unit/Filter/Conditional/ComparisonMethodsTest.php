<?php

/**
 * Comparison methods test case
 *
 * @package   Test\Slick\ImageCache\Filter\Conditional
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Filter\Conditional;

use CodeGuy;
use Codeception\TestCase\Test;
use Slick\ImageCache\Filter\Conditional\ComparisonMethods;

/**
 * Comparison methods test case
 *
 * @package   Test\Slick\ImageCache\Filter\Conditional
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class ComparisonMethodsTest extends Test
{
    /**
     * @var CodeGuy
     */
    protected $codeGuy;

    /**
     * Load methods trait
     */
    use ComparisonMethods;

    /**
     * Check if tow values are equal
     * @test
     */
    public function validateEquality()
    {

        $this->assertTrue($this->isEqual(1, 1));
        $this->assertFalse($this->isEqual(1, 0));
    }

    /**
     * Check if tow values are equal
     * @test
     */
    public function validateNotEquality()
    {

        $this->assertTrue($this->isNotEqual(1, 0));
        $this->assertFalse($this->isNotEqual(1, 1));
    }

    /**
     * check higher then method
     * @test
     */
    public function checkHigherThenMethod()
    {
        $this->assertTrue($this->isHigherThen(1, 0));
        $this->assertFalse($this->isHigherThen(1, 1));
    }

    /**
     * check higher then equal method
     * @test
     */
    public function checkHigherThenEqual()
    {
        $this->assertTrue($this->isHigherThenEqual(1, 0));
        $this->assertTrue($this->isHigherThenEqual(1, 1));
        $this->assertFalse($this->isHigherThenEqual(1, 2));
    }

    /**
     * check Lower then method
     * @test
     */
    public function checkLowerThenMethod()
    {
        $this->assertTrue($this->isLowerThen(1, 2));
        $this->assertFalse($this->isLowerThen(1, 1));
    }

    /**
     * check Lower then equal method
     * @test
     */
    public function checkLowerThenEqual()
    {
        $this->assertTrue($this->isLowerThenEqual(1, 2));
        $this->assertTrue($this->isLowerThenEqual(1, 1));
        $this->assertFalse($this->isLowerThenEqual(1, 0));
    }
}