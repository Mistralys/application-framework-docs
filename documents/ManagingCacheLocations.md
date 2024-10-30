# Managing Cache Locations

## Introduction

The framework has a number of locations where temporary and cache files
are stored. The application itself can define additional locations as needed.
To manage and maintain the data stored in these locations, the `CacheManager`
class is the central hub to access the cache system.

## Registering cache locations

Custom application cache locations can be registered with the dedicated
offline event `RegisterCacheLocationsEvent` (also see [Offline events](OfflineEvents.md)).
Add a handler for this event, and register the locations there.

Locations must implement the `CacheLocationInterface` interface.

As an example, look at the following classes:

- `RegisterClassCacheHandler` - Handler for registering the class cache location.
- `ClassCacheLocation` - Implementation of the class cache location.

## Clearing cache in the UI

If the application has enabled the "Cache control" developer screen, the cache
can be managed from there. The screen provides a list of all cache locations
and allows the user to clear them individually or all at once.

## Clearing cache programmatically

### Individual cache locations

To clear a specific cache location, fetch the target location and use the 
`clear()` method:

```php
$manager = \Application\AppFactory::createCacheManager();

$location = $manager->getByID('LocationID');

$location->clear();
````

> The `LocationID` is the unique identifier of the cache location.
> Locations typically define the `CACHE_ID` constant to provide this value.

### All cache locations

The manager has a utility method that automatically clears all cache locations:

```php
$manager = \Application\AppFactory::createCacheManager();
$manager->clearAll();
```

