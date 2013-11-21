	<!-- Button trigger modal -->
	<div class="row-fluid well well-lg">
		<button class="btn btn-success " data-toggle="modal" data-target="#registerModal">
		  Register <i class="glyphicon glyphicon-plus-sign"></i>
		</button>
		
	</div>
	<!-- Modal -->
	<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">register</h4>
	      </div>
	      <form id="create" action="#">
	      <div class="modal-body">
	      
		       <div class="form-group">
				<input  class="form-control" type="text" id="usernameIn" placeholder="username" required />
				</div>
		       <div class="form-group">
				<input  class="form-control" type="password" id="passwordIn" name="password" placeholder="password" required />
				</div>
		       <div class="form-group">
				<input  class="form-control" type="password" id="passwordCheck" name="passwordCheck" placeholder="password check"  required/>
				</div>

			
			<div class="alert alert-success fade in" style="display:none;" id="registerAlert"></div>
	      </div>
	      <div class="modal-footer">
	       <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
	        <button type="submit" class="btn btn-primary"  >Sign up</button>
	      </div>
	      </form>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->