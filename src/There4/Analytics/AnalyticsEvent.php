<?php
namespace There4\Analytics;

/**
 * Google Analytics Event Tracking
 *
 * This library provides a method to track a server side event to
 * Google Analytics
 *
 * @author Craig Davis <craig@there4development.com>
 * @created 07/15/2010
 */
class AnalyticsEvent
{
    /**
    * @var string Google Analytics code
    */
    private $_code;

    /**
    * @var string Domain name we are requesting from
    */
    private $_domain;

    /**
    * @var string User Agent string for this request from CURL
    */
    private $_useragent = 'PHPAnalyticsAgent/0.1 (http://there4development.com/)';

    /**
    * @var string cookie name
    */
    private $_cookie = "phpanalytics";

    /**
    * @var bool verbose output
    */
    private $_verbose = false;

    /**
    * Url for the google analytics gif
    *
    * http://code.google.com/intl/de-DE/apis/analytics/docs/tracking/ +
    *   gaTrackingTroubleshooting.html#gifParameters
    *
    * @var string url for the gif string at google
    */
    private $_urchin_url = 'http://www.google-analytics.com/__utm.gif';

    /**
    * Setup Analytics
    *
    * @param string $code   Google Analytics key (default: const GOOG_UA)
    * @param string $domain HTTP_HOST (default: $_SERVER['HTTP_HOST'])
    *
    * @return void
    */
    public function __construct($code = '', $domain = '')
    {
        $this->_code = !empty($code) ? $code : GOOG_UA;
        $this->_domain = 'No Domain Set';

        if (!empty($domain)) {
            $this->_domain = $domain;
        } elseif (array_key_exists('HTTP_HOST', $_SERVER)) {
            $this->_domain = $_SERVER['HTTP_HOST'];
        }
    }

    /**
    * Track and event in Google Analytics
    *
    *  http://code.google.com/apis/analytics/docs/tracking/ +
    *    eventTrackerGuide.html
    *
    * @param string $object the name you supply for the group of objects
    *                       you want to track.
    * @param string $action A string that is uniquely paired with each category,
    *                       and commonly used to define the type of user
    *                       interaction for the web object.
    * @param string $label  An optional string to provide additional dimensions
    *                       to the event data.
    * @param string $value  An integer that you can use to provide numerical
    *                       data about the user event.
    *
    * @return bool success
    */
    public function trackEvent($object, $action, $label = '', $value = 1)
    {
        $var_utmac   = $this->_code;
        $var_utmhn   = $this->_domain;
        $var_utmn    = rand(1000000000, 9999999999); //random request number
        $var_cookie  = rand(10000000, 99999999);     //random cookie number
        $var_random  = rand(1000000000, 2147483647); //number under 2147483647
        $var_today   = time();                       //today
        $var_referer = $_SERVER['SCRIPT_URI']; //referer url
        $var_utmp    = 'index.php';
        $var_uservar = '';

        $urchin_params = ''
            .'?utmwv=1'               // Tracking code version
            .'&utmn='.$var_utmn       // Prevent caching random number
            .'&utmsr=-'               // Screen resolution
            .'&utmsc=-'               // Screen color depth
            .'&utmul=-'               // Browser language
            .'&utmje=0'               // Is browser Java-enabled
            .'&utmfl=-'               // Flash Version
            .'&utmdt=-'               // Page title, url encoded
            .'&utmhn=' . $var_utmhn   // Host Name
            .'&utmp=' .  $var_utmp    // page
            .'&utmr=' .  $var_referer // Referral, complete url
            .'&utmac=' . $var_utmac   // Account code
            .'&utmt=event'            // Type of request
            // utme is an extensible parameter, used for the event data here
            ."&utme=" . rawurlencode("5($object*$action*$label)($value):")
            .'&utmcc=__utma%3D' . $var_cookie . '.' . $var_random . '.' . $var_today
                . '.' . $var_today . '.' . $var_today . '.2%3B%2B__utmb%3D'
                . $var_cookie . '%3B%2B__utmc%3D' . $var_cookie . '%3B%2B__utmz%3D'
                . $var_cookie . '.' . $var_today
                . '.2.2.utmccn%3D(direct)%7Cutmcsr%3D(direct)'
                . '%7Cutmcmd%3D(none)%3B%2B__utmv%3D'
                . $var_cookie . '.' . $var_uservar . '%3B'
            ; // Cookie values are in this utmcc

        $url = $this->_urchin_url . $urchin_params;

        $ch = curl_init();
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_URL            =>$url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_USERAGENT      => $this->_useragent,
                CURLOPT_VERBOSE        => $this->_verbose,
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_COOKIEFILE     => $this->_cookie
            )
        );
        $output = curl_exec($ch);
        curl_close($ch);

        $is_gif = ('GIF89a' == substr($output, 0, 6));

        return $is_gif;
    }
}

/* End of file AnalyticsEvent.php */
