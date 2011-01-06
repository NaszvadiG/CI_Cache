<?php
/*
 *  Cache Configuration
 */

/*
 *  Caches
 *
 *  @driver     Driver to use for this cache
 *  @expire     How long in seconds should a item should remain cached
 *  @silent     Whether or not it should fail silently if the library
 *              cannot connect to the servers (ex: Memcache)
 */
$config['servers'] = array(
    'testA' => array(
        'driver' => 'Memory',
        'expire' => 300,
        'silent' => true
    ),
    'testB' => array(
        'driver' => 'Memcache',
        'host' => '127.0.0.1.',
        'port' => '11211',
        'expire' => 600,
        'silent' => true
    ),
    'testC' => array(
        'driver' => 'APC',
        'expire' => 200,
        'silent' => true
    )
);
