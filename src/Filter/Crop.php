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

    /**#@+
     * @var string Position definitions
     */
    const CENTER = 'center';
    const LEFT   = 'left';
    const RIGHT  = 'right';
    const TOP    = 'top';
    const MIDDLE = 'middle';
    const BOTTOM = 'bottom';
    /**#@-*/

    /**
     * @var array
     */
    protected $point = [-1, -1];

    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var string
     */
    protected $verticalAlign = self::TOP;

    /**
     * @var string
     */
    protected $horizontalAlign = self::LEFT;

    /**
     * Applies the filter to the image returning the resulting filtered image
     *
     * @return ImageInterface $image
     */
    public function applyFilter()
    {
        $this->image->getResourceImage()->crop(
            new Point($this->getXPoint(), $this->getYPoint()),
            new Box($this->width, $this->height)
        );
        return $this->image;
    }

    /**
     * Calculates the start x value for cropping
     *
     * @return float|int
     */
    protected function getXPoint()
    {
        if ($this->point[0] >= 0) {
            return $this->point[0];
        }

        $size = $this->image->getResourceImage()->getSize();
        if ($this->width > $size->getWidth()) {
            $this->width = $size->getWidth();
            return 0;
        }

        switch ($this->horizontalAlign) {
            case self::CENTER:
                $xPoint = ceil(($size->getWidth() - $this->width) / 2);
                break;

            case self::RIGHT:
                $xPoint = $size->getWidth() - $this->width;
                break;

            case self::LEFT;
            default:
                $xPoint = 0;
        }
        return $xPoint;
    }

    /**
     * Calculates the start y value for cropping
     *
     * @return float|int
     */
    protected function getYPoint()
    {
        if ($this->point[1] >= 0) {
            return $this->point[1];
        }

        $size = $this->image->getResourceImage()->getSize();
        if ($this->height > $size->getHeight()) {
            $this->height = $size->getHeight();
            return 0;
        }

        switch ($this->verticalAlign) {
            case self::MIDDLE:
                $yPoint = ceil(($size->getHeight() - $this->height) / 2);
                break;

            case self::BOTTOM:
                $yPoint = $size->getHeight() - $this->height;
                break;

            case self::TOP:
            default:
                $yPoint = 0;
        }

        return $yPoint;
    }
}
