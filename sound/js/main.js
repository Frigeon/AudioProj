'use strict';

// Create an instance
var wavesurfer = Object.create(WaveSurfer);

// Init & load mp3
document.addEventListener('DOMContentLoaded', function () {
    var options = {
        container     : document.querySelector('#waveform'),
        waveColor     : 'rgba(75, 122, 251, 1)',
        progressColor : 'rgba(19, 24, 164, 1)',
        loaderColor   : 'purple',
        cursorColor   : 'navy',
        markerWidth   : 2
    };

   
        options.minPxPerSec = 100;
        options.scrollParent = true;
    

    if (location.search.match('normalize')) {
        options.normalize = true;
    }

    if (location.search.match('svg')) {
        options.renderer = 'SVG';
    }

    /* Progress bar */
    var progressDiv = document.querySelector('#progress-bar');
    var progressBar = progressDiv.querySelector('.progress-bar');
    wavesurfer.on('loading', function (percent, xhr) {
        progressDiv.style.display = 'block';
        progressBar.style.width = percent + '%';
    });
    wavesurfer.on('ready', function () {
        progressDiv.style.display = 'none';
        
        wavesurfer.WebAudio.createBufferSource ;
       
    });

    // Init
    wavesurfer.init(options);
    // Load audio from URL
    wavesurfer.load('FluxPavilion_ICantStop.mp3');

    // Start listening to drag'n'drop on document
    wavesurfer.bindDragNDrop('#drop');
});

// Play at once when ready
// Won't work on iOS until you touch the page
wavesurfer.on('ready', function () {
     //loop through and create markers for modal data entry
     for(var i = 0; i < wavesurfer.backend.buffer.duration; i += 60)
     {
     	 wavesurfer.mark({
              id: i,
              position: i,
              color: 'rgba(255, 255, 0, 0.9)',
              played: true
          });
     }
});

// Bind buttons and keypresses
(function () {
    var eventHandlers = {
        'play': function () {
            wavesurfer.playPause();
            console.log(wavesurfer.backend);
        },

        'green-mark': function () {
            wavesurfer.mark({
                id: 'up',
                color: 'rgba(0, 255, 0, 0.5)'
            });
        },

        'red-mark': function () {
            wavesurfer.mark({
                id: 'down',
                color: 'rgba(255, 0, 0, 0.5)'
            });
        },

        'back': function () {
            wavesurfer.skipBackward();
        },

        'forth': function () {
            wavesurfer.skipForward();
        },

        'toggle-mute': function () {
            wavesurfer.toggleMute();
            if($("#volumeChanger").val() > 0)
            {
            	$("#volumeChanger").val("0");
            }else{
            	$("#volumeChanger").val("50");
            }
        	
        },
		'volumeChange': function() {
			wavesurfer.setVolume(0.1);
		}

    };


	
    document.addEventListener('keydown', function (e) {
        var map = {
            38: 'play',       // up
            37: 'back',       // left
            39: 'forth'       // right
        };
        if (e.keyCode in map) {
            var handler = eventHandlers[map[e.keyCode]];
            e.preventDefault();
            handler && handler(e);
        }
    });

    document.addEventListener('click', function (e) {
        var action = e.target.dataset && e.target.dataset.action;
        if (action && action in eventHandlers) {
            eventHandlers[action](e);
        }
    });
    
    
	
		
}());

// Flash mark when it's played over
wavesurfer.on('mark', function (marker) {
    if (marker.timer) { return; }
    wavesurfer.pause();
    
    //ajax call to get the comments from the database.
   
    $.post("application/views/sound/get.php",{
		curTime : marker.position,
		fileID : wavesurfer.backend.buffer.duration,
		userID : $('#userID').val()
	},
	function(data) {
		var obj = jQuery.parseJSON(data);
		$("#comments").val(obj.comments);
	});
    
    //Toggle the save modal.
    $("#toSave").modal('show');
    $("#currentTime").val(marker.position);
	$("#saveLength").val(wavesurfer.backend.buffer.length);
    $("#sid").val(wavesurfer.backend.buffer.duration);
    $("#channels").val(wavesurfer.backend.buffer.numberOfChannels);
    $("#saveSampleRate").val(wavesurfer.backend.buffer.sampleRate);
    
});



wavesurfer.on('error', function (err) {
    console.error(err);
});