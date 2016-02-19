<?php
	 
echo time()."<br><br>";

$conexao = mysql_connect('HOST', 'USER_DB', 'PASSWORD'); 
if (!$conexao) { 
    die('Could not connect: ' . mysql_error()); 
}
//mysql_set_charset('UTF8', $conexao);
mysql_select_db(clientes_db); 

$result = mysql_query("SELECT * FROM clientes WHERE (Status > 0) ORDER BY Name ASC"); //  //LIMIT 0 , 6  NOT LIKE (-1)

$find = array ( "[nome]",
				"[middle]",
				"[last]",
				"[genero]",
				"[tel1]",
				"[tel2]",
				"[nascimento]",
				"[email]",
				"[detalhes]");

echo "
	<html>
	<head>
	
	<title>Mailer Sender</title>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	</head>
	<body>";

	$headers  = 'From: NOME - Facilitador <EMAIL>' . "\r\n";
	$headers .= 'Reply-To: EMAIL' . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	

	echo "Total: " . mysql_num_rows($result) . "<br><br>";

while ($cliente = mysql_fetch_array($result, MYSQL_BOTH)) {
	//$time = time();
	$i++;
	$replace = array ($cliente["Name"],
					  $cliente["Middle"],
					  $cliente["Last"],
					  $cliente["Genero"],
					  $cliente["Tel1"],
					  $cliente["Tel2"],
					  $cliente["Nascimento"],
					  $cliente["Email"],
					  $cliente["Detalhes"]);

	$subject  = "[Autossuficiência] - Emissão do Certificado."; // - 2º Aviso

	switch ($cliente["ID"]){
		case 32:
			$extra = "
			<br>
			MSG EXTRA<br>
			<br>
			";
		break;
		default: $extra = "";
	}
	
	$assinatura = "
	Obrigado,<br>
	<br>
	NOME<br>
	";

	$msg = "
Boa tarde [nome],<br>
MSG<br>
<br>

$assinatura
	";

	$msg1 = "
	Bom dia [nome],<br>
	<br>
	Encaminhei os dados do questionário e agora estou no aguardo do recebimento dos certificados.<br>
	<br>
	Conversando com outros facilitadores, não iremos mais ter a cerimônia de formatura. Portanto a data do dia 05 de Dezembro foi cancelada.<br>
	<br>
	Assim que eu estiver com os certificados em mãos, estarei marcando um novo dia e horário para que eu possa fazer a entrega do certificado.<br>
	<br>

	$assinatura
	";
	
	$msg2 = "

	<br>
	$assinatura
	";


	$message = str_replace($find, $replace, $msg1);

//$send = 1;

if (isset($send) and ($cliente["Email"] <> "-")){
		mail($cliente["Email"], $subject, $message, $headers);
		echo "Email Sent";
	}
	$full_name = mb_strtoupper($cliente["Name"]." ".$cliente["Middle"]." ".$cliente["Last"], 'UTF-8');
	echo "
		<fieldset>
			<legend>
				<b> $cliente[ID]: $full_name  | $cliente[Status]</b>
			</legend>
			$subject <br><br>
			$message
		</fieldset><br>
	";
	//usleep(1000000);
	$status = "";
}

echo "
	</body>
	</html>";
mysql_free_result($result);
mysql_close($conexao);
?>