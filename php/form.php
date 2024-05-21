<?php

	header('Content-Type: application/json; charset=utf-8');

	$address = "elefante@elefante.me"; //Put your own email address here

	$name = ( isset($_POST["name"]) ) ? trim( $_POST["name"] ) : '' ;
	$email = ( isset($_POST["email"]) ) ? trim( $_POST["email"] ) : '' ;
	$message = ( isset($_POST["message"]) ) ? trim( $_POST["message"] ) : '' ;
	$subject = ( isset($_POST["subject"]) ) ? trim( $_POST["subject"] ) : '' ;
	$errors = array();


	if(strlen($name) < 2) {
		if(!$name) {
			$errors[] = "Você deve preencher o nome.";
		} else {
			$errors[] = "O nome deve ter ao menos 2 caracteres!";
		}
	}

	if(empty($email)) {
		$errors[] = "Você deve preencher o e-mail.";
	}

	if(!validEmail($email)) {
		$errors[] = "Você deve preencher com um e-mail válido.";
	}


	if(strlen($message) < 10) {
		if(!$message) {
			$errors[] = "Você deve escrever uma mensagem.";
		} else {
			$errors[] = "A mensagem deve ter ao menos 10 caracteres!";
		}
	}

	if($errors) {
		die( json_encode(array("errors" => $errors)) );
	}

	if(function_exists('stripslashes')) {
		$message = stripslashes($message);
	}


	if (empty($subject)) {
		$subject = 'Você foi contatado por ' . $name . '.';
	}
	

	$headers = "From: $email \r\n";
	$headers .= "Reply-To: $email \r\n";
	$headers .= "MIME-Version: 1.0 \r\n";
	$headers .= "Content-type: text/plain; charset=utf-8 \r\n";
	$headers .= "Content-Transfer-Encoding: quoted-printable \r\n";

	if(mail($address, $subject, $message, $headers)) {

		die( json_encode(array("success" => "E-mail enviado com sucesso :)")) );

	} else {

		die( json_encode(array("errors" => $errors)) );

	}



function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}

?>