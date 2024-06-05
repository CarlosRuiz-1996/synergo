<div>
    <div>
        <h1>Reporte de pagos</h1>
    </div>

    <div class="card-body mt-1">
        <form action="{{route('reporte.cajas')}}">

            <div class="row">
                <div class="col-md-4">
                    <div class="d-inline-block w-100">
                        <label for="">Expediente</label>
                        <input type="text" id="expediente" name=expediente class="form-control">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="d-inline-block w-100">
                        <label for="">Folio</label>
                        <input type="text" id="folio" name=folio class="form-control">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="d-inline-block w-100">
                        <label for="">Fechas desde </label>
                        <input type="date" id="fechadesde" name=fechadesde class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="d-inline-block w-100">
                        <label for="">Fecha hasta</label>
                        <input type="date" id="fechahasta" name=fechahasta class="form-control">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="d-inline-block w-100">
                        <label for="">Grupo</label>
                        <select id="ctgGrupoUsr" name="ctgGrupoUsr" class="form-control">
                            <option value="0">--Seleccione--</option>
                            @if ($groups)
                                @foreach ($groups as $c)
                                    <option value="{{ $c->cve_grupo }}">
                                        {{ $c->ds_nomgrupo }}
                                    </option>
                                @endforeach

                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-inline-block w-100">
                        <label for="">Empresa</label>
                        <select name="ctgEmpresa" id="ctgEmpresa" class="form-control">
                            <option value="0">--Seleccione--</option>

                            @if ($empresas)
                                @foreach ($empresas as $c)
                                    <option value="{{ $c->cve_empresa }}">
                                        {{ $c->ds_razonsocial }}
                                    </option>
                                @endforeach

                            @endif
                        </select>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="d-inline-block w-100">
                        <label for="">PLAN</label>
                        <select id="inpTipoPlan" name="inpTipoPlan" class="form-control">
                            <option value="0">Tipo de Plan</option>
                            <option value="1">INDIVIDUAL</option>
                            <option value="2">FAMILIAR</option>
                            <option value="3">EXTERNO</option>
                        </select>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="d-inline-block w-100">
                        <label for="">Forma de pago </label>
                        <select id="formapago" name="formapago" class="form-control">
                            <option value="0">Tipo de pago</option>
                            <option value="2">EFECTIVO</option>
                            <option value="1">TARJETA</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-inline-block w-100">
                        <label for="">Concepto de Pago</label>
                        <select id="conceptoPago" name="conceptoPago" class="form-control">
                            <option value="0">--Seleccione--</option>

                            @if ($conceptos)
                                @foreach ($conceptos as $c)
                                    <option value="{{ $c->id_dcConceptoDePago }}">
                                        {{ $c->concepto }}
                                    </option>
                                @endforeach

                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-inline-block w-100">
                        <label for="">Mes Cubierto</label>
                        <select name="mes_cubierto" id="mes_cubierto" class="form-control">
                            <option value="">Mes Cubierto</option>
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-inline-block w-100">
                        <label for="">Actividad</label>
                        <select id="actividadesnombre" name="actividadesnombre" class="form-control">
                            <option value="">Seleccione Actividad</option>
                            <?php
                            // $nombresUnicos = array_unique(array_column($actividadesExtras, 'nombreactividad'));
                            
                            // foreach ($nombresUnicos as $nombre) {
                            //     echo '<option value="' . $nombre . '">' . $nombre . '</option>';
                            // }
                            ?>
                            @if ($actividadesExtras)
                                @foreach ($actividadesExtras as $c)
                                    <option value="{{ $c->nombreactividad }}">
                                        {{ $c->nombreactividad }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
               
            </div>
            <div class="col-md-4 mt-4">
                <div class="d-inline-block w-100">
                    <button type="submit" class="btn btn-primary btn-block w-100" id="miBoton">Buscar</button>
                </div>
            </div>
            <div class="col-md-4 mt-4">
                <div class="d-inline-block w-100">
                    <button type="button" class="btn btn-secondary btn-block w-100" id="limpiarCampos">Limpiar
                        campos</button>
                </div>
            </div>
        </form>

        <div id="exportacion" class="mt-4"></div>
        <div class="container-fluid">
            <div class="">
                <table class="table mt-3" id="dtMdlListPagos">
                    <thead>
                        <tr>
                            <th>No.Folio</th>
                            <th>Expediente</th>
                            <th>Nombre</th>
                            <th>Plan</th>
                            <th>Empresa</th>
                            <th>Grupo</th>
                            <th>Fecha</th>
                            <th>Concepto</th>
                            <th>Actividad</th>
                            <th>Total</th>
                            <th>Mes Cubierto</th>
                            <th>Recibo</th>
                            <th>Cancelar</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if($pagos)
                            @foreach ($pagos as $pago )
                                <tr>
                                    <td>{{$pago->no_foliorecibo}}</td>
                                    <td>{{$pago->cve_expediente}}</td>
                                    <td>{{$pago->cliente->razonsocial}}</td>
                                    <td>{{$pago->cliente->plan->nombreTipoPlan}}</td>
                                    <td>{{$pago->cliente->empresa->razonsocial}}</td>
                                    <td>{{$pago->cliente->grupo->nombreGrupo}}</td>

                                    <td>{{$pago->fecha_alta}}</td>
                                    <td>{{$pago->conceptoDePago->concepto}}</td>

                                    <td>{{$pago->actividadExtra}}</td>
                                    <td>{{$pago->subtotal}}</td>
                                    <td>{{$pago->mes_cubierto}}</td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-secondary"
                                            data-bs-toggle="popover"
                                            title="Popup title"
                                            data-bs-content="Popup content"
                                        >
                                            Trigger
                                        </button>
                                        
                                    </td>
                                    <td>
                                        @if ($pago->estatus == "1") 
                                            <button class="btn btn-primary btn-sm" onclick="cancelarPago(' + no_foliorecibo + ')">Cancelar Pago</button>
                                        @elseif ($pago->estatus == "0") 
                                           
                                            <h2>Pago Cancelado</h2>
                                        @else 
                                            {{$pago->estatus}}
                                            hola
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>

                </table>
            </div>
        </div>
    </div>


    @push('js')
        <script>
            $(document).ready(function() {
                // Cuando se hace clic en el botón "Limpiar"
                $("#limpiarCampos").click(function() {
                    // Restablece el valor de todos los campos de entrada a su valor predeterminado
                    $("#expediente").val("");
                    $("#folio").val("");
                    $("#fechadesde").val("");
                    $("#fechahasta").val("");
                    $("#ctgGrupoUsr").val("0");
                    $("#ctgEmpresa").val("0");
                    $("#inpTipoPlan").val("0");
                    $("#formapago").val("0");
                    $("#conceptoPago").val("0");
                    $("#mes_cubierto").val("");
                    $("#actividadesnombre").val("");

                });
            });
        </script>
    @endpush
</div>
