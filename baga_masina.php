<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
 
mysql_connect('localhost', 'root', 'cumparamasini');
mysql_select_db('cumparamasini');

if(isset($_POST['submit']))
{
    //die(print_r($_POST));
    require(dirname(__FILE__) . '/Class.Masini.php');
    $masini = new Masini();
    $masini->insert($_POST);

    $bagat = 1;
}
?>
<html>
<head>
<title>Baga Masina</title>
<script type='text/javascript' src='jquery-1.7.2.min.js'></script>

</head>
<body>
    <body>
        <a href="baga_tara.php">Baga tara</a>&nbsp;&nbsp;&nbsp;
        <a href="baga_marca.php">Baga marca</a>&nbsp;&nbsp;&nbsp;
        <a href="baga_model.php">Baga model</a>&nbsp;&nbsp;&nbsp;
        <a href="baga_masina.php">Baga masina</a>
<h1>Baga masina</h1>
<?php
if($bagat == 1)
    echo '<h2>Am bagat masina</h2>';
?>
<form action="" method="post">
	Marca:
	<select name="marci_id" id="camp_marca">
	<?php 
	$res = mysql_query("SELECT * from marci");
	while($row = mysql_fetch_assoc($res))
	{
		echo '<option value="' . $row['id'] . '">' . $row['nume_marca'] . '</option>';
	}
	?>
	</select>
	<br/>Model:
	<select name="model_id" id="camp_model">
	
	</select>
	<br/>Nume:
	<input type="text" name="nume_anunt"/>
	<br/>Tip masina:
	<select name="tip_masina">
		<option value="Berlina">Berlina</option>
		<option value="Break">Break</option>
		<option value="Van/minibus">Van/minibus</option>
		<option value="Pick-Up/Off-road">Pick-Up/Off-road</option>
		<option value="Cabrio">Cabrio</option>
		<option value="Coupe/Sport">Coupe/Sport</option>
		<option value="Alta">Alta</option>
	</select>
	<br/>An fabricatie:
	<input type="text" name="an_fabricatie"/>
	<br/>Kilometraj:
	<input type="text" name="kilometraj"/>
	<br/>Pret:
	<input type="text" name="pret"/>
	<br/>Tara Origine:
	<select name="tara_origine">
	<?php 
	$res = mysql_query("SELECT * from tari");
	while($row = mysql_fetch_assoc($res))
	{
		echo '<option value="' . $row['id'] . '">' . $row['nume_tara'] . '</option>';
	}
	?>
	</select>
	<br/>Tara inmatriculare:
	<select name="tara_inmatriculare">
	<?php 
	$res = mysql_query("SELECT * from tari");
	while($row = mysql_fetch_assoc($res))
	{
		echo '<option value="' . $row['id'] . '">' . $row['nume_tara'] . '</option>';
	}
	?>
	</select>
	<br/>Putere:
	<input type="text" name="putere"/>
	<br/>Capacitate:
	<input type="text" name="capacitate"/>
	<br/>Tip combustibil:
	<select name="tip_combustibil">
		<option value="Diesel">Diesel</option>
		<option value="Benzina">Benzina</option>
		<option value="Gaz">Gaz</option>
		<option value="Hibrid">Hibrid</option>
		<option value="Electric">Electric</option>
		<option value="Hidrogen"></option>
		<option value="Etanol">Etanol</option>
		<option value="Alta">Alta</option>
	</select>
	<br/>Transmisie:
	<select name="transmisie">
		<option value="Automata">Automata</option>
		<option value="Manuala">Manuala</option>
		<option value="Semi-automata/Secventiala">Semi-automata/Secventiala</option>
	</select>
	<br/>Numar de usi:
	<select name="nr_usi">
		<option value="2/3">2/3</option>
		<option value="4/5">4/5</option>
		<option value="6/7">6/7</option>
	</select>
	<br/>Culoare:
	<select name="culoare">
		<option value="Alb">Alb</option>
		<option value="Albastru">Albastru</option>
		<option value="Argintiu">Argintiu</option>
		<option value="Auriu">Auriu</option>
		<option value="Bej">Bej</option>
		<option value="Galben">Galben</option>
		<option value="Gri">Gri</option>
		<option value="Maro">Maro</option>
		<option value="Negru">Negru</option>
		<option value="Portocaliu">Portocaliu</option>
		<option value="Rosu">Rosu</option>
		<option value="Verde">Verde</option>
		<option value="Violet">Violet</option>
		<option value="Visiniu">Visiniu</option>
	</select>

        <br/>Metalizat:
        <input type="checkbox" name="metalizat" value="1"/>
