# Dynamic Class Loading

## Introduction

One of the core working principles of the framework is to load classes dynamically.
Instead of using enums, switch statements or if-else blocks, classes are loaded
dynamically by loading all PHP classes from a specific directory.

The main reasons for this are:

- Flexibility in adding and removing elements.
- Reducing code maintenance overhead.
- Reducing documentation requirements.
- Reducing a developer's cognitive load.
- Facilitating safe refactoring.

## Example use case

Look at the AJAX methods available in the framework, under `Application\AjaxMethods`: 
To determine which methods are available, the framework loads all classes in the 
folder dynamically. 

AJAX methods can be added or removed by simply adding or removing classes from the folder.
Because the methods are identified by their method name (also available with the 
`METHOD_NAME` class constant), and because only classes that extend `Application_AjaxMethod`
are loaded, the classes can be refactored safely.

## Implementation

Whenever a set of classes is to be loaded dynamically, please use the AppFactory's
method `findClassesInFolder()`. This fire-and-forget method will load all classes
in the specified folder and return them as an array, optionally constraining the
results to classes that extend a specific class.

> NOTE: As many file system operations are costly, the results are cached.

```php
use Application\AppFactory;
use AppUtils\FileHelper\FolderInfo;

$classes = AppFactory::findClassesInFolder(
    FolderInfo::factory('Application\AjaxMethods'), 
    true,
    Application_AjaxMethod::class
);
```

## Controlling the cache

### Automatic invalidation

The cache is invalidated when the application's version changes, which means it
will automatically be refreshed with each release.

### Clearing the cache

The cache can be cleared manually by calling the `clearClassCache()` method of the 
cache handler class. It can also be cleared in the application's UI using the
cache control screen (see [Managing Cache Locations](ManagingCacheLocations.md)).

```php
use Application\AppFactory\ClassCacheHandler;

ClassCacheHandler::clearClassCache();
```

## Storage location

The class cache is saved to the application's `storage/class-cache` folder.
This can be removed safely at any time, as it will be recreated automatically
when the application is accessed.

> NOTE: The cache folder should be added to the application's `.gitignore` file.
