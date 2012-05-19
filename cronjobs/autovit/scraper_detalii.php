<?php

set_time_limit(0);
define('ABSPATH', dirname(__FILE__).'/');
include_once(ABSPATH.'/../../simplehtmldom/simple_html_dom.php');
include_once(ABSPATH.'../../class.scraper_autovit.php');

$s = new Scraper();
$s->pornesteScraperDetalii();

?>