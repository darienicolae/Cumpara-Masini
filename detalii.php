<?php
include(dirname(__FILE__) . '/html/header.php');
?>

<?php
include 'Class.Masini.php';



$titluri = array("marca"=>"","model"=>"","pret"=>" Euro","kilometraj"=>" Km",
                 "an_fabricatie"=>"","putere"=>"CP","capacitate"=>" cm cubi","tip_combustibil"=>"",
                 "transmisie"=>"","nr_usi"=>"","culoare"=>"","stare_tehnica"=>"","tara_origine"=>"",
                 "tara_inmatriculare"=>"","cilindre"=>"","tapiserie"=>"","culoare_tapiserie"=>"","norme_euro"=>"");

$masina = new Masini();
if ($rezultat = $masina->getDetails($_GET["id"]))
{
//die(print_r($rezultat));
    $dotari = '';
    foreach ($masina->dotari as $dotare)
    {
        if($rezultat[$dotare] == '1')
            $dotari .= $dotare . ' , ';
    }
	echo '<div style="width: 100%; padding: 10px; font-size: 13px;">';
    echo "<h2 style='font-size: 20px;'>".$rezultat['nume_anunt']."</h2><br/>";

?>

<div style="width: 420px; float: right; font-size: 13px;">
    <?php //die(print_r($rezultat));  ?>
<a href="<?php echo $rezultat['imagini'][0]['url'];?>" rel="poze"><img src="<?php echo $rezultat['imagini'][0]['url'];?>" width="400" border="0" alt="Poza"/></a>
<?php
$i = 0;
foreach($rezultat['imagini'] as $img)
{
	if($i>0)
	echo '<a href="'.$img['url'].'" rel="poze"></a>';	
	$i++;
}
?>
</div>
<?php    
    
    echo '<table>';

    foreach($titluri as $val => $aux)
    {
        if(!empty($rezultat[$val]))
        {
            echo '<tr>';
            echo '<td style="padding-right: 30px; padding-bottom: 4px;">' . ucwords(str_replace('_', ' ', $val)) . ':</td>';
            echo '<td>' . $rezultat[$val] . $aux . '</td>';
            echo '</tr>';
        }
    }

    echo '</table><br/>';
    echo "<h4 style='font-size: 15px;'> Dotari: </h4><br/>".substr(ucwords(str_replace('_' , ' ',$dotari)),0,-2);

    echo "<br/><br/><h4 style='font-size: 15px;'> Descriere: </h4><br/>".$rezultat['descriere']."<br><br>";
    echo "<h4 style='font-size: 15px;'> Detalii vanzator: </h4><br/>";
    echo "Tara: ".$rezultat['vanzator_tara'];
    if(!empty($rezultat['vanzator_oras']))
    echo "<br>Oras: ".$rezultat['vanzator_oras'];
    echo "<br>Telefon: ".$rezultat['vanzator_telefon']."<br><br>";

    echo "<h4> Linkuri: </h4>";
    if (!empty($rezultat['url_autovit']))
        echo "<a href='".$rezultat['url_autovit']."'>".$rezultat['url_autovit']."</a><br>";
    if (!empty($rezultat['url_mobile']))
        echo "<a href='".$rezultat['url_mobile']."'>".$rezultat['url_mobile']."</a><br>";
}
echo '</div>';
?>

<?php
include(dirname(__FILE__) . '/html/footer.php');
?>
