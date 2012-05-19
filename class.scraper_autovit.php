<?php

include('config.php');
include('Class.Masini.php');

class Scraper {
	
	var $table_queue = 'scraper_queue';
	var $limita_anunturi = 500;
	var $limita_nr_pagini = 100;
	var $limita_status = 1000;

	var $log_file = 'log.txt';
		
	function __construct() {
		
		$link = mysql_connect('localhost', MYSQL_USER, MYSQL_PASS) or die(mysql_error());
		mysql_select_db(MYSQL_DB, $link) or die(mysql_error());
		mysql_query("SET NAMES utf8");
		
	}
	
	function log($line) {
		
		file_put_contents($this->log_file,$line . "\n",FILE_APPEND);
		
	}
	
	
	// ultimele anunturi
	
	function scraperAnunturiNoi() {
		
		for ($i=1;$i<=10;$i++) {
		
			$urls = $this->scrapePagina($nr);
			
			foreach($urls as $url) {
				echo 'Scrape la ' . $url['url_masina'];

				$this->scrapePaginaDetaliu($url['url_masina']);
			}
			
			sleep(1);
			
		}
		
	}
	
	// porneste scraper-ul pentru url-urile din db
	
	function pornesteScraperDetalii() {

		$this->log('A pornit scraperul de pagini de detalii la '.date("Y-m-d H:i:s"));

		$query = mysql_query("SELECT * FROM $this->table_queue WHERE vazut=0 ORDER BY id LIMIT $this->limita_anunturi");
	
		while ($r = mysql_fetch_array($query)) {
			
			// verifica daca nu exista URLU deja in db
			
			$url = $r['url'].$r['url_masina'];
			
			if (!verificaURLMasina($url)) {
				$masina = $this->scrapePaginaDetaliu($url);
				$this->log('Scrape Detaliu : '.$url);
			}
			
			if ($masina) {
					// marcheaza ca vazut
					mysql_query("UPDATE $this->table_queue SET vazut=1 WHERE id='".$r['id']."'") or die(mysql_error());
			}
			else {
					// nu a fost gasit anuntul, stergel
					mysql_query("DELETE FROM $this->table_queue WHERE id='".$r['id']."'");
			}
				
	
			sleep(rand(1,3)); // fa o pauza de 1-3 secunde
			
		}
		
	}
	
	// porneste scraper-ul de url-uri de anunturi
	
	function pornesteScraperURLs() {
		
		$this->log('A pornit scraperul de url-uri la '.date("Y-m-d H:m:s"));
		
		// vezi la ce pagina a ramas
		$result = mysql_fetch_array(mysql_query("SELECT pagina FROM $this->table_queue ORDER BY pagina DESC LIMIT 1"));
		
		if ($result['pagina'])
			$start = $result['pagina'];
		else
			$start = 0;
		
		// parseaza $limita_nr_pagini in total
		for($i=1;$i<=$this->limita_nr_pagini;$i++) {
			$nr = $start+$i;
			$url = 'http://www.autovit.ro/index.php?sect=search&sub=car&page='.$nr.'&qid=2490016043&order_by=p';
			
			$this->scrapeForURLs($url,$nr);
			sleep(rand(1,2));
			$this->log('URL : '.$url);
		}
		
		
	}
	
	function scrapeForURLs($url_page,$page_nr) {
		
		$ret = array();
		$html = file_get_html($url_page);
		
		foreach($html->find('h4[id^=C]') as $masina) {


			$item['id'] = $masina->id;
		    $item['nume_masina'] = addslashes(trim($masina->find('a.otoLink', 0)->plaintext));
			$item['url_masina'] = trim($masina->find('a.otoLink', 0)->href);

			// verifica daca exista deja codul masinii
			if (!$this->verificaCodMasina($item['id']))
				$this->insertURL($item['id'],$item['nume_masina'],$item['url_masina'],'http://autovit.ro/',$page_nr);
			
			$ret[] = $item;	
	
		}
		
		$html->clear();
		unset($html);
		
		return $ret;
	
	}

	
	// are ca parametru url-ul unei pagini
	function scrapePagina($page_nr) {
		
		$url = "http://www.autovit.ro/index.php?sect=search&sub=car&page=$page_nr&qid=2485979133&order_by=p";
		$ret = $this->scrapeForURLs($url,$page_nr);
		
		return $ret;
		
	}
	
