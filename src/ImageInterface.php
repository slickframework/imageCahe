<?php

/**
 * Image interface
 *
 * @package   Slick\ImageCache
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Slick\ImageCache;

use Imagine\Image\ImageInterface as ImagineImage;

/**
 * Image interface
 *
 * @package   Slick\ImageCache
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
interface ImageInterface
{

    /**
     * Sets image source file
     *
     * @param string $file
     *
     * @return self
     */
    public function setSourceFile($file);

    /**
     * Returns the resource image to
     *
     * @return ImagineImage
     */
    public function getResourceImage();

    /**
     * Returns the image file name without extension
     *
     * @return string
     */
    public function getName();

    /**
     * Sets image content type for output
     *
     * @param $contentType
     * @return self
     */
    public function setContentType($contentType);

    /**
     * Returns the image author
     *
     * @return string
     */
    public function getAuthor();

    /**
     * Sets image author
     *
     * @param string $author
     *
     * @return self
     */
    public function setAuthor($author);
}
