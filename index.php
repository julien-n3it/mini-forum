<?php
require("includes/bdd/bdd.php");
require("includes/bdd/fonctions.php");
require("Mobile-Detect/Mobile_Detect.php");
$detect = new Mobile_Detect();
if ($detect->isMobile()) {
    $mobile_chain = "-fluid" ;
}else{
	$mobile_chain = "" ;
}

$heure = date("H");
$minute = date("i");

// on teste si un formulaire est recu
if(isset($_POST['nom']))
{
	// On vérifie si la ligne existe déjà
	$nom = $_POST['nom'] ;
	$datetime = substr($_POST['date'],6,4)."-".substr($_POST['date'],3,2)."-".substr($_POST['date'],0,2)." ".$_POST['heure'].":".$_POST['minute'].":00" ;
	$select_sujet = "SELECT * FROM tblsujets WHERE suj_nom = '".str_replace("'","\'",$nom)."' AND suj_datetime = '".$datetime."'" ;
	$result_sujet = $conn->query($select_sujet);
	$row_count = $result_sujet->rowCount();  
	
	// sinon on insère
	if($row_count == 0)
	{
		$query_insert = "INSERT INTO tblsujets
							(suj_nom,suj_datetime)
							VALUES ('".str_replace("'","\'",$nom)."','".$datetime."') " ;
		$conn->query($query_insert);
		$sujet_id = $conn->lastInsertId();
		
	}else {
		$row_sujet = $result_sujet->fetch();
		$sujet_id = $row_sujet['id_suj'] ;
	}
	
	// si une ligne existe on redirige dessus
	header('Location: sujet.php?sujet_id='.$sujet_id); 
	
}
?><!doctype html>
<html lang="fr"><head>
	<head>
		<title>Bienvenue</title>
		    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
			<link rel="stylesheet" href="bootstrap-datepicker/css/bootstrap-datepicker.min.css">
			<link rel="stylesheet" href="custom/css/custom.css">
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
			<script src="bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
			<script src="bootstrap-datepicker/locales/bootstrap-datepicker.fr.min.js" charset="UTF-8"></script>
			<script>
			$( document ).ready(function() {
			  // application du calendrier
			  $('#date').datepicker({
					language: 'fr'
				});
			});
			
			function verifyForm(){
				if($("#date").val() == '' || $("#nom").val() == '')
				{
					alert('Veuillez renseigner un nom et une date pour le sujet.')
				}else $("#form").submit();
			}
			</script>
	<head>
	<body>
	<div class="container<?php echo $mobile_chain;?>">
		<?php include "includes/header.php" ?>
		<div class="row">
			<div class="col">
			</div>
			<div class="col text-center">
				<p>Un mini forum personnalisé pour tous ! Ici on met autre chose pour chercher le conflit</p>
			</div>
			<div class="col">
			</div>
		</div>
		<form action="#" id="form" method="POST">
		<div class="row">
			<div class="col text-center">
				<h2>Votre sujet personnalisé</h2>
			</div>
			<div class="col">
				<div class="row">
					<div class="col">
						<div class="form-group">
							<label for="nom">Nom</label>
							<input type="text" name="nom" class="form-control" id="nom" aria-describedby="nom" placeholder="Entrez le nom de votre sujet">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="form-group">
							<label for="date">Date</label>
							<input type="text" name="date" class="form-control" id="date" value="<?php echo date("d/m/Y");?>">
						</div>
					</div>
					<div class="col">
						<div class="form-group">
							<label for="heure">Heure<br/></label>
							<select name="heure" class="form-control" id="heure">
							<?php
							for($i = 0; $i <= 23 ; $i++)
							{
								if(str_pad($i, 2, 0, STR_PAD_LEFT) == $heure) $selected = " selected " ;
								else $selected = "" ;								
							?>
							  <option value="<?php echo str_pad($i, 2, 0, STR_PAD_LEFT);?>"<?php echo $selected;?>><?php echo str_pad($i, 2, 0, STR_PAD_LEFT);?></option>
							<?php
							}
							?>
							</select>
						</div>
					</div>
					<div class="col">
						<div class="form-group">
							<label for="heure">Minute<br/></label>
							<select name="minute" class="form-control" id="minute">
							<?php
							for($i = 0; $i <= 59 ; $i++)
							{
								if(str_pad($i, 2, 0, STR_PAD_LEFT) == $minute) $selected = " selected " ;
								else $selected = "" ;
							?>
							  <option value="<?php echo str_pad($i, 2, 0, STR_PAD_LEFT);?>"<?php echo $selected;?>><?php echo str_pad($i, 2, 0, STR_PAD_LEFT);?></option>
							<?php
							}
							?>
							</select>
						</div>
					</div>
				</div>
					<button type="button" onclick="verifyForm();" class="btn btn-primary">Envoyer</button>
			</div>
		</div>
		</form>
		<h2>Exemple de discussion</h2>
	</div>
	<div class="container<?php echo $mobile_chain;?> rounded" style="margin-top:5px;background-color:#EE2222;">
		<div class="col">
			<h3>Sujet 1</h3>
			<small>24/02/2019</small>
			<small>18h30</small>
		</div>
		<div class="col discussion">
		<span class="badge badge-pill badge-primary">Pierre</span>
			<p>- J'aime discuter et vous ?</p>
		</div>
		<div class="col discussion indent1">
		<span class="badge badge-pill badge-primary">Thomas</span>
			<p>- Moi aussi surtout de politique.</p>
		</div>
		<div class="col discussion indent2">
		<span class="badge badge-pill badge-primary">Luc</span>
			<p>- @Thomas La politique c'est compliqué.</p>
		</div>
		<div class="col discussion">
		<span class="badge badge-pill badge-primary">Claude</span>
			<p>- Où trouver des informations sur la politique ?</p>
		</div>
		<div class="col discussion indent1">
		<span class="badge badge-pill badge-primary">Chris</span>
			<p>- Sur internet ou en lisant des livres.</p>
		</div>
		<br />
	</div>
	<div class="container<?php echo $mobile_chain;?> rounded" style="margin-top:5px;">
		<h2>Discussions en cours</h2>
	</div>
	<div class="container<?php echo $mobile_chain;?> rounded" style="margin-top:5px;padding-top:10px;padding-bottom:10px;background-color:#FF3333;">
		<?php
		// lecture des commentaires premier niveau
		$query_sujet = "SELECT * FROM tblsujets ORDER BY suj_datetime DESC " ;
		$result_sujet = $conn->query($query_sujet);
		while($row_sujet = $result_sujet->fetch()){
			?>
			<div class="alert alert-secondary" role="alert">
				<a href="sujet.php?sujet_id=<?php echo $row_sujet['id_suj'];?>">
				>>
				<?php echo $row_sujet['suj_nom'];?> (le <?php echo substr($row_sujet['suj_datetime'],8,2)."/".substr($row_sujet['suj_datetime'],5,2)."/".substr($row_sujet['suj_datetime'],0,4);?> à <?php echo substr($row_sujet['suj_datetime'],11,2);?>h<?php echo substr($row_sujet['suj_datetime'],14,2);?>)
				</a>
			</div>
			<?php
		}
		?>
	</div>
	</body>
</html>