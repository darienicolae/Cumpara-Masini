<?php
include(dirname(__FILE__) . '/html/header.php');
?>

<div align="center">
<img src ="images/header.jpg"/>
<br/><br/>
<h2 style="font-size: 20px"> Best Buy </h2>
<br/><br/>
<?php
echo "<table border=0 width='100%' style='padding-left: 5px;'>";
$result = mysql_query("SELECT * FROM bestbuy b, imagini i, masini m WHERE b.id_masina=m.id AND m.id=i.masina_id AND i.pozitie=1 ORDER BY m.id DESC LIMIT 0,9");
while ($row = mysql_fetch_assoc($result))
{
    echo "<tr>";
    echo "<td style='padding-right: 5px; padding-bottom: 30px !important; '>";
    echo "<a href='detalii.php?id=".$row['id']."'><img src='".$row['url']."' alt='poza' width='150px' border='0'/></a>";
    echo "</td><td valign='top' style='font-size: 13px;'>";
    echo "<a href='detalii.php?id=".$row['id']."'>".$row['nume_anunt']."</a><br/>";
    echo $row['descriere'];
    echo "</td>";
    echo "</tr>";
}
echo "</table>";
?>
<br/><br/>


<h2 style="font-size: 20px"> Ultimele 10 masini </h2>
<br/><br/>
<?php
echo "<table border=0 width='100%' style='padding-left: 5px;'>";
$result = mysql_query("SELECT * FROM imagini i, masini m WHERE m.id=i.masina_id AND i.pozitie=1 ORDER BY m.id DESC LIMIT 0,9");
while ($row = mysql_fetch_assoc($result))
{
    echo "<tr>";
    echo "<td style='padding-right: 5px; padding-bottom: 30px !important; '>";
    echo "<a href='detalii.php?id=".$row['id']."'><img src='".$row['url']."' alt='poza' width='150px' border='0'/></a>";
    echo "</td><td valign='top' style='font-size: 13px;'>";
    echo "<a href='detalii.php?id=".$row['id']."'>".$row['nume_anunt']."</a><br/>";
    echo $row['descriere'];
    echo "</td>";
    echo "</tr>";
}
echo "</table>";
?>
</div>

<?php
include(dirname(__FILE__) . '/html/footer.php');
?>
