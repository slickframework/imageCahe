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
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $extension;

    /**
     * @var string
     */
    private $contentType;

    /**
     * @var string
     */
    private $author;

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

    /**
     * Returns the image file name without extension
     *
     * @return string
     */
    public function getName()
    {
        if (is_null($this->name)) {
            $this->parseName();
        }
        return $this->name;
    }

    /**
     * Returns the image file extension
     *
     * @return string
     */
    public function getExtension()
    {
        if (is_null($this->extension)) {
            $this->parseName();
        }
        return $this->extension;
    }

    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Sets image content type for output
     *
     * @param $contentType
     * @return self
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * Returns the image author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Sets image author
     *
     * @param string $author
     * @return self
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }



    /**
     * Parses the file property to retrieve the file name and extension
     */
    private function parseName()
    {
        $parts = explode(DIRECTORY_SEPARATOR, $this->file);
        $name = end($parts);

        $parts = explode('.', $name);
        $extension = array_pop($parts);
        $this->extension = trim($extension,'.');
        $this->name = implode('', $parts);
    }
}