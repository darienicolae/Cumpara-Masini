<?php

include('config.php');
include('Class.Masini.php');

class Scraper2 {
	
	var $table_queue = 'scraper_queue2';
	var $table_cars = 'masini';
	var $table_duplicate = 'duplicate';
	var $limita_anunturi = 20;
	var $limita_nr_pagini = 10;
	var $limita_verificare = 30;
	var $alreadyInDB = false;
	
	function __construct() {
		
		$link = mysql_connect('localhost', MYSQL_USER, MYSQL_PASS) or die(mysql_error());
		mysql_select_db(MYSQL_DB, $link) or die(mysql_error());
		
	}
	
	// porneste scraper-ul pentru url-urile din db
	
	function pornesteScraperDetalii() {										//  ok

		$query = mysql_query("SELECT * FROM $this->table_queue WHERE vazut=0 ORDER BY id DESC LIMIT $this->limita_anunturi");
	
		while ($r = mysql_fetch_array($query)) {

			echo $r['cod_masina'].'<br>';
			$masina = $this->scrapePaginaDetaliu($r['cod_masina']);
			if ($masina) {
					// marcheaza ca vazut
					mysql_query("UPDATE $this->table_queue SET vazut=1 WHERE cod_masina='".$r['cod_masina']."'") or die(mysql_error());
			}
			else {
					// nu a fost gasit anuntul, stergel
					mysql_query("DELETE FROM $this->table_queue WHERE cod_masina='".$r['cod_masina']."'");
			}
				
	
			print_r($masina);
			//sleep(rand(5,10)); // fa o pauza de 5-10 secunde
			
		}
		
	}
	
	// porneste scraper-ul de url-uri de anunturi
	
	function pornesteScraperURLs() {										//  ok
		
		// parseaza $limita_nr_pagini in total
		for ($nr=1; $nr <= $this->limita_nr_pagini; $nr++) {
			$url = 'http://cautare.mobile.ro/automobile/search.html?useCase=SearchResult&pageNumber='.$nr.'&__lp=1759&scopeId=C&sortOption.sortBy=creationTime&sortOption.sortOrder=DESCENDING&makeModelVariant1.searchInFreetext=false&makeModelVariant2.searchInFreetext=false&makeModelVariant3.searchInFreetext=false&ambitCountry=RO&siteId=ROMANIA&negativeFeatures=EXPORT&lang=ro';
			
			if ($this->alreadyInDB == true)
			{
				break;
			}
			$this->scrapeForURLs($url, $nr);
		}
		
		
	}
	
	function pornesteScraperOlderURLs() {										//  ok
		
		// vezi la ce pagina a ramas
		$result = mysql_fetch_array(mysql_query("SELECT pagina FROM `$this->table_queue` ORDER BY pagina DESC LIMIT 1"));
		
		// parseaza $limita_nr_pagini in total
		$nr=1;
		//$delay=0;
		
		while ($nr <= $this->limita_nr_pagini) {
		
			$nr_pagina=$nr+$result['pagina'];
			//$delay=0;
			$url = 'http://cautare.mobile.ro/automobile/search.html?useCase=SearchResult&pageNumber='.$nr_pagina.'&__lp=1759&scopeId=C&sortOption.sortBy=creationTime&sortOption.sortOrder=DESCENDING&makeModelVariant1.searchInFreetext=false&makeModelVariant2.searchInFreetext=false&makeModelVariant3.searchInFreetext=false&ambitCountry=RO&siteId=ROMANIA&negativeFeatures=EXPORT&lang=ro';
			
			$this->scrapeForURLs($url, $nr_pagina);
			/*
							echo ';;;;;'.$nr_pagina.';;;;;';
			if ($this->alreadyInDB != true)
			{
			echo 'ok3';
				$this->alreadyInDB = false;
				echo ';;;;;'.$nr_pagina.';;;;;';
				$this->scrapeForURLs($url, $nr_pagina);
			}
			else
			{
				//$delay=1;
			}*/
			
			$nr++;
		}
		
		
	}
	
