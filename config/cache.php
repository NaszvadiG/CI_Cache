<?php
/*
 *  Cache Configuration
 */

/*
 *  Cache Drivers
 *
 *  Add or Remove to the list as you add drivers to the Cache folder inside
 *  the application libraries.
 */
$config['drivers'] = array('APC','Memcache','Memory');

/*
 *  Expiration Time
 *
 *  Amount of seconds the items should exist in the cache
 *  Default: 10 minutes (600 seconds)
 */
$config['expire'] = 600;

/*
 *  Silent Mode
 *
 *  Should the library fail silently if it does not connect to a cache
 *  server like memcache.
 */
$config['silent'] = true;

/*
 *  Caches
 */
$config['servers'] = array(
    'testA' => array(
        'driver' => 'Memory'
    ),
    'testB' => array(
        'driver' => 'Memcache',
        'host' => '127.0.0.1.',
        'port' => '11211'
    ),
    'testC' => array(
        'driver' => 'APC'
    )
);
?>
