
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
        	
        	<form role="form" id="form-albuns" alt="<?php echo $_GET['op']; ?>" rel="<?php echo $_GET['id']; ?>">
        		<div class="form-group" enctype="multipart/form-data">
			    	<label for="exampleInputEmail1">Titulo</label>
			    	<input type="Titulo" name="titulo" id="ab-titulo" class="form-control" id="exampleInputEmail1" placeholder="Titulo do album">
			  	</div>
			  	<div class="form-group" >
			    	<label for="exampleInputEmail1">Lançamento</label>
			    	<div class="date-form" >
			    		<input type="date" name="lancamento" id="ab-lancamento" class="form-control" id="exampleInputEmail1" placeholder="dd/mm/yyyy">
			    	</div>
			  	</div>
			  	<div class="form-group">
			    	<label for="exampleInputEmail1">Foto</label><br />
			    	<img src="../images/icons/no_image.jpg" id="ab-prev" class="img-thumbnail" />
			    	<input type="file" name="foto" id="ab-foto" class="form-control"/>
			  	</div>
			  	
			  	
			  	
			  	
			  	<button type="button" id="enviar-album" class="btn btn-default">Enviar</button>
			</form>
			<br>
			<div class="modal" id="modal">
				<div class="modal-dialog">
			      <div class="modal-content">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			          <h4 class="modal-title">Adicionar Musicas</h4>
			        </div>
			        <div class="modal-body">
			        	<form role="form" id="form-musicas">
			        		<div class='group-music'>
								<div class='form-group'>
									<label >Nome</label>
									<input type='Nome' class='form-control' placeholder='Nome'>
								</div>
								<div class='form-group'>
									<label >Numero</label>
									<input type='Numero'  class='form-control' placeholder='Numero'>
								</div>
								<div class='form-group'>
									<label >Compositores</label>
									<input type='Compositores' class='form-control' placeholder='Compositores'>
								</div>
								<div class='form-group'>
									<label >Letra</label>
									<input type='Letra' class='form-control' placeholder='Letra'>
								</div>
								<div class='form-group'>
									<label>Musica</label><br />
								    <input type='file'  class='form-control'/>
								</div>
							</div>					
						</form>
			          
			        </div>
			        <div class="modal-footer">
			          <a href="#" data-dismiss="modal" class="btn">Fechar</a>
			          <a href="#" id="btn-sav-music" class="btn btn-primary">Salvar</a>
			        </div>
			      </div>
			    </div>
				
			</div>
			
			<div class="table-responsive">
				<table class="table .table-condensed">
			    	<thead>
			    		<tr>
			    			<th class="col-md-1">#</th>
			    			<th>Nome</th>
			    			<th class="col-md-1"></th>
			    			<th class="col-md-1"></th>
			    		</tr>
			    	</thead>
			    	<tbody>
			    		<tr>
			    			<td >01</td>
			    			<td>Pé na Estdada</td>
			    			<td ><button type="button" class="btn btn-warning">Editar</button></td>
			    			<td ><button type="button" class="btn btn-danger">Remover</button></td>
			    		</tr>			    		
			    	</tbody>
			  	</table>
			</div>
			<button type="button" id="addMusic" class="btn btn-default btn-success">Adicionar</button>
			<button type="button" class="btn btn-default btn-danger">Remover Selecionadas</button>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/forms.js"></script>
    <script type="text/javascript">
    	$(document).ready(function () {
		    $("#ab-foto").change(readURL);
		    
		    
		    if($( '#form-albuns' ).attr('alt') == 2){
		    	$.post( "savealbuns.php",{ op: 4 , id: $( '#form-albuns' ).attr('rel') }, function( data ) {
					var obj = jQuery.parseJSON ( data );
					if(obj.RET){
						$("#ab-titulo").val(obj.RESP[0].Nome);
						$("#ab-lancamento").val(Date.parse(obj.RESP[0].lancamento));
						
						$("#ab-prev").attr("src","../"+obj.RESP[0].foto);
						
					}
				});
		    }
		});
		
		
		function readURL(e) {
			
		    if (this.files && this.files[0]) {
		        var reader = new FileReader();
		        $(reader).load(function(e) {
		        	 $('#ab-prev').attr('src', e.target.result); });
		        	
		        reader.readAsDataURL(this.files[0]);
		        
		        
		    }
		}
		
		//$("#addMusic").click(function(){
		//	$('#modal').modal({show:true});				  	
		//});
		
		$("#enviar-album").click(function(){
			form_data = new FormData();
			op = $( '#form-albuns' ).attr('alt');
    		form_data.append( 'op', op);
    		if(op == 2){
    			form_data.append( 'id', $( '#form-albuns' ).attr('rel'));
    		}   			
    			
    		form_data.append( 'foto', $( '#ab-foto' )[0].files[0] );
    		form_data.append( 'titulo', $("#ab-titulo").val() );
    		form_data.append( 'lancamento', $("#ab-lancamento").val() );
			var formData = new FormData($('form')[0]);
			
			$.ajax({
	                url: "savealbuns.php",
	                dataType: 'script',
	                cache: false,
	                contentType: false,
	                processData: false,
	                data: form_data,                         // Setting the data attribute of ajax with file_data
	                type: 'POST'
	                
		    }).complete(function(data){
		    	alert(data.responseText);
		    	var obj = jQuery.parseJSON ( data.responseText );
		    	if(obj.RET){
		    		if(op == 1){
			    		$( '#form-albuns' ).attr('alt',2);
			    		$( '#form-albuns' ).attr('rel',obj.RESP[0].ID);
			    	}else{
			    		
			    	}
		    	}
		    	
		    });
			
		});
		//$("#btn-save-music").click(function(){
			
		//});
    </script>
  </body>
</html>
