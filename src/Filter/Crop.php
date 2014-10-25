<?php

/**
 * Crop filter
 *
 * @package   Slick\ImageCache\Filter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Slick\ImageCache\Filter;

use Imagine\Image\Box;
use Imagine\Image\Point;
use Slick\ImageCache\ImageInterface;

/**
 * Crop filter
 *
 * @package   Slick\ImageCache\Filter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class Crop extends AbstractFilter
{

    /**
     * @var array
     */
    protected $point = [0, 0];

    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * Applies the filter to the image returning the resulting filtered image
     *
     * @return ImageInterface $image
     */
    public function applyFilter()
    {
        $this->image->getResourceImage()->crop(
            new Point($this->point[0], $this->point[1]),
            new Box($this->width, $this->height)
        );
        return $this->image;
    }
}
