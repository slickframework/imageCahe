<?php

/**
 * Conditional filter
 *
 * @package   Slick\ImageCache\Filter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Slick\ImageCache\Filter;

use Slick\ImageCache\ImageInterface;
use Slick\ImageCache\FilterInterface;
use Slick\ImageCache\Filter\Conditional\ComparisonMethods;

/**
 * Conditional filter
 *
 * @package   Slick\ImageCache\Filter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class ConditionalFilter extends AbstractFilter
{

    /**
     * @var array The list of conditions
     */
    protected $condition = [];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var FilterInterface
     */
    protected $positiveFilter;

    /**
     * @var FilterInterface
     */
    protected $negativeFilter;

    /**
     * Uses the comparison methods
     */
    use ComparisonMethods;

    /**#@+
     * @var string Conditional properties
     */
    const COND_ORIENTATION = 'orientation';
    const COND_WIDTH = 'width';
    const COND_HEIGHT = 'height';
    /**#@-*/

    /**#@+
     * @var string Conditional operations
     */
    const IS_EQUAL = 'isEqual';
    const IS_NOT_EQUAL = 'isNotEqual';
    const IS_LOWER_THEN = 'isLowerThen';
    const IS_LOWER_THEN_EQUAL = 'isLowerThenEqual';
    const IS_HIGHER_THEN = 'isHigherThen';
    const IS_HIGHER_THEN_EQUAL = 'isHigherThenEqual';
    /**#@-*/

    /**#@+
     * @var string Orientations
     */
    const ORIENTATION_PORTRAIT = 'portrait';
    const ORIENTATION_LANDSCAPE = 'landscape';
    /**#@-*/

    /**
     * Process metadata
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->parseFilters();
    }

    /**
     * Applies the filter to the image returning the resulting filtered image
     *
     * @return ImageInterface $image
     */
    public function applyFilter()
    {
        if ($this->checkCondition()) {
            $this->image = $this->getPositiveFilter()
                ->setImage($this->image)
                ->applyFilter();
        } else {
            $this->image = $this->getNegativeFilter()
                ->setImage($this->image)
                ->applyFilter();
        }

        return $this->image;
    }

    /**
     * Returns te filter to apply when condition is true
     *
     * @return FilterInterface
     */
    public function getPositiveFilter()
    {
        if (is_null($this->positiveFilter)) {
            $this->positiveFilter = new NullFilter();
        }
        return $this->positiveFilter;
    }

    /**
     * Returns te filter to apply when condition is false
     *
     * @return FilterInterface
     */
    public function getNegativeFilter()
    {
        if (is_null($this->negativeFilter)) {
            $this->negativeFilter = new NullFilter();
        }
        return $this->negativeFilter;
    }

    /**
     * Checks the list conditions
     *
     * @return bool
     */
    public function checkCondition()
    {
        $condition = true;
        foreach ($this->condition as $method => $value) {
            $property = $this->get(reset($value));
            $condition = $condition && $this->$method($property, end($value));
        }
        return $condition;
    }

    /**
     * Parses the metadata and creates the filters
     */
    protected function parseFilters()
    {
        $namespace = '\\Slick\\ImageCache\\Filter\\';
        $count = 0;
        foreach($this->filters as $class => $filterOptions) {

            $className = "{$namespace}{$class}";
            if (isset($filterOptions['class'])) {
                $className = "{$namespace}{$filterOptions['class']}";
                unset($filterOptions['class']);
            }

            /** @var FilterInterface $filter */
            $filter = new $className($filterOptions);
            if ($count++ == 0) {
                $this->positiveFilter = $filter;
            } else {
                $this->negativeFilter = $filter;
                break;
            }
        }
    }

    /**
     * Gets value for provided property
     *
     * @param string $property
     * @return int|null|string
     */
    public function get($property)
    {
        $value = null;
        $size = $this->image->getResourceImage()->getSize();
        switch ($property) {
            case self::COND_ORIENTATION:
                if ($size->getWidth() > $size->getHeight()) {
                    $value = self::ORIENTATION_LANDSCAPE;
                } else {
                    $value = self::ORIENTATION_PORTRAIT;
                }
                break;

            case self::COND_WIDTH:
                $value = $size->getWidth();
                break;

            case self::COND_HEIGHT:
                $value = $size->getHeight();
                break;
        }
        return $value;
    }
}