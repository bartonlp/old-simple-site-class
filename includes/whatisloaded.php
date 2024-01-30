<?php
// WhatIsLoaded class.
// We return an array with one numeric and the rest are name=>value pairs.
// Look at the getWhatIsInfo() method for what is returned.

namespace bartonlp\whatisloaded;

define("WHATISLOADED_VERSION", "1.0.1whatis-pdo");

(function() {
  class WhatIsLoaded {
    // make all of the values private
    private $site;
    private $siteClass;
    private $database;
    private $dbPdo;
    private $helper;
    private $javaScript;
    private $dbTables;
    private $ErrorClass;
    private $SqlException;
        
    public function __construct() {
      $__VERSION_ONLY = true; // also used by siteload.php, tracker.php, beacon.php.

      $this->site = require(getenv("SITELOADNAME"));
      //$this->site = require("/var/www/simple-site-class/includes/autoload.php"); // USE site-class for
      //TESTING!
      
      $this->siteClass = \SimpleSiteClass::getVersion();
      $this->database = \Database::getVersion();
      $this->dbPdo = \dbPdo::getVersion();
      $this->helper = HELPER_FUNCTION_VERSION;
      $this->dbTables = \dbTables::getVersion();
      $this->ErrorClass= \ErrorClass::getVersion();
      $this->SqlException = \SqlException::getVersion();
    }

    public function getWhatIsInfo() {
      $whatis = $this->getVersion(); // Get the version
      
      $tbl =<<<EOF
<table id='whatIsLoaded' border='1'>
<tbody>
<tr><td>siteload.php</td><td>$this->site</td></tr>
<tr><td>SimpleSiteClass.class.php</td><td>$this->siteClass</td></tr>
<tr><td>SimpleDatabase.class.php</td><td>$this->database</td></tr>
<tr><td>SimpledbPdo.class.php</td><td>$this->dbPdo</td></tr>
<tr><td>SimpledbTables.class.php</td><td>$this->dbTables</td></tr>
<tr><td>SimpleErrorClass.class.php</td><td>$this->ErrorClass</td></tr>
<tr><td>SimpleSqlException.class.php</td><td>$this->SqlException</td></tr>
<tr><td>whatisloaded.class.php</td><td>$whatis</td></tr>
<tr><td>simple-helper-functions.php</td><td>$this->helper</td></tr>
</tbody>
</table>
EOF;

      return [$tbl, "siteload.php"=>$this->site, "SiteClass.class.php"=>$this->siteClass,
      "Database.class.php"=>$this->database,
      "dbPdo.class.php"=>$this->dbPdo,
      "dbTables.class.php"=>$this->dbTables, "ErrorClass.class.php"=>$this->ErrorClass,
      "SqlException.class.php"=>$this->SqlException, 
      "whatisloaded.class.php"=>$whatis,];
    }

    public static function getVersion() {
      return WHATISLOADED_VERSION;
    }
  }
})();

return (new WhatIsLoaded)->getWhatIsInfo();
