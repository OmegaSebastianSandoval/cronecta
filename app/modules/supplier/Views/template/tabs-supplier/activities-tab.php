<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>

<div class="row">
  <div class="col-12">
    <div class="interests-bx1">
      <div class="col-12">
        <span class="text-lg font-medium text-slate-600">Mis actividades económicas:</span>
      </div>
    </div>
  </div>

  <!-- Búsqueda (oculta por defecto) -->
  <div class="col-md-12 d-none">
    <div class="col-12">
      <div class="d-flex justify-content-center">
        <div class="col-md-6">
          <div class="input-group my-3">
            <button class="input-group-text" id="basic-addon1">
              <i class="fas fa-search"></i>
            </button>
            <!-- v-select sería reemplazado por un select normal o un plugin de selección -->
            <select class="form-control" id="buscador" placeholder="Buscar">
              <!-- Opciones se cargarían dinámicamente -->
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Sección de Sectores -->
  <div class="col-md-12 mt-5">
    <div class="caja_azul">
      <div class="row">
        <div class="col-lg-6">
          <label class="form-label">Seleccione Sector</label>
        </div>
        <div class="col-lg-6 text-end">
          <button type="button" class="btn btn-orange" id="openIndustryModal">
            <i class="fa-solid fa-pen-to-square"></i>
          </button>
        </div>
      </div>
    </div>

    <div class="caja_gris" id="selectedIndustriesContainer">
      <!-- Sectores seleccionados aparecerán aquí -->
    </div>
  </div>

  <!-- Sección de Segmentos -->
  <div class="col-md-12">
    <div class="caja_azul">
      <div class="row">
        <div class="col-lg-6">
          <label class="form-label">Seleccione Segmentos</label>
        </div>
        <div class="col-lg-6 text-end">
          <button type="button" class="btn btn-orange" id="openSegmentModal">
            <i class="fa-solid fa-pen-to-square"></i>
          </button>
        </div>
      </div>
    </div>

    <div class="caja_gris" id="selectedSegmentsContainer">
      <!-- Segmentos seleccionados aparecerán aquí -->
    </div>
  </div>

  <!-- Sección de Familias -->
  <div class="col-md-12">
    <div class="caja_azul">
      <div class="row">
        <div class="col-lg-6">
          <label class="form-label">Seleccione Familia</label>
        </div>
        <div class="col-lg-6 text-end">
          <button type="button" class="btn btn-orange" id="openFamilyModal">
            <i class="fa-solid fa-pen-to-square"></i>
          </button>
        </div>
      </div>
    </div>

    <div class="caja_gris" id="selectedFamiliesContainer">
      <!-- Familias seleccionadas aparecerán aquí -->
    </div>
  </div>

  <!-- Sección de Clases -->
  <div class="col-md-12">
    <div class="caja_azul">
      <div class="row">
        <div class="col-lg-6">
          <label class="form-label">Seleccione Clase</label>
        </div>
        <div class="col-lg-6 text-end">
          <button type="button" class="btn btn-orange" id="openClassModal">
            <i class="fa-solid fa-pen-to-square"></i>
          </button>
        </div>
      </div>
    </div>

    <div class="caja_gris" id="selectedClassesContainer">
      <!-- Clases seleccionadas aparecerán aquí -->
    </div>
  </div>

  <!-- Sección de Productos -->
  <div class="col-md-12">
    <div class="caja_azul">
      <div class="row">
        <div class="col-lg-6">
          <label class="form-label">Seleccione Producto</label>
        </div>
        <div class="col-lg-6 text-end">
          <button type="button" class="btn btn-orange" id="openProductModal">
            <i class="fa-solid fa-pen-to-square"></i>
          </button>
        </div>
      </div>
    </div>

    <div class="caja_gris" id="selectedProductsContainer">
      <!-- Productos seleccionados aparecerán aquí -->
    </div>
  </div>
</div>

<!-- MODALES -->
<!-- Modal de Industrias -->
<div class="modal cv-modal fade" id="industryModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-dismiss="modal"></button>

        <div class="caja_azul">
          <h2 class="form-label">Seleccionar industrias</h2>
        </div>

        <div class="caja_gris">
          <div class="row mt-2" id="industriesList">
            <!-- Industrias se cargarán aquí -->
          </div>

          <div align="center" class="mt-5 mb-2">
            <button type="button" class="btn btn-primary" id="addIndustries">Agregar</button>
          </div>
        </div>

        <div class="caja_azul mt-3">
          <h2 class="form-label">Industrias seleccionadas</h2>
        </div>

        <div class="caja_gris min60">
          <div id="selectedIndustriesModal" class="mt-2">
            <!-- Industrias seleccionadas aparecerán aquí -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Segmentos -->
