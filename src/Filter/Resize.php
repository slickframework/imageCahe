<?php

/**
 * Resize filter
 *
 * @package   Slick\ImageCache\Filter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Slick\ImageCache\Filter;

use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
use Slick\ImageCache\ImageInterface;

/**
 * Class Resize
 * @package Slick\ImageCache\Filter
 */
class Resize extends AbstractFilter
{

    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var bool
     */
    protected $proportional = true;

    /**
     * Applies the filter to the image returning the resulting filtered image
     *
     * @return ImageInterface $image
     */
    public function applyFilter()
    {
        $this->image->getResourceImage()->resize($this->getBox());
        return $this->image;
    }

    /**
     * Creates the correct box for resizing
     *
     * @return Box
     */
    private function getBox()
    {
        $size = $this->image->getResourceImage()->getSize();
        if (is_null($this->width)) {
            $this->width = ($size->getWidth() * $this->height) /
                $size->getHeight();

        } elseif (is_null($this->height)) {
            $this->height = ($this->width * $size->getHeight()) /
                $size->getWidth();
        } else {
            $this->setSize($size);
        }
        return new Box($this->width, $this->height);
    }

    /**
     * Fix box for proportion
     *
     * @param BoxInterface $box
     */
    private function setSize(BoxInterface $box)
    {
        if (!$this->proportional) {
            return;
        }

        if ($box->getHeight() > $box->getWidth()) {
            $this->height = ($this->width * $box->getHeight()) /
                $box->getWidth();
        } else {
            $this->width = ($box->getWidth() * $this->height) /
                $box->getHeight();
        }
    }
}
