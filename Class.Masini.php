<?php
include 'class.database.php';

class Masini 
{
 var $db;
 
 var $field_n = array('nume_anunt','model_id','tip_masina','an_fabricatie','kilometraj','pret','tara_origine','tara_inmatriculare','putere','capacitate','tip_combustibil','transmisie','nr_usi','culoare','marci_id','url_autovit','url_mobile','cilindre','tapiserie','culoare_tapiserie','stare_tehnica','norme_euro','descriere','vanzatori_id');
 var $dotari = array('primul_proprietar','tva_deductibil','fara_accident','filtru_particule','ABS','alarma','comenzi_volan','geamuri_electrice','jante_aliaj','radio/CD','sistem_navigatie','4x4','EDS','antifurt_mecanic','computer_bord','imobilizator','oglinzi_electrice','scaune_incalzite','suspensie_reglabila','ESP','bare_portbagaj','controlul_tractiunii','incalzire_auxiliara','parbriz_incalzit','senzori_parcare','tapiserie_piele','aer_conditionat','cadru_de_protectie','diferential_blocabil','inchidere_centralizata','pilot_automat','senzori_ploaie','trapa','airbag','carlig_remorcare','geamuri_colorate','interior_velur','proiectoare_ceata','servo_directie','xenon','pt_pers_cu_dizabilitati','garantie','taxi','carte_service','epoca','tuning','pret_negociabil','predare_leasing','taxa_mediu','metalizat');

 var $culori_masini = array('Alb','Albastru','Argintiu','Auriu','Bej','Galben','Gri','Maro','Negru','Portocaliu','Rosu','Verde','Violet','Visiniu');
 var $tipuri_masini = array('Berlina','Break','Van/minibus','Pick-Up/Off-road','Cabrio','Coupe/Sport','Alta');
 var $tipuri_combustibil = array('Diesel','Benzina','Gaz','Hibrid','Electric','Hidrogen','Etanol','Alta');
 var $tipuri_transmisie = array('Automata','Manuala','Semi-automata/Secventiala');
 var $culori_tapiserie = array('Alb','Albastru','Argintiu','Auriu','Bej','Galben','Gri','Maro','Negru','Portocaliu','Rosu','Verde','Violet','Visiniu','Alta');
 var $stari_tehnice = array('Avariat','Neavariat','Nou');
 var $norme_euro = array('non-euro','euro 1','euro 2','euro 3','euro 4','euro 5','euro 6');
 var $campuri=array();

 var $search_fields = array(
 	 'masini.marci_id' => '=',
     'model_id' => '=',
     'tip_masina' => '=',
     'an_fabricatie_min' => '>=',
     'an_fabricatie_max' => '<=',
     'kilometraj_min' => '>=',
     'kilometraj_max' => '<=',
     'pret_min' => '>=',
     'pret_max' => '<=',
     'putere_min' => '>=',
     'putere_max' => '<=',
     'capacitate_min' => '>=',
     'capacitate_max' => '<=',
     'tip_combustibil' => '=',
     'transmisie' => '=',
     'numar_usi' => '=',
     'culoare' => '=',
     'primul_proprietar' => '=',
     'tva_deductibil' => '=',
     'filtru_particule' => '=',
     'metalizat' => '=',
     'stare_tehnica' => '=',
     'ABS' => '=',
     'EDS' => '=',
     'ESP' => '=',
     'airbag' => '=',
     'carlig_remorcare' => '=',
     'jante_aliaj' => '=',
     'xenon' => '=',
     '4x4' => '='
 );

 function __construct()
 {
	$this->db = new Database();
        $this->campuri = array_merge($this->field_n,$this->dotari);
 }
 
 function validare($details)
 {
    $dots = array();
	foreach ($this->dotari as $val)
		if (!empty($details[$val]))
			$dots[$val]=1;
		else $dots[$val]=0;
		
	if (!is_numeric($details['model_id']))
	  return false;
	if (!is_numeric($details['an_fabricatie']))
	  return false;
	if (!is_numeric($details['kilometraj']))
	  return false;
	if (!is_numeric($details['pret']))
	  return false;
	if (!is_numeric($details['tara_origine']))
	  return false;
	if (!is_numeric($details['tara_inmatriculare']))
	  return false;
	if (!is_numeric($details['putere']))
	  return false;
	if (!is_numeric($details['capacitate']))
	  return false;
    if (!is_numeric($details['marci_id']))
	  return false;
	if (!in_array($details['tip_masina'],$this->tipuri_masini))
	  return false;
	if (!in_array($details['tip_combustibil'],$this->tipuri_combustibil))
	  return false;
	if (!in_array($details['culoare'],$this->culori_masini))
      return false;	
	if (!in_array($details['transmisie'],$this->tipuri_transmisie))
	  return false;
	if (!in_array($details['culoare_tapiserie'],$this->culori_tapiserie))
	  return false;
	if (!in_array($details['stare_tehnica'],$this->stari_tehnice))
	  return false;
	if (!in_array($details['norme_euro'],$this->norme_euro))
	  return false;
	
    $rezult=array_merge($details,$dots);
	
	return $rezult;
 }
 
