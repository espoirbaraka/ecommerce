<?php
	include 'includes/session.php';

	if(isset($_GET['pay'])){
		$payid = $_GET['pay'];
		$date = date('Y-m-d');

		$conn = $pdo->open();

		try{
			
			$stmt = $conn->prepare("INSERT INTO sales (user_id, pay_id, sales_date) VALUES (:user_id, :pay_id, :sales_date)");
			$stmt->execute(['user_id'=>$user['id'], 'pay_id'=>$payid, 'sales_date'=>$date]);
			$salesid = $conn->lastInsertId();
			
			try{
				$stmt = $conn->prepare("SELECT * FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user_id");
				$stmt->execute(['user_id'=>$user['id']]);

				foreach($stmt as $row){
					$stmt = $conn->prepare("INSERT INTO details (sales_id, product_id, quantity) VALUES (:sales_id, :product_id, :quantity)");
					$stmt->execute(['sales_id'=>$salesid, 'product_id'=>$row['product_id'], 'quantity'=>$row['quantity']]);
				}

				// $title = 'Une transaction a été effectué';
				// $body = $user['firstname'] . ' ' . $user['lastname'] . ' vient de passer une commande sur le site.';
				// $headers = "From: gkompanyi@gmail.com";



				$dest = "gkompanyi@gmail.com";
				$sujet = "gTEST";
				$corps = "SUJET";
				$headers = "From: esbarakabigega@gmail.com";


				// if(mail($dest, $sujet, $corps, $headers))
				// {
					$stmt = $conn->prepare("DELETE FROM cart WHERE user_id=:user_id");
					$stmt->execute(['user_id'=>$user['id']]);

					$_SESSION['success'] = 'Transaction effectuée. Merci.';
				// }
				// else
				// {

				// 	$_SESSION['success'] = 'Mail non envoye.';
				// }



				// mail($user['email'], $title, $body, $headers);

				// $title = 'Merci pour la transaction';
				// $body = $user['firstname'] . ' ' . $user['lastname'] . ', nous sommes heureux pour votre commande sur notre site.';
				
				// mail('gkompanyi@gmail.com', $title, $body, $headers);

				// $stmt = $conn->prepare("DELETE FROM cart WHERE user_id=:user_id");
				// $stmt->execute(['user_id'=>$user['id']]);

				// $_SESSION['success'] = 'Transaction effectuée. Merci.';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	
	header('location: profile.php');
	
?>
