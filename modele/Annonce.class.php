<?php
//require "../annonces/modele/Modele.php";

class Annonce
{
	private $id;
	private $titre;
	private $contenu;
	private $prix;
	private $date_creation;
	private $id_cat;
	private $id_reg;
	private $tel;
	private $email;
	private $motdepasse;

	
	// construct
	public function __construct($ID) {
		
		if ($ID=="")
		{
	    	$this->id="";
	      $this->titre="";
	   	$this->contenu="";
	   	$this->prix="";
	    	$this->date_creation="";
			$this->id_cat="";
			$this->id_reg="";
			$this->tel="";
			$this->email="";
			$this->motdepasse="";
		}
		else 
		{
		   //global $bdd;
		   $bdd=getBDD();
		   // table annonce
			$req=$bdd->prepare("SELECT id,id_cat,id_reg,titre,contenu,prix,tel,email,motdepasse,DATE_FORMAT(date_creation,'%d/%m/%Y') AS date_creation_fr  FROM annonces WHERE id=:idannonce");
			$req->execute(array(
			"idannonce"=>$ID
			));
			$donnees=$req->fetch();
			
	    	$this->id=$donnees["id"];
	      $this->titre=$donnees["titre"];
	   	$this->contenu=$donnees["contenu"];
	   	$this->prix=$donnees["prix"];
	    	$this->date_creation=$donnees["date_creation_fr"];
			$this->id_cat=$donnees["id_cat"];
			$this->id_reg=$donnees["id_reg"];
			$this->tel=$donnees["tel"];
			$this->email=$donnees["email"];
			$this->motdepasse=$donnees["motdepasse"];
	    	
	    	$req->closeCursor();
		}
		}
	// ajout bdd
	public function ajout_bdd() {
		//global $bdd;
		$bdd=getBDD();
		//echo var_dump($this->getValide());
		if ($this->getValide())
		{
			$req=$bdd->prepare("INSERT INTO annonces(titre, prix, contenu, date_creation, id_cat, id_reg, tel, email, motdepasse) VALUES (:titre,:prix,:contenu,NOW(),:id_cat,:id_reg,:tel,:email, :motdepasse)");
			$req->execute(array(
				"titre"=>$this->titre,
				"prix"=>$this->prix,
				"contenu"=>$this->contenu,
				"id_cat"=>$this->id_cat,
				"id_reg"=>$this->id_reg,
				"tel"=>$this->tel,
				"email"=>$this->email,
				"motdepasse"=>$this->getMotdepasse()
				));			
			$count = $req->rowCount();
			
			//$last = $bdd->query('SELECT LAST_INSERT_ID(id) FROM annonces')->fetch(PDO::FETCH_ROW)[0];
			$last = $bdd->lastInsertId("id");
			$this->setId($last);
			
			//echo $last;
			//echo var_dump($count==1);
			
			$req->closeCursor();
			return $count==1; // à revoir		
		}
		else 
		{  
		  return FALSE;
		}
		
		}
	 //check user
	 public function check_user($email,$motdepasse) {
	 	$bdd=getBDD();
	 	
    	$mdp=hash('sha256', $motdepasse);
    	$req=$bdd->prepare('SELECT id FROM annonces WHERE (id=:id AND email=:email AND motdepasse=:motdepasse)');
		$req->execute(array(
		"id"=>$this->id,
		"email"=>$email,
		"motdepasse"=>$mdp
		));
		$count = $req->rowCount();
		$req->closeCursor();
		
		if ($count ==1) {
			return true;
		}
		else {
			return false;		
		}
		
	 	}	
    // suppression de la bdd
    public function suppr_bdd($email,$motdepasse) {
    	//global $bdd;
    	$bdd=getBDD();
    	
	 	if ($this->check_user($email,$motdepasse)) {
	    	// suppression dossier uploads
	      $uploads_dir = $this->getUploadsDir();
	    	// d'abord les images
	    	$liste_nom_img = $this->getImage();
	    	foreach ($liste_nom_img as $im_name) {
				unlink($uploads_dir.$im_name["nom_img"]);	    	
	    	}
	    	//puis le dossier
  			if ( is_dir($uploads_dir)) {
  				rmdir($uploads_dir); // uniquement dossier vide
  				//print("suppression dossier");
  			}
			// nettoyage table annonces_img
	    	$req=$bdd->prepare('DELETE FROM annonces_img WHERE (id_ann=:id)');
			$req->execute(array(
			"id"=>$this->id
			));
			$req->closeCursor();	    	
	    	// nettoyage table annonces
	    	$req=$bdd->prepare('DELETE FROM annonces WHERE (id=:id)');
			$req->execute(array(
			"id"=>$this->id
			));
			$count = $req->rowCount();
			$req->closeCursor();
			
			return $count==1; // à revoir
		} 
		else {
			return false;
		}
		
    	}
    //affichage
    public function affiche() {
        echo $this->titre . " | " . $this->prix . "€ | " . $this->date_creation . "<br />";
        }
	 //id    
    public function getId() {
        return htmlspecialchars($this->id);
        }
    public function setId($id) {
        $this->id = $id;
    }
 	 //titre    
    public function getTitre() {
        return htmlspecialchars($this->titre);
        }
    public function setTitre($titre) {
        $this->titre = $titre;
    }
 	 //contenu   
    public function getContenu() {
        return nl2br(htmlspecialchars($this->contenu, ENT_QUOTES, "UTF-8"));
        }
    public function setContenu($contenu) {
        $this->contenu = $contenu;
    }
 	 //prix   
    public function getPrix() {
        return htmlspecialchars($this->prix);
        }
    public function setPrix($prix) {
        $this->prix = (int)$prix;
    }
 	 //date_creation   
    public function getDate_creation() {
        return htmlspecialchars($this->date_creation);
        }
    public function setDate_creation($date_creation) {
        $this->date_creation = $date_creation;
    }
    // categorie
    public function getId_cat() {
        return $this->id_cat;
        }
    public function setId_cat($id_cat) {
        $this->id_cat = $id_cat;
    }
    public function getNom_cat() {
    	//global $bdd;
    	$bdd=getBDD();
		$req=$bdd->prepare("SELECT nom FROM categories WHERE id=:id_cat");
		$req->execute(array(
		"id_cat"=>$this->getId_cat()
		));
		$donnees=$req->fetch();
		$req->closeCursor();
      return $donnees["nom"];
      }
    // regions
    public function getId_reg() {
        return $this->id_reg;
        }
    public function setId_reg($id_reg) {
        $this->id_reg = $id_reg;
    }
    public function getNom_reg() {
    	//global $bdd;
    	$bdd=getBDD();
		$req=$bdd->prepare("SELECT nom FROM regions WHERE id=:id_reg");
		$req->execute(array(
		"id_reg"=>$this->getId_reg()
		));
		$donnees=$req->fetch();
		$req->closeCursor();
      return $donnees["nom"];
      }
 	 //telephone   
    public function getTel() {
        return htmlspecialchars($this->tel);
        }
    public function setTel($tel) {
        $this->tel = $tel;
        }
 	 //mail   
    public function getEmail() {
        return $this->email;
        }
    public function setEmail($email) {
        $this->email = $email;
    }
    //motdepasse
    public function getMotdepasse() {
        return $this->motdepasse;
        }
    public function setMotdepasse($motdepasse) {
        $this->motdepasse = hash('sha256', $motdepasse);
    }
    //vérifier validité annonce
    public function getValide() {
		  $titre_valid=(strlen($this->titre)>3 AND strlen($this->titre)<50 );
    	  $contenu_valid=(strlen($this->contenu)>9 AND strlen($this->contenu)<2000);
    	  $prix_valid=is_int($this->prix);
    	  $tel_valid=boolval(preg_match("#^[0-9]{9}[0-9]$#", $this->tel));
    	  $email_valid=boolval(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $this->email));
    	  $motdepasse_valid=(strlen($this->titre)>5);
    	  //echo var_dump(($titre_valid AND $contenu_valid AND $prix_valid AND $tel_valid AND $email_valid AND $motdepasse_valid));
    	  return ($titre_valid AND $contenu_valid AND $prix_valid AND $tel_valid AND $email_valid AND $motdepasse_valid);

    }
    // chemin de stockage
    public function getUploadsDir() {
    	$uploads_dir = 'uploads/'.$this->getId().'/';
		if ( ! is_dir($uploads_dir)) {
		    mkdir($uploads_dir);
		}
		if ( ! is_dir($uploads_dir)) {
		    echo "Erreur création dossier de stockage image";
		}
    	return $uploads_dir;
    }
    // ajout image
    public function setImage($DATA) {
    
 		$bdd=getBDD();
		$req=$bdd->prepare('INSERT INTO annonces_img(id_ann,nom_img) VALUES (:id_ann, :nom_img)');
		
		$uploads_dir = $this->getUploadsDir();
		
		foreach ($DATA["pictures"]["error"] as $key => $error) {
			 // verif upload réussi et taille image
		    if ($error == UPLOAD_ERR_OK AND $DATA["pictures"]["size"][$key]<2097152 ) {
		    	    // verif du format fichier
		    	    $finfo = new finfo(FILEINFO_MIME_TYPE);
				    if (!(false === $ext = array_search(
				        $finfo->file($DATA['pictures']['tmp_name'][$key]),
				        array(
				            'jpg' => 'image/jpeg',
				            'png' => 'image/png',
				            //'gif' => 'image/gif',
				        ),
				        true
				    ))) 
				    {   
				    	  // upload fichier et mise a jour bdd
						  $tmp_name = $DATA["pictures"]["tmp_name"][$key];
				        //$name = $_FILES["pictures"]["name"][$key];
				        $name = sha1_file($DATA["pictures"]["tmp_name"][$key]).'.'.$ext;
				        $chemin_fichier=$uploads_dir.$name;
				        move_uploaded_file($tmp_name, $chemin_fichier);
						  $redimOK = fctredimimage(600,600,$uploads_dir,$name,$uploads_dir,$name);
				        //echo $chemin_fichier;
				        
				        $req->execute(array(
						  "id_ann"=>$this->getId(),
						  "nom_img"=>$name
						  ));
				    }

		    }
		}
		$req->closeCursor();
						
    }
    // recup nom image
    public function getImage() {
    	$bdd=getBDD();
		$req=$bdd->prepare("SELECT nom_img FROM annonces_img WHERE id_ann=:id_ann");
		$req->execute(array(
		"id_ann"=>$this->getId()
		));
		$liste_nom_img=$req->fetchAll();
		$req->closeCursor();
      return $liste_nom_img;
    }
    public function getNbImages() {
    	
    	$bdd=getBDD();
		$req=$bdd->prepare("SELECT COUNT(*) AS nb_img FROM annonces_img WHERE id_ann=:id_ann");
		$req->execute(array(
		"id_ann"=>$this->getId()
		));
		$donnees=$req->fetch();
		$req->closeCursor();
      return $donnees["nb_img"];
    
    }
    
}