CodeIgniter Cache: Driver Driven Caching Library
=====================================================

CI_Cache is a driver based caching library similar to the database forge
included in CodeIgniter. You can extend the library to add as many
different types of caching as you wish by simply writing drivers.

Written by Ian Livingstone with inspiration from Elliot Haughin's
Multicache library.

Usage
--------------------------------------------------

Define a cache in config, for example APC.

$config['servers']['users'] = array(
    'driver' => 'APC'
);

Then either in your controller or models you can now load the cache.

$this->load->cache('users');
$this->users_cache->set('user_id:'.$user_id, array(
    'name' => 'Jake',
    'Age' => '12'
));
$this->users_cache->get('user_id:'.$user_id);
$this->users_cache->replace('user_id:'.$user_id, array(
    'name' => 'Nancy',
    'Age' => '12'
));
$this->users_cache->delete('user_id:'.$user_id);

You can also perform multiple get/set/replace/delete

$this->users_cache->get(array('a','b','c','d'));

This will return a key value array with the values being that contained in
the array. If the get failed, the value for the key that failed will be
false.

Installation
---------------------------------------------------

If you are going to use apc, or memcache it is required that you the
correlating php libraries installed. You can use just the Memory cache
which only caches during the session and does not cross sessions.

This is a PHP 5, and CodeIgniter 2.0 only library.

1) Copy and paste the files into their destined folders.
2) Edit the MY_Loader name if you are not using the default extension name.
3) Edit the config/cache.php file.
4) You should be good to go!

Adding Additional Drivers
----------------------------------------------------

To add a driver extend the CacheDriver class included in
libraries/Cache/CacheDriver.php and then overload the _get, _set, _delete,
_replace methods. 

If your caching method supports multi-get and multi-set in one call then
you can overload the public methods similar to the Memcache driver.

Add the driver name to the configuration list.

Now you should be good to go :)


Changelog
--------------------------------------------------
Version 1.0
    Starting the changelog now
