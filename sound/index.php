<?php session_start();?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Soundsation</title>
		<?php
			//include('db.php');
			define('PATH', 'AudioProj/sound/');
			define('SALT', 'Hey.This.!5,A,S@LTY #');
		?>

		<!-- Bootstrap -->
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="style.css" />
		<link rel="stylesheet" href="chosen/chosen.min.css" />

		<!-- wavesurfer.js -->
		<script src="js/jquery.min.js"></script>
		<script src="js/wavesurfer.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
		<script src="js/main.js"></script>
		<script src="js/surfer.js"></script>
		<script src="chosen/chosen.jquery.min.js"></script>
	</head>

	<body >
		<div class="container">
			<div class="header">
				<h1 itemprop="name">Soundsation</h1>
				<p><a href="https://github.com/katspaugh/wavesurfer.js/pull/17" title="Wavesurfer.js" target="_blank"> - using wavesurfer.js</a></p>
				<div class="">
					<?php 

						if(!isset($_SESSION['userSession']))
							include 'view/register.php';
						include 'view/login.php';
						include 'model/db.php';
					?>
				</div>
			</div>
			<?php 
			if(isset($_SESSION['userSession'])){
			?>
			<div id="demo">
				<div id="waveform" style="height: 128px">
					<div class="progress progress-striped active" id="progress-bar">
						<div class="progress-bar progress-bar-info"></div>
					</div>
					<div id="time"></div>
					<!-- Here be the waveform -->
				</div>

				<div class="controls">
					<button class="btn btn-primary" data-action="noteBack">
						<i class="glyphicon glyphicon-step-backward"></i>
						Prev. Note
					</button>
					<button class="btn btn-primary" data-action="back">
						<i class="glyphicon glyphicon-backward"></i>
						Backward
					</button>
					<button class="btn btn-primary" data-action="play">
						<i class="glyphicon glyphicon-play"></i>
						Play
						/
						<i class="glyphicon glyphicon-pause"></i>
						Pause
					</button>
					<button class="btn btn-primary" data-action="forth">
						<i class="glyphicon glyphicon-forward"></i>
						Forward
					</button>
					<button class="btn btn-primary" data-action="noteForth">
						<i class="glyphicon glyphicon-step-forward"></i>
						Next Note
					</button>
					<button class="btn btn-primary" data-action="toggle-mute">
						<i class="glyphicon glyphicon-volume-off"></i>
						Toggle Mute
					</button>
					<!--<button class="btn btn-primary">
						<i class="glyphicon glyphicon-zoom-out"></i>
						<input id="zoomChanger" type="range" min="0" max="200" value="100" />
						<i class="glyphicon glyphicon-zoom-in"></i>
					</button>-->
					<button class="btn btn-primary">
						<i class="glyphicon glyphicon-volume-down"></i>
						<input id="volumeChanger" type="range" min="0" max="100" value="100" />
						<i class="glyphicon glyphicon-volume-up"></i>
					</button>
					<button class="btn btn-primary" id="loadData" >Load Data</button>
					<button class="btn btn-primary" id="annotate" >Test Annotation</button>
				</div>
				<div id="response">
				</div>
				<p class="lead pull-center" id="drop">
					Drag'n'drop your favorite
					<i class="glyphicon glyphicon-music"></i>-file here!
				</p>

				<!-- Modal -->
				<div class="modal fade " id="toSave" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content toSave">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h2 class="modal-title" id="myModalLabel">Annotation</h2>
							</div>
							<div id="speciesFamily" class="form-group">
								<?php 
									$con =  new DB();
									$con->connect();

									$families = $con->getSpeciesFamily();
									//var_dump($families);
								?>
								<select data-placeholder="Choose Species Family" style="width:350px;"  class="chosen-select chosen-single" id="family">
									<option>Choose Species Family</option>
									<?php 
										foreach($families as $family){
											echo '<option value="'.$family['familyID'].'">'.$family['CommonName'].' - '.$family['ScientificName'].'</option>';
										}
									?>
								</select>
							</div>
							<div id="speciesList" class="form-group">
								<select data-placeholder="Choose Species Family" style="width:350px;"  class="chosen-select chosen-single" id="speciesListSelect">
									<option>Choose Species</option>
									<?php
										$species = $con->getSpeciesList();
										foreach($species as $val){
											echo '<option value="'.$val['BirdID'].'" data-family="'.$val['familyID'].'" class="species hide"> '.$val['CommonName'].' - '.$val['ScientificName'].' - '.$val['Code4'].'</option>';
										}
									?>
								</select>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
								<button class="btn btn-success" id="save" >Save</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->

				<!-- Modal -->
				<div class="modal fade toLoad" id="viewData" tabindex="-1" role="dialog" aria-labelledby="viewDataLabel" aria-hidden="true">
					<div class="modal-dialog toLoad">
						<div class="modal-content toSave">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h2 class="modal-title" id="myModalLabel">Data</h2>
							</div>
							<div id="loadDataModal" class="">
							</div>
							<div class="modal-footer toLoad">
								<button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
			</div>
			<?php 
			}
			?>
		</div>
	</body>
</html>
