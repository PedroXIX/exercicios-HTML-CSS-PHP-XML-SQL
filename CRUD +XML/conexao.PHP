<?php
//crfiação de variáveis de banco de dados
	$servidor="localhost";
	$usuario="root";
	$senha = "root";
	$banco="bdpamii";

	try{
		//conexão com o banco de dados
		$conexao = mysqli_connect($servidor,$usuario,$senha,$banco);

		// validar se a conexao foi efetuada
		if($conexao){
		mysqli_select_db($conexao,$banco);
		echo "Banco de dados conectado";
		}
		else{
		echo "Problema na conexão do Banco de Dados(".$banco.")";
		}
	}
	catch(Exception $erro){
		echo "Erro ==>".$erro->getMessage();
		exit;
	}
	
?>