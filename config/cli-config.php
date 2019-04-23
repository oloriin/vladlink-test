<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once dirname(__DIR__).'/bootstrap.php';

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
