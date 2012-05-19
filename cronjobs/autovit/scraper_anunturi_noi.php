<?php

set_time_limit(0);
include_once('../../simplehtmldom/simple_html_dom.php');
include_once('../../class.scraper_autovit.php');

$s = new Scraper();
$s->scraperAnunturiNoi();

?>