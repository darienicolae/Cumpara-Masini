<?php
include(dirname(__FILE__) . '/html/header.php');
?>

<?php
if($_GET['submit'] != 'Cauta')
{
    header('Location: index.php');
    die();
}

require 'Class.Masini.php';

$masini = new Masini();
foreach($_GET as $dada=>$nunu)
	$_GET[$dada] = mysql_real_escape_string($nunu);
$rezult =  $masini->search($_GET);

//die(print_r($rezult));

echo '<div width="868" style="padding: 7px; font-size: 15px; font-weight:bold;"><br/>S-au gasit ' . $rezult[0]['nr_rez'] . ' rezultate<br/><hr/>';

if($rezult[0]['nr_rez'] > 0)
{
if(empty($_GET['page']))
	$_GET['page'] = 1;
$nr_rez = $rezult[0]['nr_rez'];
$nr_pagini = floor($nr_rez / 10) + 1;

$current_link = 'listare.php?';
foreach($_GET as $key => $param)
	if($key != 'page')
		$current_link .= $key . '=' . $param . '&';
$current_link = substr($current_link, 0, -1);	

echo '<table width="882" id="tabel_pg"><tr>';
if($_GET['page'] > 1)
{
	echo '<td width="30"><a href="'.$current_link.'&page=1">&lt;&lt;</a></td>';
	echo '<td width="30"><a href="'.$current_link.'&page=' . ($_GET['page'] - 1) . '">&lt;</a></td>';
}
else 
	echo '<td width="30">&nbsp;</td><td width="30">&nbsp;</td>';

echo '<td align="center">Pagina ' . $_GET['page'] . ' din ' . $nr_pagini . '</td>';	
	
if($_GET['page'] < $nr_pagini)
{
	echo '<td width="30"><a href="'.$current_link.'&page=' . ($_GET['page'] + 1) . '">&gt;</a></td>';
	echo '<td width="30"><a href="'.$current_link.'&page=' . $nr_pagini . '">&gt;&gt;</a></td>';
}
else 
	echo '<td width="30">&nbsp;</td><td width="30">&nbsp;</td>';
echo '</tr></table>';
echo '<hr/></div>';
echo "<table width='882' id='tabel_rezultate'>";
echo "<tr>";
echo "<th width='210' align='left'> Poze </th><th align='left'> Descriere </th><th width='100' align='left'> Pret </th><th width='100' align='left'> Kilometraj</th>";
echo "</tr>";
echo "<tr><td colspan='4'><hr/></td></tr>";

foreach($rezult as $value)
{
    echo "<tr>";

    echo "<td width='210'><a href='detalii.php?id=" .$value['id']. "'><img border='0' src='".$value['url']."' alt='Poza' width='200'/></a></td>";

    echo "<td valign='top'>";
    echo '<a href="detalii.php?id=' .$value['id']. '">' . $value['nume_anunt'] . '</a><br/>';
    
    $dotari = '';
    foreach ($masini->dotari as $dotare)
    {
        if($value[$dotare] == '1')
            $dotari .= $dotare . ', ';
    }
    echo '<br/>' . substr(ucwords(str_replace('_' , ' ',$dotari)),0,-2);
    echo "</td>";

    echo '<td>' . $value['pret'] . ' euro</td>';
    echo '<td>' . $value['kilometraj'] . ' km</td>';
    echo "</tr>";
    
    echo "<tr><td colspan='4'><hr/></td></tr>";
}
echo "</table>";

echo '<div width="868" style="padding: 7px; padding-top: 0px; font-size: 15px; font-weight:bold;">';
echo '<table width="882" id="tabel_pg"><tr>';
if($_GET['page'] > 1)
{
	echo '<td width="30"><a href="'.$current_link.'&page=1">&lt;&lt;</a></td>';
	echo '<td width="30"><a href="'.$current_link.'&page=' . ($_GET['page'] - 1) . '">&lt;</a></td>';
}
else 
	echo '<td width="30">&nbsp;</td><td width="30">&nbsp;</td>';

echo '<td align="center">Pagina ' . $_GET['page'] . ' din ' . $nr_pagini . '</td>';	
	
if($_GET['page'] < $nr_pagini)
{
	echo '<td width="30"><a href="'.$current_link.'&page=' . ($_GET['page'] + 1) . '">&gt;</a></td>';
	echo '<td width="30"><a href="'.$current_link.'&page=' . $nr_pagini . '">&gt;&gt;</a></td>';
}
else 
	echo '<td width="30">&nbsp;</td><td width="30">&nbsp;</td>';
echo '</tr></table>';
echo '<hr/></div>';
}
?>

<?php
include(dirname(__FILE__) . '/html/footer.php');
?>