<div class="modal cv-modal fade" id="segmentModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl ancho100" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-dismiss="modal"></button>

        <div class="caja_azul">
          <h2 class="form-label">Seleccionar segmentos</h2>
        </div>

        <div class="caja_gris">
          <div class="input-group my-3">
            <button class="input-group-text" id="searchSegmentBtn">
              <i class="fas fa-search"></i>
            </button>
            <input type="text" class="form-control py-2" placeholder="Buscar" id="inputSegmentSearch">
          </div>

          <div class="row mt-2" id="segmentsList">
            <!-- Segmentos se cargarán aquí -->
          </div>

          <div align="center" class="mt-5">
            <button type="button" class="btn btn-primary" id="addSegments">Agregar</button>
          </div>
        </div>

        <div class="caja_azul mt-3">
          <h2 class="form-label">Segmentos seleccionados</h2>
        </div>
        <div class="caja_gris min60">
          <div id="selectedSegmentsModal" class="mt-2">
            <!-- Segmentos seleccionados aparecerán aquí -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Familias -->
<div class="modal cv-modal fade" id="familyModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl ancho100" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-dismiss="modal"></button>

        <div class="caja_azul">
          <h2 class="form-label">Seleccionar familia</h2>
        </div>

        <div class="caja_gris">
          <div class="input-group my-3">
            <button class="input-group-text" id="searchFamilyBtn">
              <i class="fas fa-search"></i>
            </button>
            <input type="text" class="form-control py-2" placeholder="Buscar" id="inputFamilySearch">
          </div>

          <div class="row mt-2" id="familiesList">
            <!-- Familias se cargarán aquí -->
          </div>

          <div align="center" class="mt-5">
            <button type="button" class="btn btn-primary" id="addFamilies">Agregar</button>
          </div>
        </div>

        <div class="caja_azul mt-3">
          <h2 class="form-label">Familias seleccionadas</h2>
        </div>
        <div class="caja_gris min60">
          <div id="selectedFamiliesModal" class="mt-2">
            <!-- Familias seleccionadas aparecerán aquí -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Clases -->
<div class="modal cv-modal fade" id="classModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl ancho100" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-dismiss="modal"></button>

        <div class="caja_azul">
          <h2 class="form-label">Seleccionar clase</h2>
        </div>

        <div class="caja_gris">
          <div class="input-group my-3">
            <button class="input-group-text" id="searchClassBtn">
              <i class="fas fa-search"></i>
            </button>
            <input type="text" class="form-control py-2" placeholder="Buscar" id="inputClassSearch">
          </div>

          <div class="row mt-2" id="classesList">
            <!-- Clases se cargarán aquí -->
          </div>

          <div align="center" class="mt-5">
            <button type="button" class="btn btn-primary" id="addClasses">Agregar</button>
          </div>
        </div>

        <div class="caja_azul mt-3">
          <h2 class="form-label">Clases seleccionadas</h2>
        </div>
        <div class="caja_gris min60">
          <div id="selectedClassesModal" class="mt-2">
            <!-- Clases seleccionadas aparecerán aquí -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Productos -->
<div class="modal cv-modal fade" id="productModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl ancho100" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-dismiss="modal"></button>

        <div class="caja_azul">
          <h2 class="form-label">Seleccionar producto</h2>
        </div>
        <div class="caja_gris">
          <div class="input-group my-3">
            <button class="input-group-text" id="searchProductBtn">
              <i class="fas fa-search"></i>
            </button>
            <input type="text" class="form-control py-2" placeholder="Buscar" id="inputProductSearch">
          </div>

          <div class="row mt-2" id="productsList">
            <!-- Productos se cargarán aquí -->
          </div>

          <div align="center" class="mt-5">
            <button type="button" class="btn btn-primary" id="addProducts">Agregar</button>
          </div>
        </div>
        <div class="caja_azul mt-3">
          <h2 class="form-label">Productos seleccionados</h2>
        </div>
        <div class="caja_gris min60">
          <div id="selectedProductsModal" class="mt-2">
            <!-- Productos seleccionados aparecerán aquí -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Backdrop para modales -->
<div class="modal-backdrop fade" id="modalBackdrop" style="display: none;"></div>