 function insert($rezult)
 {
	//$rezult = $this->validare($rezult);
	
	if ($rezult != false)
	{		

		
		/* de refacut */
	    $nume_vanzator = $rezult['nume_vanzator'];
		$prenume_vanzator = $rezult['prenume_vanzator'];
		$tara_vanzator = $rezult['tara_vanzator'];
		$oras_vanzator = $rezult['oras_vanzator'];
		$telefon_vanzator = $rezult['telefon_vanzator'];
		
		/*
		$vanzator = $this->db->select("SELECT * FROM vanzatori WHERE nume='$nume_vanzator' AND prenume='$prenume_vanzator' AND tara='$tara_vanzator'");
		$vanzator_id = 0;
		if (!empty($vanzator))
		{
			$vanzator_id = $vanzator['id'];
		}
		else {
				$camps_v = array("nume","prenume","tara","oras","telefon");
				$vals_v = array("nume"=>$nume_vanzator,"prenume"=>$prenume_vanzator,"tara"=>$tara_vanzator,"oras"=>$oras_vanzator,"telefon"=>$telefon_vanzator);
				
				$this->db->insert("vanzatori",$camps_v,$vals_v);
				$vanzator_id = $this->db->insert_id();
		     }
		
		$rezult['vanzatori_id']=$vanzator_id;
		*/
		
	    $this->db->insert('masini',$this->campuri,$rezult);
		
		return $this->db->insert_id();
		
	}
	else return false;
 }
 
 function getDetails($masina_id)
 {
	if (is_numeric($masina_id))
	{
		$result = $this->db->select("SELECT * FROM masini WHERE id='$masina_id'");
		$model_id = $result['model_id'];
		$tara_origine_id = $result['tara_origine'];
		$tara_inmatriculare_id = $result['tara_inmatriculare'];
		$marci_id = $result['marci_id'];
		$vanzator_id = $result['vanzatori_id'];
		
		$model = ($this->db->select("SELECT * FROM modele WHERE id='$model_id'"));
		$tara_origine_name = ($this->db->select("SELECT * FROM tari WHERE id='$tara_origine_id'"));
		$tara_inmatriculare_name = ($this->db->select("SELECT * FROM tari WHERE id='$tara_inmatriculare_id'"));
		$marci = ($this->db->select("SELECT * FROM marci WHERE id='$marci_id'"));
		$vanzator = ($this->db->select("SELECT * FROM vanzatori WHERE id='$vanzator_id'"));
		$id_tara_vanzator = $vanzator['tara'];
	    $tara_vanzator_name = ($this->db->select("SELECT * FROM tari WHERE id='$id_tara_vanzator'"));
		
		
		$result['model']=$model['nume_model'];
		$result['tara_origine']=$tara_origine_name['nume_tara'];
		$result['tara_inmatriculare']=$tara_inmatriculare_name['nume_tara'];
		$result['marca']=$marci['nume_marca'];
		$result['vanzator_nume']=$vanzator['nume'];
		$result['vanzator_prenume']=$vanzator['prenume'];
		$result['vanzator_tara']=$tara_vanzator_name['nume_tara'];
		$result['vanzator_oras']=$vanzator['oras'];
		$result['vanzator_telefon']=$vanzator['telefon'];
		 
		return $result;
	}
	else return false;
 }
 
