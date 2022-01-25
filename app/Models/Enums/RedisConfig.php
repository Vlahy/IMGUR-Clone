<?php

namespace App\Models\Enums;

interface RedisConfig
{

    const REDIS_HOST = '127.0.0.1';
    const REDIS_PORT = '6379';

    /**
     * RedisConfig Keys
     */
    const ONE_GALLERY = 'ONE_GALLERY';
    const ALL_GALLERIES = 'ALL_GALLERIES';
    const ONE_IMAGE = 'ONE_IMAGE';
    const ALL_IMAGES = 'ALL_IMAGES';
    const IMAGE_COMMENT = 'IMAGE_COMMENT';
    const GALLERY_COMMENT = 'GALLERY_COMMENT';
    const LOGGER = 'LOGGER';

    /**
     * Array of keys for cache
     */
    const REDIS_KEYS = [
        self::ONE_GALLERY,
        self::ALL_GALLERIES,
        self::ONE_IMAGE,
        self::ALL_IMAGES,
        self::IMAGE_COMMENT,
        self::GALLERY_COMMENT,
        self::LOGGER,
    ];

}