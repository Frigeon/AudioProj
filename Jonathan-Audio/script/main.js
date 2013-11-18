'use strict';

// Create an instance
var wavesurfer = Object.create(WaveSurfer);
var intCreated = false;
var numberOf = 1;
var note = 1;
var timeInterval;
var intervalText;
var interval;
var file;
var session;
var storage = new Array();

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
        waveColor     : 'blue',
        progressColor : 'purple',
        loaderColor   : 'purple',
        cursorColor   : 'green',
        markerWidth   : 2
    };

	intervalText = $("#interval");
	interval = intervalText.val();
	
    /*if (location.search.match('scroll')) {
        options.minPxPerSec = 100;
        options.scrollParent = true;
    }

    if (location.search.match('normalize')) {
        options.normalize = true;
    }

    if (location.search.match('svg')) {
        options.renderer = 'SVG';
    }*/
	
	//make the bar scrollable by default
	options.minPxPerSec = 50;
	options.scrollParent = true;
	
    /* Progress bar */
    var progressDiv = document.querySelector('#progress-bar');
    var progressBar = progressDiv.querySelector('.progress-bar');
    wavesurfer.on('loading', function (percent, xhr) {
        progressDiv.style.display = 'block';
        progressBar.style.width = percent + '%';
    });
    wavesurfer.on('ready', function () {
        progressDiv.style.display = 'none';
    });
	
    // Init
    wavesurfer.init(options);
    // Load audio from URL
    //wavesurfer.load("yourFile.mp3");
	
    // Start listening to drag'n'drop on document
	// modified wavesurfer.min.js to replace the parameter's innerHTML with the filename
    wavesurfer.bindDragNDrop('#drop');
});

// Play at once when ready
// Won't work on iOS until you touch the page
wavesurfer.on('ready', function () {
    //wavesurfer.play(); //not using this at the moment.
	intCreated = false;
	interval = intervalText.val();
	intervalMark();
	document.getElementById("duration").innerHTML = getLength().toString().toHHMMSS();
	document.getElementById("noteID").innerHTML = note + " of " + (numberOf+1);
	file = document.getElementById("drop").innerHTML; //get the filename once the file has loaded
	$("#download").attr("download", file.replace(/\.[^/.]+$/, "") + ".csv");
});

