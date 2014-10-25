<?php

/**
 * AbstractFilter
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

/**
 * AbstractFilter
 *
 * @package   Slick\ImageCache\Filter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
abstract class AbstractFilter implements FilterInterface
{
    /**
     * @var ImageInterface
     */
    protected $image;

    /**
     * @var array
     */
    protected $defaultOptions = [];

    /**
     * Creates the filter with the given parameters
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $options = array_merge($this->defaultOptions, $options);
        foreach ($options as $property => $value) {
            if ($property == 'image') {
                $this->setImage($value);
                continue;
            }
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }

    /**
     * Sets the source image where filter will be applied
     *
     * @param ImageInterface $image
     *
     * @return self
     */
    public function setImage(ImageInterface $image)
    {
        $this->image = $image;
        return $this;
    }
}
