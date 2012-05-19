<?php
require('core.php');

$result = mysql_query("SELECT * from masini AS m ORDER BY (quality-(SELECT AVG(quality) FROM masini WHERE marci_id = m.marci_id)) DESC LIMIT 0, 10");

mysql_query("DELETE from bestbuy");
while($row = mysql_fetch_assoc($result))
{
    mysql_query("INSERT INTO bestbuy (id_masina) VALUES ('$row[id]')");
}
?>