<br/><br/>
        <div style="width: 1000px; text-align: left;">
        <div style="width: 200px; float: right">
        Primul proprietar:
	<input type="checkbox" name="primul_proprietar" value="1"/>
	<br/>TVA deductibil:
	<input type="checkbox" name="tva_deductibil" value="1"/>
	<br/>Fara accidente:
	<input type="checkbox" name="fara_accident" value="1"/>
	<br/>Filtru de particule:
	<input type="checkbox" name="filtru_particule" value="1"/>
	<br/>
        
	ABS:
	<input type="checkbox" name="ABS" value="1"/>
	<br/>Alarma:
	<input type="checkbox" name="alarma" value="1"/>
	<br/>Comenzi Volan:
	<input type="checkbox" name="comenzi_volan" value="1"/>
	<br/>Geamuri Electrice:
	<input type="checkbox" name="geamuri_electrice" value="1"/>
	<br/>Jante aliaj:
	<input type="checkbox" name="jante_aliaj" value="1"/>
	<br/>Radio/CD:
	<input type="checkbox" name="radio/CD" value="1"/>
	<br/>Sistem de navigare:
	<input type="checkbox" name="sistem_navigatie" value="1"/>
	<br/>4x4:
	<input type="checkbox" name="4x4" value="1"/>
	<br/>EDS:
	<input type="checkbox" name="EDS" value="1"/>
        </div>
        <div style="width: 200px; float: right">
	Antifurt mecanic:
	<input type="checkbox" name="antifurt_mecanic" value="1"/>
	<br/>Computer de bord:
	<input type="checkbox" name="computer_bord" value="1"/>
	<br/>Imobilizator:
	<input type="checkbox" name="imobilizator" value="1"/>
	<br/>Oglinzi electrice:
	<input type="checkbox" name="oglinzi_electrice" value="1"/>
	<br/>Scaune incalzite:
	<input type="checkbox" name="scaune_incalzite" value="1"/>
	<br/>Suspensie reglabila:
	<input type="checkbox" name="suspensie_reglabila" value="1"/>
	<br/>ESP:
	<input type="checkbox" name="ESP" value="1"/>
	<br/>Bare portbagaj:
	<input type="checkbox" name="bare_portbagaj" value="1"/>
	<br/>Controlul tractiunii:
	<input type="checkbox" name="controlul_tractiunii" value="1"/>
        </div>
        <div style="width: 200px; float: right">
	Incalzire auxiliara:
	<input type="checkbox" name="incalzire_auxiliara" value="1"/>
	<br/>Parbriz incalzit:
	<input type="checkbox" name="parbriz_incalzit" value="1"/>
	<br/>Senzori parcare:
	<input type="checkbox" name="senzori_parcare" value="1"/>
	<br/>Tapiserie piele:
	<input type="checkbox" name="tapiserie_piele" value="1"/>
	<br/>Aer conditionat:
	<input type="checkbox" name="aer_conditionat" value="1"/>
	<br/>Cadru de protectie:
	<input type="checkbox" name="cadru_de_protectie" value="1"/>
	<br/>Diferential blocabil:
	<input type="checkbox" name="diferential_blocabil" value="1"/>
	<br/>Inchidere centralizata:
	<input type="checkbox" name="inchidere_centralizata" value="1"/>
	<br/>Pilot automat:
	<input type="checkbox" name="pilot_automat" value="1"/>
        </div>
        <div style="width: 200px; float: right">
	Senzori de ploaie:
	<input type="checkbox" name="senzori_ploaie" value="1"/>
	<br/>Trapa:
	<input type="checkbox" name="trapa" value="1"/>
	<br/>Airbag:
	<input type="checkbox" name="airbag" value="1"/>
	<br/>Carlig remorcare:
	<input type="checkbox" name="carlig_remorcare" value="1"/>
	<br/>Geamuri colorate:
	<input type="checkbox" name="geamuri_colorate" value="1"/>
	<br/>Interior velur:
	<input type="checkbox" name="interior_velur" value="1"/>
	<br/>Proiectoare ceata:
	<input type="checkbox" name="proiectoare_ceata" value="1"/>
	<br/>Servodirectie:
	<input type="checkbox" name="servo_directie" value="1"/>
	<br/>Xenon:
	<input type="checkbox" name="xenon" value="1"/>
        </div>
        <div style="width: 200px; float: right">
	Comenzi volan:
	<input type="checkbox" name="comenzi_volan" value="1"/>
        <br/>Pt persoane cu dizabilitati:
	<input type="checkbox" name="pt_pers_cu_dizabilitati" value="1"/>
        <br/>Garantie:
	<input type="checkbox" name="garantie" value="1"/>
        <br/>Taxi:
	<input type="checkbox" name="taxi" value="1"/>
        <br/>Carte service:
	<input type="checkbox" name="carte_service" value="1"/>
        <br/>De epoca:
	<input type="checkbox" name="epoca" value="1"/>
        <br/>Tuning:
	<input type="checkbox" name="tuning" value="1"/>
        <br/>Pret negociabil:
	<input type="checkbox" name="pret_negociabil" value="1"/>
        <br/>Predare leasing:
	<input type="checkbox" name="predare_leasing" value="1"/>
        <br/>Taxa de mediu:
	<input type="checkbox" name="taxa_mediu" value="1"/>
        </div>
