<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Movie WatchedList: A slim php, msql application">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/ico/favicon.ico">

    <title>Movie WatchedList</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/app.css" rel="stylesheet">
  </head>

  <body>

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li class="active"><a href="#" data-toggle="modal" data-target="#myModal">Add</a></li>
        </ul>
        <h3 class="text-muted">Movie WatchedList</h3>
      </div>
	  <hr>
      <div class="row">
        <div class="col-md-12" id="list">
	        
        </div>
      </div>

    </div> 

    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">Add Watched Movie</h4>
	      </div>
	      <div class="modal-body">
	        <form role="form" id="addForm">
			  <div class="form-group">
			    <label>Movie Name</label>
			    <input type="text" class="form-control" name="name" autocomplete="off">
			  </div>
			  <div class="form-group">
			    <label>Genre</label>
			    <select class="form-control" name="genre">
			    	<option value="0" selected="selected" disabled="disabled"></option>
			    	<option>Action</option>
			    	<option>Drama</option>
			    	<option>Comedy</option>
			    </select>
			  </div>
			  <div class="form-group">
			    <label>Watched On</label>
			    <input type="date" class="form-control" name="watched_on">
			  </div>
			  <div class="form-group">
			    <label>Medium</label>
			    <select class="form-control" name="medium">
			    	<option value="0" selected="selected" disabled="disabled"></option>
			    	<option>Hall</option>
			    	<option>TV</option>
			    	<option>Laptop</option>
			    	<option>Tablet</option>
			    	<option>Mobile</option>
			    </select>
			  </div>
			  <div class="form-group">
			    <label>Rating</label>
			    <select class="form-control" name="rating">
			    	<option value="0" selected="selected" disabled="disabled"></option>
			    	<option>Good</option>
			    	<option>Average</option>
			    	<option>Bad</option>
			    </select>
			  </div>
			</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	        <button type="button" class="btn btn-primary" onclick="addMovie()">Save</button>
	      </div>
	    </div>
	  </div>
	</div>
	<script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    
    <script type="text/javascript">
    	var url = 'http://localhost/testslim/';
    	window.onload = function() {
    		getList();
        };

        function getList(){
        	$.ajax({
				type: 'GET',
				contentType: 'application/json',
				url: url+'movielist',
				dataType: 'JSON',
				success: function(resp){
					var content = ''
					var css='';
					for(var i in resp){
						if(resp[i].rating == 'Good'){css = "class ='alert alert-success'";}
						if(resp[i].rating == 'Average'){css = "class ='alert alert-info'";}
						if(resp[i].rating == 'Bad'){css = "class ='alert alert-danger'";}
						content = '<div '+css+'>'
					          +'<h4>'+resp[i].name+' <small>'+resp[i].genre+'</small></h4>'
					          +'<p>'+resp[i].watched_on+' on '+resp[i].medium+'</p>'
					          +'<p>'+resp[i].rating+'</p>'
					        +'</div>';
				        $('#list').prepend(content);
					}
				}
			}); 
        }

        function addMovie(){
			var formData = $('form#addForm').serializeArray();
			$.ajax({
				type: 'POST',
				url: url+'add',
				data: formData,
				dataType: 'JSON',
				success: function(resp){
					var content = ''
					var css='';
						if(resp['rating'] == 'Good'){css = "class ='alert alert-success'";}
						if(resp['rating'] == 'Average'){css = "class ='alert alert-info'";}
						if(resp['rating'] == 'Bad'){css = "class ='alert alert-danger'";}
						content = '<div '+css+'>'
						          +'<h4>'+resp['name']+' <small>'+resp['genre']+'</small></h4>'
						          +'<p>'+resp['watched_on']+' on '+resp['medium']+'</p>'
						          +'<p>'+resp['rating']+'</p>'
						        +'</div>';
					    $('#list').prepend(content);
					    $('#myModal').modal('hide');
				}
			});
		}
	</script>
  </body>
</html>