	function scrapeForURLs($url_page, $nr) {										//  ok
		
		$ret = array();
		$html = file_get_html($url_page);
		
		foreach($html->find('a[class=infoLink detailsViewLink]') as $masina) {
			//  Iau id masina
			$regexIdAd = '/html\?id=(.{9})/';
			preg_match_all($regexIdAd,$masina->href,$matchIdAd, PREG_PATTERN_ORDER);
			
			$item['id'] = $matchIdAd[1][0];
		    $item['nume_masina'] = trim($masina->plaintext);

			//echo 'Masina id: '.$item['id'].' ; Nume: '.$item['nume_masina'].'<br>';
			// verifica daca exista deja codul masinii
			if (!$this->verificaCodMasina($item['id']))
			{
				echo '|';
				$this->insertURL($item['id'], $item['nume_masina'], $nr);
			}
			else
			{
				$this->alreadyInDB = true;
				break;
			}
			
			$ret[] = $item;	
	
		}
		
		$html->clear();
		unset($html);
		
		return $ret;
	
	}

	
	// are ca parametru url-ul unei pagini
	function scrapePagina($page_nr) {										//  ok
		
		$url = "http://cautare.mobile.ro/automobile/search.html?useCase=SearchResult&pageNumber=$page_nr&__lp=1759&scopeId=C&sortOption.sortBy=creationTime&sortOption.sortOrder=DESCENDING&makeModelVariant1.searchInFreetext=false&makeModelVariant2.searchInFreetext=false&makeModelVariant3.searchInFreetext=false&ambitCountry=RO&siteId=ROMANIA&negativeFeatures=EXPORT&lang=ro";
		$ret = $this->scrapeForURLs($url);
		
		return $ret;
		
	}
	
	function verificaCodMasina($cod) {										//  ok
		
		if (mysql_num_rows(mysql_query("SELECT * FROM $this->table_queue WHERE cod_masina='$cod'")))
			return true;
			
		return false;
		
	}
	
	function insertURL($cod_masina,$nume_masina, $pagina) {							//  ok
		
		mysql_query("INSERT INTO $this->table_queue (cod_masina,nume_masina,vazut,pagina) VALUES ('$cod_masina','$nume_masina',0,'$pagina')") or die(mysql_error());
		
	}
	
