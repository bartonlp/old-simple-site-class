<?php

function callback($class) {
  switch($class) {
    case "SimpleSiteClass":
      require(__DIR__ . "/../../includes/$class.php");
      break;
    default:
      $class = preg_replace("~Simple~", "", $class);
      require(__DIR__ . "/../../includes/database-engines/$class.class.php");
      break;
  }
}

if(spl_autoload_register("callback") === false) exit("Can't Autoload");

SimpleErrorClass::setDevelopment(true);

require(__DIR__ . "/../../includes/database-engines/simple-helper-functions.php");

$_site = json_decode(stripComments(file_get_contents("./mysitemap.json")));

$S = new SimpledbPdo($_site);

// There is more information about the mysql functions at https://bartonlp.github.io/site-class/ or
// in the docs directory.

$sql = "create table if not exists barton.test (`name` varchar(20), `date` datetime, `lasttime` datetime)";
$S->sql($sql);
for($i=0; $i<5; $i++) {
  $name = "A-name$i";
  $S->sql("insert into barton.test (name, date, lasttime) values('$name', now(), now())");
}
$sql = "select * from barton.test order by lasttime";

// For more information on dbTables you can look at the source or the documentation in the docs
// directory on on line at https://bartonlp.github.io/site-class/

$T = new SimpledbTables($S);
$tbl = $T->maketable($sql, ['attr'=>['id'=>'table1', 'border'=>'1']])[0];

$S->sql("drop table barton.test");

$eng = $S->dbinfo->engine;
$dat = $S->dbinfo->database;

echo <<<EOF
<h1>Example6</h1>
<p>Using engine=$eng, database=$dat</p>
<p>We are using the SimpledbPod and SimpledbTables class. We can't have \$top or \$footer.
Also, isBot() and many more things are not in the SimpledbPdo class.</p>
<p>Here are some entries from the 'test' table.</p>
$tbl
<hr>
<a href="example1.php">Example1</a><br>
<a href="example2.php">Example2</a><br>
<a href="example3.php">Example3</a><br>
<a href="example4.php">Example4</a><br>
<a href="example5.php">Example5</a><br>
<a href="example6.php">Example6</a><br>
<a href="../phpinfo.php">PHPINFO</a>
EOF;
