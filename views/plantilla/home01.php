
<?php VISTA::show("frmConsultar.php");?>
                    <?php 
                    if (isset($deudas) && is_array($deudas)) {
                        //var_dump ($deudas);
                        foreach ($deudas as $d) {
                        
                    ?>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-3">
                                            <div class="display-2 text-warning">
                                                <i class="mdi mdi-database"></i>
                                            </div>    
                                        </div>
                                        <div class="col-9">
                                            <div class="m-l-10">
                                                <h4 class="m-b-0">El DNI: <span class="text-info"><?=$d['DNI']?></span> </h4>
                                                <h4 class="m-b-0">Para el CÓD: <span class="text-info"><?=$d['codigo']?></span>  tiene una deuda de: </h4>
                                                <h2 class="m-b-0 text-danger">S/ <?=($d['deuda']!=null)?number_format($d['deuda'],2):'0.00'?> </h2>   
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                    <?php }
                    } ?>
                    