	// scoate detaliile pentru o masina
	function scrapePaginaDetaliu ($id)
	{
		
		$url = "http://cautare.mobile.ro/vehicule/showDetails.html?id=$id&lang=ro&pageNumber=1&__lp=1702&scopeId=C&sortOption.sortBy=creationTime&sortOption.sortOrder=DESCENDING&makeModelVariant1.searchInFreetext=false&makeModelVariant2.searchInFreetext=false&makeModelVariant3.searchInFreetext=false&ambitCountry=RO&siteId=ROMANIA&negativeFeatures=EXPORT&tabNumber=";
		
		$html = file_get_html($url.'1');  //  first tab
		
		// nu mai e valabil anuntul
		if (strstr($html->plaintext,"nu a putut fi") || strstr($html->plaintext,"Anuntul este inactiv"))
			return false;
			
		$nume_masina = $html->find('meta[name=keywords]',0)->content;
		echo 'nume masina='.$nume_masina;
		//  accesez pagina cu poze
		$htmlImages = file_get_html($url.'2');  //  images tab
		
		foreach($htmlImages->find('link[rel=image_src]') as $image) { //					ok
			$poze[] = str_replace('14.JPG', '19.JPG', $image->href);
			//echo str_replace('14.JPG', '19.JPG', $image->href).'<br>';
		}
		
		
		//  accesez pagina cu detalii
		$htmlDetails = file_get_html($url.'3');  //  details tab
		
		foreach ($htmlDetails->find('dl[class=feature-pairs]') as $pairs)
		{
			$children = $pairs->children();
			
			for ($i = 0; $i < sizeof($children); $i +=4 )
			{
				echo substr(trim($children[$i]->plaintext),0,-1).'---'.trim($children[$i+2]->plaintext).'<br>';
				
				if (substr(trim($children[$i]->plaintext),0,17) == "Clasă de poluare")
				{
					$ret["Clasă de poluare"] = trim($children[$i+2]->plaintext);
				}
				else
				{
					$ret[substr(trim($children[$i]->plaintext),0,-1)] = trim($children[$i+2]->plaintext);
				}
			}
		}
		
		echo '<br><br><br><br>';
		//  seturi de caracteristici
		$seturi = $htmlDetails->find('div[class=block detailbox]', 0)->children(1)->plaintext;
		echo $seturi;
		if ($seturi)
			$ret['Dotari'] = $seturi;
		/*                   //     foarte bun
		$seturiUntrimmed = explode(',', $seturi);
		
		$i = 0;
		foreach($seturiUntrimmed as $value)
		{
			$seturiCaracteristici[$i++] = trim($value);
		}
		
		for ($i = 0; $i < sizeof($seturiCaracteristici); $i++ )
			echo $seturiCaracteristici[$i].'<br>';
		*/
		
		echo '<br><br><br><br>';
		//  descriere vehicul
		
		$detalii = $htmlDetails->find('div[class=block detailbox]', 1)->children(1)->first_child()->plaintext;
		$descrUntrimmed = trim($detalii);
		echo $descrUntrimmed;
		
		if ($descrUntrimmed)
		{
			/*$descrUntrimmed = explode(' -', $descrUntrimmed);
			$tmp = '';
			foreach($descrUntrimmed as $value)
			{
				$tmp = $tmp . trim($value).', ';
			}*/
			$ret['Descrierea vehiculului'] = $descrUntrimmed;//substr($tmp, 0, -2);
		}
		/*        //            foarte bun
		$descrUntrimmed = explode(' -', $descrUntrimmed);
		
		foreach($descrUntrimmed as $value)
		{
			echo trim($value).'<br>';
		}
		*/
		
		echo '<br><br><br><br>';
		//  contact vanzator
		
		$htmlVanzator = file_get_html($url.'4');  //  details tab
		//echo $htmlVanzator;
		//die();
		//$htmlVanzator = str_replace('&nbsp;','',$htmlVanzator);
		//echo $htmlVanzator->find('div[class=block detailbox]',0)->children(0)->plaintext;
		//echo '<Br><br><br>';
		$contact = $htmlVanzator->find('div[class=dealerDetailTabDealerAddress]',0)->plaintext;
		
		//  Regex nume prenume
		$regex = '/([a-zA-Z ]{2,})[0-9]*/';
		preg_match_all($regex, $contact, $match, PREG_PATTERN_ORDER);
		//echo $contact.'         '.$match[1][0];
		//print_r($match);
		if (isset($match[1][0]))
		{
			$tmp = explode(" ", $match[1][0]);
			echo '<br>nume='.$tmp[0].' prenume='.trim($tmp[1]).'<br>';
			$ret['nume_vanzator'] = $tmp[0];
			$ret['prenume_vanzator'] = trim($tmp[1]);
			
			unset($match);
		}
		else
		{
			$ret['nume_vanzator'] = '';
			$ret['prenume_vanzator'] = '';
		}
		
		//  Regex localitate
		$regex = '/[0-9]{6}&nbsp;([a-zA-Z ]*)/';  //  scoate &nbsp;
		preg_match_all($regex, $contact, $match, PREG_PATTERN_ORDER);
		if (isset($match[1][0]))
		{
			echo 'localitate='.$match[1][0];
			$ret['localitate'] = $match[1][0];
		}
		else
		{
			$ret['localitate'] = '';
		}
		
		//  Regex telefon
		$regex = '/([0-9]{9})/';
		preg_match_all($regex, $contact, $match, PREG_PATTERN_ORDER);
		if (isset($match[1][0]))
		{
			echo '<br>telefon=0'.$match[1][0];
			$ret['telefon1'] = '0'.$match[1][0];
		}
		else
		{
			$ret['telefon1'] = '';
		}
		
		$ret['telefon2'] = "";
		
		//- -------------------
		
		$regex = '/([0-9]{3}&nbsp;[0-9]{6})/';
		preg_match_all($regex, $contact, $match, PREG_PATTERN_ORDER);
		if (isset($match[1][0]))
		{
			echo '<br>telefon=0'.$match[1][0];
			$ret['telefon1'] = '0'.$match[1][0];
		}
		else
		{
			$ret['telefon1'] = '';
		}
		
		$ret['telefon2'] = "";
		//  - -------------------
		
		
		$tmp = explode(" ",$nume_masina);

		$ret['marca'] = $tmp[0];
		$ret['model'] = $tmp[1];
		echo '<Br>marca='.$ret['marca'].' model='.$ret['model'].'<Br>';
		$ret['poze'] = $poze;
		
		$ret['Caroserie'] = '';
		$ret['nume_anunt'] = $htmlVanzator->find('title',0)->plaintext;
		echo '<br>nume anunt='.$ret['nume_anunt'].'<br>';
		$ret['url_mobile'] = $url.'1';
		$ret['Data inmatricularii'] = '';
		
		$masina = $this->formateazaDetalii($ret);
		return $this->insereazaMasina($masina);
	}
	
