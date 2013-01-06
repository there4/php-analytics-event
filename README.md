
# PHP Analytics Events

This is a small class to post Analytics events from PHP. This is useful for logging and event tracking.

## Example

    <?php
    
    require_once "class.Analytics.php";
    
    // Send latest command line client zip file.
    header(…);
    readfile(…);
    
    // Record the download event in Analytics
    $events = new Analytics("UAxxxxxxx", "example.com");
    $events->trackEvent("resources", "download", "cli-latest");
    
    ?>
