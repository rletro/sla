<?php
	include 'mysql_class.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/bootstrap-theme.min.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">

          <a class="navbar-brand" href="#">Project name</a>
        </div>
        
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#">A Banda</a></li>
            <li><a href="#">Fotos</a></li>
            <li><a href="#">Integrantes</a></li>
            <li><a href="#">Eventos</a></li>
          </ul>
          
          
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">		
			<div class="table-responsive">
				<table class="table table-condensed" id="ab-tab">
			    	<thead>
			    		<tr>
			    			<th class='col-md-1'></th>
			    			<th>Titulo</th>
			    			<th class='col-md-1'>Lancamento</th>
			    			<th class='col-md-1'></th>
			    			<th class='col-md-1'></th>
			    		</tr>
			    	</thead>
			    	<tbody>
			    					   
			    	</tbody>
			  	</table>
			</div>
			<button type="button" id="addAlbum" class="btn btn-default btn-success">Adicionar</button>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript">
    
		
    	$(document).ready(function () {
		    carregaAlbuns();		    
		});

		
			
		$("#addAlbum").click(function(){
			alert("teste");
			location.href="editalbum.php?op=1&id=0";			
			
		});
		
		
		
		
		function carregaAlbuns(){
			html = "";
			$.post( "savealbuns.php",{ op: 4 }, function( data ) {
				var obj = jQuery.parseJSON ( data );
				if(obj.RET){
					for (var i=0; i < obj.RESP.length; i++) {
						html += "<tr rel='"+obj.RESP[i].id+"'>"; 
						html += "<td class='col-md-1'><img src='../"+obj.RESP[i].foto+"' width='40px'/></td>";
					    html += "<td><h5>"+obj.RESP[i].Nome+"</h5> </td>";
					    html += "<td><h5>"+obj.RESP[i].lancamento+"</h5> </td>";
					    html += "<td class='col-md-1'><button type='button' class='btn btn-warning btn-edit-album'>Editar</button></td>";
					    html += "<td class='col-md-1'><button type='button' class='btn btn-danger btn-delete-album'>Remover</button></td>";
						html += "</tr>	";	
					}
					
					$("#ab-tab > tbody").html(html);
					$("button.btn-edit-album").bind("click",function(){
						
						id = $(this).parent().parent().attr('rel');
						location.href="editalbum.php?op=2&id="+id+"";			
					});
					
					$("button.btn-delete-album").bind("click",function(){
						abid = $(this).parent().parent().attr('rel');
						alert(abid);
						$.post( "savealbuns.php",{ op : 3, id : abid}, function( data ) {
							alert(data);
							var obj = jQuery.parseJSON ( data );
							if(obj.RET){
								carregaAlbuns();
							}
						});		
					});
				}
			});
		}
		
		
		
		
		//$("#btn-save-music").click(function(){
			
		//});
    </script>
  </body>
</html>
