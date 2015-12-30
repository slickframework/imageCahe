<?php

/**
 * This file is part of imageCahe package
 *
 * @package   Slick\ImageCache\Filter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014-2015 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.1.0
 */

namespace Slick\ImageCache\Filter;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Color;
use Slick\ImageCache\Image;
use Slick\ImageCache\ImageInterface;

/**
 * Frame filter
 *
 * @package Slick\ImageCache\Filter
 */
class Frame extends AbstractFilter
{

    /**
     * @var int Frame with
     */
    protected $width;

    /**
     * @var int Frame height
     */
    protected $height;

    /**
     * @var string Frame background color
     */
    protected $backgroundColor = '#f9f9f9';

    protected $padding = 2;

    /**
     * Applies the filter to the image returning the resulting filtered image
     *
     * @return ImageInterface $image
     */
    public function applyFilter()
    {
        $this->getResizeImage();
        $image = clone $this->image;
        $this->getFrameImage();

        $addImage = new AddImage(
            [
                'image' => $this->image,
                'sourceImage' => $image,
                'verticalAlign' => AddImage::MIDDLE,
                'horizontalAlign' => AddImage::CENTER

            ]
        );
        return $addImage->applyFilter();
    }

    /**
     * Resize the original image
     *
     * @return ImageInterface
     */
    protected function getResizeImage()
    {
        $imageSize = $this->image->getResourceImage()->getSize();
        $newHeight = ($this->width * $imageSize->getHeight()) / $imageSize->getWidth();
        $resize = new Resize (
            [
                'image' => $this->image,
                'width' => $this->width
            ]
        );
        if ($newHeight > $this->height) {
            $resize = new Resize (
                [
                    'image' => $this->image,
                    'height' => $this->height
                ]
            );
        }

        return $resize->applyFilter();
    }

    /**
     * Creates the colored frame
     *
     * @return Imagine
     */
    protected function getFrameImage()
    {
        $imagine = new \Imagine\Gd\Imagine();
        $imageGD = $imagine->create(
            new Box(
                $this->width,
                $this->height
            ),
            new Color($this->backgroundColor)
        );
        return $this->image->setResourceImage($imageGD);
    }
}