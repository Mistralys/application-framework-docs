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

## Usage

### Class hierarchy

The offline events live in the `OfflineEvents` folder of the application:

`{DriverName}/OfflineEvents/CriticalEvent.php`
`{DriverName}/OfflineEvents/CriticalEvent/LogHandler.php`
`{DriverName}/OfflineEvents/CriticalEvent/NotifyHandler.php`

- `CriticalEvent.php` contains the event class.
- `LogHandler.php` is a listener.
- `NotifyHandler.php` is a listener.

### Adding an offline event

1. Create the folder `{DriverName}/OfflineEvents` if it does not exist.
2. Create the event class, e.g. `CriticalEvent.php`.
3. The class must extend `Application_EventHandler_Event`.
4. Add the `EVENT_NAME` constant to easily access the event name.
5. Add any relevant utility methods.

### Adding listeners

Listeners are added as separate classes in the same folder as the event class.

1. Create the class `{Driver}/OfflineEvents/{EventClassName}/MyListener.php`.
2. The class must extend `Application_EventHandler_OfflineEvents_OfflineListener`.
3. Add the `wakeUp()` method.

The `wakeUp()` method must return a closure, which is the actual event listener.

```php
class LogHandler extends Application_EventHandler_OfflineEvents_OfflineListener
{
    protected function wakeUp(): NamedClosure
    {
        $callback = array($this, 'handleEvent');

        return NamedClosure::fromClosure(Closure::fromCallable($callback), $callback);
    }

    private function handleEvent(CriticalEvent $event): void
    {
        // Handle the event here.
    }
}
```

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
