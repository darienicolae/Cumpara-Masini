<?php
require('core.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cumpara Masini</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='jquery-1.7.2.min.js'></script>
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
		$(document).ready(function() {
			$("a[rel=poze]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Imagine ' + (currentIndex + 1) + ' din ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});
		});
	</script>
<script type="text/javascript">
function showHideCautare()
{
	if ($('#cautare_avansata').css('display') == "none")
            {
		$('#cautare_avansata').show('slow');
                $('#cautare_avansata2').show('slow');
            }
	else
            {
		$('#cautare_avansata').hide('slow');
                $('#cautare_avansata2').hide('slow');
            }
}
</script>
</head>

<body>
<div id="topbar">
<div id="TopSection">
    <div id="divFix">

<div id="topbarnav">
    <form action="listare.php" method="get">
    <span class="topnavitems">
        <div class="searchform" align="center">
            <div style="width: 0px; float:left;margin-left: 25px;" >
                <h1 id="sitename"><span><a href="index.php">C</a></span><a href="index.php">umpara <span>M</span>asini</a></h1>
            </div>
            <table style="border: 0px;width: 980px; padding-left:-35px !important;" id="tabelas">
                <tr>
                    <td>
                        <label for="searchtxt">Marca:</label>
            <select class="keywordfield" id="camp_marca" name="masini_marci_id">
                <option value="oricare">Oricare</option>
                <?php
                    $res = mysql_query("SELECT * from marci");
                    while($row = mysql_fetch_assoc($res))
                    {
                        echo '<option value="' . $row['id'] . '"';

                        if($_GET['masini_marci_id'] == $row['id'])
                        	echo ' selected ';

                        echo '>' . $row['nume_marca'] . '</option>';
                    }
                ?>
            </select>
                    </td>
                    <td>
                        <label for="searchtxt">Pret de la:</label>
            <select class="keywordfield" name="pret_min">
                <option value="oricare">Oricare</option>
                <option value="500" <?php if($_GET['pret_min'] == '500') echo 'selected';?>>500</option>
                <option value="1000" <?php if($_GET['pret_min'] == '1000') echo 'selected';?>>1.000</option>
                <option value="2000" <?php if($_GET['pret_min'] == '2000') echo 'selected';?>>2.000</option>
                <option value="3000" <?php if($_GET['pret_min'] == '3000') echo 'selected';?>>3.000</option>
                <option value="4000" <?php if($_GET['pret_min'] == '4000') echo 'selected';?>>4.000</option>
                <option value="5000" <?php if($_GET['pret_min'] == '5000') echo 'selected';?>>5.000</option>
                <option value="6000" <?php if($_GET['pret_min'] == '6000') echo 'selected';?>>6.000</option>
                <option value="7000" <?php if($_GET['pret_min'] == '7000') echo 'selected';?>>7.000</option>
                <option value="8000" <?php if($_GET['pret_min'] == '8000') echo 'selected';?>>8.000</option>
                <option value="9000" <?php if($_GET['pret_min'] == '9000') echo 'selected';?>>9.000</option>
                <option value="10000" <?php if($_GET['pret_min'] == '10000') echo 'selected';?>>10.000</option>
                <option value="11000" <?php if($_GET['pret_min'] == '11000') echo 'selected';?>>11.000</option>
                <option value="12000" <?php if($_GET['pret_min'] == '12000') echo 'selected';?>>12.000</option>
                <option value="13000" <?php if($_GET['pret_min'] == '13000') echo 'selected';?>>13.000</option>
                <option value="14000" <?php if($_GET['pret_min'] == '14000') echo 'selected';?>>14.000</option>
                <option value="15000" <?php if($_GET['pret_min'] == '15000') echo 'selected';?>>15.000</option>
                <option value="17500" <?php if($_GET['pret_min'] == '17500') echo 'selected';?>>17.500</option>
                <option value="20000" <?php if($_GET['pret_min'] == '20000') echo 'selected';?>>20.000</option>
                <option value="22500" <?php if($_GET['pret_min'] == '22500') echo 'selected';?>>22.500</option>
                <option value="25000" <?php if($_GET['pret_min'] == '25000') echo 'selected';?>>25.000</option>
            </select>
                    </td>
                    <td>
                         <label for="searchtxt">An de fabricatie de la:</label>
            <select class="keywordfield" name="an_fabricatie_min">
                <option value="oricare">Oricare</option>
                <option value="2012" <?php if($_GET['an_fabricatie_min'] == '2012') echo 'selected';?>>2012</option>
				<option value="2011" <?php if($_GET['an_fabricatie_min'] == '2011') echo 'selected';?>>2011</option>
				<option value="2010" <?php if($_GET['an_fabricatie_min'] == '2010') echo 'selected';?>>2010</option>
				<option value="2009" <?php if($_GET['an_fabricatie_min'] == '2009') echo 'selected';?>>2009</option>
				<option value="2008" <?php if($_GET['an_fabricatie_min'] == '2008') echo 'selected';?>>2008</option>
                <option value="2007" <?php if($_GET['an_fabricatie_min'] == '2007') echo 'selected';?>>2007</option>
                <option value="2006" <?php if($_GET['an_fabricatie_min'] == '2006') echo 'selected';?>>2006</option>
                <option value="2005" <?php if($_GET['an_fabricatie_min'] == '2005') echo 'selected';?>>2005</option>
                <option value="2004" <?php if($_GET['an_fabricatie_min'] == '2004') echo 'selected';?>>2004</option>
                <option value="2003" <?php if($_GET['an_fabricatie_min'] == '2003') echo 'selected';?>>2003</option>
                <option value="2002" <?php if($_GET['an_fabricatie_min'] == '2002') echo 'selected';?>>2002</option>
                <option value="2001" <?php if($_GET['an_fabricatie_min'] == '2001') echo 'selected';?>>2001</option>
                <option value="2000" <?php if($_GET['an_fabricatie_min'] == '2000') echo 'selected';?>>2000</option>
                <option value="1999" <?php if($_GET['an_fabricatie_min'] == '1999') echo 'selected';?>>1999</option>
                <option value="1998" <?php if($_GET['an_fabricatie_min'] == '1998') echo 'selected';?>>1998</option>
                <option value="1997" <?php if($_GET['an_fabricatie_min'] == '1997') echo 'selected';?>>1997</option>
                <option value="1996" <?php if($_GET['an_fabricatie_min'] == '1996') echo 'selected';?>>1996</option>
                <option value="1995" <?php if($_GET['an_fabricatie_min'] == '1995') echo 'selected';?>>1995</option>
                <option value="1994" <?php if($_GET['an_fabricatie_min'] == '1994') echo 'selected';?>>1994</option>
                <option value="1993" <?php if($_GET['an_fabricatie_min'] == '1993') echo 'selected';?>>1993</option>
                <option value="1992" <?php if($_GET['an_fabricatie_min'] == '1992') echo 'selected';?>>1992</option>
                <option value="1991" <?php if($_GET['an_fabricatie_min'] == '1991') echo 'selected';?>>1991</option>
                <option value="1990" <?php if($_GET['an_fabricatie_min'] == '1990') echo 'selected';?>>1990</option>
                <option value="1985" <?php if($_GET['an_fabricatie_min'] == '1985') echo 'selected';?>>1985</option>
                <option value="1980" <?php if($_GET['an_fabricatie_min'] == '1980') echo 'selected';?>>1980</option>
                <option value="1975" <?php if($_GET['an_fabricatie_min'] == '1975') echo 'selected';?>>1975</option>
                <option value="1970" <?php if($_GET['an_fabricatie_min'] == '1970') echo 'selected';?>>1970</option>
                <option value="1965" <?php if($_GET['an_fabricatie_min'] == '1965') echo 'selected';?>>1965</option>
                <option value="1960" <?php if($_GET['an_fabricatie_min'] == '1960') echo 'selected';?>>1960</option>
                <option value="1900" <?php if($_GET['an_fabricatie_min'] == '1900') echo 'selected';?>>1900</option>
            </select>
                    </td>
                    <td>
                        <label for="searchtxt">Km parcursi de la:</label>
            <select class="keywordfield" name="kilometraj_min">
                <option value="">Oricare</option>
                <option value="5000" <?php if($_GET['kilometraj_min'] == '5000') echo 'selected';?>>5.000</option>
                <option value="10000" <?php if($_GET['kilometraj_min'] == '10000') echo 'selected';?>>10.000</option>
                <option value="20000" <?php if($_GET['kilometraj_min'] == '20000') echo 'selected';?>>20.000</option>
                <option value="30000" <?php if($_GET['kilometraj_min'] == '30000') echo 'selected';?>>30.000</option>
                <option value="40000" <?php if($_GET['kilometraj_min'] == '40000') echo 'selected';?>>40.000</option>
                <option value="50000" <?php if($_GET['kilometraj_min'] == '50000') echo 'selected';?>>50.000</option>
                <option value="60000" <?php if($_GET['kilometraj_min'] == '60000') echo 'selected';?>>60.000</option>
                <option value="70000" <?php if($_GET['kilometraj_min'] == '70000') echo 'selected';?>>70.000</option>
                <option value="80000" <?php if($_GET['kilometraj_min'] == '80000') echo 'selected';?>>80.000</option>
                <option value="90000" <?php if($_GET['kilometraj_min'] == '90000') echo 'selected';?>>90.000</option>
                <option value="100000" <?php if($_GET['kilometraj_min'] == '100000') echo 'selected';?>>100.000</option>
                <option value="125000" <?php if($_GET['kilometraj_min'] == '125000') echo 'selected';?>>125.000</option>
                <option value="150000" <?php if($_GET['kilometraj_min'] == '150000') echo 'selected';?>>150.000</option>
            </select>
                    </td>
                    <td>
                        <label for="searchtxt">Tara:</label>
            <select class="keywordfield" name="tara_vanzator">
                <option value="oricare">Oricare</option>
                <?php
                    $res = mysql_query("SELECT * from tari");
                    while($row = mysql_fetch_assoc($res))
                    {
                        echo '<option value="' . $row['id'] . '"';

                        if($_GET['tara_vanzator'] == $row['id'])
                        	echo ' selected ';

                        echo '>' . $row['nume_tara'] . '</option>';
                    }
                ?>
            </select>
                    </td>
                    <td style="text-align: center !important; padding-left: 25px;" rowspan="2">
                                         <input type="image" src="images/search.png" style="width: 75px;" value="Cauta" name="submit"/>
                <br/>
                <a href="#" onclick="showHideCautare();">Cautare avansata</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="searchtxt">Model:</label>
            <select class="keywordfield" id="camp_model" name="model_id">
            <option value="oricare">Oricare</option>
            <?php
                $res = mysql_query("SELECT * from modele WHERE marci_id='$_GET[masini_marci_id]'");
                    while($row = mysql_fetch_assoc($res))
                    {
                        echo '<option value="' . $row['id'] . '"';

                        if($_GET['model_id'] == $row['id'])
                        	echo ' selected ';

                        echo '>' . $row['nume_model'] . '</option>';
                    }
            ?>
            </select>
                    </td>
                    <td>
                        <label for="searchtxt">pana la:</label>
            <select class="keywordfield" name="pret_max">
                <option value="oricare">Oricare</option>
                <option value="501" <?php if($_GET['pret_max'] == '501') echo 'selected';?>>501</option>
                <option value="1001" <?php if($_GET['pret_max'] == '1001') echo 'selected';?>>1.001</option>
                <option value="2001" <?php if($_GET['pret_max'] == '2001') echo 'selected';?>>2.001</option>
                <option value="3001" <?php if($_GET['pret_max'] == '3001') echo 'selected';?>>3.001</option>
                <option value="4001" <?php if($_GET['pret_max'] == '4001') echo 'selected';?>>4.001</option>
                <option value="5001" <?php if($_GET['pret_max'] == '5001') echo 'selected';?>>5.001</option>
                <option value="6001" <?php if($_GET['pret_max'] == '6001') echo 'selected';?>>6.001</option>
                <option value="7001" <?php if($_GET['pret_max'] == '7001') echo 'selected';?>>7.001</option>
                <option value="8001" <?php if($_GET['pret_max'] == '8001') echo 'selected';?>>8.001</option>
                <option value="9001" <?php if($_GET['pret_max'] == '9001') echo 'selected';?>>9.001</option>
                <option value="10001" <?php if($_GET['pret_max'] == '10001') echo 'selected';?>>10.001</option>
                <option value="11001" <?php if($_GET['pret_max'] == '11001') echo 'selected';?>>11.001</option>
                <option value="12001" <?php if($_GET['pret_max'] == '12001') echo 'selected';?>>12.001</option>
                <option value="13001" <?php if($_GET['pret_max'] == '13001') echo 'selected';?>>13.001</option>
                <option value="14001" <?php if($_GET['pret_max'] == '14001') echo 'selected';?>>14.001</option>
                <option value="15001" <?php if($_GET['pret_max'] == '15001') echo 'selected';?>>15.001</option>
                <option value="17501" <?php if($_GET['pret_max'] == '17501') echo 'selected';?>>17.501</option>
                <option value="20001" <?php if($_GET['pret_max'] == '20001') echo 'selected';?>>20.001</option>
                <option value="22501" <?php if($_GET['pret_max'] == '22501') echo 'selected';?>>22.501</option>
                <option value="25001" <?php if($_GET['pret_max'] == '25001') echo 'selected';?>>25.001</option>
            </select>
                    </td>
                    <td>
                        <label for="searchtxt">pana la:</label>
            <select class="keywordfield" name="an_fabricatie_max">
                <option value="oricare">Oricare</option>
                <option value="2012" <?php if($_GET['an_fabricatie_max'] == '2012') echo 'selected';?>>2012</option>
				<option value="2011" <?php if($_GET['an_fabricatie_max'] == '2011') echo 'selected';?>>2011</option>
				<option value="2010" <?php if($_GET['an_fabricatie_max'] == '2010') echo 'selected';?>>2010</option>
				<option value="2009" <?php if($_GET['an_fabricatie_max'] == '2009') echo 'selected';?>>2009</option>
				<option value="2008" <?php if($_GET['an_fabricatie_max'] == '2008') echo 'selected';?>>2008</option>
                <option value="2007" <?php if($_GET['an_fabricatie_max'] == '2007') echo 'selected';?>>2007</option>
                <option value="2006" <?php if($_GET['an_fabricatie_max'] == '2006') echo 'selected';?>>2006</option>
                <option value="2005" <?php if($_GET['an_fabricatie_max'] == '2005') echo 'selected';?>>2005</option>
                <option value="2004" <?php if($_GET['an_fabricatie_max'] == '2004') echo 'selected';?>>2004</option>
                <option value="2003" <?php if($_GET['an_fabricatie_max'] == '2003') echo 'selected';?>>2003</option>
                <option value="2002" <?php if($_GET['an_fabricatie_max'] == '2002') echo 'selected';?>>2002</option>
                <option value="2001" <?php if($_GET['an_fabricatie_max'] == '2001') echo 'selected';?>>2001</option>
                <option value="2000" <?php if($_GET['an_fabricatie_max'] == '2000') echo 'selected';?>>2000</option>
                <option value="1999" <?php if($_GET['an_fabricatie_max'] == '1999') echo 'selected';?>>1999</option>
                <option value="1998" <?php if($_GET['an_fabricatie_max'] == '1998') echo 'selected';?>>1998</option>
                <option value="1997" <?php if($_GET['an_fabricatie_max'] == '1997') echo 'selected';?>>1997</option>
                <option value="1996" <?php if($_GET['an_fabricatie_max'] == '1996') echo 'selected';?>>1996</option>
                <option value="1995" <?php if($_GET['an_fabricatie_max'] == '1995') echo 'selected';?>>1995</option>
                <option value="1994" <?php if($_GET['an_fabricatie_max'] == '1994') echo 'selected';?>>1994</option>
                <option value="1993" <?php if($_GET['an_fabricatie_max'] == '1993') echo 'selected';?>>1993</option>
                <option value="1992" <?php if($_GET['an_fabricatie_max'] == '1992') echo 'selected';?>>1992</option>
                <option value="1991" <?php if($_GET['an_fabricatie_max'] == '1991') echo 'selected';?>>1991</option>
                <option value="1990" <?php if($_GET['an_fabricatie_max'] == '1990') echo 'selected';?>>1990</option>
                <option value="1985" <?php if($_GET['an_fabricatie_max'] == '1985') echo 'selected';?>>1985</option>
                <option value="1980" <?php if($_GET['an_fabricatie_max'] == '1980') echo 'selected';?>>1980</option>
                <option value="1975" <?php if($_GET['an_fabricatie_max'] == '1975') echo 'selected';?>>1975</option>
                <option value="1970" <?php if($_GET['an_fabricatie_max'] == '1970') echo 'selected';?>>1970</option>
                <option value="1965" <?php if($_GET['an_fabricatie_max'] == '1965') echo 'selected';?>>1965</option>
                <option value="1960" <?php if($_GET['an_fabricatie_max'] == '1960') echo 'selected';?>>1960</option>
                <option value="1900" <?php if($_GET['an_fabricatie_max'] == '1900') echo 'selected';?>>1900</option>
            </select>
                    </td>
                    <td>
                        <label for="searchtxt">pana la:</label>
            <select class="keywordfield" name="kilometraj_max">
                <option value="oricare">Oricare</option>
                <option value="5000" <?php if($_GET['kilometraj_max'] == '5000') echo 'selected';?>>5.000</option>
                <option value="10000" <?php if($_GET['kilometraj_max'] == '10000') echo 'selected';?>>10.000</option>
                <option value="20000" <?php if($_GET['kilometraj_max'] == '20000') echo 'selected';?>>20.000</option>
                <option value="30000" <?php if($_GET['kilometraj_max'] == '30000') echo 'selected';?>>30.000</option>
                <option value="40000" <?php if($_GET['kilometraj_max'] == '40000') echo 'selected';?>>40.000</option>
                <option value="50000" <?php if($_GET['kilometraj_max'] == '50000') echo 'selected';?>>50.000</option>
                <option value="60000" <?php if($_GET['kilometraj_max'] == '60000') echo 'selected';?>>60.000</option>
                <option value="70000" <?php if($_GET['kilometraj_max'] == '70000') echo 'selected';?>>70.000</option>
                <option value="80000" <?php if($_GET['kilometraj_max'] == '80000') echo 'selected';?>>80.000</option>
                <option value="90000" <?php if($_GET['kilometraj_max'] == '90000') echo 'selected';?>>90.000</option>
                <option value="100000" <?php if($_GET['kilometraj_max'] == '100000') echo 'selected';?>>100.000</option>
                <option value="125000" <?php if($_GET['kilometraj_max'] == '125000') echo 'selected';?>>125.000</option>
                <option value="150000" <?php if($_GET['kilometraj_max'] == '150000') echo 'selected';?>>150.000</option>
                <option value="200000" <?php if($_GET['kilometraj_max'] == '200000') echo 'selected';?>>200.000</option>
            </select>
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>           
   	<div id="cautare_avansata" style="background-color: #336699; display: none;">
   	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>
        <table id="tavans">
            <tr>
            <td>
                <label for="">Putere de la:</label>
                <select class="keywordfield" name="putere_min">
        	<option value="oricare">Oricare</option>
        	<option value="50" <?php if($_GET['putere_min'] == '50') echo 'selected';?>>50 CP</option>
			<option value="60" <?php if($_GET['putere_min'] == '60') echo 'selected';?>>60 CP</option>
			<option value="80" <?php if($_GET['putere_min'] == '80') echo 'selected';?>>80 CP</option>
			<option value="100" <?php if($_GET['putere_min'] == '100') echo 'selected';?>>100 CP</option>
			<option value="125" <?php if($_GET['putere_min'] == '125') echo 'selected';?>>125 CP</option>
			<option value="150" <?php if($_GET['putere_min'] == '150') echo 'selected';?>>150 CP</option>
			<option value="200" <?php if($_GET['putere_min'] == '200') echo 'selected';?>>200 CP</option>
			<option value="300" <?php if($_GET['putere_min'] == '300') echo 'selected';?>>300 CP</option>
			<option value="400" <?php if($_GET['putere_min'] == '400') echo 'selected';?>>400 CP</option>
			<option value="500" <?php if($_GET['putere_min'] == '500') echo 'selected';?>>500 CP</option>
                </select>
            </td>
            <td>
                <label for="">Capacitate de la</label>
                <select class="keywordfield" name="capacitate_min">
        	<option value="oricare">Oricare</option>
			<option value="500" <?php if($_GET['capacitate_min'] == '500') echo 'selected';?>>500 cm cubi</option>
			<option value="700" <?php if($_GET['capacitate_min'] == '700') echo 'selected';?>>700 cm cubi</option>
			<option value="900" <?php if($_GET['capacitate_min'] == '900') echo 'selected';?>>900 cm cubi</option>
			<option value="1100" <?php if($_GET['capacitate_min'] == '1100') echo 'selected';?>>1100 cm cubi</option>
			<option value="1200" <?php if($_GET['capacitate_min'] == '1200') echo 'selected';?>>1200 cm cubi</option>
			<option value="1400" <?php if($_GET['capacitate_min'] == '1400') echo 'selected';?>>1400 cm cubi</option>
			<option value="1500" <?php if($_GET['capacitate_min'] == '1500') echo 'selected';?>>1500 cm cubi</option>
			<option value="1600" <?php if($_GET['capacitate_min'] == '1600') echo 'selected';?>>1600 cm cubi</option>
			<option value="1700" <?php if($_GET['capacitate_min'] == '1700') echo 'selected';?>>1700 cm cubi</option>
			<option value="1800" <?php if($_GET['capacitate_min'] == '1800') echo 'selected';?>>1800 cm cubi</option>
			<option value="1900" <?php if($_GET['capacitate_min'] == '1900') echo 'selected';?>>1900 cm cubi</option>
			<option value="2000" <?php if($_GET['capacitate_min'] == '2000') echo 'selected';?>>2000 cm cubi</option>
			<option value="2500" <?php if($_GET['capacitate_min'] == '2500') echo 'selected';?>>2500 cm cubi</option>
			<option value="3000" <?php if($_GET['capacitate_min'] == '3000') echo 'selected';?>>3000 cm cubi</option>
			<option value="3500" <?php if($_GET['capacitate_min'] == '3500') echo 'selected';?>>3500 cm cubi</option>
			<option value="4000" <?php if($_GET['capacitate_min'] == '4000') echo 'selected';?>>4000 cm cubi</option>
			<option value="5000" <?php if($_GET['capacitate_min'] == '5000') echo 'selected';?>>5000 cm cubi</option>
			<option value="6000" <?php if($_GET['capacitate_min'] == '6000') echo 'selected';?>>6000 cm cubi</option>
                </select>
            </td>
            <td>
            <label for="searchtxt">Tip masina:</label>
            <select class="keywordfield" name="tip_masina">
        	<option value="oricare">Oricare</option>
        	<option value="Berlina" <?php if($_GET['tip_masina'] == 'Berlina') echo 'selected';?>>Berlina</option>
        	<option value="Break" <?php if($_GET['tip_masina'] == 'Break') echo 'selected';?>>Break</option>
        	<option value="Van/minibus" <?php if($_GET['tip_masina'] == 'Van/minibus') echo 'selected';?>>Van/minibus</option>
        	<option value="Pick-Up/Off-road" <?php if($_GET['tip_masina'] == 'Pick-Up/Off-road') echo 'selected';?>>Pick-Up/Off-road</option>
        	<option value="Cabrio" <?php if($_GET['tip_masina'] == 'Cabrio') echo 'selected';?>>Cabrio</option>
        	<option value="Coupe/Sport" <?php if($_GET['tip_masina'] == 'Coupe/Sport') echo 'selected';?>>Coupe/Sport</option>
             </select>
            </td>
            <td>
                <label for="">Tip combustibil</label>
                <select class="keywordfield" name="tip_combustibil">
        	<option value="oricare">Oricare</option>
        	<option value="Diesel" <?php if($_GET['tip_combustibil'] == 'Diesel') echo 'selected';?>>Diesel</option>
        	<option value="Benzina" <?php if($_GET['tip_combustibil'] == 'Benzina') echo 'selected';?>>Benzina</option>
        	<option value="Gaz" <?php if($_GET['tip_combustibil'] == 'Gaz') echo 'selected';?>>Gaz</option>
        	<option value="Hibrid" <?php if($_GET['tip_combustibil'] == 'Hibrid') echo 'selected';?>>Hibrid</option>
        	<option value="Electric" <?php if($_GET['tip_combustibil'] == 'Electric') echo 'selected';?>>Electric</option>
        	<option value="Hidrogen" <?php if($_GET['tip_combustibil'] == 'Hidrogen') echo 'selected';?>>Hidrogen</option>
        	<option value="Etanol" <?php if($_GET['tip_combustibil'] == 'Etanol') echo 'selected';?>>Etanol</option>
                </select>
            </td>
            <td>
                <label for="">Transmisie</label>
                <select class="keywordfield" name="transmisie">
        	<option value="oricare">Oricare</option>
        	<option value="Automata" <?php if($_GET['transmisie'] == 'Automata') echo 'selected';?>>Automata</option>
        	<option value="Manuala" <?php if($_GET['transmisie'] == 'Manuala') echo 'selected';?>>Manuala</option>
        	<option value="Semi-automata/Secventiala" <?php if($_GET['transmisie'] == 'Semi-automata/Secventiala') echo 'selected';?>>Semi-automata/Secventiala</option>
                </select>
            </td>
            </tr>

            <tr>
            <td>
                <label for="">pana la:</label>
                <select class="keywordfield" name="putere_max">
        	<option value="oricare">Oricare</option>
        	<option value="50" <?php if($_GET['putere_max'] == '50') echo 'selected';?>>50 CP</option>
			<option value="60" <?php if($_GET['putere_max'] == '60') echo 'selected';?>>60 CP</option>
			<option value="80" <?php if($_GET['putere_max'] == '80') echo 'selected';?>>80 CP</option>
			<option value="100" <?php if($_GET['putere_max'] == '100') echo 'selected';?>>100 CP</option>
			<option value="125" <?php if($_GET['putere_max'] == '125') echo 'selected';?>>125 CP</option>
			<option value="150" <?php if($_GET['putere_max'] == '150') echo 'selected';?>>150 CP</option>
			<option value="200" <?php if($_GET['putere_max'] == '200') echo 'selected';?>>200 CP</option>
			<option value="300" <?php if($_GET['putere_max'] == '300') echo 'selected';?>>300 CP</option>
			<option value="400" <?php if($_GET['putere_max'] == '400') echo 'selected';?>>400 CP</option>
			<option value="500" <?php if($_GET['putere_max'] == '500') echo 'selected';?>>500 CP</option>
                </select>
            </td>
            <td>
                <label for="">pana la</label>
                <select class="keywordfield" name="capacitate_max">
        	<option value="oricare">Oricare</option>
			<option value="500" <?php if($_GET['capacitate_max'] == '500') echo 'selected';?>>500 cm cubi</option>
			<option value="700" <?php if($_GET['capacitate_max'] == '700') echo 'selected';?>>700 cm cubi</option>
			<option value="900" <?php if($_GET['capacitate_max'] == '900') echo 'selected';?>>900 cm cubi</option>
			<option value="1100" <?php if($_GET['capacitate_max'] == '1100') echo 'selected';?>>1100 cm cubi</option>
			<option value="1200" <?php if($_GET['capacitate_max'] == '1200') echo 'selected';?>>1200 cm cubi</option>
			<option value="1400" <?php if($_GET['capacitate_max'] == '1400') echo 'selected';?>>1400 cm cubi</option>
			<option value="1500" <?php if($_GET['capacitate_max'] == '1500') echo 'selected';?>>1500 cm cubi</option>
			<option value="1600" <?php if($_GET['capacitate_max'] == '1600') echo 'selected';?>>1600 cm cubi</option>
			<option value="1700" <?php if($_GET['capacitate_max'] == '1700') echo 'selected';?>>1700 cm cubi</option>
			<option value="1800" <?php if($_GET['capacitate_max'] == '1800') echo 'selected';?>>1800 cm cubi</option>
			<option value="1900" <?php if($_GET['capacitate_max'] == '1900') echo 'selected';?>>1900 cm cubi</option>
			<option value="2000" <?php if($_GET['capacitate_max'] == '2000') echo 'selected';?>>2000 cm cubi</option>
			<option value="2500" <?php if($_GET['capacitate_max'] == '2500') echo 'selected';?>>2500 cm cubi</option>
			<option value="3000" <?php if($_GET['capacitate_max'] == '3000') echo 'selected';?>>3000 cm cubi</option>
			<option value="3500" <?php if($_GET['capacitate_max'] == '3500') echo 'selected';?>>3500 cm cubi</option>
			<option value="4000" <?php if($_GET['capacitate_max'] == '4000') echo 'selected';?>>4000 cm cubi</option>
			<option value="5000" <?php if($_GET['capacitate_max'] == '5000') echo 'selected';?>>5000 cm cubi</option>
			<option value="6000" <?php if($_GET['capacitate_max'] == '6000') echo 'selected';?>>6000 cm cubi</option>
                </select>
            </td>
            <td>
                <label for="">Stare tehnica</label>
                <select class="keywordfield" name="stare_tehnica">
        	<option value="oricare">Oricare</option>
        	<option value="Avariat" <?php if($_GET['stare_tehnica'] == 'Avariat') echo 'selected';?>>Avariat</option>
        	<option value="Neavariat" <?php if($_GET['stare_tehnica'] == 'Neavariat') echo 'selected';?>>Neavariat</option>
        	<option value="Nou" <?php if($_GET['stare_tehnica'] == 'Nou') echo 'selected';?>>Nou</option>
                </select>
            </td>
            <td>
                <label for="">Numar de usi</label>
                <select class="keywordfield" name="nr_usi">
        	<option value="oricare">Oricare</option>
        	<option value="2/3" <?php if($_GET['nr_usi'] == '2/3') echo 'selected';?>>2/3</option>
        	<option value="4/5" <?php if($_GET['nr_usi'] == '4/5') echo 'selected';?>>4/5</option>
        	<option value="6/7" <?php if($_GET['nr_usi'] == '6/7') echo 'selected';?>>6/7</option>
                </select>
            </td>
            <td>
                <label for="">Culoare</label>
                <select class="keywordfield" name="culoare">
        	<option value="oricare">Oricare</option>
        	<option value="Alb" <?php if($_GET['culoare'] == 'Alb') echo 'selected';?>>Alb</option>
        	<option value="Albastru"<?php if($_GET['culoare'] == 'Albastru') echo 'selected';?>>Albastru</option>
        	<option value="Argintiu"<?php if($_GET['culoare'] == 'Argintiu') echo 'selected';?>>Argintiu</option>
        	<option value="Auriu"<?php if($_GET['culoare'] == 'Auriu') echo 'selected';?>>Auriu</option>
        	<option value="Bej"<?php if($_GET['culoare'] == 'Bej') echo 'selected';?>>Bej</option>
        	<option value="Galben"<?php if($_GET['culoare'] == 'Galben') echo 'selected';?>>Galben</option>
        	<option value="Gri"<?php if($_GET['culoare'] == 'Gri') echo 'selected';?>>Gri</option>
        	<option value="Maro"<?php if($_GET['culoare'] == 'Maro') echo 'selected';?>>Maro</option>
        	<option value="Negru"<?php if($_GET['culoare'] == 'Negru') echo 'selected';?>>Negru</option>
        	<option value="Portocaliu"<?php if($_GET['culoare'] == 'Portocaliu') echo 'selected';?>>Portocaliu</option>
        	<option value="Rosu"<?php if($_GET['culoare'] == 'Rosu') echo 'selected';?>>Rosu</option>
        	<option value="Verde"<?php if($_GET['culoare'] == 'Verde') echo 'selected';?>>Verde</option>
        	<option value="Violet"<?php if($_GET['culoare'] == 'Violet') echo 'selected';?>>Violet</option>
        	<option value="Visiniu"<?php if($_GET['culoare'] == 'Visiniu') echo 'selected';?>>Visiniu</option>
                </select>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Metalizat <input type="checkbox" <?php if($_GET['metalizat'] == '1') echo 'checked';?> name="metalizat" value="1"/>
            </td>
            </tr>
        </table>
 <br/>
        
        
        Primul proprietar <input type="checkbox" <?php if($_GET['primul_proprietar'] == '1') echo 'checked';?> name="primul_proprietar" value="1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Tva deductbil <input type="checkbox" <?php if($_GET['tva_deductibil'] == '1') echo 'checked';?> name="tva_deductibil" value="1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Filtru de particule <input type="checkbox" <?php if($_GET['filtru_particule'] == '1') echo 'checked';?> name="filtru_particule" value="1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Airbag <input type="checkbox" name="airbag" <?php if($_GET['airbag'] == '1') echo 'checked';?> value="1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        
        ABS <input type="checkbox" <?php if($_GET['ABS'] == '1') echo 'checked';?> name="ABS" value="1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        EDS <input type="checkbox" <?php if($_GET['EDS'] == '1') echo 'checked';?> name="EDS" value="1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        ESP <input type="checkbox" <?php if($_GET['ESP'] == '1') echo 'checked';?> name="ESP" value="1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Carlig de remorcare <input type="checkbox" <?php if($_GET['carlig_remorcare'] == '1') echo 'checked';?> name="carlig_remorcare" value="1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
        
        
        Jante de aliaj <input type="checkbox" <?php if($_GET['jante_aliaj'] == '1') echo 'checked';?> name="jante_aliaj" value="1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Xenon <input type="checkbox" <?php if($_GET['xenon'] == '1') echo 'checked';?> name="xenon" value="1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        4x4 <input type="checkbox" <?php if($_GET['4x4'] == '1') echo 'checked';?> name="4x4" value="1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<br/><br/>		
    </div>
     
           
        </div>
    </span>
    </form>
<br/><br/>
    
</div>
</div>
<div class="clear"></div>
</div>
</div>

<div id="wrap">
    <div id="cautare_avansata2" style="height:110px; display: none;">
   &nbsp;
    </div>
<div id="contents">
<div class="clear"></div>