	function verificaCodMasina($cod) {
		
		if (mysql_num_rows(mysql_query("SELECT * FROM $this->table_queue WHERE cod_masina='$cod'")))
			return true;
			
		return false;
		
	}
	
	function verificaURLMasina($url) {
		
		if (mysql_num_rows(mysql_query("SELECT * FROM $this->table_queue WHERE url_autovit LiKE '%$url%'")))
			return true;
			
		return false;
		
	}
	
	function insertURL($cod_masina,$nume_masina,$url_masina,$url,$page_nr) {
		
		mysql_query("INSERT INTO $this->table_queue (cod_masina,nume_masina,url_masina,url,vazut,pagina) VALUES ('$cod_masina','$nume_masina','$url_masina','$url','0','$page_nr')");
		
	}
	
	// scoate detaliile pentru o masina
	function scrapePaginaDetaliu($url) {
		
		$html = file_get_html($url);
		
		// nu mai e valabil anuntul
		if (strstr($html->plaintext,"nu a fost gasit") || strstr($html->plaintext,"Anuntul este inactiv"))
			return false;
			
		
		$details = $html->find('#offerDetails',0)->children(0)->plaintext;
		$url_poze = $html->find('#offerGallery',0)->getAttribute('data-photos');
		$nume_masina = $html->find('#contentOM',0)->children(1)->plaintext;

		$url_poze = substr(stripslashes($url_poze),1,-1); // scoate parantezele []
		$tmp = explode(",",$url_poze);


		foreach($tmp as $p) {

			$poze[] = str_replace("60x45","original",substr($p,1,-1));

		}

		$tmp = explode("            ",$details);

		foreach($tmp as $key => $value) {

			if ($value) {
				$a = explode(":",$value);
				$ret[trim($a[0])] = trim($a[1]);
			}

		}


		// detalii mai multe

		// DOTARI
		$cheie = $html->find('#offerDetails',0)->children(2)->plaintext;

		if ($cheie)
			$ret[substr($cheie,0,-1)] = $html->find('#offerDetails',0)->children(3)->plaintext;

		// INFORMATII SUPLIMENTARE
		$cheie = $html->find('#offerDetails',0)->children(4)->plaintext;

		if ($cheie)
			$ret[substr($cheie,0,-1)] = $html->find('#offerDetails',0)->children(5)->plaintext;

		// DESCRIERE MASINA
		$cheie = $html->find('#offerDetails',0)->children(6)->plaintext;

		if ($cheie)
			$ret[substr($cheie,0,-1)] = $html->find('#offerDetails',0)->children(7)->plaintext;

		// contact

		$tmp = explode(" ",$nume_masina);

		$ret['marca'] = $tmp[0];
		$ret['model'] = $tmp[1];

		$ret['localitate'] = trim($html->find('#offerContactDetails',0)->children(1)->plaintext);
		$ret['telefon1'] = trim(trim($html->find('.phoneOM',0)->plaintext)," ");
		$ret['telefon2'] = trim($html->find('.phoneOM',1)->plaintext);
		$ret['poze'] = $poze;
		$ret['nume_anunt'] = $nume_masina;
		$ret['url_autovit'] = $url;

		$masina = $this->formateazaDetalii($ret);
		return $this->insereazaMasina($masina);
		
	}
	
