<link href="/components/DataTables/datatables.min.css" rel="stylesheet">

<script src="/components/DataTables/datatables.min.js"></script>
<style>
  .section-title {
    border: none;
    display: flex;
    align-items: center;
    font-size: 1.3rem;
    background-color: rgb(255, 255, 255);
    padding: 10px 0px 20px 0;
    margin: 0;
  }

  /*   .table-bx table{
  max-width: 100% !important;
  width: 100% !important;

}
.dataTables_scrollHeadInner,
.dataTables_scrollHead
{
  width: 100% !important;

} */
  /* Estilos específicos para responsividad */
  .dataTables_wrapper .dataTables_filter input {
    width: 100% !important;
  }

  .dataTables_wrapper .dataTables_length select {
    width: auto !important;
  }

  .table-responsive {
    overflow-x: auto;
  }

  .dt-responsive>.dataTables_wrapper {
    overflow: auto;
  }

  .read-title th {
    background-color: #fff !important;
  }

  @media (max-width: 768px) {
    .filters>div {
      flex: 0 0 50% !important;
      max-width: 50% !important;
      padding: 5px !important;
    }

    .filters>div:last-child {
      flex: 0 0 100% !important;
      max-width: 100% !important;
    }

    .sticky-header,
    .sticky-body {
      position: relative;
    }

    .table-buttons-container {
      flex-wrap: wrap;
    }

    .table-buttons-container .btn {
      margin-bottom: 5px;
    }
  }
</style>

