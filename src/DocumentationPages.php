<?php

declare(strict_types=1);

namespace Mistralys\AppFrameworkDocs;

class DocumentationPages
{
    public const DEPLOYING = 'https://github.com/Mistralys/application-framework-docs/blob/main/documents/DeployingAnApplication.md';
    public const OFFLINE_EVENTS = 'https://github.com/Mistralys/application-framework-docs/blob/main/documents/OfflineEvents.md';
    public const MANAGING_CACHE_LOCATIONS = 'https://github.com/Mistralys/application-framework-docs/blob/main/documents/ManagingCacheLocations.md';
    public const THE_TEST_APPLICATION = 'https://github.com/Mistralys/application-framework-docs/blob/main/documents/TheTestApplication.md';
    public const START = 'https://github.com/Mistralys/application-framework-docs';

    public function start() : string
    {
        return self::START;
    }

    public function deploying() : string
    {
        return self::DEPLOYING;
    }

    public function offlineEvents() : string
    {
        return self::OFFLINE_EVENTS;
    }

    public function managingCacheLocations() : string
    {
        return self::MANAGING_CACHE_LOCATIONS;
    }

    public function theTestApplication() : string
    {
        return self::THE_TEST_APPLICATION;
    }
}
