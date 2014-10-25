<?php

/**
 * Filter interface
 *
 * @package   Slick\ImageCache
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Slick\ImageCache;

/**
 * Filter interface
 *
 * @package   Slick\ImageCache
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
interface FilterInterface
{

    /**
     * Sets the source image where filter will be applied
     *
     * @param ImageInterface $image
     *
     * @return self
     */
    public function setImage(ImageInterface $image);

    /**
     * Applies the filter to the image returning the resulting filtered image
     *
     * @return ImageInterface $image
     */
    public function applyFilter();
}
