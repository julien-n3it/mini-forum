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

$select_sujet = "SELECT * FROM tblsujets WHERE id_suj = ".$_GET['sujet_id'] ;
$result_sujet = $conn->query($select_sujet);
$row_sujet = $result_sujet->fetch();

if(!isset($_GET['onglet']))$_GET['onglet'] = 1;

if($_GET['onglet'] == 1)
{
	$selected_onglet1 = " checked " ;
	$selected_onglet2 = "" ;
}else{
	$selected_onglet1 = "" ;
	$selected_onglet2 = " checked " ;
}

// on teste l'existence d'un envoi
if(isset($_POST['envoi']))
{
	// si envoi on insère la ligne de discussion
	$query_insert = "INSERT INTO tbldiscussions 
					(lnk_suj,lnk_ong,lnk_dis,dis_auteur,dis_texte,dis_datetime)
					VALUES (".$_GET['sujet_id'].",".$_GET['onglet'].",".$_POST['lnk_dis_'.$_POST['envoi']].",'".str_replace("'","\'",$_POST['nom_'.$_POST['envoi']])."','".str_replace("'","\'",$_POST[$_POST['envoi']])."','".date('Y-m-d H:i:s')."') " ;
	$conn->query($query_insert);
}

?><!doctype html>
<html lang="fr"><head>
	<head>
		<title>Sujet</title>
		    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
			<link rel="stylesheet" href="bootstrap-datepicker/css/bootstrap-datepicker.min.css">
			<link rel="stylesheet" href="custom/css/custom.css">
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
			<script src="bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
			<script src="bootstrap-datepicker/locales/bootstrap-datepicker.fr.min.js" charset="UTF-8"></script>
			<script>
			function verifyCommentForm(id){
				if($("#"+id).val() == '' || $("#nom_"+id).val() == '')
				{
					alert('Veuillez renseigner un commentaire et votre nom avant de cliquer sur envoyer.')
				}else $("#form_"+id).submit();
			}
			</script>
	<head>
	<body>
	<div class="container<?php echo $mobile_chain;?>">
		<div class="row rounded center" style="margin-top:5px;background-color:#338dff;">
			<div class="col">
			</div>
			<div class="col">
				<h1 style="color:#FFFFFF;">MINI-FORUM.COM</h1>
			</div>
			<div class="col">
			</div>
		</div>
		<div class="container<?php echo $mobile_chain;?> rounded" style="margin-top:5px;background-color:#c1dbfd;">
		<small><a href="index.php"><< Revenir à l'accueil</a></small>
		<div class="row">
			<div class="col">
				<h3><?php echo $row_sujet['suj_nom'];?></h3>
				<small><?php echo substr($row_sujet['suj_datetime'],8,2)."/".substr($row_sujet['suj_datetime'],5,2)."/".substr($row_sujet['suj_datetime'],0,4);?></small>
				<small><?php echo substr($row_sujet['suj_datetime'],11,2);?>h<?php echo substr($row_sujet['suj_datetime'],14,2);?></small>
			</div>
			<div class="col">
			</div>
			<div class="col">
				<div class="alert alert-primary center" role="alert">
					<a id="onglet1" href="sujet.php?sujet_id=<?php echo $_GET['sujet_id']?>&onglet=1"><input type="radio" <?php echo $selected_onglet1;?> /> Onglet 1</a>
				</div>
			</div>
			<div class="col">
				<div class="alert alert-primary center" role="alert">
					<a id="onglet2" href="sujet.php?sujet_id=<?php echo $_GET['sujet_id']?>&onglet=2"><input type="radio" <?php echo $selected_onglet2;?> /> Onglet 2</a>
				</div>
			</div>
			<div class="col">
			</div>
		</div>
		<?php
		// lecture des commentaires premier niveau
		$query_discussion = "SELECT * FROM tbldiscussions WHERE lnk_suj = ".$_GET['sujet_id']." AND lnk_ong = ".$_GET['onglet']." AND lnk_dis = 0 ORDER BY dis_datetime DESC " ;
		$result_discussion = $conn->query($query_discussion);
		while($row_discussion = $result_discussion->fetch()){
			?>
			<div class="col discussion" id="div_commentaire<?php echo $row_discussion['id_dis'];?>">
			<span class="badge badge-pill badge-primary"><?php echo $row_discussion['dis_auteur'];?></span> <small><?php echo datetimefr($row_discussion['dis_datetime']);?></small>
				<p>- <?php echo $row_discussion['dis_texte'];?></p>
				<span><a href="#div_commentaire<?php echo $row_discussion['id_dis'];?>" onclick="$('#com<?php echo $row_discussion['id_dis'];?>').show();">Répondre</a></span>
			</div>
			<div class="col" id="com<?php echo $row_discussion['id_dis'];?>" style="display:none;">
				<form action="#" id="form_commentaire<?php echo $row_discussion['id_dis'];?>" method="POST">
					<div class="form-group">
					  <label for="comment">Nom :</label>
					  <input type="text" name="nom_commentaire<?php echo $row_discussion['id_dis'];?>" class="form-control" id="nom_commentaire<?php echo $row_discussion['id_dis'];?>" aria-describedby="nom" placeholder="Entrez votre nom">
					</div> 
					<div class="form-group">
					  <label for="comment">Commenter :</label>
					  <textarea class="form-control" rows="5" id="commentaire<?php echo $row_discussion['id_dis'];?>" name="commentaire<?php echo $row_discussion['id_dis'];?>"></textarea>
					</div> 
					<input type="hidden" name="envoi" value="commentaire<?php echo $row_discussion['id_dis'];?>" />
					<input type="hidden" name="lnk_dis_commentaire<?php echo $row_discussion['id_dis'];?>" value="<?php echo $row_discussion['id_dis'];?>" />
				</form>
				<button type="button" onclick="$('#com<?php echo $row_discussion['id_dis'];?>').hide();" class="btn btn-primary">Annuler</button>
				<button type="button" onclick="verifyCommentForm('commentaire<?php echo $row_discussion['id_dis'];?>');" class="btn btn-primary">Envoyer</button>
			</div>
			<?php
			// lecture des commentaires 2nd niveau
			$query_discussion2 = "SELECT * FROM tbldiscussions WHERE lnk_suj = ".$_GET['sujet_id']." AND lnk_ong = ".$_GET['onglet']." AND lnk_dis = ".$row_discussion['id_dis']." ORDER BY dis_datetime " ;
			$result_discussion2 = $conn->query($query_discussion2);
			while($row_discussion2 = $result_discussion2->fetch()){
				?>
				<div class="col discussion indent1" id="div_commentaire<?php echo $row_discussion2['id_dis'];?>">
				<span class="badge badge-pill badge-primary"><?php echo $row_discussion2['dis_auteur'];?></span> <small><?php echo datetimefr($row_discussion2['dis_datetime']);?></small>
					<p>- <?php echo $row_discussion2['dis_texte'];?></p>
					<span><a href="#div_commentaire<?php echo $row_discussion2['id_dis'];?>" onclick="$('#com<?php echo $row_discussion2['id_dis'];?>').show();">Répondre</a></span>
				</div>
				<div class="col" id="com<?php echo $row_discussion2['id_dis'];?>" style="display:none;">
					<form action="#" id="form_commentaire<?php echo $row_discussion2['id_dis'];?>" method="POST">
						<div class="form-group">
						  <label for="comment">Nom :</label>
						  <input type="text" name="nom_commentaire<?php echo $row_discussion2['id_dis'];?>" class="form-control" id="nom_commentaire<?php echo $row_discussion2['id_dis'];?>" aria-describedby="nom" placeholder="Entrez votre nom">
						</div> 
						<div class="form-group">
						  <label for="comment">Commenter :</label>
						  <textarea class="form-control" rows="5" id="commentaire<?php echo $row_discussion2['id_dis'];?>" name="commentaire<?php echo $row_discussion2['id_dis'];?>"></textarea>
						</div> 
						<input type="hidden" name="envoi" value="commentaire<?php echo $row_discussion2['id_dis'];?>" />
						<input type="hidden" name="lnk_dis_commentaire<?php echo $row_discussion2['id_dis'];?>" value="<?php echo $row_discussion2['id_dis'];?>" />
					</form>
					<button type="button" onclick="$('#com<?php echo $row_discussion2['id_dis'];?>').hide();" class="btn btn-primary">Annuler</button>
					<button type="button" onclick="verifyCommentForm('commentaire<?php echo $row_discussion2['id_dis'];?>');" class="btn btn-primary">Envoyer</button>
				</div>
				<?php
				// lecture des commentaires 2nd niveau
				$query_discussion3 = "SELECT * FROM tbldiscussions WHERE lnk_suj = ".$_GET['sujet_id']." AND lnk_ong = ".$_GET['onglet']." AND lnk_dis = ".$row_discussion2['id_dis']." ORDER BY dis_datetime " ;
				$result_discussion3 = $conn->query($query_discussion3);
				while($row_discussion3 = $result_discussion3->fetch()){
					?>
					<div class="col discussion indent2">
					<span class="badge badge-pill badge-primary"><?php echo $row_discussion3['dis_auteur'];?></span> <small><?php echo datetimefr($row_discussion3['dis_datetime']);?></small>
						<p>- <?php echo $row_discussion3['dis_texte'];?></p>
					</div>
					<?php
				}
			}
		}
		?>
		<br />
		<div class="col">
			<form action="#" id="form_commentaire" method="POST">
				<div class="form-group">
				  <label for="comment">Nom :</label>
				  <input type="text" name="nom_commentaire" class="form-control" id="nom_commentaire" aria-describedby="nom" placeholder="Entrez votre nom">
				</div> 
				<div class="form-group">
				  <label for="comment">Commenter :</label>
				  <textarea class="form-control" rows="5" id="commentaire" name="commentaire"></textarea>
				</div> 
				<input type="hidden" name="envoi" value="commentaire" />
				<input type="hidden" name="lnk_dis_commentaire" value="0" />
			</form>
			<button type="button" onclick="verifyCommentForm('commentaire');" class="btn btn-primary">Envoyer</button>
		</div>
		<br />
	</div>
	</div>
	</body>
</html>