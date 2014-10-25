<?php

/**
 * Image cache driver
 *
 * @package   Slick\ImageCache
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Slick\ImageCache;

/**
 * Image cache driver
 *
 * @package   Slick\ImageCache
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class ImageCache
{
    /**
     * @var string
     */
    private $path = __DIR__;

    /**
     * @var Profile[]
     */
    private $profiles = [];

    /**
     * Constructs a image profile cache with give options
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        if (isset($options['path'])) {
            $this->path = $options['path'];
        }

        if (isset($options['profiles'])) {
            $this->setProfiles($options['profiles']);
        }
    }

    /**
     * Factory method for all profiles
     *
     * @param array $profiles
     */
    public function setProfiles(array $profiles)
    {
        $namespace = '\\Slick\\ImageCache\\Filter\\';
        foreach($profiles as $name => $options) {

            $options['name'] = $name;
            $options['path'] = $this->path;
            $filters = $options['filters'];
            unset($options['filters']);
            $profile = new Profile($options);

            foreach($filters as $class => $filterOptions) {
                $className = "{$namespace}{$class}";
                /** @var FilterInterface $filter */
                $filter = new $className($filterOptions);
                $profile->addFilter($filter);

            }

            $this->profiles[$profile->getName()] = $profile;
        }
    }

    /**
     * Returns the image processed with given profile, saving the
     * image on file system
     *
     * @param string $profile
     * @param ImageInterface $image
     *
     * @return ImageInterface
     */
    public function get($profile, ImageInterface $image)
    {
        if(!isset($this->profiles[$profile])) {
            return $image;
        }

        $profile = $this->profiles[$profile];

        $image = $profile->setImage($image)
            ->processImage(true);
        return $image;
    }

    /**
     * @param ImageInterface $image
     */
    public function processImage(ImageInterface $image)
    {
        $source = clone($image);
        foreach ($this->profiles as $profile) {
            $profile->setImage($image)
                ->processImage(true);
            $image = $source;
        }

    }
}
