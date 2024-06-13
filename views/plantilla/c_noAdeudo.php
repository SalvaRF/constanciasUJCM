<p align="center">
    
    "<?=$anio?>"
    
</p>

<h1 align="center">
    <u>CONSTANCIA DE NO ADUEUDO</u>
</h1>

<h3 align="right"><b>Nro.: <?=$numero?></b></h3>

<table border="0">
    <tr>
        <th align="right">
            <b>CÓD. ESTUDIANTE: </b>
        </th>
        <td><?=$codigo?></td>
        <th align="right">
            <b>SEDE: </b>
        </th>
        <td><?=$sede?></td>
    </tr>
    <tr>
        <th align="right">
            <b>APELLIDOS Y NOMBRES: </b>
        </th>
        <td colspan="3"><?=$nombre?></td>
    </tr>
    <tr>
        <th align="right">
            <b>ESCUELA PROF.: </b>
        </th>
        <td colspan="3"><?=$carrera?></td>
    </tr>
</table>
<p></p>
<table style="border-style:solid; border: 1px solid #000;">
    <tr style="border-style:solid;background-color: #000;color: #FFF;">
        <th>ID</th>
        <th>CONCEPTO</th>
        <th>IMPORTE</th>
        <th>RECARGO</th>
        <th>INTERES</th>
        <th>TOTAL</th>
        <th>FECHA.VENC.</th>
    </tr>
    <tr>
        <td colspan="7" rowspan="2">
            <br>
            No se encontraron deudas
            <br>
        </td>
    </tr>
</table>
<p>LA DETERMINACIÓN DE LA DEUDA ES EN RAZÓN A LA ÚLTIMA MATRÍCULA REGISTRADA, CON EVALUACIÓN Y REGISTRO
CENTRAL EN LA FECHA DE EMISIÓN DE LA CONSTANCIA.</p>

<h4>RECIBO DE INGRESOS N° <?=$recibo?></h4>
<p>La presente constancia tiene una validez de 03 meses, hasta el: <b><?=$validez?></b></p>
<p align="right"><?=$fecha?></p>
