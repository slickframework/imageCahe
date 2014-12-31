<?php

/**
 * Sign the author name filter
 *
 * @package   Slick\ImageCache\Filter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 * @copyright 2014 SlickFramework
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @since     Version 1.0.0
 */

namespace Slick\ImageCache\Filter;

use Imagine\Gd\Font;
use Imagine\Image\Color;
use Imagine\Image\Point;
use Slick\ImageCache\ImageInterface;

/**
 * Sign the author name filter
 *
 * @package   Slick\ImageCache\Filter
 * @author    Filipe Silva <silvam.filipe@gmail.com>
 */
class Sign extends Crop
{

    /**
     * @var string
     */
    protected $color = '#fff';

    /**
     * @var string
     */
    protected $bgColor = '#666';

    /**
     * @var string
     */
    protected $font;


    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $author = $this->image->getAuthor();
        $this->height = 26;
        $this->width = ceil((strlen($author) + 2) * 10.2) + 12;
    }

    /**
     * Applies the filter to the image returning the resulting filtered image
     *
     * @return ImageInterface $image
     */
    public function applyFilter()
    {
        $this->image->getResourceImage()->draw()
            ->text(
                ' © '.$this->image->getAuthor(),
                new Font($this->getFont(), 14, new Color($this->bgColor)),
                new Point($this->getXPoint()+1, $this->getYPoint()+1)
            );
        $this->image->getResourceImage()->draw()
            ->text(
                ' © '.$this->image->getAuthor(),
                new Font($this->getFont(), 14, new Color($this->color)),
                new Point($this->getXPoint(), $this->getYPoint())
            );
        return $this->image;
    }

    /**
     * Returns the font file path
     *
     * @return string
     */
    public function getFont()
    {
        if (is_null($this->font)) {
            $path = dirname(dirname(__DIR__));
            $this->font = "{$path}/fonts/Vera.ttf";
        }
        return $this->font;
    }

    /**
     * Calculates the start y value for cropping
     *
     * @return float|int
     */
    protected function getYPoint()
    {
        if ($this->verticalAlign == self::TOP) {
            return 8;
        }
        return parent::getYPoint();
    }
}