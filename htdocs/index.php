<?php

declare(strict_types=1);

use Mistralys\AppFrameworkDocs\DocumentationHub;

if(!file_exists(__DIR__.'/../vendor/autoload.php')) {
    die('Please run <code>composer install</code> first.');
}

require_once __DIR__.'/../vendor/autoload.php';

DocumentationHub::create(
    __DIR__.'/../vendor',
    '../vendor'
)
    ->display();
