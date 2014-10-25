<?php

/**
 * Profile
 *
 * @package   Slick\ImageCache
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Slick\ImageCache;

/**
 * Profile
 *
 * @package   Slick\ImageCache
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class Profile
{

    /**#@+
     * @var string Image types
     */
    const TYPE_JPG = 'jpg';
    const TYPE_PNG = 'png';
    /**#@-*/

    /**
     * @var FilterInterface[]
     */
    private $filters = [];

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $imageType = self::TYPE_PNG;

    /**
     * @var int
     */
    private $quality = 9;

    /**
     * @var string[]
     */
    private $qualityKeys = [
        self::TYPE_PNG => 'png_compression_level',
        self::TYPE_JPG => 'jpeg_quality'
    ];

    /**
     * @var string[]
     */
    private $contentType = [
        self::TYPE_JPG => 'image/jpg',
        self::TYPE_PNG => 'image/png'
    ];

    /**
     * @var ImageInterface
     */
    private $image;

    /**
     * @var string
     */
    private $path =  __DIR__;

    /**
     * Creates a profile with the given options.
     *
     * Available options are:
     * - filters: an array of FilterInterface objects;
     * - name: A string used to save the processed image
     * - image: The ImageInterface object to be processed
     * - imageType: The resulting image type(one of TYPE_* constants)
     * - quality: the image compression quality (0-100 to JPG, 0-9 to PNG)
     * - path: The pat where precessed image will be saved. Defaults to
     *      current working directory.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        foreach ($options as $property => $value)
        {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }

    /**
     * Returns profile name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Adds a filter to the list of profile filters
     *
     * @param FilterInterface $filter
     * @return self
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filters[] = $filter;
        return $this;
    }

    /**
     * Sets the image that will be processes by this profile
     *
     * @param ImageInterface $image
     * @return self
     */
    public function setImage(ImageInterface $image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * Returns content type to use with HTTP headers
     *
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType[$this->imageType];
    }

    /**
     * Applies the filters and optionally saves the image
     *
     * @param bool $save
     * @return ImageInterface
     */
    public function processImage($save = false)
    {
        foreach($this->filters as $filter) {
            $this->image = $filter->setImage($this->image)->applyFilter();
        }
        $this->image->setContentType($this->getContentType());
        if ($save) {
            $this->save();
        }
        return $this->image;
    }

    /**
     * Saves current image
     */
    private function save()
    {
        $name = "{$this->image->getName()}.{$this->imageType}";
        $path = "{$this->path}/{$this->name}";
        if (!is_dir($path)) {
            mkdir($path, 0775, true);
        }
        $file = str_replace('//', '/', "{$path}/{$name}");
        $this->image->getResourceImage()->save(
            $file,
            [$this->qualityKeys[$this->imageType] => $this->quality]
        );
        if (is_file($file)) {
            chmod($file, 0775);
        }
    }
}
