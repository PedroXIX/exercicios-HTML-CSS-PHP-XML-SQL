<!DOCTYPE html>
<html lang="pt BR">
	<head>
		<meta charset="UTF-8">
		<meta name ="autor" content = "Pedro Henrique Ribeiro da Silva">

		<style>
			div.solid {border-style: solid;}
			body {margin: auto;
				padding: 10px;
				font-family:'Arial';
				font-size: 14px;	
			}
			.linha{
				width: 100%;
				padding-top:1%;
				padding-bottom:1%;
			}

			.coluna2{
				width: 25%;
				height:4%;	
				float: left;
			}
		</style>
	</head>
	<body>

	<div class="solid" style="padding: 10px;">
		<h3 style="text-align: center;">League of Legends</h3>
	
		<div>
		<label>Nome do Campeão:</label>
		</div>
		<form method="post">
		
    		<div >
				<input type="text" id="nome" name="nome" size="70" maxlength="300"/>
			</div></br>
			<div class="linha">
				<div class="coluna2">
					<input type = "submit"  value = "EXIBIR">
				</div>
				<div class="coluna2">
					<button type = "reset">LIMPAR</button>
				</div>
			</div>
		</form>
	</div>
	</br>
	
	<?php
	//Conexão com base de dados MySQL
	$host = "localhost";
	$user = "root";
	$pwd = "root";
	$banco = "banco";
	$charset = "utf8";
    
	//Criando a linha de conexão
	$conexao = @mysqli_connect($host, $user, $pwd, $banco) or die ("Problemas com a conexão do banco de dados");
	@mysqli_set_charset($conexao,$charset) or die (@mysqli_error($conexao));
	
	$retorno = mysqli_query($conexao, "select * from tabelol");

	if(count($_POST)){
			//recuperar o código da pessoa enviada pelo formulario
			$valor= ucfirst(strtolower($_POST['nome']));
			$retorno = mysqli_query($conexao,"select * from tabelol where nome LIKE '%".$valor."%' or id like '%".$valor."%' order by id");
	}
			
	if(!$retorno){
		die ('Query Inválida: '.@mysqli_error($conexao)); //Mostra error_get_last
	}
		
	while($dados= mysqli_fetch_array($retorno))
	{
		//Recupera as informações do array $dados
		echo "<p style='width: 13em; background: gold; word-break: normal |break-word;'><b> Id: </b>".$dados['id']."<br>";
		echo "<b> Nome: </b>".$dados['nome']."<br>";
		echo "<b> Função: </b>".$dados['funcao']."<br>";
		echo "<b> Dificuldade: </b>".$dados['dificuldade']."<br>";
		echo "<b> Descrição: </b>".$dados['descricao']."<br>";
		echo "<b> Habilidade Especial: </b>".$dados['habilidadeEs']."<br>";
		echo "<b> Imagem: </b> <p style='text-align: center'> <img src='".$dados['imagem']."'> </p><br>";
		echo "</p><br>";
	}
	?>
	</body>
</html>