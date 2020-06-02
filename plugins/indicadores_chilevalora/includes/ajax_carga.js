
jQuery(document).ready(function($) {

	
$("#tipo_archivo").change(function(event) {

	var tipo_carga = $("#tipo_archivo").val();


 $.ajax({
                      type: "POST",
                      url: "options.php",
                      tipo_carga: tipo_carga,
                      success: function() {

                       
                      }

                  });



	//alert(tipo_carga);
		
	});



});