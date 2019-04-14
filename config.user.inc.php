<?php

/**
 * This file is included
 * @var array $cfg
 */

use Mapper\EnvironmentMapper\EnvironmentToConfigMapper;

require_once __DIR__.'/mapper/bootstrap.php';

$mapper = new EnvironmentToConfigMapper;
$mapper->setConfig( $cfg );
$mapper->setEnvironment( $_ENV );
$cfg = $mapper->map();
