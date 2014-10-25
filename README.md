Slick Image Cache
=================

Slick Image Cache is a simple library that can profile images and cache them
on the file system. You can add filters to crop, resize for example.

**Features**

> -   Cache image copies
> -   Profiling images
> -   Apply filters and transformations
> -   An easy interface to add your own filters
> -   Lightweight and simple!

**Installation**

To use Image Cache in your project just add the following line to your project’s
`composer.json` file:

    {
        "require": {
            "slick/ImageCache": "*",
            ...
        }
    }

Then you need to run:

    $ composer update


**Usage**

Create a definition array like this:

    <?php
        $config = [
            'path' => dirname(__DIR__).'/images',
                'profiles' => [
                    'thumb' => [
                        'filters' => [
                            'ResizeAndTrim' => [
                                'width' => 32,
                                'height' => 32
                            ],
                        ],
                        'imageType' => Profile::TYPE_PNG,
                        'quality' => 8
                    ],
                    'filters' => [
                    'Resize' => [
                        'width' => 680,
                        'height' => 300,
                        'proportional' => true
                    ],
                    'Crop' => [
                        'width' => 680,
                        'height' => 300,
                        'verticalAlign' => Crop::TOP,
                        'horizontalAlign' => Crop::CENTER
                    ]
                ],
                'imageType' => Profile::TYPE_PNG,
                'quality' => 8
                ]
            ]
        ];
    
and initialize the image cache object:

    <?php
        $cache = new \Slick\ImageCache\ImageCache($config);
        
Now you can use the cache object to retrieve image profiles or to process all profiles
on a provided image:

    <?php
        $image = new \Slick\ImageCache\Image("path/to/source/image.png");
        $image = $cache->get("thumb", $image);
        
        // process all profiles
        $cache->processImage($image);

**Contribute**

-   Issue Tracker: <https://github.com/slickframework/imageCahe/issues>
-   Source Code: <https://github.com/slickframework/imageCahe>

**Support**

If you are having issues, please let us know.

**License**

The project is licensed under the MIT License (MIT)