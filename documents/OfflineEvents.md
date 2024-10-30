# Offline Events

## Introduction

Offline events are a way to **trigger events on objects when they have not
been instantiated yet**. The offline event handler takes care of "waking up"
the objects and then triggering the events.

The event handling in the objects themselves is the same as for regular events,
so no special handling is required there.

## Example use case

The offline event system is used in the framework to register locations where
data is cached. The cache manager does not know about these locations, as the
application can freely define them. Also, the parts of the application that
define the cache locations are not necessarily loaded when the cache manager
is instantiated.

Instead, the cache manager relies on an offline event to let the cache locations
register themselves. See [Managing Cache Locations](ManagingCacheLocations.md) 
for more details on this process.

## Defining offline events

Adding offline events is done by adding a dedicated class in the application's
`OfflineEvents` folder.

1. Create the folder `{Driver}/OfflineEvents` in the application's class folder.
2. Add the event class file, e.g. `MyEvent.php`.
3. The class must extend `Application_EventHandler_Event`.
4. Add the `EVENT_NAME` constant to easily access the event name.

## Listening to offline events

Because offline events are triggered before the objects are instantiated,
there is no method to register listeners. Instead, the listeners are added
as PHP classes in the event's folder.

The location is as follows:

`{Driver}/OfflineEvents/{EventClassName}/MyListener.php`

You can find an example in the [Test application](TheTestApplication.md) at:

`TestDriver/OfflineEvents/TestEvent/ListenerA.php`

## Triggering an offline event

```php
use Application\AppFactory;

// Trigger the offline event: Returns an offline event instance.
$offlineEvent = AppFactory::createOfflineEvents()->triggerEvent(
    MyEvent::EVENT_NAME,
    array($this),
    MyEvent::class
);

// This will return the triggered event instance, e.g. `MyEvent`,
// or NULL if it was not triggered (for example, if there are no
// listeners).
$actualEvent = $offlineEvent->getTriggeredEvent();
```
