jQuery(document).ready(function($) {
    jQuery(".slidetd").click(function(){
        jQuery(this).parent().find("ul").slideToggle(500,"linear");
    })

    $('.data-table.nopagination').DataTable({
        "info" : false,
        'lengthMenu' : false,
        "paging": false,
        language: {
            search: 'Buscar'
        },
    });
    $('.data-table.paginated').DataTable({
        "info" : false,
        'lengthMenu' : true,
        "paging": true,
        "deferRender": true,
        language: {
            search: 'Buscar'
        },
    });
    
    $(".mod_ident").click(function(event) {
        event.preventDefault();
        var this2 = this;
        var id = $(this).attr('id');
        var section = $(this).attr('data-indsection');
        var div_current = $("div").find(".current").removeClass('current').addClass("d-none");
        var div_section = $("div").find("." + section).removeClass('d-none').addClass("current");
    });

    $('.select_alcance').change(function(){
        var alcance = $(this).children("option:selected").val();
        if($.trim(alcance) == 'regional'){
            let select = $(this).siblings('.select_region').removeClass('d-none');
        }else{
            let select = $(this).siblings('.select_region').addClass('d-none');
        }
    });

    $(".submit_ind").submit(function(event) {

        event.preventDefault();

        let container = $(this).parent();
        let data = $(this).serialize();
        let origin = $('input[name=indicator_origin]').val();
        var action;
        
        switch(origin){
            case '1': //AFC
                action = 'create_indicator';
                break;
            case '2': //CASEN
                action = 'create_indicator_casen';
                break;
        }
        
        $.ajax({
            url: ajax_var.url + '?action=' + action,
            data: data,
            dataType: 'json'
        }).done(function(data){
            console.log('exito',data);
            $(container).next('.indicator-preview').html(data.descripcion + '<button class="save-indicator" data-id="' + data.tmp_id + '">guardar indicador</button></p> ');
        }).fail(function(data) {
            console.log('error', data);
        });

    });

    $('body').on('click', '.save-indicator', function(event){
        event.preventDefault();
        var this_button = $(this);
        $.ajax({
            url: ajax_var.url + '?action=save_indicator',
            data: {tmp_id: $(this).data('id')},
            dataType: 'json'
        }).done(function(response){
            if(response.success){
                $(this_button).attr('data-id', response.id).html('Ocultar indicador front');
                $(this_button).closest('form').find('.custom-select').val('');
            } else {
                $(this_button).parent().append('<br><span class="insert-error">No se ha podido guardar el indicador, inténtelo nuevamente</span>');
            }
        });
    });

    $('.select_periodo').change(function(){
        var periodo = $(this).children("option:selected").val();
        if($.trim(periodo) == 'periodo'){
            $('.date').datetimepicker({
                format: 'YYYY'
            });

            let select = $(this).siblings('.date').removeClass('d-none'); 
        }
    });

    $(".btn-publish-indicator").click(function(event) {

        event.preventDefault();
        
        let button = $(this);
        
        $(this).attr('disabled', true);

        $(this).find('span').removeClass('hidden');
        let id = $(this).attr('id');

        $.ajax({
            type: 'POST',
            url: ajax_var.url,
            data: {action: 'save_indicator', id: id},
            dataType: 'json'
        }).done(function(data){
            console.log('exito',data);
            button.find('span').addClass('hidden');
            button.attr('disabled', true);
            button.text('Publicado');
            location.reload();
        }).fail(function(data) {
            console.log('error', data);
           $(this).attr('disabled', false);
        });

    });

    $(".btn-hide-indicator").click(function(event) {

        event.preventDefault();

        let id = $(this).attr('id');
        let button = $(this);
        $(this).find('span').removeClass('hidden');
        

        $.ajax({
            type: 'POST',
            url: ajax_var.url,
            data: {action: 'update_indicator', id: id},
            dataType: 'json'
        }).done(function(data){ 
            console.log('exito en la actualización',data);
            button.find('span').addClass('hidden');
            button.attr('disabled', true);
            button.text('Ocultado');
            location.reload();
        }).fail(function(data) {
            console.log('error en la actualización', data);
            
        });

    });

    $("#job-positions-table").on("click", ".job-position-link", function(event){
        event.preventDefault();
        var obj = $(this).next();
        if($(obj).hasClass("hidden")){
            $(obj).removeClass("hidden").slideDown();
        } else {
            $(obj).addClass("hidden").slideUp();
        }
    });

    $("#create").on("click", ".job-position-create", function(event){
        
        //let values = $(this).closest('#create-form').serializeArray();

        var id_occupation = $("#id_occupation").val();
        var digital = $("#digital").val();
        var name_job_position = $("#name_job_position").val();
        var code_job_position = $("#code_job_position").val();
        var description = $("#description").val();
        
        const values = [{name:"id_occupation", value:id_occupation}, {name:"digital", value:digital}, {name:"name_job_position", value:name_job_position}, {name:"code_job_position", value:code_job_position}, {name:"description", value:description}];

        $.ajax({
            type: 'POST',
            url: ajax_var.url,
            data: {action: 'create_job_positions', values: values},
            dataType: 'json'
        }).done(function(data){ 
            alert('Puesto de trabajo creado')
            location.reload();
        }).fail(function(data) {
            alert('Error al crear')
            location.reload();
            
        });
        
    });




    $("#job-positions-table").on("click", ".job-position-update", function(event){
        event.preventDefault();

        let values = $(this).closest('form').serializeArray();
 

        $.ajax({
            type: 'POST',
            url: ajax_var.url,
            data: {action: 'update_job_positions', values: values},
            dataType: 'json'
        }).done(function(data){ 
            
            alert('Puesto de trabajo actualizado')
            location.reload();
        }).fail(function(data) {  
            alert('Error al actualizar')
            location.reload();
            
        });
        console.log(values);
    });

    $("#job-positions-table").on("click", ".job-position-delete", function(event){
        event.preventDefault();

        let id_job_position = $(this).closest('form').find('input.id_job_position').val();
        
        $.ajax({
            type: 'POST',
            url: ajax_var.url,
            data: {action: 'remove_job_position', id_job_position: id_job_position},
            dataType: 'json'
        }).done(function(data){ 
            alert('Puesto de trabajo eliminado')
            location.reload();
        }).fail(function(data) {
            console.log('error al eliminar', data);
            alert('Error al eliminar')
            location.reload();
            
        });
        
    });

   

});