	function formateazaDetalii($array) {
		

		$m[] = array();
		foreach($array as $key => $value) {

			if ($key == "Preţ") {
				$tmp = explode(" ",$value);
				$value = str_replace(".","",$tmp[0]); // Pretul in Euro
			}

			/*if ($key == "Caroserie" && strstr($value,"PickUp"))
				$value = "Pick-Up/Off-road"; // valoarea din database
			*/
			if ($key == "Kilometraj") {
				$value = substr(str_replace(".","",$value),0,-3); // scoate "km"
			}

			if ($key == "Putere") {
				$regex = '/([0-9]*) CP/';
				preg_match_all($regex, $value, $match, PREG_PATTERN_ORDER);
				if (isset($match[1][0]))
				{
					echo '<br>putere='.$match[1][0].'<br>';
					$value = $match[1][0]; // valoarea in CP
				}
				else
				{
					$value = '';
				}
				
			}

			if ($key == "localitate") {
				/*$tmp = explode(",",$value);
				$tmp2 = explode(" ",$tmp[1]);*/
				$m['Tara_Vanzator'] = '';//ucfirst($tmp[0]);
				$m['Oras_Vanzator'] = $value;
				$m['Judet_Vanzator'] = '';//ucfirst(strtolower(substr($tmp2[3],0,-1)));

			}

			if ($key == "Capacitate cilindrică") {
				$tmp = explode(" ",$value);
				$value = $tmp[0];
				echo '<br>capacitate cilindrica='.$value.'<br>';
			}

			if ($key == "Tip de combustibil")
			{
				$value = ucfirst($value);
				echo '<br>Tip de combustibil='.$value.'<br>';
			}
			if ($key == "Cutie de viteze")
			{
				$value = ucfirst($value);
				echo '<br>Cutie de viteze='.$value.'<br>';
			}
			if ($key == "Culoare")
			{
				$value = ucfirst($value);
				echo '<br>Culoare='.$value.'<br>';
			}
			if ($key == "Clasă de poluare") {

				$value = 'euro '.substr($value, -1, 1);
				echo '<br>'.$value.'<br>';
			}


			$m[$key] = $value;
		}

		$m['poze'] = $array['poze'];

		$dotari = array('primul_proprietar','tva_deductibil','fara_accident','filtru_particule','ABS','alarma','comenzi_volan','geamuri_electrice','jante_aliaj','radio/CD','sistem_navigatie','4x4','EDS','antifurt_mecanic','computer_bord','imobilizator','oglinzi_electrice','scaune_incalzite','suspensie_reglabila','ESP','bare_portbagaj','controlul_tractiunii','incalzire_auxiliara','parbriz_incalzit','senzori_parcare','tapiserie_piele','aer_conditionat','cadru_de_protectie','diferential_blocabil','inchidere_centralizata','pilot_automat','senzori_ploaie','trapa','airbag','carlig_remorcare','geamuri_colorate','interior_velur','proiectoare_ceata','servo_directie','xenon','pt_pers_cu_dizabilitati','garantie','taxi','carte_service','epoca','tuning','pret_negociabil','predare_leasing','taxa_mediu','metalizat',
		
		'Senzori_de_parcare','Sistem_de_navigare ','Scaune_încălzite_electric','Regulator_de_viteză','Servodirecţie','Geamuri_electrice','Trapă_decapotabilă',
		'Sistem_de_încălzire_auxiliar','Închidere_centralizată','Cuplaj_pentru_remorcă','Jante_de_aliaj','ABS','Dispozitiv_antidemaraj_electric',
		'ESP ','Tracţiune_4x4 ','Filtru_de_particule','Faruri_cu_xenon','Garanţie','Taxi','Manual_de_service','Pt._pers._cu_dizabilităţi');

		$campuri = array(
			'Caroserie' => 'tip_masina',
			'An de fabricaţie' => 'an_fabricatie',
			'Data inmatricularii' => 'data_inmatricularii',
			'Kilometraj' => 'kilometraj',
			'Preţ' => 'pret',
			'Putere' => 'putere',
			'Capacitate cilindrică' => 'capacitate',
			'Tip de combustibil' => 'tip_combustibil',
			'Număr de uşi' => 'nr_usi',
			'Culoare' => 'culoare',
			'Descrierea vehiculului' => 'descriere',
			'Clasă de poluare' => 'norme_euro',
			'model' => 'model_id',
			'Cutie de viteze' => 'transmisie',
			'nume_anunt' => 'nume_anunt',
			'url_mobile' => 'url_mobile'
		);

		$masina = array();

		$masina['marca'] = ucfirst(strtolower($m['marca']));
		$masina['model'] = $m['model'];
		
		// restul de campuri
		$masina['Tara_Vanzator'] = $m['Tara_Vanzator'];
		$masina['Oras_Vanzator'] = $m['Oras_Vanzator'];
		$masina['telefon1'] = $m['telefon1'];
		$masina['telefon2'] = $m['telefon2'];
		$masina['tara_origine'] = '';//$m['Tara de origine'];
		$masina['poze'] = $m['poze'];
		$masina['nume_vanzator'] = $m['nume_vanzator'];
		$masina['prenume_vanzator'] = $m['prenume_vanzator'];
		
		// cauta dotarile care le are
		foreach($dotari as $d) {
			$dotare = str_replace("_"," ",$d);

			if (strstr($m['Dotari'],$dotare))// || strstr($m['Informatii suplimentare'],$dotare))
				$masina[$d] = 1;
			else
				$masina[$d] = 0;

		}
		
		//  Traducere campuri pt compatibilitate
		if ($masina['Jante_de_aliaj']) $masina['jante_aliaj'] = 1;
		if ($masina['Senzori_de_parcare']) $masina['senzori_parcare'] = 1;
		if ($masina['Sistem_de_navigare']) $masina['sistem_navigatie'] = 1;
		if ($masina['Scaune_încălzite_electric']) $masina['scaune_incalzite'] = 1;
		if ($masina['Servodirecţie']) $masina['servo_directie'] = 1;
		if ($masina['Trapă_decapotabilă']) $masina['trapa'] = 1;
		if ($masina['Cuplaj_pentru_remorcă']) $masina['carlig_remorcare'] = 1;
		if ($masina['Tracţiune_4x4']) $masina['4x4'] = 1;
		if ($masina['Filtru_de_particule']) $masina['filtru_particule'] = 1;
		if ($masina['Faruri_cu_xenon']) $masina['xenon'] = 1;
		if ($masina['Garanţie']) $masina['garantie'] = 1;
		if ($masina['Manual_de_service']) $masina['carte_service'] = 1;
		if ($masina['Pt._pers._cu_dizabilităţi']) $masina['pt_pers_cu_dizabilitati'] = 1;
		if ($masina['Închidere_centralizată']) $masina['inchidere_centralizata'] = 1;
		//if ($masina['']) $masina[''] = 1;
		
		
		if (strstr($m['Culoare'],"metalizat")) $masina['metalizat'] = 1;

		// rescrie key-urile array-ului (campurile) sa corespunda cu cel din baza de date

		foreach($campuri as $key => $value) {

			$masina[$value] = $m[$key]; // $value e noua cheie

		}
		echo '<br><br><br>---------------------------------------Masina:<br><br>';
		print_r($masina);
		
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
		
		// verifica id-ul tarii
		$result = mysql_fetch_array(mysql_query("SELECT id FROM tari WHERE LOWER(nume_tara)='".strtolower($m['tara_origine'])."'"));
		
		if ($result['id'])
			$m['tara_origine'] = $result['id'];
		else {
			mysql_query("INSERT INTO tari (nume_tara) VALUES ('".$m['Tara_Vanzator']."')") or die(mysql_error());
			$m['tara_origine'] = mysql_insert_id();
		}
		
		
		// introdu vanzatorul
		
		// verifica id-ul tarii
		$result = mysql_fetch_array(mysql_query("SELECT id FROM tari WHERE LOWER(nume_tara)='".strtolower($m['Tara_Vanzator'])."'"));
		
		if ($result['id'])
			$tara_id = $result['id'];
		else {
			mysql_query("INSERT INTO tari (nume_tara) VALUES ('".$m['Tara_Vanzator']."')") or die(mysql_error());
			$tara_id = mysql_insert_id();
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
			
			mysql_query("INSERT INTO vanzatori (tara,oras,telefon,telefon_2) VALUES ('$tara_id','$oras','$telefon1','$telefon2')") or die(mysql_error());
			$vanzator_id = mysql_insert_id();
		}
		
		$m['vanzatori_id'] = $vanzator_id;
		
		echo 'Vanzator id :'.$vanzator_id . '<br>';
		

		
		// insereaza masina
		
		$masini = new Masini();
		if ($this->verificaDuplicat($m) == 0) {
			
			// scoate unele campuri
			unset($m['Tara_Vanzator']);
			unset($m['Oras_Vanzator']);
			unset($m['telefon1']);
			unset($m['telefon2']);
			unset($m['model']);
			unset($m['marca']);
			unset($m['Taxa de mediu']);
			unset($m['Tara de origine']);
			
			$id_masina = $masini->insert($m);
			// introdu pozele
		
			$i=1;
			foreach($m['poze'] as $poza) {
				mysql_query("INSERT INTO imagini (masina_id,url,pozitie) VALUES ('$id_masina','$poza','$i')");
				$i++;
			}
		} else {
			//  
			echo '------duplicatduplicatduplicatduplicatduplicatduplicatduplicatduplicatduplicatduplicatduplicatduplicatduplicatduplicat-------';
		}
		
		
		
		return $m;
	}
	
