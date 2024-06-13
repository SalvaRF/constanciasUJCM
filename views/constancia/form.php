<?php
    $tipo = isset($tipo)?$tipo:'1';
?>
<div class="row">
    <form action="?ctrl=CtrlConstancia&accion=getConstancia" method="post">
    <div class="mb-3">
        <label for="dni" class="form-label">Ingresa tu DNI</label>
        <div class="input-group">
            <span class="input-group-text" id="basic-addon3">DNI:</span>
            <input required type="text" class="form-control validar" name="dni" aria-describedby="basic-addon3 basic-addon4">
        </div>
        
    </div>
    <div class="mb-3">
        <label for="recibo" class="form-label">Número de Recibo:</label>
        <div class="input-group">
            <span class="input-group-text" id="basic-addon3">Recibo:</span>
            <input required type="text" class="form-control" id="recibo" name="recibo" aria-describedby="basic-addon3 basic-addon4">
        </div>
        <input type="text" hidden name="t" value="<?=$tipo?>">
        
    </div>
    <div class="row">
        <button type="submit" class="btn btn-primary">Consultar</button>
    </div>
    </form>
</div>
<script>

    $(function () {
         
        $(".validar").on('input', function (evt) {
            // Allow only numbers.
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
    });
</script>
