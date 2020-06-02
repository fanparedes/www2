
jQuery(document).ready(function($) {

	
$("#tipo_archivo_carga").ready(function(event) {


	var tipo_carga = $("#tipo_archivo_carga").val();



 $.ajax({
                      type: "POST",
                      url: "options.php",
                      tipo_carga: tipo_carga,
                      success: function() {

                        //  alert("Ha sido ejecutada la acción.");
                        //  alert(tipo_carga); //recuperando las variables

                      }

                        type: "POST",
                      url: "uploads.php",
                      tipo_carga: tipo_carga,
                      success: function() {

                        //  alert("Ha sido ejecutada la acción.");
                        //  alert(tipo_carga); //recuperando las variables

                      }


                  });

      	});

   



});