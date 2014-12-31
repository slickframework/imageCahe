<?php

/**
 * Comparison utility methods
 *
 * @package   Slick\ImageCache\Filter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Slick\ImageCache\Filter\Conditional;

/**
 * Comparison utility methods
 *
 * @package   Slick\ImageCache\Filter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
trait ComparisonMethods
{

    /**
     * Compares tow values if they are equal
     *
     * @param mixed $value
     * @param mixed $compare
     *
     * @return bool
     */
    public function isEqual($value, $compare)
    {
        return $value == $compare;
    }

    /**
     * Compares tow values if they are not equal
     *
     * @param mixed $value
     * @param mixed $compare
     *
     * @return bool
     */
    public function isNotEqual($value, $compare)
    {
        return $value != $compare;
    }

    /**
     * Check if value is higher then compare value
     *
     * @param mixed $value
     * @param mixed $compare
     *
     * @return bool
     */
    public function isHigherThen($value, $compare)
    {
        return $value > $compare;
    }

    /**
     * Check if value is higher then equals compare value
     *
     * @param mixed $value
     * @param mixed $compare
     *
     * @return bool
     */
    public function isHigherThenEqual($value, $compare)
    {
        return $value >= $compare;
    }

    /**
     * Check if value is lower then compare value
     *
     * @param mixed $value
     * @param mixed $compare
     *
     * @return bool
     */
    public function isLowerThen($value, $compare)
    {
        return $value < $compare;
    }

    /**
     * Check if value is lower then equals compare value
     *
     * @param mixed $value
     * @param mixed $compare
     *
     * @return bool
     */
    public function isLowerThenEqual($value, $compare)
    {
        return $value <= $compare;
    }
}