$(document).ready(function(){
	$("#volumeChanger").on("change", function() {
		wavesurfer.setVolume(this.value/100);
	});

	$("#cancel").on("click", function(){
		$(".toSave").toggle();
		$('#comments').val("");
		
	});
	
	$("#save").on("click", function(){
		$(".toSave").toggle();
		save();
		$('#comments').val("");
	});
		
	$('#annotate').click(function(){
    	$('#toSave').modal('show');
    });
	
	
	$('#create').submit(function(e){
		e.preventDefault();
		 $.ajax({
		      type: "POST",
		      url: "controller/createUser.php",
		      dataType: "json",
		      success: function (data) {
		        
		      },
		   });
	});
	
	$("#zoomChanger").on("change", function() {
			$("canvas").each(function(index, element){
				var context = element.getContext('2d');
				context.scale(1, this.value/100);
			});
	});
});

function save()
{	
	wavesurfer.pause();
	wavesurfer.WebAudio
	var ac = wavesurfer.WebAudio.audioContext;
	var currentTime = ac.currentTime;
	
	
	
	$.post("application/views/sound/record.php",{
			curTime : $('#currentTime').val(),
			Duration : wavesurfer.backend.buffer.duration,
			channels : wavesurfer.backend.buffer.numberOfChannels,
			sampleRate : wavesurfer.backend.buffer.sampleRate,
			userID : $('#userID').val(),
			comments : $('#comments').val()
			
		},
		function(data) {
			var data = jQuery.parseJSON(data);
			if(data.foo)
			{
				$("#response").html("Save Successful!");
			}
		}
	);
}