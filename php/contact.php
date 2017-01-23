<?php
	$elementsDuTraitement = array("firstname" =>  "", "lastname" => "", "email" => "", "phone" => "", "msg" => "", "firstnameError" => "", "lastnameError" => "", "emailError" => "", "phoneError" => "",  "msgError" => "", "isSuccess" => false);

	$emailTo = "esimard@uqac.ca";


	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$elementsDuTraitement["firstname"] = verifyInput( $_POST["firstname"] );
		$elementsDuTraitement["lastname"] = verifyInput( $_POST["lastname"] );
		$elementsDuTraitement["email"] = verifyInput( $_POST["email"] );
		$elementsDuTraitement["phone"] = verifyInput( $_POST["phone"] );
		$elementsDuTraitement["msg"] = verifyInput( $_POST["msg"] );
		$elementsDuTraitement["isSuccess"] = true;
		$emailText = "";


		if(empty($elementsDuTraitement["firstname"])) {
			$elementsDuTraitement["firstnameError"] = "Je veux connaître ton prénom";
			$elementsDuTraitement["isSuccess"] = false;
		}
		else {
			$emailText .= "Prénom : " . $elementsDuTraitement["firstname"] . "\n";
		}

		if(empty($elementsDuTraitement["lastname"])) {
			$elementsDuTraitement["lastnameError"] = "Tu n'as donc pas de nom de famille ?";
			$elementsDuTraitement["isSuccess"] = false;
		}
		else {
			$emailText .= "Nom de famille : " . $elementsDuTraitement["lastname"] . "\n";
		}

		if(empty($elementsDuTraitement["email"])) {
			$elementsDuTraitement["emailError"] = "Je t'avais demandé ton courriel...";
			$elementsDuTraitement["isSuccess"] = false;
		}
		else
		{
			if(!isEmail($elementsDuTraitement["email"])) {
				$elementsDuTraitement["emailError"] = "Qu'est-ce que ce que tu me fais là ? C'est pas un courriel ça !";
				$elementsDuTraitement["isSuccess"] = false;
			}
			else {
				$emailText .= "Courriel : " . $elementsDuTraitement["email"] . "\n";
			}
		}

		if(!empty($elementsDuTraitement["phone"])) {
			if( !isPhone( $elementsDuTraitement["phone"] ) ) {
				$elementsDuTraitement["phoneError"] = "Que des chiffres et des espaces svp...";
				$elementsDuTraitement["isSuccess"] = false;
			}
			else {
				$emailText .= "Numéro de téléphone : " . $elementsDuTraitement["phone"] . "\n";
			}
		}


		if(empty($elementsDuTraitement["msg"])) {
			$elementsDuTraitement["msgError"] = "Quoi! Tu n'as rien à me dire ?";
			$elementsDuTraitement["isSuccess"] = false;
		}
		else {
			$emailText .= "Message : ". $elementsDuTraitement["msg"] . "\n";
		}


		if($elementsDuTraitement["isSuccess"]){
			$headers = "From: {$elementsDuTraitement["firstname"]} {$elementsDuTraitement["lastname"]} <{$elementsDuTraitement["email"]}>\r\nReply-To: {$elementsDuTraitement["email"]}";
			mail($emailTo, "Un message de mon CV", $emailText, $headers);
		}
		echo json_encode($elementsDuTraitement);
	}


	function verifyInput($inputToCheck) {
		$inputToCheck = trim($inputToCheck);
		$inputToCheck = stripslashes($inputToCheck);
		$inputToCheck = htmlspecialchars($inputToCheck);

		return $inputToCheck;
	}


	function isEmail($emailToCheck) {
		return filter_var($emailToCheck, FILTER_VALIDATE_EMAIL);
	}

	function isPhone($phoneToCheck) {
		return preg_match("/^[0-9 ]*$/", $phoneToCheck);
	}
?>
