<?php

/**
 * Configuration
 */

/**
 * Configuration for: Error reporting
 * Useful to show every little problem during development, but only show hard errors in production
 * development/production
 */
define("ENVIRONMENT", "development");

if (ENVIRONMENT === "production") {
    ini_set("display_errors", 0);
    if (version_compare(PHP_VERSION, "5.3", ">=")) {
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
    } else {
        error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
    }
} else { # for development
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    // error_reporting(0);
}

/**
 * Configuration for: URL
 * Here, we auto-detect your applications URL and the potential sub-folder. Works perfectly on most servers and in local
 * development environments. Don't touch this unless you know what you do.
 *
 * URL_PUBLIC_FOLDER:
 * The folder that is visible to public, users will only have access to that folder so nobody can have a look into
 * "/application" or other folder inside your application or call any other .php file than index.php inside "/public".
 *
 * URL_PROTOCOL:
 * The protocol. Don't change unless you know exactly what you do. This defines the protocol part of the URL
 *
 * URL_DOMAIN:
 * The domain. Don't change unless you know exactly what you do.
 *
 * URL_SUB_FOLDER:
 * The sub-folder. Leave it like it is, even if you don't use a sub-folder (then this will be just "/").
 *
 * URL:
 * The final, auto-detected URL (build via the segments above). If you don't want to use auto-detection,
 * then replace this line with full URL (and sub-folder) and a trailing slash.
 */

define("URL_PUBLIC_FOLDER", "public");
if (isset($_SERVER['HTTPS'])) {
    define("URL_PROTOCOL", "https://");
} else {
    define("URL_PROTOCOL", "http://");
}
define("URL_DOMAIN", $_SERVER["HTTP_HOST"]);
define("URL_SUB_FOLDER", str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER["SCRIPT_NAME"])));
define("URL", URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);

/**
 * Configuration for: Database
 * This is the place where you define your database credentials, database type etc.
 */
define("DB_TYPE", "mysql");
define("DB_HOST", "localhost");
define("DB_NAME", "lpb");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_CHARSET", "utf8mb4");


/**
 * Configuration for: Email Sending
 * Define email credentials
 * EMAIL_HOST (since PHPMailer) is either smtp or mail, in this case, smpt.gmail.com
 * EMAIL_USERNAME is email address e.g: example@gmail.com
 * EMAIL_PASSWORD is email app password (16 lowercase letters) e.g: vhsnghskalskdofi
 * Generate app password by (e.g: Gmail) myaccount.google.com -> app passwords
 * */

define("EMAIL_HOST", "smtp.gmail.com");
define("EMAIL_USERNAME", "pvs20231013@gmail.com");
define("EMAIL_PASSWORD", "");
define("EMAIL_SMTP_SECURE", "ssl");
define("EMAIL_PORT", "465");

/**
 * Others
 */
define("APP_NAME", "Landing Page Builder");
define("APP_VERSION", "0.1.0");
define("DIR_MODEL_PAGE", APP . 'model/page/');
define("DIR_MODEL_CUSTOM", APP . 'model/custom/');
define("DALL_E_API_KEY", "");

/**
 * Set default time zone.
 */
date_default_timezone_set("Asia/Singapore");

session_start();
