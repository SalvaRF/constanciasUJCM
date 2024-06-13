
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

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-2">
                                            <div class="display-2 text-danger text-center">
                                                <i class="mdi mdi-close-outline"></i>
                                            </div>    
                                        </div>
                                        <div class="col-10">
                                            <div class="m-l-10">
                                                <h3 class="m-b-0">No se pudo generar la Constancia</h3>
                                                   
                                            </div>
                                            <div class="alert alert-danger">
                                                <p><b>Motivo:</b></p>
                                                <?=$mensaje?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                    