	function formateazaDetalii($array) {
		

		$m[] = array();
		foreach($array as $key => $value) {

			if ($key == "Pret") {
				$tmp = explode(" ",$value);
				$value = str_replace(",","",$tmp[0]); // Pretul in Euro
			}

			if ($key == "Caroserie" && strstr($value,"PickUp"))
				$value = "Pick-Up/Off-road"; // valoarea din database

			if ($key == "Rulaj") {
				$value = substr(str_replace(",","",$value),0,-3); // scoate "km"
			}

			if ($key == "Putere") {
				$tmp = explode(" ",$value);
				$value = $tmp[0]; // valoarea in CP
			}

			if ($key == "localitate") {
				$tmp = explode(",",$value);
				$tmp2 = explode(" ",$tmp[1]);
				$m['Tara_Vanzator'] = ucfirst($tmp[0]);
				$m['Oras_Vanzator'] = ucfirst(strtolower($tmp2[1]));
				$m['Judet_Vanzator'] = ucfirst(strtolower(substr($tmp2[3],0,-1)));

			}

			if ($key == "Cilindree") {
				$tmp = explode(" ",$value);
				$value = $tmp[0];
			}

			if ($key == "Combustibil") $value = ucfirst($value);
			if ($key == "Transmisie") $value = ucfirst($value);
			if ($key == "Culoare") $value = ucfirst($value);

			if ($key == "Norma Euro") {

				$value = 'euro '.substr($value,-1);

			}


			$m[$key] = $value;
		}

		$m['poze'] = $array['poze'];

		$dotari = array('primul_proprietar','tva_deductibil','fara_accident','filtru_particule','ABS','alarma','comenzi_volan','geamuri_electrice','jante_aliaj','radio/CD','sistem_navigatie','4x4','EDS','antifurt_mecanic','computer_bord','imobilizator','oglinzi_electrice','scaune_incalzite','suspensie_reglabila','ESP','bare_portbagaj','controlul_tractiunii','incalzire_auxiliara','parbriz_incalzit','senzori_parcare','tapiserie_piele','aer_conditionat','cadru_de_protectie','diferential_blocabil','inchidere_centralizata','pilot_automat','senzori_ploaie','trapa','airbag','carlig_remorcare','geamuri_colorate','interior_velur','proiectoare_ceata','servo_directie','xenon','pt_pers_cu_dizabilitati','garantie','taxi','carte_service','epoca','tuning','pret_negociabil','predare_leasing','taxa_mediu','metalizat');

		$campuri = array(
			'Caroserie' => 'tip_masina',
			'Fabricatie' => 'an_fabricatie',
			'Data inmatricularii' => 'data_inmatricularii',
			'Rulaj' => 'kilometraj',
			'Pret' => 'pret',
			'Putere' => 'putere',
			'Cilindree' => 'capacitate',
			'Combustibil' => 'tip_combustibil',
			'Numari de usi' => 'nr_usi',
			'Culoare' => 'culoare',
			'Descrierea vehiculului' => 'descriere',
			'Norma Euro' => 'norme_euro',
			'Model' => 'model_id',
			'Transmisie' => 'transmisie',
			'nume_anunt' => 'nume_anunt',
			'url_autovit' => 'url_autovit'
		);

		$masina = array();

		$masina['marca'] = ucfirst(strtolower($m['marca']));
		$masina['model'] = $m['model'];

		
		// restul de campuri
		$masina['Tara_Vanzator'] = $m['Tara_Vanzator'];
		$masina['Oras_Vanzator'] = $m['Oras_Vanzator'];
		$masina['telefon1'] = $m['telefon1'];
		$masina['telefon2'] = $m['telefon2'];
		$masina['tara_origine'] = $m['Tara de origine'];
		$masina['poze'] = $m['poze'];
		
		// cauta dotarile care le are
		foreach($dotari as $d) {
			$dotare = str_replace("_"," ",$d);

			if (strstr($m['Dotari'],$dotare) || strstr($m['Informatii suplimentare'],$dotare))
				$masina[$d] = 1;
			else
				$masina[$d] = 0;

		}

		if (strstr($m['Culoare'],"metalizat")) $masina['metalizat'] = 1;

		// rescrie key-urile array-ului (campurile) sa corespunda cu cel din baza de date

		foreach($campuri as $key => $value) {

			$masina[$value] = $m[$key]; // $value e noua cheie

		}
		
		return $masina;
					
	}
	
