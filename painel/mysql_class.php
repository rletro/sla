<?php
class conexao {
    // Coloque aqui as Informa��es do Banco de Dados
    var $host = "localhost";
    var $user = "root"; # Usu�rio no Host/Servidor
    var $senha = "qwqw2401"; # Senha no Host/Servidor
    var $dbase = "sla"; # Nome do seu Banco de Dados

    // Cria as vari�veis que Utilizaremos
    var $query;
    var $link;
    var $resultado;
    
    function MySQL(){
		// Instancia o Objeto para usarmos
    }
	
	// Cria a fun��o para Conectar ao Banco MySQL
    function conecta(){
        $this->link = @mysql_connect($this->host,$this->user,$this->senha);
		// Conecta ao Banco de Dados
        if(!$this->link){
			// Caso ocorra um erro, exibe uma mensagem com o erro
            print "Ocorreu um Erro na conex�o MySQL:";
			print "<b>".mysql_error()."</b>";
			die();
        }elseif(!mysql_select_db($this->dbase,$this->link)){
			// Seleciona o banco ap�s a conex�o
			// Caso ocorra um erro, exibe uma mensagem com o erro
            print "Ocorreu um Erro em selecionar o Banco:";
			print "<b>".mysql_error()."</b>";
			die();
        }
    }


	// Cria a fun��o para query no Banco de Dados
    function sql_query($query,$id = FALSE){
    	$ret = array("RET" => TRUE, "RESP" => "");
        $this->conecta();
        $this->query = $query;
		// Conecta e faz a query no MySQL
        if($this->resultado = mysql_query($this->query)){
            
            //return $this->resultado;
            //mysql_query( "SELECT LAST_INSERT_ID()" );
            $ret["RESP"] = $this->resultado;
            if($id){
            	$ret["ID"] = mysql_insert_id();	
            }
			         
			$this->desconecta();
			return $ret;
			
        }else{
			$ret["RET"] = FALSE;
			$ret["RESP"] = "Ocorreu um erro ao executar a Query MySQL: <b>$query</b>";
			$ret["RESP"] .= "Erro no MySQL: <b>".mysql_error()."</b>";
			die();
            $this->desconecta();
        }        
    }

    function Select($tabela,$campos = null,$filtro = null){
        $this->conecta();
        $sql = "Select";
        $return = array();
		$ret = array("RET" => TRUE, "RESP" => "");
        if($campos)
            $sql .= " ".$campos;  
        else
            $sql .= " * ";

        $sql .= " from ".$tabela." ";
        $sql .= $filtro;
		
        $result = $this->sql_query($sql);
		if($result["RET"]){
			while($row = mysql_fetch_object($result["RESP"])){
	        	
	          
	            array_push($return, $row);
	        }
			$ret["RESP"] = $return;
			
		}else{
			$ret["RET"] = FALSE;
			$ret["RESP"] = "Problema na seleção da tabela.";
		}
        return $ret;
    }
	
	

	// Cria a fun��o para Desconectar ao Banco MySQL
    function desconecta(){
        return mysql_close($this->link);
    }
	
	
}
?>