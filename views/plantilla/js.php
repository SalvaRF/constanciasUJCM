

<script type="text/javascript">
  $(function () {
     
    $(".dni").on('input', function (evt) {
				// Allow only numbers.
				$(this).val($(this).val().replace(/[^0-9]/g, ''));
			});

      /** Opción Nuevo */
      $('.nuevo').click( function(){ 
          var tipo= $(this).data('tipo');
          var constancia= $(this).data('constancia');
            // let linkNuevo=$(this).html();
            // alert(linkNuevo)
            //$(this).html('<i class="fa fa-spinner"></i> Cargando...');
            $('.modal-title').html('Datos necesarios - Constancia '+constancia);
            $.ajax({
                url:'index.php',
                type:'get',
                data:{'ctrl':'CtrlConstancia','accion':'nuevo','t':tipo}
            }).done(function(datos){
                // $(this).html(linkNuevo);
                $('#body-form').html(datos);
                $('#modal-form').modal('show');
            }).fail(function(){
                // $(this).html(linkNuevo);
                alert("error");
            });
        });

  });
</script>
