
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <h3>Consulta si tienes alguna deuda con nosotros:</h3>
                                        <form action="?ctrl=CtrlConstancia&accion=q" method="post">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control form-control-lg dni" 
                                                placeholder="Ingresa tu DNI..." aria-label="Dni" 
                                                aria-describedby="button-addon2"
                                                name="txt">
                                                <button class="btn btn-outline-secondary" 
                                                type="submit" id="button-addon2">Buscar</button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <?php 
                    if (isset($deudas) && is_array($deudas)) {

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
                                                <h3 class="m-b-0">La deuda para el CÓD: <span class="text-info"><?=$d['codigo']?></span>  es: </h3>
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
                    