 function search($details)
 {
     //sa facem validare
	//$details = $this->validare($details);
	
 	foreach($details as $key => $value)
 		$details[$key] = mysql_real_escape_string($value);
 	
 	if(!empty($details['masini_marci_id']))
 		$details['masini.marci_id'] = $details['masini_marci_id'];

   	if(!empty($details['tara_vanzator']) && $details['tara_vanzator'] != 'oricare')
   	{
     	$query = "SELECT * FROM masini, modele, marci, vanzatori WHERE vanzatori.tara='$details[tara_vanzator]' AND vanzatori.id = masini.vanzatori_id AND masini.marci_id = marci.id AND masini.model_id = modele.id AND ";
        $query2 = "SELECT masini.id 'idul' FROM masini, modele, marci, vanzatori WHERE vanzatori.tara='$details[tara_vanzator]' AND vanzatori.id = masini.vanzatori_id AND masini.marci_id = marci.id AND masini.model_id = modele.id AND ";     	
     	$query3 = "SELECT count(*) 'nr' FROM masini, modele, marci, vanzatori WHERE vanzatori.tara='$details[tara_vanzator]' AND vanzatori.id = masini.vanzatori_id AND masini.marci_id = marci.id AND masini.model_id = modele.id AND ";
   	}
    else
    {
    	$query = "SELECT * FROM masini, modele, marci WHERE masini.marci_id = marci.id AND masini.model_id = modele.id AND ";
        $query2 = "SELECT masini.id 'idul' FROM masini, modele, marci WHERE masini.marci_id = marci.id AND masini.model_id = modele.id AND ";
    	$query3 = "SELECT count(masini.marci_id) 'nr' FROM masini, modele, marci WHERE masini.marci_id = marci.id AND masini.model_id = modele.id AND ";
    }

	foreach($this->search_fields as $key=>$value)
	{
		if(!empty($details[$key]) && $details[$key] != 'oricare')
		{
                    if($value == '=')
                    {
                        $query .= $key.$value."'".$details[$key]."'"." AND ";
                        $query2 .= $key.$value."'".$details[$key]."'"." AND ";
                        $query3 .= $key.$value."'".$details[$key]."'"." AND ";
                    }
                    else
                    {
                        $camp = substr($key, 0, -4);
                        $query .= $camp.$value."'".$details[$key]."'". " AND ";
                        $query2 .= $camp.$value."'".$details[$key]."'". " AND ";
                        $query3 .= $camp.$value."'".$details[$key]."'". " AND ";
                    }
		}
	}

        $query = substr($query, 0, -5);
        $query2 = substr($query2, 0, -5);
        $query3 = substr($query3, 0, -5);

        //echo $query3;
        $nr_res_found = $this->db->select($query3);
        
        
        if(!empty($details['sort_by']))
        {
        	$query .= " ORDER BY " . $details['sort_by'];
        	$query2 .= " ORDER BY " . $details['sort_by'];
        	
        	if(!empty($details['order']))
        	{
        		$query .= " " . $details['order'];
        		$query2 .= " " . $details['order'];
        	}        	
        }
        
        
        //paginatia. o sa fie 10 pe pagina
        $nr_res = 10;
        if(empty($details['page']))
        	$page = 1;
       	else 
       		$page = $details['page'];
        
        $query .= " LIMIT " . ($page - 1) * 10 . ", $nr_res";
        $query2 .= " LIMIT " . ($page - 1) * 10 . ", $nr_res";
        
        	//echo $query;
        
		$result = $this->db->selectMultiple($query);
        $result2 = $this->db->selectMultiple($query2);

        $i=0;
        foreach ($result as $key=>$value)
        {
               $result[$key]["id"]=$result2[$i]['idul'];
               $i++;
        }

        $result[0]['nr_rez'] = $nr_res_found['nr'];
        //echo "<br/><br/>" . $query . '<hr/><br/>';
		return $result;
 	}
}

/*

$kkt = array('nume'=>'Gigi becali 2000',
             'model_id'=>'2',
			 'tip_masina'=>'Berlina',
			 'an_fabricatie'=>'1',
			 'kilometraj'=>'2',
			 'pret'=>'3',
			 'tara_origine'=>'4',
			 'tara_inmatriculare'=>'5',
			 'putere'=>'6',
			 'capacitate'=>'8',
			 'tip_combustibil'=>'Diesel',
			 'transmisie'=>'Automata',
			 'nr_usi'=>'2/3',
			 'culoare'=>'Alb',
			 'primul_proprietar'=>'1',
			 'tva_deductibil'=>'2',
			 'fara_accident'=>'3',
			 'filtru_particule'=>'4',
			 'marci_id'=>'5',
			 'ABS'=>'b',
			 'alarma'=>'c',
			 'radio/CD'=>'d');

$caca = new Masini();
$caca->insert($kkt); 
$gogu = $caca->getDetails(3);
*/
?>