// Bind buttons and keypresses
(function () {
    var eventHandlers = {
        'play': function () {
			playTimer();
            wavesurfer.playPause();
        },

        'back': function () {
			//console.log("back");
			try{
				if(Math.floor(wavesurfer.markers[note-1].position) == Math.floor(wavesurfer.backend.getCurrentTime())){
					//console.log("if");
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
					//console.log("else");
					wavesurfer.seekTo(wavesurfer.markers[note-1].percentage);
					note = note
					wavesurfer.markers[note].played = false;
				}
				updateNoteView();
				getNote();
				if(!wavesurfer.backend.isPaused())
					wavesurfer.playPause();
			} catch(err) {
				console.log(err.message);
			}
        },

        'forth': function () {
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
				console.log(err.message);
			}
			if(!wavesurfer.backend.isPaused())
				wavesurfer.playPause();
        },

        'toggle-mute': function () {
            wavesurfer.toggleMute();
        },
		
		'store-note': function () {
			storeNote();
			playTimer();
			if(wavesurfer.backend.isPaused())
				wavesurfer.playPause();
		}
    };

    document.addEventListener('keydown', function (e) {
        var map = {
            //32: 'play',       // space
            38: 'play', // up
            //40: 'red-mark',   // down
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

// Pause when mark is played over
wavesurfer.on('mark', function (marker) {
	if(!wavesurfer.backend.isPaused())
		wavesurfer.playPause();
	note = marker.id + 1;
	updateNoteView();
	document.getElementById("noteTime").innerHTML = marker.position.toString().toHHMMSS();
	$("#notes").val("");
	getNote();
});

wavesurfer.on('error', function (err) {
    console.error(err);
});

//get the overall length of the file
function getLength(){
	var length = wavesurfer.backend.getDuration();
	switch(length){
		case length > 60:
			var minutes = Math.floor(length / 60);
			return minutes + ":" + Math.floor(length - (minutes * 60));
			break;
		case length > 60*60:
			break;
		default:
			return Math.floor(length);
	}
};

//create a set of intervals based on the chosen duration
function intervalMark(){
	//console.log(interval);
	if(interval > 0 && !intCreated){
		var length = wavesurfer.backend.getDuration();
		numberOf = Math.floor(length / interval) + 1;
		for(var i = 0; i < numberOf; i++){
			//console.log("i: " + i);
			wavesurfer.mark({id: i, color: "black", position: (i*interval)});
		}
		//console.log("i: " + numberOf);
		wavesurfer.mark({id: numberOf, color: "black", position: length});
		intCreated = true;
	}
};

//taken from stackOverflow as a useful conversion from seconds to time
String.prototype.toHHMMSS = function() {
	var d = this;
	var h = Math.floor(d / 3600);
	var m = Math.floor(d % 3600 / 60);
	var s = Math.floor(d % 3600 % 60);
	return ((h > 0 ? h + ":" : "") + (m > 0 ? (h > 0 && m < 10 ? "0" : "") + m + ":" : "0:") + (s < 10 ? "0" : "") + s); 
};



//update the displayed value of the note number
function updateNoteView(){
	document.getElementById("noteID").innerHTML = note + " of " + (numberOf + 1);
}

//get an existing note, but only if it already exists
function getNote(){
	var id = note - 1;
	$("#notes").val("");
	//technically at the moment as there is no manual modification of the id values, 
	//so we can just pull down the note value, 
	//the rest of the array storage is useful for when outputting to a downloadable file
	if(typeof(storage[file]) != 'undefined'){
		if(typeof(storage[file][id]) != 'undefined')
			$("#notes").val(storage[file][id].note);
	}
	
	//as below ajax calls have been commented out due to major issues working with session variables,
	//this works much better if we choose to work with a database
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

//store a note (this includes updates)
function storeNote(){
	//here we store notes under the filename, and then by id
	var id = note-1;
	if(typeof(storage[file]) == 'undefined')
		storage[file] = new Array();
	if(typeof(storage[file][id]) == 'undefined') {
		//console.log("storing note!");
		storage[file][id] = new Note((note-1), file, interval, wavesurfer.backend.getDuration(), $("#noteTime").html(), $("#notes").val());
		//console.log(storage[file][id].id);
	} else {
		//update the note, if we need to update for example the interval, then all of this may need to be updated
		var stor = storage[file][id];
		//stor.id = note-1;
		//stor.file = file;
		stor.intervavl = interval;
		//stor.duration = wavesurfer.backend.getDuration();
		//stor.noteTime = $("#noteTime").html();
		stor.note = $("#notes").val();
	}
	
	//ajax calls commented out due to major issues when working with session variables, 
	//if we choose to work with a database in the future then this becomes useful
	/*$.ajax({
		type: "POST",
		url: "script/entry.php",
		data: {"id": (note-1),
			   "file": file,
			   "interval": interval,
			   "duration": wavesurfer.backend.getDuration(),
			   "noteTime": $("#noteTime").html(),
			   "note": $("#notes").html()},
		dataType: "json",
		error: function(xhr, status, error){
			console.log(xhr.responseText);
			console.log("Error: " + error);
		}}
		).done(function(data){
			session = data.sess;
		}).fail(function(data){
			console.log("Error: " + data.message);
		});*/
	$("#download").attr("href", function(index, oldAttr){
		var value = "data:application/octet-stream,NoteID%09FileName%09NoteInterval%09AudioDuration%09NoteTime%09Note%0A";
		console.log(storage);
		storage[file].forEach(function(myNote, myId, myArr){
			//console.log(myNote);
			value += myNote.id + "%09" + encodeURI(myNote.file) + "%09" + myNote.interval + "%09" + myNote.duration + "%09" + myNote.noteTime + "%09" + encodeURI(myNote.note) + "%0A";
			//console.log(value);
		});
		return value;
	});
}

//set the interval to check the current time of the audio file
function playTimer(){
	timeInterval = window.setInterval(function(){
										var time = wavesurfer.backend.getCurrentTime();
										var timeID = document.getElementById("time");
										timeID.innerHTML = time.toString().toHHMMSS();
									  }, 250);
}