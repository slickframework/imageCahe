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
        $image = $this->getResizeImage();
        $this->image = $this->getFrameImage();

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
        $condition = new ConditionalFilter(
            [
                'image' => $this->image,
                'condition' => [
                    ConditionalFilter::IS_EQUAL => [
                        ConditionalFilter::COND_ORIENTATION,
                        ConditionalFilter::ORIENTATION_LANDSCAPE
                    ]
                ],
                'filters' => [
                    'positive' => [
                        'class' => 'Resize',
                        'width' => $this->width - $this->padding,
                    ],
                    'negative' => [
                        'class' => 'Resize',
                        'height'=> $this->height - $this->padding,
                    ]
                ]
            ]
        );
        return $condition->applyFilter();
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
        $image = new Image(null);
        return $image->setResourceImage($imageGD);
    }
}