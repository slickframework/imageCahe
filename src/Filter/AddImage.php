<?php

/**
 * Add image filter
 *
 * @package   Slick\ImageCache\Filter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Slick\ImageCache\Filter;

use Imagine\Image\Point;
use Slick\ImageCache\Image;
use Slick\ImageCache\ImageInterface;

/**
 * Add image filter
 *
 * @package   Slick\ImageCache\Filter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class AddImage extends Crop
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var Image
     */
    protected $sourceImage;

    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $size = $this->getSourceImage()->getResourceImage()->getSize();
        $this->width = $size->getWidth();
        $this->height = $size->getHeight();
    }

    /**
     * Applies the filter to the image returning the resulting filtered image
     *
     * @return ImageInterface $image
     */
    public function applyFilter()
    {
        $this->image->getResourceImage()
            ->paste(
                $this->sourceImage->getResourceImage(),
                new Point($this->getXPoint(), $this->getYPoint())
            );
        return $this->image;
    }

    /**
     * Returns the image that will be added to the source image
     *
     * @return ImageInterface
     */
    protected function getSourceImage()
    {
        if (is_null($this->sourceImage)) {
            $this->sourceImage = new Image($this->path);
        }
        return $this->sourceImage;
    }

}