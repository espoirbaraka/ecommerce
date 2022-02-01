
<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$name = $_POST['name'];

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM category WHERE name=:name");
		$stmt->execute(['name'=>$name]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Cette catégorie existe déjà';
		}
		else{
			try{
				$stmt = $conn->prepare("INSERT INTO category (name, cat_slug) VALUES (:name, :slug)");
				$slug = str_replace(' ', '-', strtolower($name));
				$stmt->execute(['name'=>$name, 'slug'=>$slug]);
				$_SESSION['success'] = 'Catégorie ajoutée avec succès';
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Veuillez compléter prémièrement le formulaire de la catégorie.';
	}

	header('location: category.php');

?>
