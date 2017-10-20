PHP Analytics Events [![Build Status](https://travis-ci.org/there4/php-analytics-event.svg?branch=master)](https://travis-ci.org/there4/php-analytics-event)
================================================================================
> Create a Google Analytics Event from PHP

This is a small class to post Analytics events from PHP. This is useful for
logging and event tracking.

## Installation

```bash
composer require there4/php-analytics-event
```

## Example
```php
<?php

use There4\Analytics\AnalyticsEvent;

// Record the download event in Analytics
$events = new AnalyticsEvent('UAxxxxxxx', 'example.com');
$events->trackEvent('resources', 'download', 'cli-latest');
```