	 function verificaDuplicat($masina) {

		$conditie = "model_id='$masina[model_id]' AND an_fabricatie='$masina[an_fabricatie]' AND putere='$masina[putere]' AND ABS($masina[kilometraj] - kilometraj) < kilometraj/10 AND ABS($masina[pret] - pret) < pret/10";

		$sql_query = "SELECT * FROM masini WHERE $conditie";

		$sql_query = str_replace("&nbsp", "", $sql_query);
		$query = mysql_query($sql_query);
		echo '<Br><br>query: '.$sql_query.'<br><Br>'.mysql_error().'<br><Br><br>a gasit '.mysql_num_rows($query).' rezultate<br><br>';
		if (mysql_num_rows($query) > 0)
		{
			while ($row=mysql_fetch_array($query))
			{
				//  Insert into duplicate
				$idx = $row['id'];
				$query = mysql_query("SELECT * FROM duplicate WHERE id_anunt='$idx_'");
				
				if (mysql_num_rows($query) == 0)
					mysql_query("INSERT INTO duplicate (id_anunt,telefon) VALUES (".$row['id'].",'".$masina[telefon1]."')");
			}
		}
		
		return mysql_num_rows($query);

	}
	
	function verificaStatusAnunt() {										//  ok

		$query = mysql_query("SELECT * FROM $this->table_queue WHERE vazut=1 ORDER BY id DESC LIMIT $this->limita_verificare");
	
		while ($r = mysql_fetch_array($query)) {

			$delete = $this->checkAdStatus($r['cod_masina']);
			if ($delete) {
					//  Delete from database
					mysql_query("DELETE FROM $this->table_cars WHERE url_mobile LIKE '%".$r['cod_masina']."%'");
			}
			$delete = null;
		}
	}	

	// verifica pt un anunt daca mai exista/mai e valabil
	function checkAdStatus($id)
	{
		
		$url = "http://cautare.mobile.ro/vehicule/showDetails.html?id=$id&lang=ro&pageNumber=1&__lp=1702&scopeId=C&sortOption.sortBy=creationTime&sortOption.sortOrder=DESCENDING&makeModelVariant1.searchInFreetext=false&makeModelVariant2.searchInFreetext=false&makeModelVariant3.searchInFreetext=false&ambitCountry=RO&siteId=ROMANIA&negativeFeatures=EXPORT&tabNumber=";
		
		$html = file_get_html($url.'1');  //  first tab
		
		// nu mai e valabil anuntul
		if (strstr($html->plaintext,"Anunţul solicitat de dvs. nu a putut fi găsit") || strstr($html->plaintext,"Anuntul este inactiv"))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

?>