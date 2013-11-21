
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Soundsation</title>

        <?php
			//include('db.php');
			define('PATH', 'AudioProj/sound/');
		?>

        <!-- Bootstrap -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css" />
        

        <!-- wavesurfer.js -->
		<script src="jquery.min.js"></script>
        <script src="js/wavesurfer.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
        <script src="surfer.js"></script>
    </head>

    <body >
        <div class="container">
            <div class="header">
           		<h1 itemprop="name">Soundsation</h1>
           		<p><a href="https://github.com/katspaugh/wavesurfer.js/pull/17" title="Wavesure.js" target="_blank"> - using wavesurfer.js</a></p>
           		<label>UserID: </label>
           		<input id="userID" placeholder="userID" autofocus value="" />
           		
           	<?php 
			include 'view/register.php';
			include 'view/login.php';
			?>
           		
            </div>
			
            <div id="demo">
                <div id="waveform" style="height: 128px">
                    <div class="progress progress-striped active" id="progress-bar">
                        <div class="progress-bar progress-bar-info"></div>
                    </div>

                    <!-- Here be the waveform -->
                </div>

                <div class="controls">
                    <button class="btn btn-primary" data-action="back">
                        <i class="glyphicon glyphicon-step-backward"></i>
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
                        <i class="glyphicon glyphicon-step-forward"></i>
                        Forward
                    </button>

                    <button class="btn btn-primary" data-action="toggle-mute">
                        <i class="glyphicon glyphicon-volume-off"></i>
                        Toggle Mute
                    </button>
					
					<button class="btn btn-primary">
						<i class="glyphicon glyphicon-volume-down"></i>
						<input id="volumeChanger" type="range" min="0" max="100" value="100" />
						<i class="glyphicon glyphicon-volume-up"></i>
					</button>
					
				</div>
				<div id="response">
				</div>
                <p class="lead pull-center" id="drop">
                    Drag'n'drop your favorite
                    <i class="glyphicon glyphicon-music"></i>-file
                    here!
                </p>
                
                <p>
                To load comments simply
                <ul>
                	<li>load your song by dragging the file into the square.</li>
                	<li>Enter your user ID in the userID field above.</li>
                	<li>Press play and let the applcation do the rest</li>
                </ul>
                
                <ul>
                	<li>Glyphicons not loading properly</li>
                	<li>Longer songs may not load due to browser limitations</li>
                	<li>Longer songs visual waves sometimes do not load</li>
                </ul>
                
                
                </p>
                
                
                
                <!-- Modal -->
		<div class="modal fade " id="toSave" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content toSave">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Annotation</h4>
		      </div>
		      	<div class="form-group">
		      		<label>File ID: </label><input class="form-control" disabled type="text" name="sid" id ="sid" /><br />
	      		</div>
	      		<div class="form-group">
					<label>File Samples: </label><input class="form-control" disabled type="text" name="sid" id ="saveLength" /><br />
				</div>
	      		<div class="form-group">
					<label>SampleRate: </label><input class="form-control" disabled type="text" name="sid" id ="saveSampleRate" /><br />
				</div>
	      		<div class="form-group">
					<label>Channels: </label><input class="form-control" disabled type="text" name="sid" id ="channels" /><br />
				</div>
	      		<div class="form-group">
					<label>Current Time: </label><input class="form-control" disabled type="text" name="sid" id ="currentTime" /><br />
				</div>
	      		<div class="form-group">
					<textArea name="comments" id="comments" placeholder="Comments" ></textarea><br />
				</div>
	      		<div class="form-group">
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
		        <button class="btn btn-success" id="login" >Login <i class="glyphicon glyphicon-off"></i></button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
                
            </div>
			

			
			

    </body>
</html>
