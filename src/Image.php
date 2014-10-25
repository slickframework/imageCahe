<?php

/**
 * Image
 *
 * @package   Slick\ImageCache
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Slick\ImageCache;

use Imagine\Gd\Imagine;
use Imagine\Image\ImageInterface as ImagineImage;

/**
 * Image
 *
 * @package   Slick\ImageCache
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class Image implements ImageInterface
{

    /**
     * @var string
     */
    private $file;

    /**
     * @var ImagineImage
     */
    private $resourceImage;

    /**
     * Creates an image with provided source file
     *
     * @param string $file
     */
    public function __construct($file)
    {
        $this->setSourceFile($file);
    }

    /**
     * Sets image source file
     *
     * @param string $file
     *
     * @return self
     */
    public function setSourceFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * Returns the resource image to
     *
     * @return ImagineImage
     */
    public function getResourceImage()
    {
        if (is_null($this->resourceImage)) {
            $imagine = new Imagine();
            $this->resourceImage = $imagine->open($this->file);
        }
        return $this->resourceImage;
    }
}