<script>
  // Implementación básica de la funcionalidad
  document.addEventListener('DOMContentLoaded', function() {
    // Variables para almacenar selecciones
    let selectedIndustries = [];
    let selectedSegments = [];
    let selectedFamilies = [];
    let selectedClasses = [];
    let selectedProducts = [];

    // Función para mostrar un modal
    function showModal(modalId) {
      const modal = new bootstrap.Modal(document.getElementById(modalId));
      modal.show();
      /* document.getElementById(modalId).style.display = 'block';
      document.getElementById('modalBackdrop').style.display = 'block';
      document.body.classList.add('modal-open'); */
    }

    // Función para ocultar un modal
    function hideModal(modalId) {
      const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
      modal.hide();
      /* document.getElementById(modalId).style.display = 'none';
      document.getElementById('modalBackdrop').style.display = 'none';
      document.body.classList.remove('modal-open'); */
    }

    // Event listeners para abrir modales
    document.getElementById('openIndustryModal').addEventListener('click', function() {

      showModal('industryModal');
      // Aquí se cargarían las industrias desde el servidor
    });

    document.getElementById('openSegmentModal').addEventListener('click', function() {
      showModal('segmentModal');
      // Aquí se cargarían los segmentos desde el servidor
    });

    document.getElementById('openFamilyModal').addEventListener('click', function() {
      showModal('familyModal');
      // Aquí se cargarían las familias desde el servidor
    });

    document.getElementById('openClassModal').addEventListener('click', function() {
      showModal('classModal');
      // Aquí se cargarían las clases desde el servidor
    });

    document.getElementById('openProductModal').addEventListener('click', function() {
      showModal('productModal');
      // Aquí se cargarían los productos desde el servidor
    });

    // Event listeners para cerrar modales
    const closeButtons = document.querySelectorAll('.btn-close');
    closeButtons.forEach(button => {
      button.addEventListener('click', function() {
        const modal = this.closest('.modal');
        hideModal(modal.id);
      });
    });

    // Función para renderizar elementos seleccionados
    function renderSelectedItems(containerId, items, type) {
      const container = document.getElementById(containerId);
      container.innerHTML = '';

      items.forEach(item => {
        const badge = document.createElement('span');
        badge.className = 'badge rounded-pill text-dark border-2 border-info interest1 me-1 mb-2';
        badge.innerHTML = `${item.name} <i class="fa fa-times" data-id="${item.id}" data-type="${type}"></i>`;
        container.appendChild(badge);
      });

      // Agregar event listeners a los botones de eliminar
      container.querySelectorAll('.fa-times').forEach(icon => {
        icon.addEventListener('click', function() {
          const id = this.getAttribute('data-id');
          const type = this.getAttribute('data-type');
          removeItem(id, type);
        });
      });
    }

    // Función para eliminar un item
    function removeItem(id, type) {
      if (confirm('¿Estás seguro de eliminar este elemento?')) {
        // Aquí se haría una llamada AJAX para eliminar el elemento del servidor
        // y luego actualizar la lista correspondiente

        // Ejemplo para industrias:
        if (type === 'industry') {
          selectedIndustries = selectedIndustries.filter(item => item.id !== id);
          renderSelectedItems('selectedIndustriesContainer', selectedIndustries, 'industry');
          renderSelectedItems('selectedIndustriesModal', selectedIndustries, 'industry');
        }
        // Implementar similar para los otros tipos...
      }
    }

    // Implementar funciones similares para segmentos, familias, clases y productos
    // Implementar funciones para buscar en cada modal
    // Implementar funciones para agregar selecciones

    // Cargar datos iniciales
    // fetchInitialData();
  });

  // Estilos (los mismos que en el original)
</script>
<style>
  .interests-bx {
    padding: 15px;
    border: 1px solid #20469730;
    border-radius: 5px;
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
  }

  .interest {
    background-color: #20469730;
    color: #204697;
    border: 1px solid #204697;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: 300ms ease;
  }

  .interest i:hover {
    color: red;
    cursor: pointer;
    transition: 300ms ease;
  }


  .form-select option {
    padding: 10px 10px;
  }

  .btn-orange {
    color: #f77904;
    color: #FFFFFF;
    margin-top: -1px;
  }

  .btn-orange i {
    font-size: 20px;
  }

  .btn-primary {
    background: #23366c;
    color: #FFFFFF;
  }

  .form-check-input {
    margin-top: 0px;
  }

  .border-info {
    --bs-border-opacity: 1;
    /*border-color: rgba(var(--bs-info-rgb),var(--bs-border-opacity)) !important;*/
    border: solid 2px;
    margin-right: 5px;
  }

  .top4 {
    top: 4px !important;
  }

  .ancho100 {
    max-width: 97%;
  }

  .interest1 {
    background-color: #20469730 !important;
    color: #204697 !important;
    border: 1px solid #204697 !important;
  }

  .interest1 i {
    vertical-align: text-bottom;
    font-size: 14px;
  }

  .swal2-confirm,
  .swal2-deny,
  .swal2-cancel {
    color: #FFFFFF !important;
  }

  .caja_azul {
    border: 1px solid #f77904;
    background: #f77904;
    color: #FFFFFF;
    padding: 0px 10px;
    height: 33px;
  }

  .caja_azul .form-label {
    color: #FFFFFF;
    margin-top: 3px;
  }

  .modal-body .caja_azul .form-label {
    margin-top: 5px;
  }

  .caja_gris {
    border: 1px solid #e2e8f0;
    /*gris*/
    padding: 5px 10px;
    margin-bottom: 20px;
    min-height: 46px;
    padding-top: 10px;
    color: #575555;
  }

  .min60 {
    min-height: 60px;
  }

  .cv-modal .modal-content .modal-body .btn-close {
    top: 20px;
  }

  .modal-content .modal-body .btn-close {
    position: absolute;
    right: 20px;
    filter: invert(1);
    opacity: 0.8;

  }

  .modal-body .form-check-input {
    margin-top: 4px;
  }

  .modal-body .input-group-text {
    height: 42px;
  }
</style>