<div class="container-fluid py-0 ">
  <!-- Título -->
  <div class="section-title">
    <h5>
      <i class="fa-solid fa-address-book"></i>
      Solicitudes de compra

    </h5>
  </div>

  <!-- Contenido principal -->
  <div>
    <!-- Filtros -->
    <div class="filters flex-wrap d-flex mb-3 p-0 row gap-1">
      <div class="col-md-2 col-6 ">
        <select id="filter-category" class="form-control rounded-0">
          <option value="" selected disabled>Ver por...</option>
          <option value="all">Todos</option>
          <option value="inProgress">En curso</option>
          <option value="completed">Finalizadas</option>
        </select>
      </div>

      <div class="col-md-2 col-6 ">
        <select id="filter-state" class="form-control rounded-0">
          <option value="" selected disabled>Estado</option>
          <?php foreach ($this->list_oprtunityStatus as $oportunity) { ?>
            <option value="<?= $oportunity["id"] ?>"><?= $oportunity["name"] ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-2 col-6 ">
        <select id="filter-type" class="form-control rounded-0">
          <option value="">Tipo de solicitud</option>
          <option value="1">Compra urgente</option>
          <option value="2">Compra regular</option>
          <option value="3">Exploración de proveedores</option>
          <option value="4">Cotización de precios</option>
          <option value="5">Proceso de licitación</option>
        </select>
      </div>
      <div class="col-md-3 col-6 d-flex align-items-end ">
        <button class="flex-none px-2 h-9 font-medium tracking-wider bg-slate-900 text-white w-100">
          <i class="fa-solid fa-filter"></i> Limpiar filtros
        </button>
      </div>
    </div>

    <!-- Botones de acción -->
    <div class="col-12 d-none">
      <div class="d-flex justify-content-end">
        <button class="flex-none px-2 h-9 font-medium tracking-wider bg-dark-blue text-white me-2">
          <i class="fa-solid fa-file-excel"></i>
          Exportar Excel
        </button>
        <button class="flex-none px-2 h-9 font-medium tracking-wider bg-orange text-white me-2" data-bs-toggle="modal"
          data-bs-target="#importModal">
          <i class="fa-regular fa-file-excel"></i>
          Importar Excel
        </button>
        <button class="flex-none px-2 h-9 font-medium tracking-wider bg-slate-900 text-white" data-bs-toggle="modal"
          data-bs-target="#createModal">
          <i class="fa-solid fa-plus"></i> Crear solicitud
        </button>
      </div>
    </div>

    <!-- Tabla de planes activos -->
    <div class="col-12 mt-4  d-none">
      <h4 class="text-xl font-bold text-slate-600">
        Planes anuales activos
      </h4>
    </div>
    <div class="table-bx">
      <table class="table table-striped sales-opportunities sales-opportunities-one display">
        <thead>


          <tr class="read-title">
            <th colspan="11" class="bg-white">No leidas</th>
          </tr>
          <tr>
            <th>#</th>
            <th>FECHA DE SOLICITUD</th>
            <th>EMPRESA</th>
            <th>REQUERIMIENTO</th>
            <th>LUGAR DE ENTREGA</th>
            <th>FECHA LIMITE DE RESPUESTA</th>
            <th>ESTADO</th>
            <th>TIPO SOLICITUD</th>
            <th>FECHA DE RESPUESTA</th>
            <th>MONTO DE NEGOCIACIÓN</th>
            <th>VER RESPUESTA</th>
          </tr>

        </thead>
        <tbody>
          <!--   <tr>
            <td>1</td>
            <td>Computadores portátiles</td>
            <td>50</td>
            <td>Unidad</td>
            <td>Oficina central</td>
            <td>Alta</td>
            <td>Tecnología</td>
            <td>Hardware</td>
            <td>$250,000,000</td>
            <td>Juan Pérez</td>
            <td>TI</td>
            <td>Marzo</td>
            <td>2024</td>
            <td>Proceso de licitación</td>
            <td>2024-03-01</td>
            <td>2024-04-15</td>
            <td><span class="estado-en-proceso">Planeado</span></td>
            <td>5</td>
            <td>10</td>
            <td>Dell, HP, Lenovo</td>
            <td>3</td>
            <td class="sticky-body">
              <div class="d-flex table-buttons-container">
                <div class="dropdown">
                  <button class="flex-none px-2 h-8 font-medium tracking-wider bg-gray-600 text-white dropdown-toggle"
                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis-v"></i>
                  </button>
                  <ul class="dropdown-menu custom-dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewModal">
                        <i class="fa-solid fa-eye me-2"></i>Ver
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal">
                        <i class="fa-solid fa-edit me-2"></i>Editar
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#newsModal">
                        <i class="fa-solid fa-file-pen me-2"></i>Observaciones
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#statusModal">
                        <i class="fa-solid fa-repeat me-2"></i>Cambiar Estado
                      </a>
                    </li>
                  </ul>
                </div>
                <button class="flex-none px-2 h-8 font-medium tracking-wider bg-red-500 text-white ms-2">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Sillas ergonómicas</td>
            <td>100</td>
            <td>Unidad</td>
            <td>Oficina central</td>
            <td>Media</td>
            <td>Mobiliario</td>
            <td>Sillas</td>
            <td>$120,000,000</td>
            <td>María Rodríguez</td>
            <td>Recursos Humanos</td>
            <td>Abril</td>
            <td>2024</td>
            <td>Cotización de precios</td>
            <td>2024-04-10</td>
            <td>2024-05-10</td>
            <td><span class="estado-activo">Respondido</span></td>
            <td>3</td>
            <td>7</td>
            <td>ErgoChair, ComfortSeat</td>
            <td>2</td>
            <td class="sticky-body">
              <div class="d-flex table-buttons-container">
                <div class="dropdown">
                  <button class="flex-none px-2 h-8 font-medium tracking-wider bg-gray-600 text-white dropdown-toggle"
                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis-v"></i>
                  </button>
                  <ul class="dropdown-menu custom-dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewModal">
                        <i class="fa-solid fa-eye me-2"></i>Ver
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal">
                        <i class="fa-solid fa-edit me-2"></i>Editar
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#newsModal">
                        <i class="fa-solid fa-file-pen me-2"></i>Observaciones
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#statusModal">
                        <i class="fa-solid fa-repeat me-2"></i>Cambiar Estado
                      </a>
                    </li>
                  </ul>
                </div>
                <button class="flex-none px-2 h-8 font-medium tracking-wider bg-red-500 text-white ms-2">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </div>
            </td>
          </tr> -->
        </tbody>
      </table>
    </div>

    <!-- Tabla de compras pendientes -->
    <div class="col-12 mt-2  d-none">
      <h4 class="text-xl font-bold text-slate-600">
        Compras pendientes de activar
      </h4>
    </div>
    <div class="col-12  d-none">
      <div class="alert alert-warning py-2" role="alert">
        ¡Atención! Estas compras planeadas aun no han sido activadas, por favor revisalas y completa la información
        necesaria para que los proveedores puedan verlas.
      </div>
    </div>
    <div class="table-bx">
      <table class="table table-striped sales-opportunities sales-opportunities-two display">
        <thead>
          <tr class="read-title">
            <th colspan="11">Leidas</th>
          </tr>
          <tr>
            <th>#</th>
            <th>FECHA DE SOLICITUD</th>
            <th>EMPRESA</th>
            <th>REQUERIMIENTO</th>
            <th>LUGAR DE ENTREGA</th>
            <th>FECHA LIMITE DE RESPUESTA</th>
            <th>ESTADO</th>
            <th>TIPO SOLICITUD</th>
            <th>FECHA DE RESPUESTA</th>
            <th>MONTO DE NEGOCIACIÓN</th>
            <th>VER RESPUESTA</th>
          </tr>

        </thead>
        <tbody>
          <tr>
            <td>3</td>
            <td>2024-05-31</td>
            <td>OMEGA SOLUCIONES WEB </td>
            <td>RESMAS DE PAPEL </td>
            <td>CALLE CON CARRERA </td>
            <td>2025-05-23</td>
            <td><span class="estado-activo">Respondido</span></td>
            <td>Compra urgente </td>
            <td>2025-05-07 </td>
            <td>$80,000,000</td>

            <td class="sticky-body">
              <div class="d-flex gap-2 table-buttons-container">

                <button
                  data-bs-tooltip="tooltip"
                  data-bs-title="Ver historico de cambios"
                  class="p-2 d-flex bg-sky-700 text-white"
                  data-bs-toggle="modal" data-bs-target="#historyModal">
                  <i class="fa-solid fa-table-list"></i>
                </button>
                <button
                  data-bs-tooltip="tooltip"
                  data-bs-title="Ver detalle | responder"
                  class=" p-2 d-flex bg-sky-700 text-white"
                  data-bs-toggle="modal" data-bs-target="#detailModal">
                  <i class="fa-solid fa-eye"></i>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modales -->

<!-- Modales -->
<!-- Modal para Ver Respuesta -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-xl">
          Revisa las propuestas
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">
          Aquí se mostrarían las propuestas relacionadas con la solicitud seleccionada.
        </div>
        <div class="row">
          <div class="col-md-6">
            <h6>Detalles de la solicitud</h6>
            <ul class="list-group list-group-flush">
              <li class="list-group-item"><strong>Empresa:</strong> OMEGA SOLUCIONES WEB</li>
              <li class="list-group-item"><strong>Requerimiento:</strong> RESMAS DE PAPEL</li>
              <li class="list-group-item"><strong>Lugar de entrega:</strong> CALLE CON CARRERA</li>
              <li class="list-group-item"><strong>Fecha límite:</strong> 2025-05-23</li>
            </ul>
          </div>
          <div class="col-md-6">
            <h6>Propuestas recibidas</h6>
            <div class="list-group">
              <a href="#" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                  <h6 class="mb-1">Proveedor A</h6>
                  <small>Hace 2 días</small>
                </div>
                <p class="mb-1">$78,000,000</p>
              </a>
              <a href="#" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                  <h6 class="mb-1">Proveedor B</h6>
                  <small>Hace 1 día</small>
                </div>
                <p class="mb-1">$80,500,000</p>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Responder</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Crear Solicitud -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-xl">
          Crear nueva solicitud
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Campo Interés del Producto -->
          <div class="col-md-6 my-2">
            <label class="form-label">Interés del Producto <span>*</span></label>
            <input type="text" class="form-control" id="product_interest" name="product_interest" required>
          </div>

          <!-- Campo Tipo de Compra -->
          <div class="col-md-6 my-2">
            <label class="form-label">Tipo de Compra <span>*</span></label>
            <select class="form-control" id="buy_type" name="buy_type" required>
              <option value="">Seleccione...</option>
              <option value="1">Compra directa</option>
              <option value="2">Licitación</option>
              <option value="3">Subasta</option>
            </select>
          </div>

          <div class="col-md-8 my-2">
            <label class="form-label">Cantidad <span>*</span></label>
            <input type="number" class="form-control" id="amount" name="amount" required>
          </div>

          <div class="col-md-4 my-2">
            <label class="form-label">Unidad de medida</label>
            <input type="text" class="form-control" id="measure_unit" name="measure_unit">
          </div>

          <div class="col-md-6 my-2">
            <label class="form-label">No. proveedores requeridos <span>*</span></label>
            <input type="number" min="0" max="15" class="form-control" id="supplier_amount" name="supplier_amount" required>
          </div>

          <!-- Campo Fecha Estimada -->
          <div class="col-md-6 my-2">
            <label class="form-label">Fecha Estimada <span>*</span></label>
            <input type="date" class="form-control" id="estimated_date" name="estimated_date" required>
          </div>

          <!-- Campo Descripción -->
          <div class="col-12 my-2">
            <label class="form-label">Descripción de la necesidad de compra <span>*</span></label>
            <textarea class="form-control" id="request_detail" name="request_detail" required></textarea>
          </div>

          <!-- Campo Industria -->
          <div class="col-md-6 my-2">
            <label class="form-label" for="industry">Industria <span>*</span></label>
            <select class="form-select selec-search" id="industry" name="industry" required>

              <option value="">Selecciona una opción</option>
              <?php foreach ($this->list_industry as $key => $industry) { ?>
                <option value="<?= $key; ?>"><?= $industry; ?></option>
              <?php } ?>
            </select>
          </div>

          <!-- Campo Segmento -->
          <div class="col-md-6 my-2">
            <label class="form-label">Segmento <span>*</span></label>
            <select class="form-select selec-multiple" id="segment" name="segment" required>
              <!-- se llenará dinámicamente -->
            </select>
          </div>

          <!-- Campo Lugar de Entrega -->
          <div class="col-md-6 my-2">
            <label class="form-label">Lugar de Entrega <span>*</span></label>
            <input type="text" class="form-control" id="delivery_place" name="delivery_place" required>
          </div>

          <!-- Campo Complejidad de Compra -->
          <div class="col-md-6 my-2">
            <label class="form-label">Complejidad de Compra <span>*</span></label>
            <select class="form-control" id="complexity" name="complexity" required>
              <option value="alta">Alta</option>
              <option value="media">Media</option>
              <option value="baja">Baja</option>
            </select>
          </div>

          <div class="col-md-6 my-2">
            <label class="form-label">Presupuesto <span>*</span></label>
            <input type="text" class="form-control" id="budget" name="budget" required>
          </div>

          <div class="col-md-6 my-2">
            <label class="form-label">Visibilidad de Presupuesto <span>*</span></label>
            <select class="form-control" id="budget_visibility" name="budget_visibility">
              <option value="1">Público</option>
              <option value="0">Confidencial</option>
            </select>
          </div>

          <!-- Campo Usuario Requisitor -->
          <div class="col-md-6 my-2">
            <label class="form-label">Usuario Requisitor</label>
            <input type="text" class="form-control" id="user" name="user">
          </div>

          <!-- Campo Área de Solicitud -->
          <div class="col-md-6 my-2">
            <label class="form-label">Área de Solicitud</label>
            <input type="text" class="form-control" id="area" name="area">
          </div>

          <!-- Campo Fecha de Apertura Real -->
          <div class="col-md-6 my-2">
            <label class="form-label">Fecha de Apertura Real <span>*</span></label>
            <input type="date" class="form-control" id="open_date" name="open_date" required>
          </div>

          <!-- Campo Fecha Límite de Respuesta -->
          <div class="col-md-6 my-2">
            <label class="form-label">Fecha Límite de Respuesta <span>*</span></label>
            <input type="date" class="form-control" id="max_date" name="max_date" required>
          </div>

          <!-- Campos de archivos adjuntos -->
          <div class="col-md-4 my-2">
            <label class="form-label">Adjunto 1</label>
            <input type="file" class="form-control" id="attachment_0" name="attachment_0">
          </div>

          <div class="col-md-4 my-2">
            <label class="form-label">Adjunto 2</label>
            <input type="file" class="form-control" id="attachment_1" name="attachment_1">
          </div>

          <div class="col-md-4 my-2">
            <label class="form-label">Adjunto 3</label>
            <input type="file" class="form-control" id="attachment_2" name="attachment_2">
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary rounded-0" type="button">
          Cancelar
        </button>
        <button class="btn btn-primary rounded-0 bg-slate-900 " type="submit">
          Crear Solicitud
        </button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal para Editar Solicitud -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-xl">
          Editar solicitud
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label class="form-label">Requerimiento</label>
            <input type="text" class="form-control" value="RESMAS DE PAPEL">
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Cantidad</label>
              <input type="number" class="form-control" value="150">
            </div>
            <div class="col-md-6">
              <label class="form-label">Unidad de medida</label>
              <input type="text" class="form-control" value="Unidad">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Lugar de entrega</label>
            <input type="text" class="form-control" value="CALLE CON CARRERA">
          </div>
          <div class="mb-3">
            <label class="form-label">Fecha límite de respuesta</label>
            <input type="date" class="form-control" value="2025-05-23">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Cambiar Estado -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Cambiar estado</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row">
          <div class="col-12">
            <div class="form-group">
              <label for="edit-status" class="form-label">Cambiar estado</label>
              <select class="form-control" id="edit-status">
                <option value="1">En espera</option>
                <option value="2" selected>Respondido</option>
                <option value="3">Cancelado</option>
                <option value="4">Finalizado</option>
                <option value="5">Invitado</option>
                <option value="6">Pendiente</option>
                <option value="7">Rechazado</option>
                <option value="8">Adjudicado</option>
                <option value="9">Vencido</option>
              </select>
            </div>
          </div>
          <div class="col-12 mt-3">
            <div class="form-group">
              <label for="status-comment" class="form-label">Comentario</label>
              <textarea class="form-control" id="status-comment" rows="2"></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Cambiar estado</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Observaciones -->
<div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Observaciones</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row">
          <div class="col-12">
            <div class="form-group">
              <label for="quill-editor" class="form-label">Registrar observaciones</label>
              <textarea id="quill-editor" class="form-control" rows="5" placeholder="Escribe tus observaciones aquí..."></textarea>
            </div>
          </div>
          <div class="col-12 mt-3">
            <div class="form-group">
              <label class="form-label">Adjuntar archivo</label>
              <input type="file" class="form-control">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Guardar observación</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Importar Excel -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-2xl font-bold">Carga masiva</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row">
          <div class="col-12 mb-3">
            <div class="alert alert-warning">
              Descarga el formato de ejemplo para la carga masiva de planes
              <a href="/skins/page/files/plan_de_compras_ejemplo.xlsx" target="_blank" style="text-decoration: underline;"><strong>aquí</strong></a>
            </div>
          </div>
          <div class="col-12">
            <label for="">Cargar Excel</label>
            <input type="file" class="form-control" />
          </div>
          <div class="col-12 mt-4">
            <button class="flex-none px-4 h-9 font-medium tracking-wider bg-slate-900 text-white w-100">
              Guardar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal para ver el historico de cambios -->
<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5"> Historico de Cambios</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <table class="gray-table">
            <thead>
              <tr>
                <th># de solicitud</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Acción</th>
                <th>Descripción</th>
                <th>Estado del cambio</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>114</td>
                <td>04/05/2025 06:53:27 </td>
                <td>

                  <span> Proveedor </span>
                </td>
                <td>Cambiar monto de negociación </td>
                <td>El monto cambio a: $9.000.000 </td>
                <td>
                  Sin cambio de estado
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer d-none">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Cambiar estado</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Ver detalle || responder -->

<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-2xl font-bold">

        </h5>
        <span
          class="d-block ms-auto not-viewed-link">
          <i class="fa-solid fa-eye-slash"></i>
          Marcar como no leído
        </span>
        <button type="button" class="ms-0 btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row w-100 m-auto">
          <div class="col-8 request-info-container">
            <div class="row">
              <div class="col-12">
                <div class="company-name">
                  <i class="fa-solid fa-building"></i> OMEGA SOLUCIONES WEB
                </div>
              </div>
              <div class="col-12">
                <h3>
                  RESMAS DE PAPEL
                </h3>
              </div>
              <div class="col-12 my-1">
                <p class="product-interest">
                  <span>Compra urgente</span> - <span>cALLE CON CARRERA</span> - <span>Fecha máxima de respuesta 2025-05-23</span>
                </p>
              </div>
              <div class="col-12 my-1">
                <p class="product-interest">
                  <strong>Descripción: </strong>
                  <br>
                  <span>NECESITAMSO 30 RESMAS DE PAPEL

                  </span>
                </p>
              </div>
              <!-- Validar si existen los archivos  y validar individualmente -->
              <div
                class="col-12 documents d-none">
                <p class="product-interest">
                  <strong class="py-2 pb-1 d-block">Documentos adjuntos:</strong>
                <div class="file-links-bx">
                  <a

                    href="'/storage/' + activeOportunity.file1"
                    target="_blank"
                    class="file-link"> <i class="fa-solid fa-file"></i> Adjunto 1 <i class="fa-solid fa-arrow-down download-icon"></i></a>
                  <a

                    href="'/storage/' + activeOportunity.file2"
                    target="_blank"
                    class="file-link"> <i class="fa-solid fa-file"></i> Adjunto 2 <i class="fa-solid fa-arrow-down download-icon"></i></a>
                  <a

                    href="'/storage/' + activeOportunity.file3"
                    target="_blank"
                    class="file-link"> <i class="fa-solid fa-file"></i> Adjunto 3 <i class="fa-solid fa-arrow-down download-icon"></i></a>
                </div>
                </p>
              </div>
            </div>
          </div>
          <div class="col-4 pb-2">
            <form class="row pr-3">
              <div class="change-amount-bx">
                <div class="form-group col-md-12">
                  <label for="">Cambia tu monto de negociación</label>
                  <input

                    type="text"
                    class="form-control rounded-0"
                    id="supplierValue"

                    placeholder="Digita el monto" />
                </div>
                <div class="col-md-12">
                  <br />
                  <button
                    class="flex-none w-100 px-4 h-10 font-medium tracking-wider bg-slate-900 text-white">
                    Guardar
                  </button>
                </div>
              </div>
            </form>
          </div>

          <div class="col-12 my-1">
            <hr />
          </div>
          <!-- Validar v-if="!activeOportunity.proposal" -->
          <div class="col-12">
            <h5 class="text-xl font-bold mb-2 send-proposal-title"><i class="fa-solid fa-paper-plane"></i> Enviar propuesta</h5>
          </div>
          <!-- Validar v-if="activeOportunity.proposal" -->
          <div class="col-12 d-none">
            <h5 class="text-xl font-bold mb-2 send-proposal-title"><i class="fa-solid fa-paper-plane"></i> Propuesta enviada</h5>
          </div>
          <!-- Validar v-if="!activeOportunity.proposal" -->
          <div class="col-12" v-if="!activeOportunity.proposal">
            <form class="row">
              <div class="w-full">
                <label
                  for="message"
                  class="block text-gray-700 font-medium mb-2">
                  Mensaje
                </label>
                <textarea
                  name="message"
                  id="message"

                  cols="30"
                  rows="2"
                  class="w-full p-3 border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none resize-none"></textarea>
                <div class="text-sm text-end text-gray-500 mt-1">
                  0 / 300 caracteres
                </div>
              </div>

              <div class="col-12">
                <span class="text-sm text-slate-600">
                  Puedes adjuntar hasta 3 archivos
                </span>
              </div>

              <div class="col-4">
                <label for="">Archivo 1</label>
                <input
                  type="file"
                  class="form-control rounded-0" />
              </div>
              <div class="col-4">
                <label for="">Archivo 2</label>
                <input
                  type="file"
                  class="form-control rounded-0" />
              </div>
              <div class="col-4">
                <label for="">Archivo 3</label>
                <input
                  type="file"
                  class="form-control rounded-0" />
              </div>
              <div class="w-full text-center mt-3">
                <span class="text-sm text-slate-600">
                  Al enviar este mensaje, el cliente recibirá una
                  notificación y podrá ver sus datos de contacto.
                </span>
              </div>
              <div class="w-full text-end mt-3">
                <button type="button" class="flex-none px-4 h-10 font-medium tracking-wider bg-slate-400 text-white me-2" data-bs-dismiss="modal">Cancelar</button>
                <button
                  type="submit"
                  class="flex-none px-4 h-10 font-medium tracking-wider bg-slate-900 text-white">
                  Enviar propuesta
                </button>
              </div>
            </form>
          </div>
          <div class="col-12 d-none">
            <div class="row">
              <div class="col-8 request-info-container no-before">
                <div class="row">
                  <div class="col-12">
                    <p><strong>Tu propuesta:</strong> <br>
                    </p>
                  </div>
                  <!-- Validar si existen los archivos  y validar individualmente -->

                  <div
                    class="col-12 documents">
                    <p class="product-interest">
                      <strong class="py-2 pb-1 d-block">Documentos adjuntos:</strong>
                    <div class="file-links-bx">
                      <a

                        href="'/storage/' + activeOportunity.proposal.file1"
                        target="_blank"
                        class="file-link"> <i class="fa-solid fa-file"></i> Adjunto 1 <i class="fa-solid fa-arrow-down download-icon"></i></a>
                      <a

                        href="'/storage/' + activeOportunity.proposal.file2"
                        target="_blank"
                        class="file-link"> <i class="fa-solid fa-file"></i> Adjunto 2 <i class="fa-solid fa-arrow-down download-icon"></i></a>
                      <a

                        href="'/storage/' + activeOportunity.proposal.file3"
                        target="_blank"
                        class="file-link"> <i class="fa-solid fa-file"></i> Adjunto 3 <i class="fa-solid fa-arrow-down download-icon"></i></a>
                    </div>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
   
    </div>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    let table = new DataTable('.sales-opportunities-one', {
      // responsive: true,
      dom: '<"top"ilf>rt<"bottom"p><"clear">',
      scrollX: true,
      paging: false,

      rowReorder: {
        selector: 'td:nth-child(2)'
      },
      language: {
        processing: "Procesando...",
        search: "Buscar...",
        lengthMenu: "Mostrar _MENU_ elementos",
        info: "Mostrando de _START_ a _END_ de _TOTAL_ elementos",
        infoEmpty: "Mostrando ningún elemento.",
        infoFiltered: "(filtrado _MAX_ elementos total)",
        infoPostFix: "",
        loadingRecords: "Cargando registros...",
        zeroRecords: "No se encontraron registros",
        emptyTable: "No hay datos disponibles en la tabla",

        aria: {
          sortAscending: ": Activar para ordenar la columna en orden ascendente",
          sortDescending: ": Activar para ordenar la columna en orden descendente",
        },
      },
    });

    let table2 = new DataTable('.sales-opportunities-two ', {
      // responsive: true,
      dom: '<"top"ilf>rt<"bottom"p><"clear">',
      scrollX: true,


      rowReorder: {
        selector: 'td:nth-child(2)'
      },
      language: {
        processing: "Procesando...",
        search: "Buscar...",
        lengthMenu: "Mostrar _MENU_ elementos",
        info: "Mostrando de _START_ a _END_ de _TOTAL_ elementos",
        infoEmpty: "Mostrando ningún elemento.",
        infoFiltered: "(filtrado _MAX_ elementos total)",
        infoPostFix: "",
        loadingRecords: "Cargando registros...",
        zeroRecords: "No se encontraron registros",
        emptyTable: "No hay datos disponibles en la tabla",

        aria: {
          sortAscending: ": Activar para ordenar la columna en orden ascendente",
          sortDescending: ": Activar para ordenar la columna en orden descendente",
        },
      },
    });


  });


  $(document).ready(function() {
    // Inicializa Select2 para ambos
    $("#industry").select2({
      width: "100%",
      placeholder: "Busca una industria",
      dropdownParent: $('#createModal') // si estás dentro de un modal
    });

    $("#segment").select2({
      width: "100%",
      tags: true,
      placeholder: "Seleccione uno o más segmentos",
      dropdownParent: $('#createModal'), // si estás dentro de un modal
      multiple: true
    });

    // Escucha cambio de industria y carga segmentos
    $("#industry").off("change.industry").on("change.industry", async function() {
      const id = $(this).val();
      const $segment = $("#segment");

      // Limpia y muestra mensaje de carga
      $segment.empty().append('<option value="">Cargando…</option>').trigger('change');

      if (!id) return;

      try {
        const resp = await fetch(`/supplier/register/getsegments/?industryId=${id}`);
        const list = await resp.json();

        $segment.empty(); // Limpia opciones anteriores

        // Agrega nuevas opciones
        list.forEach((s) => {
          const option = new Option(s.name, s.id, false, false);
          $segment.append(option);
        });

        $segment.trigger("change"); // actualiza Select2

      } catch (err) {
        console.error(err);
        $segment.html('<option>Error al cargar</option>').trigger('change');
      }
    });
  });
</script>