# Delivery Exclude Date

Authors: Thelia <info@thelia.net>, Gilles Bourgeat <gbourgeat@openstudio.fr>

* This module manages excluding delivery dates.
* It manages a date list and test them by event.
* The developer competencies is required for use.

## Compatibility

Thelia > 2.1

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is ```DeliveryExcludeDate```.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/delivery-exclude-date-module:~1.0
```

## Usage

* Once activated, click on the configure button for add or edit dates.

### Example in controller for one date

```php
    $event = new DateIsAvailableEvent(new \DateTime('2015-09-09'));

    $this->getDispatcher()->dispatch(
        DeliveryExcludeDateEvents::DATE_IS_AVAILABLE,
        $event
    );

    if ($event->getIsAvailable()) {
        // date is available
    } else {
        // date is not available
    }
```

### Example in controller for multiple dates

```php
    $date1 = new \DateTime('2015-09-09');
    $date2 = new \DateTime('2015-10-09');
    $date3 = new \DateTime('2015-11-09');

    $event = new DatesIsAvailableEvent(array($date1, $date2, $date3));

    $this->getDispatcher()->dispatch(
        DeliveryExcludeDateEvents::DATES_IS_AVAILABLE,
        $event
    );

    if ($event->getIsAvailable($date1)) {
        // date 1 is available
    } else {
        // date 1 is not available
    }

    if ($event->getIsAvailable($date2)) {
        // date 1 is available
    } else {
        // date 1 is not available
    }

    if ($event->getIsAvailable($date3)) {
        // date 1 is available
    } else {
        // date 1 is not available
    }
```

## Loop

### delivery_exclude_date

#### Output arguments

|Variable       |Description |
|---            |--- |
|$ID            | Int Value |
|TITLE    | String value |
|DESCRIPTION    | String value |
|ACTIVE    | Int value |
|DATE    | Date value |