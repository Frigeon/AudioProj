

<?php 
if(!isset($_SESSION['userSession']))
{
	?>
		<!-- Button trigger modal -->
		<button class="btn btn-primary pull-right marg15" data-toggle="modal" data-target="#loginModal" onclick="setTimeout(function(){$('#username').focus();}, 500);">
		  Login
		</button>
		<!-- Modal -->
		<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Login</h4>
		      </div>
		      <form id="login" action="#">
		      <div class="modal-body">
		      <div class="form-group">
		      
		       <input type="text"  class="form-control" id="username" placeholder="username" />
		       </div>
		       <div class="form-group">
				<input class="form-control" type="password" id="password" name="password" placeholder="password" />
				</div>
				
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
		        <button class="btn btn-success" id="login" >Login <i class="glyphicon glyphicon-off"></i></button>
		      </div>
		      </form>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	
		
	<?php 
}
else
{
	?>
	
	<button class="btn btn-danger pull-right marg15" id="logout" >Logout <i class="glyphicon glyphicon-off"></i></button>
	<?php 
}	
?>

