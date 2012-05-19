<option value="oricare">Oricare</option>
<?php
require('core.php');
$res = mysql_query("SELECT * from modele where marci_id='$_GET[id]'");
while($row = mysql_fetch_assoc($res))
{
    //die(print_r($row));
    echo '<option value="' . $row['id'] . '">' . $row['nume_model'] . "</option>\n";
}
?>
