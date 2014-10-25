<?php

/**
 * Resize and trim filter
 *
 * @package   Slick\ImageCache\Filter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Slick\ImageCache\Filter;

use Slick\ImageCache\ImageInterface;

/**
 * Resize and trim filter
 *
 * @package   Slick\ImageCache\Filter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class ResizeAndTrim extends AbstractFilter
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
     * Applies the filter to the image returning the resulting filtered image
     *
     * @return ImageInterface $image
     */
    public function applyFilter()
    {
        $resize = new Resize([
            'image' => $this->image,
            'width' => $this->width,
            'height' => $this->height,
            'proportional' => true
        ]);
        $this->image = $resize->applyFilter();
        $crop = new Crop([
            'image' => $this->image,
            'verticalAlign' => Crop::MIDDLE,
            'horizontalAlign' => Crop::CENTER,
            'width' => $this->width,
            'height' => $this->height
        ]);
        return $crop->applyFilter();
    }
}