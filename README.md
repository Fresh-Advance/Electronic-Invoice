# Electronic Invoice module for OXID eShop

[![Development](https://github.com/Fresh-Advance/Electronic-Invoice/actions/workflows/trigger.yaml/badge.svg?branch=b-7.3.x)](https://github.com/Fresh-Advance/Electronic-Invoice/actions/workflows/trigger.yaml)
[![Latest Version](https://img.shields.io/packagist/v/Fresh-Advance/Electronic-Invoice?logo=composer&label=latest&include_prereleases&color=orange)](https://packagist.org/packages/Fresh-Advance/Electronic-Invoice)
[![PHP Version](https://img.shields.io/packagist/php-v/Fresh-Advance/Electronic-Invoice)](https://github.com/Fresh-Advance/Electronic-Invoice)

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=Fresh-Advance_Invoice&metric=alert_status)](https://sonarcloud.io/dashboard?id=Fresh-Advance_Invoice)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=Fresh-Advance_Invoice&metric=coverage)](https://sonarcloud.io/dashboard?id=Fresh-Advance_Invoice)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=Fresh-Advance_Invoice&metric=sqale_index)](https://sonarcloud.io/dashboard?id=Fresh-Advance_Invoice)

## Features

* Extends the [PDF Invoice module](https://github.com/Fresh-Advance/Invoice) to generate ZUGFeRD compliant PDF invoices

<img width="470" alt="image" src="https://github.com/user-attachments/assets/1867d8a5-a7ad-4b0d-a7c5-2ec2c176fb5c" />
<img width="350" alt="image" src="https://github.com/user-attachments/assets/62c355f2-7817-43ce-9cca-335e4b08731f" />


## Requirements

Please read this section carefully before using the module. Everything here is very important to make the invoice valid.

* The [PDF Invoice Module](https://github.com/Fresh-Advance/Invoice) is required to be installed and active
* Seller information is taken from the shop information settings (**Master Settings -> Core Settings**) and should be filled in correctly
    * Company Name
    * **Tax number (Valid Tax ID)**
    * **VAT number (Valid Sales Tax ID)**
    * Company address (Street, City, ZIP).
    * Responsible person information (Name, Surnname, Phone, Fax, Email - info email in settings)
    * Email (info email in settings)
* **The country ISO2 code should be configured in the Electronic Invoice module settings**
* The invoice will be valid only if your Net and VAT totals are correct (item lines should sum up to correct totals)
    * The default shop functionality may lead to not matching totals in some cases.
    * The module which changes how the total VAT is calculated might help - https://github.com/Fresh-Advance/OXID-Per-Line-VAT

## Branch compatibility

* Branch **b-7.3.x** is compatible with OXID Shop compilation **7.3.0 and up**
* Branch **b-7.2.x** is compatible with OXID Shop compilation **7.2.0**
* Branch **b-7.1.x** is compatible with OXID Shop compilation **7.1.0**

Note: Not all latest features are available in the older branches.

## Version compatibility

* v1.x is compatible with OXID Shop compilation 7.1.x and up

Note: Not all latest features and fixes are available in older than the last versions - always prefer the latest possible release.

## What to expect in next versions

* Factur-X support
* Possibility to create electronic invoice as a separate document

## Installation

Module is available on packagist and installable via composer

```
composer require fresh-advance/electronic-invoice
```

# Development installation

To be able running the tests and other preconfigured quality tools, please install the module as a [root package](https://getcomposer.org/doc/04-schema.md#root-package).

The next section shows how to install the module as a root package by using the [Fresh Advance Development Base](https://github.com/Fresh-Advance/development).

In case of different environment usage, please adjust by your own needs.

# Development installation on Fresh Advance Development Base

The installation instructions below are shown for the current [Fresh Advance Development Base](https://github.com/Fresh-Advance/development)
for shop 7.3. Make sure your system meets the requirements of the Development Base.

0. Ensure all docker containers are down to avoid port conflicts

1. Clone the SDK for the new project
```shell
echo MyProject && git clone https://github.com/Fresh-Advance/development.git $_ && cd $_
```

2. Clone the repository to the source directory
```shell
git clone --recurse-submodules https://github.com/Fresh-Advance/Electronic-Invoice.git --branch=b-7.3.x ./source
```

3. Run the recipe to setup the development environment
```shell
./source/recipes/setup-development.sh
```

You should be able to access the shop with http://localhost.local and the admin panel with http://localhost.local/admin
(credentials: noreply@oxid-esales.com / admin)

### Running the tests and quality tools

Check the "scripts" section in the `composer.json` file for the available commands. Those commands can be executed
by connecting to the php container and running the command from there, example:

```shell
make php
composer tests-coverage
```

Commands can be also triggered directly on the container with docker compose, example:

```shell
docker compose exec -T php composer tests-coverage
```

## License

Please ensure that you have reviewed the licensing requirements before using this module.
License subscriptions are available for purchase through the [Fresh Advance website](https://freshadvance.eu/).
