$("form#login").on('submit',function(e){

	e.preventDefault();



	$.post("action/login.php",$(this).serialize(),function(data){

		
		if(data=="success"){
		
			window.location="admin.php";
		


		}else {
			$("div#loginMsg").text(data);
		}
		



	});
	
});