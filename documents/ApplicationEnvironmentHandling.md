# Application environment handling

## What are environments?

An environment is an infrastructure on which an application is running. 
It can be a local development machine, a staging server, or a production 
server. Each environment has its own configuration, which can be different 
from other environments.

## Automatic environment detection

The framework has a built-in environment handling system, which can be 
used to detect the current environment based on freely definable criteria.

## Typical application setup

### 1. The main environments configuration

The main environment configuration is used to determine which environments
are available, and to set default and common values for application 
configuration settings.

1. Create a class that extends `BaseEnvironmentsConfig`.
2. Implement all abstract methods.
3. Create an instance of the class in the `app-config.php` file.
4. Call the `detect()` method to detect the environment.

Example:

```php
declare(strict_types=1);

use Application\Environments;
use AppUtils\FileHelper\FolderInfo;
use ApplicationNamespace\EnvironmentsConfig;

try
{
    (new EnvironmentsConfig(FolderInfo::factory(__DIR__)))
        ->detect();
}
catch (Throwable $e)
{
    if(isset($_REQUEST['simulate_only']) && $_REQUEST['simulate_only'] === 'yes') {
        Environments::displayException($e);
    }

    die('Exception #'.$e->getCode().': '.$e->getMessage());
}
```

### 2. The individual environments

These classes define the criteria that are used to detect the environments,
as well as set the environment-specific configuration values.

1. Under the Driver's class folder, create a folder named `Environments`.
2. For each environment, create a class that extends `BaseEnvironmentConfig`.
3. Implement all abstract methods.

## Local development

When registering a local development environment, create the
file `dev-hosts.txt` in the config folder, and add all host names
to the environment that should be considered as local development
hosts.

The method `BaseEnvironmentConfig::getDevHosts()` facilitates this 
when used from within `BaseEnvironmentConfig::setUpEnvironment()`,
as shown in the following example:

```php
protected function setUpEnvironment(): void
{
    $localHosts = $this->getDevHosts();
    foreach ($localHosts as $host) {
        $this->environment->or()->requireHostNameContains($host);
    }
}
```

## Debugging environment-level issues

At the time the environment is detected, the application has not completed
its boot process yet. This means that the environment detection handles 
logging and debugging a little differently.

To be able to see what's happening in case of an exception, append the 
parameter `simulate_only=yes` to the target URL, to enable the display
of a more detailed error message that includes the application log. This
will illustrate at which point the environment system failed, and why.
