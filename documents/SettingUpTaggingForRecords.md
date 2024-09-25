# Setting up tagging for records

## Purpose

The tagging layer in the framework can be used to add tagging
capabilities to any record type, to leverage the full capabilities
of the tagging classes, from filtering to administration screens. 

This guide explains how to integrate the tagging system into your 
records and collections.

## Prerequisites

The tagging layer can be used with DBHelper collections and records,
but can be added to any classes using the provided interfaces and
traits. 

The tagging system requires a database table to connect records,
which means that the records themselves must be stored in a database.
Loose data storage is not supported.

## 1. Database setup

Create a database table to connect records with tags, typically
called `records_tags`. This table should have two columns, one for
the record ID and one for the tag ID. 

Also remember to add constraints for the IDs to ensure that they
reference the correct tables.

## 2. Create the connector utility class

If you do not plan on storing any additional metadata in the connection
table, you can skip this step. Otherwise, you can create a connector
class to access this metadata.

Use the following class skeleton:

```php
<?php

declare(strict_types=1);

namespace DriverName\Records;

use Application\Tags\Taggables\TagConnector;

class RecordTagConnector extends TagConnector
{
    // Your utility methods here
}
```

> NOTE: Replace "Record" with the name of the record class you are connecting.

## 3. Add tagging to the collection

1. Implement the interface `TagCollectionInterface`.
2. Use the matching trait `TagCollectionTrait`.
3. Add the constant `TAG_REGISTRY_KEY = '{recordtype}_tagging'` to the collection class.
4. Add the leftover interface methods:

- `getTagPrimary()`: Name of the primary key of the records being tagged.
- `getTagTable()`: Name of the table connecting records and tags.
- `getTagSourceTable()`: Name of the table storing the records.
- `getTagConnectorClass()`: Name of the connector class you created, if any.
- `getTagRegistryKey()`: Return the `TAG_REGISTRY_KEY` constant.

## 4. Add tagging to the records

1. Implement the interface `TaggableInterface`.
2. Use the matching trait `TaggableTrait`.
3. Add the leftover interface methods:

- `getTagRecordPrimaryValue()`: The ID of the record.
- `adminURLTagging()`: URL to the screen you created in step 3).
- `getTagCollection()`: The record's collection that implements `TagCollectionInterface`.
- `isTaggingEnabled()`: Whether tagging is enabled for the record. You can add logic here if needed.

## 5. Create the record's tagging screen

1. Create a new screen in the record's admin screens.
2. Implement the interface `RecordTaggingScreenInterface`.
3. Use the matching trait `RecordTaggingScreenTrait`.
4. Override `_handleHiddenFormVars()` if needed.
5. Call `handleTaggableActions()` in the screen's `_handleActions()` method.
6. Add the leftover interface methods:

- `getTaggableRecord()`: The instance of the record being tagged.

## 6. Create a tag settings screen

The tags available for the records are taken from the sub-tags of a root tag.
The tag registry allows storing which root tag is used for the records, which
means that a setting screen is needed for this.

Example: The `BaseMediaSettingsScreen` class where the root tag for the media 
library tagging can be selected.

1. Create a new screen in the admin screens.
2. Add a form to select the target root tag and save its ID somewhere.
3. Store the tag in the registry:

```php
TagRegistry::setTagByKey(
    CollectionClass::TAG_REGISTRY_KEY,
    $tag
);
```

> NOTE: `CollectionClass` is the class implementing `TagCollectionInterface`.
