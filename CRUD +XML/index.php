<?php
//Carregar a conexão com o servidor de Banco de Dados
	require_once("./conexao.php");
	
$codigo = "";
$nome = "";
$email = "";
$fone = "";
$usuario = "";

if($_POST){
	$acao="";
	if(isset($_REQUEST["acao"])){
		$acao=$_REQUEST["acao"];
	}
	
	if($acao =="incluir"){
		//Recuperar todos os dados enviados pelo método POST
		$nome= $_REQUEST["pesnome"];
		$email= $_REQUEST["pesemail"];
		$telefone= $_REQUEST["pestelefone"];
		$usrnome= $_REQUEST["usrnome"];
		$senha= $_REQUEST["usrsenha"];
		
		//Inserir os dados que o usuário enviou para o banco de dados
		$sqlstring = "insert into tblpessoa (pesid,pesnome,pesemail,pestelefone) values (NULL,";
		$sqlstring .="'".$nome."','".$email."'".",".$telefone.")";
			
		//executar instrução no banco de dados
		$retorno = mysqli_query($conexao,$sqlstring);
		
		//verificar se a instrução foi executada com sucesso
		if(mysqli_affected_rows($conexao)>0){ 
			//consutar os dados da pessoa
			$sqlstring ="select * from tblpessoa where pesnome='".$_REQUEST["pesnome"]."'";
			$sqlstring .= "and pesemail= '".$_REQUEST["pesemail"]."'";
			$sqlstring .= "and pestelefone= '".$_REQUEST["pestelefone"]."'";
							
			//executar a instrução no banco
			$retorno = mysqli_query($conexao,$sqlstring);
			
			//verificar se a instrução foi executada com sucesso
			if(mysqli_affected_rows($conexao)>0){
				//desbloquear o registro encontrado pelo select

				$dados = mysqli_fetch_array($retorno);
				
				//recuperar id da pessoa
				$idpessoa =$dados["pesid"];
				
				//instrução para incluir os dados do usuario da pessoa
				$sqlstring ="insert into tblusuario (pesid,usrnome,usrsenha,usrperfil) values (";
				$sqlstring .= $idpessoa.",'".$_REQUEST["usrnome"]."','".base64_encode(sha1(md5($_REQUEST["usrsenha"])))."',";
				$sqlstring .= "'".$_REQUEST["perfil"]."')";
				//executar a instrução no banco
				$retorno = mysqli_query($conexao,$sqlstring);
				
				if(mysqli_affected_rows($conexao)>0) {
					echo "<script>alert('Cadastro efetuado com sucesso!');</script>";
				}
				else{
					echo "<script>alert('Problema no cadastro da pessoaa!');</script>";
			    }	
			}
		}

	}
	else if($acao =="consultar"){
		//recuperar o código da pessoa enviada pelo formulario
		$codigo= $_REQUEST["id"];
		$sqlstring = "select*from tblpessoa inner join tblusuario on tblpessoa.pesid = tblusuario.pesid where tblpessoa.pesid= ".$codigo;
		$retorno = mysqli_query($conexao,$sqlstring);
		if(mysqli_affected_rows($conexao)>0){
			$dados= mysqli_fetch_array($retorno);
			
			$nome = $dados["pesnome"];
			$email = $dados["pesemail"];
			$fone = $dados["pestelefone"];
			$usuario= $dados["usrnome"];
			$usrperfil = $dados["usrperfil"];
		}
		else{
			echo "<script>alert('Pessoa não encontrada!');</script>";
		}
	}
	else if($acao == "alterar") {
		//recuperar o codigo da pessoa
		$codigo = $_REQUEST["id"];
	
		$sqlstring ="select * from tblpessoa inner join tblusuario on tblpessoa.pesid = tblusuario.pesid where tblpessoa.pesid =".$codigo;
		$retorno = mysqli_query($conexao,$sqlstring);
		if(mysqli_affected_rows($conexao) > 0) {
			//Instrução para alterar os dados da pessoa na tabela 
			$sqlstring = "update tblpessoa set ";
			$sqlstring.= "pesnome ='".$_REQUEST["pesnome"]."',";
			$sqlstring.= "pesemail ='".$_REQUEST["pesemail"]."',";
			$sqlstring.= "pestelefone ='".$_REQUEST["pestelefone"]."' ";
			$sqlstring.= "where pesid =".$codigo;
			
	
			$retorno = mysqli_query($conexao,$sqlstring);
			if(mysqli_affected_rows($conexao) >= 0) {
				//Alterar a senha da pessoa se o campo senha estiver preenchido
				$sqlstring = "update  tblusuario set ";
				$sqlstring.= "usrperfil ='".$_REQUEST["usrperfil"]."',";
				$sqlstring.= "usrsenha ='".base64_encode(sha1(md5($_REQUEST["usrsenha"])))."' ";
				$sqlstring.= "where pesid =".$codigo;
			
				$retorno = mysqli_query($conexao,$sqlstring);
				if(mysqli_affected_rows($conexao) >= 0) {
					echo "<script>alert('Pessoa alterada com sucesso!!');</script>";
				}	
				else{
					echo "<script>alert('Problema na alteração dos dados do usuario da pessoa!!');</script>";
				}
			}
			else{
				echo "<script>alert('Problema na alteração dos dados da pessoa!!');</script>";
			}
		}
		else{
			echo "<script>alert('Pesoa não encontrada!!');</script>";
		}
	}
	else if($acao =="excluir"){
	//recuperar o código da pessoa enviada pelo formulario
	$codigo= $_REQUEST["id"];
	$sqlstring = "select*from tblpessoa inner join tblusuario on tblpessoa.pesid = tblusuario.pesid where tblpessoa.pesid= ".$codigo;
	$retorno = mysqli_query($conexao,$sqlstring);
	if(mysqli_affected_rows($conexao)>0){
		$sqlstring="delete from tblusuario where pesid=".$codigo;

		$retorno = mysqli_query($conexao,$sqlstring);
		if(mysqli_affected_rows($conexao)>=0){
			$sqlstring="delete from tblpessoa where pesid=".$codigo;
	
		$retorno = mysqli_query($conexao,$sqlstring);
		if(mysqli_affected_rows($conexao)>=0){
		echo"<scrip>alert('Pessoa eliminida com sucesso!');</script>";
		}
		else{
		echo "<script>alert('Problema na exclusão dos dados da pessoa!');</script>";
		}
	}
	else{
	echo "<script>alert('Problema na exclusão do usuário da pessoa!');</script>";
	}
}
else{
	echo "<scrip>alert('Pessoa não encontrada!');</script>";
}
}
	else if($acao=="exportarxml"){
		

		//variável arquivo armazena o nome e extensão do arquivo 
		$arquivo = "exportacao.xml";
		//verificar se o arquivo a ser importado existe dentro do local indicado
		if(file_exists($arquivo)){
			//eliminando arquivo existente
			unlink($arquivo);
		}

		//Variável $fp armazena a conexao com o arquivo e o tipo de ação
		$fp = fopen($arquivo, "a");
		$texto = "<?xml version= 1.0 encoding=UTF-8 standalone=yes?>";
		$texto .= "<bdpamii>";
		fwrite($fp,$texto); 

		//selecionar os registros do banco de dados
		$sqlstring = "select * from tblpessoa inner join tblusuario on tblpessoa.pesid = tblusuario.pesid";
		$retorno = mysqli_query($conexao,$sqlstring);
		if(mysqli_affected_rows($conexao)>0){
			$conteudo="";
			while ($dados= mysqli_fetch_array($retorno)){

			//Variável que armazena o conteúdo do arquivo
				$conteudo .= "<bdpamii>";
				$conteudo .= "<tblpessoa>";
				$conteudo .="<pesid>".$dados["pesid"]."</pesid>";
				$conteudo .="<pesnome>".$dados["pesnome"]."</pesnome>";
				$conteudo .="<pesemail>".$dados["pesemail"]."</pesemail>";
				$conteudo .="<pestelefone>".$dados["pestelefone"]."</pestelefone>";
				$conteudo .="</tblpessoa>";
				$conteudo .="<tblusuario>";
				$conteudo .="<pesid>".$dados["pesid"]."</pesid>";
				$conteudo .="<usrnome>".$dados["usrnome"]."</usrnome>";
				$conteudo .= "<usrsenha>".$dados["usrsenha"]."</usrsenha>";
				$conteudo .="<usrperfil>".$dados["usrperfil"]."</usrperfil>";
				$conteudo .="</tblusuario>";
				$conteudo .= "\n</bdpamii>";

				//Escreve no arquivo aberto
				fwrite($fp,$conteudo); 
			}			
		}
		//fecha o xml
			$texto ="\n\n</array>";
			fwrite($fp,$texto);
			//Fecha arquivo.
			fclose($fp);
			echo "<script>alert('Exportação XML efetuada com sucesso!');</script>";
			//echo "<script>window.location='.index.php?acao=';</script>";
	}
			
	else if($acao=="carregarxml"){
		//verificar se o arquivo armazena o nome e extensão do arquivo
		$arquivo = "exportacao.xml";

		if(file_exists($arquivo)){
		//Variável $fp armazena a conexao com o arquivo e o tipo de ação
		$fp = fopen($arquivo, "r");
		//Lê o conteúdo do arquivo aberto.
		$valor = "";
		while (!feof($fp)){
			$valor .= fgets($fp,4096)."<br/>";
		}
		echo $valor;		
		
		//Fecha arquivo.
		fclose($fp);
		echo "<script>alert('Importação XML efetuada com sucesso!');</script>";
	}
	else{
		echo "<script>alert('O arquivo ".$arquivo." não exise no servidor');</script>";
	}
  }
  
  	else if($acao=="consultaxml"){
		
		
		$xml = simplexml_load_file("exportacao.xml") -> bdpamii;
		
		foreach($xml -> tblpessoa as $tblpessoa){
			echo "<strong>Nome:</strong> ".utf8_decode($tblpessoa -> pesnome)."<br />";
			//echo "<strong>Texto:</strong> ".utf8_decode($tblpessoa -> texto)."<br />";
			echo "<br/>";
		}

  }
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Cadastro de Pessoas </title>
		<link rel="stylesheet" type="text/css" href="./pagcss.css">
		<script>
			function fnValidarDados(acao){
				if(document.getElementById("pesnome").value==''){
					alert('Campo Nome obrigatório!');
					document.getElementById("pesnome").focus();
				}
				else if(document.getElementById("pestelefone").value==''){
					alert('Campo Telefone obrigatório!');
					document.getElementById("pestelefone").focus();
				}
				else if(document.getElementById("pesemail").value==''){
					alert('Campo E-Mail obrigatório!');
					document.getElementById("pesemail").focus();
				}			
				else if(document.getElementById("usrnome").value==''){
					alert('Campo Usuário obrigatório!');
					document.getElementById("usrnome").focus();
				}
				else if(document.getElementById("usrsenha").value==''){
					alert('Campo Senha obrigatório!');
					document.getElementById("usrsenha").focus();
				}
				else if(document.getElementById("perfil").options[document.getElementById("perfil").selectedIndex].value==''){
					alert('Campo Perfil obrigatório!');
					document.getElementById("perfil").focus();
				}
				else{
					if(acao == 'alterar'){
						if(document.getElementById("pesid").value==''){
							alert('Campo Código obrigatório!');
							document.getElementById("pesid").focus();
						}	
						else {
							document.frmPrincipal.action = './index.php?acao=' + acao + '&id=' + document.getElementById("pesid").value;
							document.frmPrincipal.submit();
						}
					}
					else{
						document.frmPrincipal.action = './index.php?acao=' + acao;
						document.frmPrincipal.submit();
					} 
				}
				
			return false;
			}
			
			function fnLimparDados(){
				document.frmPrincipal.action='./index.php';
				document.frmPrincipal.submit();
				
				return false;
			}
			
			function fnValidarDadosConsulta(acao,codigo){	
			if(document.getElementById("pesid").value==''){
					alert('Campo Código obrigatório!');
					document.getElementById("pesid").focus();
				}
				else{
					document.frmPrincipal.action='./index.php?acao='+acao+'&id='+codigo;
					document.frmPrincipal.submit();
				}
				
			return false;
			}

			function fnValidarDadosExcluir(codigo){	
			if(codigo==''){
					alert('Campo Código obrigatório!');
					document.getElementById("pesid").focus();
				}

				else{
					if(confirm("Deseja excluir a pessoa selecionada?")){
					document.frmPrincipal.action='./index.php?acao='+acao+'&id='+codigo;
					document.frmPrincipal.submit();
				}
			}
				return false;
			}

			function fnExportarXML(){
				document.frmPrincipal.action='./index.php?acao=exportarxml';
				document.frmPrincipal.submit();
			}
			
			function fnCarregarXML(){
				document.frmPrincipal.action='./index.php?acao=carregarxml';
				document.frmPrincipal.submit();
			}
			
			function fnConsultaXML(){
				document.frmPrincipal.action='./index.php?acao=consultaxml';
				document.frmPrincipal.submit();
			}
		</script>
	</head>
	<body>
		<form name="frmPrincipal" method="post" action="">
			<div class="linha">
				<div class="coluna-12 titulo">
					Cadastro de Pessoas
				</div>
			</div>
			<div class="linha">
				<div class="coluna-6">
					<label>Código</label>
				</div>
				<div class="coluna-6">
					<label>Nome:</label>
				</div>
			</div>
			<div class="linha">
				<div class="coluna-6">
					<input type ="text" id="pesid" name="pesid" size="11" maxlength= "11" value="<?php echo $codigo; ?>">
				</div>
				<div class="coluna-6">
					<input type="text" id="pesnome" name="pesnome" size="50" maxlength="50" value="<?php echo $nome; ?>">
				</div>
			</div>
			
			<div class="linha">
				<div class="coluna-6">
					<label>Telefone</label>
				</div>
				<div class="coluna-6">
					<label>Email:</label>
				</div>
			</div>
			<div class="linha">
				<div class="coluna-6">
					<input type ="number" id="pestelefone" name="pestelefone" min="0" step= "1" maxlength= "15" value="<?php echo $fone; ?>">
				</div>
				<div class="coluna-6">
					<input type="text" id="pesemail" name="pesemail" size="70" maxlength="300" value="<?php echo $email; ?>">
				</div>				
			</div>
			<div class="linha">
				<div class="coluna-4">
					<label>Usuário:</label>
				</div>
				<div class="coluna-4">
					<label>Senha:</label>
				</div>
				<div class="coluna-4">
					<label>Perfil:</label>
				</div>				
			</div>
			<div class="linha">
				<div class="coluna-4">
					<input type ="text" id="usrnome" name="usrnome" size="10" maxlength= "10" value="<?php echo $usuario; ?>">
				</div>
				<div class="coluna-4">
					<input type="password" id="usrsenha" name="usrsenha" value="">
				</div>			
				<div class="coluna-4">
					<select id="perfil" name="perfil">
				    	<option selected value="">Selecione o perfil</option>
						<?php
							if($usrperfil =="C"){
								echo '<option selected value="C">Cliente</option>';
								echo '<option value="E">Empresa</option>';
								echo '<option value="F">Funcionário</option>';
							}
							else if($usrperfil =="E"){
								echo '<option value="C">Cliente</option>';
								echo '<option selected value="E">Empresa</option>';
								echo '<option value="F">Funcionário</option>';
							}
							else if($usrperfil =="F"){
								echo '<option value="C">Cliente</option>';
								echo '<option value="E">Empresa</option>';
								echo '<option selected value="F">Funcionário</option>';
							}
							else{
								echo '<option value="C">Cliente</option>';
								echo '<option value="E">Empresa</option>';
								echo '<option value="F">Funcionário</option>';
							}
						?>	
					</select>
				</div>			
			</div>

			<div class="linha meio padsup3">
				<div class="coluna-3">
					<button id="btnIncluir" name="btnIncluir" class="botao botao-ok negrito" onclick="fnValidarDados('incluir');">Cadastro</button>
				</div>
				<div class="coluna-3">
					<button id="btnAlterar" name="btnAlterar" class="botao botao-aviso negrito" onclick="fnValidarDados('alterar');">Alterar</button>
				</div>
				<div class="coluna-3">
					<button id="btnConsultar" name="btnConsultar" class="botao botao-info negrito" onclick="fnValidarDadosConsulta('consultar',document.getElementById('pesid').value);">Consultar</button>
				</div>
				<div class="coluna-3">
					<input type= "button" id="btnExcluir" name="btnExcluir" class="botao botao-erro negrito" onclick="fnValidarDadosExcluir(document.getElementById('pesid').value);" value="Excluir"/>
				</div>

			</div>
			<div class="linha meio padsup3">
				<div class="coluna-3">
					<button id="btnLimpar" name="btnLimpar" class="botao botao-limpar negrito" onclick="fnLimparDados();">Limpar</button>
				</div>
				<div class="coluna-3">
					<input type ="button" id="btnExportarXML" name="btnExportarXML" class="botao botao-xml negrito" onclick="fnExportarXML();" value="Exportar XML">
				</div>
				<div class="coluna-3">
					<input type ="button" id="btnCarregarXML" name="btnCarregarXML" class="botao botao-xml negrito" onclick="fnCarregarXML();" value="Carregar XML">
				</div>
				<div class="coluna-3">
					<input type ="button" id="btnConsultaXML" name="btnConsultaXML" class="botao botao-xml negrito" onclick="fnConsultaXML();" value="Consultar XML">
				</div>
			</div>
		</form>
	</body>
</html>