//var estatus = $(this).attr('data-status');

        // var request = jQuery.ajax({
        //     url : ajax_var.url,
        //     type: 'POST',
        //     dataType: "json",
        //     cache: false,
        //     data: {
        //         _ajax_nonce: ajax_var.nonce,
        //         action: 'get_types_indicator',
        //         id : id
        //     }
        // });

        // request.done(function(msg){
        //     for (var i = 0; i >= msg.length; i++) {
                 
        //     }
        //     // Swal.fire(
        //     //     'Modificado!',
        //     //     'El indicador ha cambiado de estado correctamente!',
        //     //     'success'
        //     // ).then((result) => {
        //     //     window.location.reload();
        //     // })
            
        // })
        // request.fail(function(msg){
        //     console.log(msg);
        //     Swal.fire(
        //         'Error!',
        //         'El indicador no ha cambiado de estado!',
        //         'warning'
        //     )
        // })

        // Swal.fire({
        //     title: '¿Estas Seguro?',
        //     text: "¿Quieres modificar el estado de este indicador?",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'Si, quiro hacerlo!'
        // }).then((result) => {
        //     if (result.value) {

        //         var request = jQuery.ajax({
        //             url : ajax_var.url,
        //             type: 'POST',
        //             dataType: "json",
        //             cache: false,
        //             data: {
        //                 _ajax_nonce: ajax_var.nonce,
        //                 action: 'mod_indicator',
        //                 id : id,
        //                 estatus : estatus
        //             }
        //         });

        //         request.done(function(msg){ 
        //             Swal.fire(
        //                 'Modificado!',
        //                 'El indicador ha cambiado de estado correctamente!',
        //                 'success'
        //             ).then((result) => {
        //                 window.location.reload();
        //             })
                    
        //         })
        //         request.fail(function(msg){
        //             console.log(msg);
        //             Swal.fire(
        //                 'Error!',
        //                 'El indicador no ha cambiado de estado!',
        //                 'warning'
        //             )
        //         })
        //     }
        // })
