<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var $loader ClassLoader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$loader->add('Sonata', __DIR__.'/../vendor/bundles');
$loader->add('Exporter', __DIR__.'/../vendor/exporter/lib');
$loader->add('Knp\Bundle',__DIR__.'/../vendor/bundles');
$loader->add('Knp\Menu', __DIR__.'/../vendor/KnpMenu/src');
$loader->add('SaadTazi', __DIR__.'/../vendor/bundles');

return $loader;
