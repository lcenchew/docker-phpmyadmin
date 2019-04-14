<?php

/**
 * This file is included
 * @var array $cfg
 */

use Mapper\EnvironmentToConfigMapper;

require_once __DIR__.'/mapper/bootstrap.php';

$mapper = new EnvironmentToConfigMapper;
$mapper->setEnvironment( $_ENV );
$extraConfig = $mapper->map();
$cfg = array_merge($cfg, $extraConfig);
