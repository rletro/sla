<?php
	include 'valida.php';
	include 'config.php';
	include 'funcoes.php';
	include 'mysql_class.php';
	$arr = array();
	$ret = array('RET' => TRUE , "RESP" => array());
	
	if($_POST["op"] == 1 || $_POST["op"] == 2){
		if(vazio($_POST['titulo'])){
			$ret["RET"] = FALSE;
			$arr["NOME"] = 'titulo';
			$arr["MOT"] = 'Campo deve ser preenchido';
			array_push($ret["RESP"],$arr);
		}
		
		if(vazio($_POST['lancamento'])){
			$ret["RET"] = FALSE;
			$arr["NOME"] = 'lancamento';
			$arr["MOT"] = 'Campo deve ser preenchido';
			array_push($ret["RESP"],$arr);
		}
		
		
		
		$ext = array("jpg", "png", "gif", "jpeg"); 
		
		if(isset($_FILES["foto"]))  
		{
			  
		   //Filter the file types , if you want.  
			if ($_FILES["foto"]["error"] > 0)  
		   	{
		   		$ret["RET"] = FALSE;  
				$arr["NOME"] = 'foto';
		    	$arr["MOT"] = "Error: " . $_FILES["file"]["error"] . "<br>";
				array_push($ret["RESP"],$arr);		  
		   	}  
		   	else  
		   	{
		   		
		  		if (validaExt($_FILES['foto']['name'],$ext)){
		  			if(!validaTamImgIgual($_FILES['foto']['tmp_name'],200,200)){
		  				//tamanho diferente
		  				$ret["RET"] = FALSE;
						$arr["NOME"] = 'foto';
						$arr["MOT"] = 'Tamanho da imagem deve ser de 200px X 200px.';
						array_push($ret["RESP"],$arr);	
		  			}
		  		}else{
		  			//extansão invalida
		  			$ret["RET"] = FALSE;
		  			$arr["NOME"] = 'foto';
					$arr["MOT"] = 'O arquivo deve ser das seguintes extensões';
					for ($i=0; $i < count($ext); $i++) {
						$arr["MOT"] .= ", ".$ext[$i];					
					}
					array_push($ret["RESP"],$arr);	
		     //move the uploaded file to uploads folder;  
		    // 	  
		    //	echo "Uploaded File :".$_FILES["myFile"]["name"];  
		   		}  
		 	}
		 }else{
		 	if($_POST["op"] == '1'){
		 		$ret["RET"] = FALSE;
				$arr["NOME"] = 'foto';
				$arr["MOT"] = 'Não há nenhuma imagem em anexo.';	
		 	}
		 	
		 }
		
		
		
		if($ret["RET"]){
			if($_POST["op"] == '1'){
				
				$conn = new conexao();
				//$conn->conecta();
				$sql = "insert into album (nome,lancamento) values ('".$_POST["titulo"]."','".datebrtobd($_POST["lancamento"])."')";
				$resultado = $conn->sql_query($sql,TRUE);
				if($resultado["RET"]){
					$id = $resultado["ID"];
					$dir_save = DIR_ALBUM."/".$id;
					mkdir($dir_save, 0700 ); 
					move_uploaded_file($_FILES["foto"]["tmp_name"],$dir_save."/".$_FILES["foto"]["name"]);
					$dir_save = PATCH_ALBUM.$id."/";
					$sql = "UPDATE album set foto='".$dir_save.$_FILES["foto"]["name"]."' where id=".$id."";
					$resultado = $conn->sql_query($sql);	
					
					$arr = array();
					$arr["ID"] = $id;	
					$arr["MOT"] = "Incuído com sucesso.";	
					array_push($ret["RESP"],$arr);	
					
				}else{
					$ret["RET"] = FALSE;
					$arr["NOME"] = 'master';
					$arr["MOT"] = 'Ocorreu um erro no envio das informações, favo entrar em contato com a Inove.';
				}
			}elseif($_POST["op"] == '2'){
				$filtro = "";
				$conn = new conexao();
				if(isset($_FILES["foto"])){
					$filtro = "where id = ".$_POST["id"];
					$resultado = $conn->select("album",null,$filtro);
					if($resultado["RET"]){
						unlink($resultado["RESP"][0]->foto);
						$dir_save = DIR_ALBUM."/".$resultado["RESP"][0]->id;
						move_uploaded_file($_FILES["foto"]["tmp_name"],$dir_save."/".$_FILES["foto"]["name"]);
						$dir_save = PATCH_ALBUM.$resultado["RESP"][0]->id."/";
						$filtro = "foto='".$dir_save.$_FILES["foto"]["name"]."'";			
								
					}else{
						$ret["RET"] = FALSE;
						$arr["NOME"] = 'master';
						$arr["MOT"] = 'Ocorreu um erro na busca das informações, favo entrar em contato com a Inove.';	
					}
				}
				$sql = "UPDATE album set 
										nome = '".$_POST["titulo"]."',
										lancamento = '".$_POST["lancamento"]."',
										".$filtro." where id=".$_POST["id"]."";
				$resultado = $conn->sql_query($sql);
			}
			
		}
	}elseif($_POST['op'] == 3){
		$conn = new conexao();
		$sql = "delete from album where id=".$_POST['id'];
		$resultado = $conn->sql_query($sql);
		if($resultado["RET"]){
			$dir_del = DIR_ALBUM."/".$_POST['id'];
			delPasta($dir_del);
			$ret["RESP"] = "Excluído com sucesso";
		}
	}else{
		$filtro = "";
		$conn = new conexao();
		if(isset($_POST['id'])){
			$filtro = "where id=".$_POST["id"];		
		}
		$resultado = $conn->select("album",null,$filtro);
		for ($i=0; $i < count($resultado["RESP"]); $i++) { 
			$resultado["RESP"][$i]->lancamento = datebdtobr($resultado["RESP"][$i]->lancamento);
		}
		$ret["RESP"] = 	$resultado["RESP"];
		
	}

	echo json_encode($ret);
?>