</div>
        <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
	<br/>URL Autovit:
        <input type="text" name="url_autovit"/>

        <br/>URL Mobile.ro:
        <input type="text" name="url_mobile"/>

        <br/>Cilindre:
        <input type="text" name="cilindre"/>

        <br/>Tapiserie:
        <input type="text" name="tapiserie"/>

        <br/>Culoare tapiserie:
	<select name="culoare_tapiserie">
		<option value="Alb">Alb</option>
		<option value="Albastru">Albastru</option>
		<option value="Argintiu">Argintiu</option>
		<option value="Auriu">Auriu</option>
		<option value="Bej">Bej</option>
		<option value="Galben">Galben</option>
		<option value="Gri">Gri</option>
		<option value="Maro">Maro</option>
		<option value="Negru">Negru</option>
		<option value="Portocaliu">Portocaliu</option>
		<option value="Rosu">Rosu</option>
		<option value="Verde">Verde</option>
		<option value="Violet">Violet</option>
		<option value="Visiniu">Visiniu</option>
	</select>

        <br/>Starea tehnica:
        <select name="stare_tehnica">
            <option value="Avariat">Avariat</option>
            <option value="Neavariat">Neavariat</option>
            <option value="Nou">Nou</option>
        </select>
        
        <br/>Norme euro
        <select name="norme_euro">
            <option value="non-euro">non-euro</option>
            <option value="euro 1">euro 1</option>
            <option value="euro 2">euro 2</option>
            <option value="euro 3">euro 3</option>
            <option value="euro 4">euro 4</option>
            <option value="euro 5">euro 5</option>
            <option value="euro 6">euro 6</option>
        </select>

        <br/>Descriere:
        <textarea name="descriere"></textarea>

        <br/>Nume vanzator:
        <input type="text" name="nume_vanzator"/>

        <br/>Prenume vanzator:
        <input type="text" name="prenume_vanzator"/>

        <br/>Tara vanzator:
        <select name="tara_vanzator">
	<?php
	$res = mysql_query("SELECT * from tari");
	while($row = mysql_fetch_assoc($res))
	{
		echo '<option value="' . $row['id'] . '">' . $row['nume_tara'] . '</option>';
	}
	?>
	</select>

        <br/>Oras vanzator:
        <input type="text" name="oras_vanzator"/>

        <br/>Telefon vanzator:
        <input type="text" name="telefon_vanzator"/>
        
	<br/><input type="submit" name="submit" value="Baga"/>
</form>

<script type="text/javascript">
$("#camp_marca").change(function(){
        $("#camp_model").load("http://173.203.100.21/cumparamasini/getmodels.php?id=" + $("#camp_marca").find(":selected").val());
});
</script>
</body>
</html>