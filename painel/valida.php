<?php

	function validaExt($arquivo,$ext){
		$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
		
		return in_array($extensao, $ext);
		
	}
	
	
	function validaTamImgIgual($imagem,$largura,$altura){
		$tam_img = getimagesize($imagem);
		return ($tam_img[0] == $largura || $tam_img[1] == $altura);
	}

	function Vazio($str){
		return $str == null;
	}
	
	function ValidaData($dat){
		$data = explode("/","$dat"); // fatia a string $dat em pedados, usando / como referência
		$d = $data[0];
		$m = $data[1];
		$y = $data[2];
		
		return checkdate($m,$d,$y);
	}


?>