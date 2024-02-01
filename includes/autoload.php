<?php
// Auto load classes for SimpleSiteClass

namespace bartonlp\siteload;

error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_WARNING & ~E_NOTICE);

define("SITELOAD_VERSION", "1.1.2autoload-pdo"); // BLP 2024-01-14 - fix HTML to HTTP_HOST.
define("SITECLASS_DIR", __DIR__);

function getSiteloadVersion() {
  return SITELOAD_VERSION;
}

function _callback($class) {
  $class = preg_replace("~^Simple~", "", $class);

  switch($class) {
    case "SiteClass":
      require(__DIR__."/$class.class.php");
      break;
    default:
      require(__DIR__."/database-engines/$class.class.php");
      break;
  }
}

if(spl_autoload_register("\bartonlp\siteload\_callback") === false) exit("Can't Autoload");

require(__DIR__."/database-engines/simple-helper-functions.php");

\SimpleErrorClass::setDevelopment(true);

date_default_timezone_set('America/New_York'); // Done here and in dbPdo.class.php constructor.

// BLP 2024-01-31 -  If this is /var/www/html just return and get the info from mysitemap.json.

if($_SERVER['HTTP_HOST'] == "195.252.232.86") return; 

// BLP 2024-01-31 - for my domain names on HP or rpi.

if($__VERSION_ONLY) {
  return SITELOAD_VERSION;
} else {
  if($_SERVER['HTTP_HOST'] == "bartonphillips.org") {
    if(file_exists("/var/www/bartonphillips.org:8000")) $port = ":8000";
    return json_decode(stripComments(file_get_contents("https://bartonphillips.org$port/mysitemap.json")));
  } else {
    return json_decode(stripComments(file_get_contents("./mysitemap.json")));
  }
}
