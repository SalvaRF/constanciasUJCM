<!-- 
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
 -->
<script type="text/javascript">
  $(function () {
     
   'use strict'
        let msg='<?=$msg['titulo']?>';
        if(msg!=''){
            let icono = (msg=='Error')?'error':'success';
            $.toast({
                heading: msg,
                text: '<?=$msg['cuerpo']?>',
                icon: icono,
                position: 'top-right',
                showHideTransition: 'plain',
                // bgColor: 'green',
                    textColor: 'white',
                    hideAfter: 2000
            });
        }
   
        $("#txtBuscar").keyup(function (e) { 
            e.preventDefault();
            let clave= $("#txtBuscar").val().trim();
            if (clave){
                $("table").find('tbody tr').hide();

                $('table tbody tr').each(function(){
                    let nombres=$(this).children().eq(1);
                    if (nombres.text().toUpperCase().includes(clave.toUpperCase())){
                        $(this).show();
                    }
                });
            }else{
                $("table").find('tbody tr').show();

            }
        });
        
        $('.nuevo').click( function(){ 
            let linkNuevo=$(this).html();
            // alert(linkNuevo)
            $(this).html('<i class="fa fa-spinner"></i> Cargando...');
            $('.modal-title').html('Nuevo Registro');
            $.ajax({
                url:'index.php',
                type:'get',
                data:{'ctrl':'<?=isset($_GET['ctrl'])?$_GET['ctrl']:''?>','accion':'nuevo'}
            }).done(function(datos){
                $('.nuevo').html(linkNuevo);
                $('#body-form').html(datos);
                $('#modal-form').modal('show');
            }).fail(function(){
                $('.nuevo').html(linkNuevo);
                alert("error");
            });
        });
        $('.editar').click( function(){ 
            var id= $(this).data('id');
            $('.modal-title').html('Editando el Reg.: '+id);
            $.ajax({
                url:'index.php',
                type:'get',
                data:{'ctrl':'<?=isset($_GET['ctrl'])?$_GET['ctrl']:'';?>','accion':'editar','id':id}
            }).done(function(datos){
                $('#body-form').html(datos);
                $('#modal-form').modal('show');
            }).fail(function(){
                alert("error");
            });
        });
        $('.eliminar').click( function(){ 
            var id= $(this).data('id');
            var nombre= $(this).data('nombre');
           
            $('.modal-title').html('<i class="fa fa-trash"></i> Eliminando el Reg.: '+id );
            
            $('.reg-eliminacion').html('Registro: <code>' + nombre +'</code>');
            
            $('#btn-confirmar').attr('href', '?ctrl=<?=isset($_GET['ctrl'])?$_GET['ctrl']:'';?>&accion=eliminar&id='+id);
            
            $('#modal-eliminar').modal('show');
            
        });
        $('#imprimirPDF').click(function (e) { 
            e.preventDefault();
            let link=$(this).html();
            alert(link)
            $(this).html('<i class="fa fa-spinner"></i> Descargando...');
            var datos= <?=json_encode(isset($data)?$data:'');?>;
            let titulo=$('#titulo').html();

            /**
             * Añadiendo imagenes
             */
             // var logo = new Image();

            // logo.src = 'dist/img/prod-1.jpg';
            // logo.src = 'recursos/images/logo.JPG';

             /**
              * Fin añadir imagen
              */
            var doc = new jsPDF('p')
                 // doc.addImage(logo, 'JPEG', 10, 10,20,22);

                doc.setFontSize(20)
                doc.setTextColor(255, 0, 0) // Rojo
                doc.text(35, 25, titulo)
                let columnas =[]
                columnas.push( Object.keys(datos[0]) )

                let data = [] 

                for (let i in datos) {
                    data.push( Object.values(datos[i]));
                }

            doc.autoTable({ 
                head: columnas,
                body: data,
                    margin:{top:40}
                })
            $('#imprimirPDF').html(link);
            doc.save(titulo)
            
        });
  });
</script>