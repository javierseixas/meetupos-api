MeetupOS - Open Source Meetup API
=============================

This is an API to support the MeetupOS project

How to test it
----------------------------

I'm developing this following a BDD approach, trying to apply modeling by example. So the way to execute the test is by run:

1. First run Docker dev (Docker-Compose-Run):

```
./dcr app app/console cache:clear
```

For running the domain (?) tests:

```
./dcrt -s bdd
```

For running the functional api tests:

```
./dcrt -s api
```

For running specs (you don't need docker if already have php in your machine):

```
bin/phpspec run
```


How to run docker containers for using the app (Still not accessible)
---------------

```
./dcr
```


  * An AppBundle you can use to start coding;

  * Twig as the only configured template engine;

  * Doctrine ORM/DBAL;

  * Swiftmailer;

  * Annotations enabled for everything.

It comes pre-configured with the following bundles:

  * **FrameworkBundle** - The core Symfony framework bundle

  * [**SensioFrameworkExtraBundle**][6] - Adds several enhancements, including
    template and routing annotation capability

  * [**DoctrineBundle**][7] - Adds support for the Doctrine ORM

  * [**TwigBundle**][8] - Adds support for the Twig templating engine

  * [**SecurityBundle**][9] - Adds security by integrating Symfony's security
    component

  * [**SwiftmailerBundle**][10] - Adds support for Swiftmailer, a library for
    sending emails

  * [**MonologBundle**][11] - Adds support for Monolog, a logging library

  * [**AsseticBundle**][12] - Adds support for Assetic, an asset processing
    library

  * **WebProfilerBundle** (in dev/test env) - Adds profiling functionality and
    the web debug toolbar

  * **SensioDistributionBundle** (in dev/test env) - Adds functionality for
    configuring and working with Symfony distributions

  * [**SensioGeneratorBundle**][13] (in dev/test env) - Adds code generation
    capabilities

  * **DebugBundle** (in dev/test env) - Adds Debug and VarDumper component
    integration

All libraries and bundles included in the Symfony Standard Edition are
released under the MIT or BSD license.