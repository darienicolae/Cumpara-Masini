<?php

set_time_limit(0);
define('ABSPATH', dirname(__FILE__).'/');
include_once(ABSPATH.'/../../simplehtmldom/simple_html_dom.php');
include_once(ABSPATH.'../../class.scraper_mobile.php');

$s = new Scraper2();
$s->pornesteScraperOlderURLs();

?>