'use strict';

// Create an instance
var wavesurfer = Object.create(WaveSurfer);

//Note object
function Note(id, file, interval, duration, noteTime, note) {
	var t = this;
	t.id = id;
	t.file = file;
	t.interval = interval;
	t.duration = duration;
	t.noteTime = noteTime;
	t.note = note;
}

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
			playTimer();
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
		
		'noteBack': function() {
			//currently not working as the note number hasn't been defined that I can see at least within this file...
			try{
				if(Math.floor(wavesurfer.markers[note-1].position) == Math.floor(wavesurfer.backend.getCurrentTime())){
					if(note < 1){
						note = 1;
						wavesurfer.markers[note].played = false;
					}	
					wavesurfer.seekTo(wavesurfer.markers[note-2].percentage);
					note = note-1;
					wavesurfer.markers[note].played = false;
				} else {
					if(note < 1){
						note = 1;
					}
					wavesurfer.seekTo(wavesurfer.markers[note-1].percentage);
					note = note
					wavesurfer.markers[note].played = false;
				}
				//updateNoteView(); //this was only to update the note # on screen as needed
				getNote();
				if(!wavesurfer.backend.isPaused())
					wavesurfer.playPause();
			} catch(err) {
				console.log("Error: " + err.message);
			}
		},
        'back': function () {
            wavesurfer.skipBackward();
        },

		'noteForth': function() {
			//currently not working as the note number hasn't been defined that I can see at least within this file...
			try{
				getNote();
				if(note + 1 <= numberOf+1){
					wavesurfer.seekTo(wavesurfer.markers[note].percentage);
					note++;
					if(note > numberOf+1){
						note = numberOf+1; //extra error checking just to be safe
					}
				}
				updateNoteView();
				getNote();
			} catch (err) {
				console.log("Error: " + err.message);
			}
			if(!wavesurfer.backend.isPaused())
				wavesurfer.playPause();
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


/**
 *	This was the getNote method from Jonathan's version (used in the noteBack and noteForth methods)
 *	it is mostly ready to be set up with an AJAX call to pull the next note-id from the database, 
 *	or if we're preloading them from the database from the array/object
 */
function getNote(){
	//This method is currently a stub
	
	/*var id = note - 1;
	$("#notes").val("");
	
	//technically at the moment as there is no manual modification of the id values, 
	//so we can just pull down the note value, 
	//the rest of the array storage is useful for when outputting to a downloadable file
	if(typeof(storage[file]) != 'undefined'){
		if(typeof(storage[file][id]) != 'undefined')
			$("#notes").val(storage[file][id].note);
	}*/
	
	//Ajax code mostly prepared from previous work
	/*$.ajax({
		type: "POST",
		url: "script/return.php",
		data: {"id": (note-1),
			   "file": file,
			   "sess": session},
		dataType: "json",
		error: function(xhr, status, error){console.log(xhr.responseText)}}
	).done(function(data){
		$("#notes").val(data.note);
		//$("#drop").html(data.message);
	}).fail(function(data){
		console.log("Error: " + data);
	});*/
}

/**
 *	playTimer method to update the play timer overlay that appears overtop of the canvas element
 */
function playTimer(){
	timeInterval = window.setInterval(function(){
										var time = wavesurfer.backend.getCurrentTime();
										var timeID = document.getElementById("time");
										timeID.innerHTML = time.toString().toHHMMSS();
									  }, 250);
}

//taken from stackOverflow as a useful conversion from seconds to time
String.prototype.toHHMMSS = function() {
	var d = this;
	var h = Math.floor(d / 3600);
	var m = Math.floor(d % 3600 / 60);
	var s = Math.floor(d % 3600 % 60);
	return ((h > 0 ? h + ":" : "") + (m > 0 ? (h > 0 && m < 10 ? "0" : "") + m + ":" : "0:") + (s < 10 ? "0" : "") + s); 
};