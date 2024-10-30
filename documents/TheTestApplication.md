# The Test Application

## Introduction

The framework comes with a test application that is used both as an example
application, and to provide a test bed for the framework's features.

## Installation

1. Clone the application framework repository.
2. Run `composer install` to install the dependencies.
3. Import the file `tests/testsuite.sql` into a database.
4. Open the folder `tests/application/config`.
5. Copy the `*.dist.php` files to `*.php`.
6. Edit the files to set up your local environment.
7. Open the folder `tests/application` in a browser.

## Application structure

To understand the typical application structure, look in the folder
`tests/application`. The class structure is stored under `assets/classes/TestDriver`.
