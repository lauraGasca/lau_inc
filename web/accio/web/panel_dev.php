<?php

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('panel', 'dev', true);
sfContext::createInstance($configuration)->dispatch();
