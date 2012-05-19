<?php
include_once('../../simple_html_dom.php');

function scraping_slashdot() {
    // create HTML DOM
    $html = file_get_html('http://slashdot.org/');

    // get article block
    foreach($html->find('h4[id^=C]') as $masina) {

        $item['body'] = trim($masina->find('a.otoLink', 0)->plaintext);
		
        $ret[] = $item;

    }
    
    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}

// -----------------------------------------------------------------------------
// test it!
$ret = scraping_slashdot();

foreach($ret as $v) {
    echo '<ul>';
    echo '<li>'.$v['body'].'</li>';
    echo '</ul>';
}
?>