PHP Analytics Events
================================================================================
> Create a Google Analytics Event from PHP

This is a small class to post Analytics events from PHP. This is useful for
logging and event tracking.

```php
<?php

use There4\Analytics\AnalyticsEvent;

// Record the download event in Analytics
$events = new AnalyticsEvent('UAxxxxxxx', 'example.com');
$events->trackEvent('resources', 'download', 'cli-latest');
```
