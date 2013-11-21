
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
        <link href="js/bootstrap.min.css" rel="stylesheet">
        <link href="js/bootstrap-glyphicons.css" rel="stylesheet">


        <link rel="stylesheet" href="style.css" />
        

        <!-- wavesurfer.js -->
		<script src="jquery.min.js"></script>
        <script src="js/wavesurfer.min.js"></script>


        <!-- Demo -->
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
            </div>
			
			<div class="toSave" id="toSave">
				<label>File ID: </label><input disabled type="text" name="sid" id ="sid" /><br />
				<label>File Samples: </label><input disabled type="text" name="sid" id ="saveLength" /><br />
				<label>SampleRate: </label><input disabled type="text" name="sid" id ="saveSampleRate" /><br />
				<label>Channels: </label><input disabled type="text" name="sid" id ="channels" /><br />
				<label>Current Time: </label><input disabled type="text" name="sid" id ="currentTime" /><br />
				
				<textArea name="comments" id="comments" placeholder="Comments" ></textarea><br />
				<button id="save" class="btn btn-success">Save</button>
				<button id="cancel" class="btn btn-danger">Cancel</button>
			</div>

    </body>
</html>
