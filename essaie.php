<?php
				$dest = "gkompanyi@gmail.com";
				$sujet = "gTEST";
				$corps = "SUJET";
				$headers = "From: esbarakabigega@gmail.com";


				if(mail($dest, $sujet, $corps, $headers))
				{

					echo "ok";
				}
				else
				{

					echo "mail non envoye";
				}
				?>