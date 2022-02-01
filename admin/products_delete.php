<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("DELETE FROM products WHERE id=:id");
			$stmt->execute(['id'=>$id]);

			$_SESSION['success'] = 'Produit supprimé avec succès';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Selectionnez le produit à supprimer avant tout';
	}

	header('location: products.php');
	
?>
