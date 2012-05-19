<?php
require('core.php');

mysql_query("UPDATE masini SET quality=(an_fabricatie*fara_accident+ABS*0.148+airbag*0.087+aer_conditionat*0.025)/(pret+kilometraj) WHERE id<50");
?>