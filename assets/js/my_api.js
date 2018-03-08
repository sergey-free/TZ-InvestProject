$(document).ready(function(){
	
	//create
	$("#submit_create").click(function(){
		$.ajax({
			url:"/create",
			type:"POST",
			cache:true,
			data: {
				family: $("#family").val(),
				name: $("#name").val(),
				middle_family: $("#middle_family").val(),
				tel: $("#tel").val(),
				email: $("#email").val()
			},
			success: function(html){
			}
		})
	});
	
	//read
	$("#submit_read").click(function(){
		$.ajax({
			url:"/read",
			type:"POST",
			cache:true,
			data: {
				id: $("#number").val(),
			},
			success: function(html){
				$("#read_output").html(html);
			}
		})
	});
	
	//update
	$("#submit_update").click(function(){
		$.ajax({
			url:"/update",
			type:"POST",
			cache:true,
			data: {
				id: $("#number").val(),
				family: $("#family").val(),
				name: $("#name").val(),
				middle_family: $("#middle_family").val(),
				tel: $("#tel").val(),
				email: $("#email").val()
			},
			success: function(html){
			}
		})
	});
	
	//delete
	$("#submit_delete").click(function(){
		$.ajax({
			url:"/delete",
			type:"POST",
			cache:true,
			data: {
				id: $("#number").val(),
			},
			success: function(html){
			}
		})
	});
	
})