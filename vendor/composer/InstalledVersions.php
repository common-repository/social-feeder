<?php

namespace Composer;

use Composer\Semver\VersionParser;






class InstalledVersions
{
private static $installed = array (
  'root' => 
  array (
    'pretty_version' => 'dev-master',
    'version' => 'dev-master',
    'aliases' => 
    array (
    ),
    'reference' => 'd1cbd025ffb237d94c3e8decc91d00ea5360c44b',
    'name' => 'wpmvc/social-feeder',
  ),
  'versions' => 
  array (
    '10quality/ayuco' => 
    array (
      'pretty_version' => 'v1.0.x-dev',
      'version' => '1.0.9999999.9999999-dev',
      'aliases' => 
      array (
        0 => '9999999-dev',
      ),
      'reference' => '6c4d11232dc7b80ebb87c7899db98c76829e1a63',
    ),
    '10quality/wp-file' => 
    array (
      'pretty_version' => 'v0.9.4',
      'version' => '0.9.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '282f0f6733a9e18b392a8b9999dcd8949275a77b',
    ),
    '10quality/wpmvc-commands' => 
    array (
      'pretty_version' => 'v1.1.13',
      'version' => '1.1.13.0',
      'aliases' => 
      array (
      ),
      'reference' => '1be04c5a84d3c5c3b596dc622a977094d1d242d5',
    ),
    '10quality/wpmvc-core' => 
    array (
      'pretty_version' => 'v3.1.15',
      'version' => '3.1.15.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f44dc7b38d3ab581a7034396c1f61e29f0f52b85',
    ),
    '10quality/wpmvc-logger' => 
    array (
      'pretty_version' => 'v2.0.x-dev',
      'version' => '2.0.9999999.9999999-dev',
      'aliases' => 
      array (
        0 => '9999999-dev',
      ),
      'reference' => '3f8959bd7fe585d248d102e198aae4a2504a90d1',
    ),
    '10quality/wpmvc-mvc' => 
    array (
      'pretty_version' => 'v2.1.13',
      'version' => '2.1.13.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c1d14a9deacb5d4b0e782d3435530c0d3eaabd4e',
    ),
    '10quality/wpmvc-phpfastcache' => 
    array (
      'pretty_version' => 'v4.0.x-dev',
      'version' => '4.0.9999999.9999999-dev',
      'aliases' => 
      array (
        0 => '9999999-dev',
      ),
      'reference' => '6d0b4ca7fd1e3d5b27992a2d8321768eb484873e',
    ),
    'facebook/graph-sdk' => 
    array (
      'pretty_version' => '5.x-dev',
      'version' => '5.9999999.9999999.9999999-dev',
      'aliases' => 
      array (
        0 => '9999999-dev',
      ),
      'reference' => '2d8250638b33d73e7a87add65f47fabf91f8ad9b',
    ),
    'j7mbo/twitter-api-php' => 
    array (
      'pretty_version' => 'dev-master',
      'version' => 'dev-master',
      'aliases' => 
      array (
        0 => '1.0.x-dev',
      ),
      'reference' => 'f1a84c8c39a854ac7a8bc87e59c997b526c7bbc7',
    ),
    'nikic/php-parser' => 
    array (
      'pretty_version' => 'v4.12.0',
      'version' => '4.12.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '6608f01670c3cc5079e18c1dab1104e002579143',
    ),
    'php-instagram-api/php-instagram-api' => 
    array (
      'pretty_version' => 'dev-master',
      'version' => 'dev-master',
      'aliases' => 
      array (
        0 => '9999999-dev',
      ),
      'reference' => '7a796fdae715fcdccc00590933ce482437342c35',
    ),
    'psr/log' => 
    array (
      'pretty_version' => '1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'fe0936ee26643249e916849d48e3a51d5f5e278b',
    ),
    'wpmvc/social-feeder' => 
    array (
      'pretty_version' => 'dev-master',
      'version' => 'dev-master',
      'aliases' => 
      array (
      ),
      'reference' => 'd1cbd025ffb237d94c3e8decc91d00ea5360c44b',
    ),
  ),
);







public static function getInstalledPackages()
{
return array_keys(self::$installed['versions']);
}









public static function isInstalled($packageName)
{
return isset(self::$installed['versions'][$packageName]);
}














public static function satisfies(VersionParser $parser, $packageName, $constraint)
{
$constraint = $parser->parseConstraints($constraint);
$provided = $parser->parseConstraints(self::getVersionRanges($packageName));

return $provided->matches($constraint);
}










public static function getVersionRanges($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

$ranges = array();
if (isset(self::$installed['versions'][$packageName]['pretty_version'])) {
$ranges[] = self::$installed['versions'][$packageName]['pretty_version'];
}
if (array_key_exists('aliases', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['aliases']);
}
if (array_key_exists('replaced', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['replaced']);
}
if (array_key_exists('provided', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['provided']);
}

return implode(' || ', $ranges);
}





public static function getVersion($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['version'])) {
return null;
}

return self::$installed['versions'][$packageName]['version'];
}





public static function getPrettyVersion($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['pretty_version'])) {
return null;
}

return self::$installed['versions'][$packageName]['pretty_version'];
}





public static function getReference($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['reference'])) {
return null;
}

return self::$installed['versions'][$packageName]['reference'];
}





public static function getRootPackage()
{
return self::$installed['root'];
}







public static function getRawData()
{
return self::$installed;
}



















public static function reload($data)
{
self::$installed = $data;
}
}
