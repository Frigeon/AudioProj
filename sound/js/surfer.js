$(document).ready(function(){
	
	$(".chosen-select").chosen({width: "95%"});
	
	$("#volumeChanger").on("change", function() {
		wavesurfer.setVolume(this.value/100);
	});

	$("#cancel").on("click", function(){
		$(".toSave").toggle();
		$('#comments').val("");
		
	});
	
	$("#save").on("click", function(){

		save();
		$('#comments').val("");
	});
		
	$('#annotate').click(function(){
    	$('#toSave').modal('show');
    });

	
	$('#loadData').click(function(){
		 $.ajax({
		      type: "POST",
		      url: "controller/loadData.php",
		      dataType: "json",
		      data:{
		    	  fileName:$('#drop').text()
		    	  },
		      success: function (data) {
		        $('#loadDataModal').html(data.data);
		      }
		   });
		console.log($('#drop').text());
    	$('#viewData').modal('show');
    });
	
	$('#create').submit(function(e){
		e.preventDefault();
		if($('#passwordIn').val() == $('#passwordCheck').val())
		{
		 $.ajax({
		      type: "POST",
		      url: "controller/createUser.php",
		      dataType: "json",
		      data:{
		    	  username:$('#usernameIn').val(),
		    	  password:$('#passwordIn').val(),
		    	  email:$('#email').val()
		    	  },
		      success: function (data) {
		        alert('Created user');
		      }
		   });
		}else{
			alert('Pasword Don\'t match');
		}
	});
	
	$('#login').submit(function(e){
		e.preventDefault();

		 $.ajax({
		      type: "POST",
		      url: "controller/login.php",
		      dataType: "json",
		      data:{
		    	  username:$('#username').val(),
		    	  password:$('#password').val()
		    	  },
		      success: function (data) {
		        //location.reload();
		      }
		   });
		
	});
	
	$('#logout').click(function(){
		 $.ajax({
		      type: "POST",
		      url: "controller/logout.php",
		      dataType: "json",
		      success: function (data) {
		    	  location.reload()
		      }
		   });
	});
	
	
	$("#zoomChanger").on("change", function() {
			zoom = this.value/100;
			console.log("Zoom: " + zoom);
	});
	
	$("#family").chosen().change(function(){	
		var famID = $("#family option:selected").val();
		$(".species").each(function(index, element){
			if($(element).attr('data-family') == famID){
				$(element).removeClass('hide');
			} else if(!$(element).hasClass('hide')){
				$(element).addClass('hide');
			}
			
		});
		$('#speciesListSelect').chosen();
		$('#speciesListSelect').trigger("chosen:updated");
		
	});
	
	$('#saveButton').on('click', function(){
		console.log('test');
		
		 $.ajax({
		      type: "POST",
		      url: "controller/saveNote.php",
		      dataType: "json",
		      data:{
		    	  	
		    	  },
		      success: function (data) {
		    	  $("#toSave").modal('hide');
		      }
		   });
		
	});
	
});

function save()
{	
//	wavesurfer.pause();
//	wavesurfer.WebAudio;
//	var ac = wavesurfer.WebAudio.audioContext;
//	var currentTime = ac.currentTime;
	
	
	
//	$.post("application/views/sound/record.php",{
//			curTime : $('#currentTime').val(),
//			Duration : wavesurfer.backend.buffer.duration,
//			channels : wavesurfer.backend.buffer.numberOfChannels,
//			sampleRate : wavesurfer.backend.buffer.sampleRate,
//			userID : $('#userID').val(),
//			comments : $('#comments').val()
//			
//		},
//		function(data) {
//			var data = jQuery.parseJSON(data);
//			if(data.foo)
//			{
//				$("#response").html("Save Successful!");
//			}
//		}
//	);
}