	function insereazaMasina($m) {
		
		
		// verifica daca exista marca, daca nu introdu
		
		$marca = $m['marca'];
		$result = mysql_fetch_array(mysql_query("SELECT id FROM marci WHERE nume_marca='$marca'"));
		
		if ($result['id']) {
			$marca_id = $result['id'];
			$m['marci_id'] = $marca_id;
		}
		else {
 			mysql_query("INSERT INTO marci (nume_marca) VALUES ('$marca')") or die(mysql_error());
			$marca_id = mysql_insert_id();
			$m['marci_id'] = $marca_id;
		}
		
		
		// verifica daca exista marca, daca nu introdu
		
		$model = $m['model'];
		$model_lower = strtolower($model);
		$result = mysql_fetch_array(mysql_query("SELECT id FROM modele WHERE LOWER(nume_model)='$model_lower'"));
		
		if ($result['id'])
			$model_id = $result['id'];
		else {
			mysql_query("INSERT INTO modele (marci_id,nume_model) VALUES ('$marca_id','$model')") or die(mysql_error());
			$model_id = mysql_insert_id();
		}	
		
		$m['model_id'] = $model_id; // adauga idu de model
		
		echo 'Marca id : ' . $marca_id . '<br>';
		echo 'Model id : ' . $model_id . '<br>';
		
		// tara de origine
		
		$result = array();
		// verifica id-ul tarii
		$result = mysql_fetch_array(mysql_query("SELECT id FROM tari WHERE LOWER(nume_tara)='".strtolower($m['tara_origine'])."'"));
		
		if ($result['id'])
			$m['tara_origine'] = $result['id'];
		else {
			//mysql_query("INSERT INTO tari (nume_tara) VALUES ('".$m['Tara_Vanzator']."')") or die(mysql_error());
			
		}
		
		
		// introdu vanzatorul
		
		
		//echo "SELECT id FROM tari WHERE LOWER(nume_tara)='".strtolower($m['Tara_Vanzator'])."'";
		
		// verifica id-ul tarii
		$result = mysql_fetch_array(mysql_query("SELECT id FROM tari WHERE LOWER(nume_tara)='".strtolower($m['Tara_Vanzator'])."'"));
		
		if ($result['id'])
			$tara_id = $result['id'];
		else {
			//mysql_query("INSERT INTO tari (nume_tara) VALUES ('".$m['Tara_Vanzator']."')") or die(mysql_error());
			//$tara_id = mysql_insert_id();
			// e nume de vanzator si nu tara ?
			$nume_vanzator = $m['Tara_Vanzator'];
		}
			
		echo 'Tara id : '.$tara_id . "<br>";
		
		// verifica si introdu vanzatorul

		$result = mysql_fetch_array(mysql_query("SELECT id FROM vanzatori WHERE telefon='".$m['telefon1']."'"));
		
		if ($result['id']) {
			$vanzator_id = $result['id'];
		}
		else {
			$telefon1 = $m['telefon1'];
			$telefon2 = $m['telefon2'];
			$oras = $m['Oras_Vanzator'];
			
			mysql_query("INSERT INTO vanzatori (nume,tara,oras,telefon,telefon_2) VALUES ('$nume_vanzator','$tara_id','$oras','$telefon1','$telefon2')") or die(mysql_error());
			$vanzator_id = mysql_insert_id();
		}
		
		$m['vanzatori_id'] = $vanzator_id;
		
		echo 'Vanzator id :'.$vanzator_id . '<br>';
		
		
		// scoate unele campuri
		unset($m['Tara_Vanzator']);
		unset($m['Oras_Vanzator']);
		unset($m['telefon1']);
		unset($m['telefon2']);
		unset($m['model']);
		unset($m['marca']);
		unset($m['Taxa de mediu']);
		unset($m['Tara de origine']);
		
		
		
		// verifica duplicatul
	
		if ($this->verificaDuplicat($m) == 0) { // nu e duplicat 
		
			// insereaza masina
		
			$masini = new Masini();
			$id_masina = $masini->insert($m);
		
			// introdu pozele
		
			$i=1;
			foreach($m['poze'] as $poza) {
				mysql_query("INSERT INTO imagini (masina_id,url,pozitie) VALUES ('$id_masina','$poza','$i')");
				$i++;
			}
		
			return $m;
		
		}
		else
			return false;
		
			
	}
	
	function verificaStatusAnunt() {
		
		$query = mysql_query("SELECT * FROM $this->table_queue WHERE vazut=1 ORDER BY id LIMIT $this->limita_status");

		while ($r = mysql_fetch_array($query)) {
			
			$url = $r['url'] . $r['url_masina'];
			if ($this->scrapePaginaDetaliu($url) == false)

				mysql_query("DELETE FROM $this->table_queue WHERE url_masina='".$r['url_masina']."'");
				// sterge anuntul
				mysql_query("DELETE FROM masini WHERE url_masina LIKE '%$url%'");
							
		}
		
	}
	
	function verificaDuplicat($masina) {
		
		$conditie = "model_id='$masina[model_id]' AND an_fabricatie='$masina[an_fabricatie]' AND putere='$masina[putere]' AND ABS($masina[kilometraj] - kilometraj) < kilometraj/10 AND ABS($masina[pret] - pret) < pret/10";
		
		$sql_query = "SELECT * FROM masini WHERE $conditie";
		
		
		$query = mysql_query($sql_query);

		return mysql_num_rows($query);
	
	}
	
}

?>