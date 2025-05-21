<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>
<div class="text-end mb-2 d-none">Haz completado el <span class="completitud" id="completitud2">-%</span> de esta sección</div>
<script>
  const supplierGroupsFromServer = <?= json_encode($this->segments) ?>;
  const industriesFromServer = <?= json_encode($this->list_industry) ?>;
</script>

<form action="/supplier/register/savesegments" method="post" class="supplier-register-form form-bx" id="form-segments">

  <div id="supplierGroupsContainer">

    <!-- Los grupos de industria/segmentos se agregarán dinámicamente aquí -->
  </div>

  <!-- Botón único para agregar nuevas industrias -->
  <div class="row">
    <div class="col-md-5">
      <button type="button" class="btn bg-slate-900 rounded-0 my-2 text-white add-group">
        Agregar industria <i class="fa-solid fa-circle-plus ms-2"></i>
      </button>
    </div>
  </div>

  <div class="d-flex justify-content-center">
    <button type="submit" class="btn bg-orange text-white rounded-0" id="submitForm">
      Guardar Industrias y segmentos
    </button>
  </div>
</form>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const container = document.getElementById("supplierGroupsContainer");

    const industries = Object.entries(industriesFromServer).map(([id, label]) => ({
      id,
      label
    }));

    const supplierGroups = supplierGroupsFromServer.map(group => ({
      industryId: group.industry_id,
      segments: group.segments.map(s => s.segment_id)
    }));

    async function renderInitialGroups() {
      container.innerHTML = "";

      for (let i = 0; i < supplierGroups.length; i++) {
        const {
          industryId,
          segments
        } = supplierGroups[i];

        const groupHtml = `
        <div class="row mb-3" data-group-index="${i}">
          <div class="col-md-5">
            <label class="form-label">Industria <span>*</span></label>
            <select class="form-control industry-select" data-group-index="${i}" required>
              <option></option>
              ${industries.map(ind => 
                `<option value="${ind.id}" ${ind.id == industryId ? 'selected' : ''}>${ind.label}</option>`
              ).join('')}
            </select>
          </div>
          <div class="col-md-5">
            <label class="form-label">Segmentos <span>*</span></label>
            <select class="form-control segments-select" multiple data-group-index="${i}" required>
              <option>Cargando...</option>
            </select>
          </div>
          <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-danger rounded-0  remove-group">
              <i class="fa-solid fa-trash-can"></i>
            </button>
          </div>
        </div>
      `;

        container.insertAdjacentHTML("beforeend", groupHtml);

        // Select2 Industria
        $(`.industry-select[data-group-index="${i}"]`).select2({
          placeholder: "Selecciona una industria",
          allowClear: true
        });

        // Fetch segmentos
        const segmentSelect = $(`.segments-select[data-group-index="${i}"]`);
        try {
          const resp = await fetch(`/supplier/register/getsegments/?industryId=${industryId}`);
          const list = await resp.json();
          segmentSelect.empty();
          list.forEach(s => {
            const selected = segments.includes(s.id);
            const opt = new Option(s.name, s.id, selected, selected);
            segmentSelect.append(opt);
          });
          segmentSelect.select2({
            placeholder: "Selecciona uno o más segmentos",
            allowClear: true
          });
        } catch (err) {

        }
      }
    }

    renderInitialGroups();

    // Eliminar grupo
    container.addEventListener('click', function(e) {
      if (e.target.classList.contains('remove-group')) {
        const group = e.target.closest('[data-group-index]');
        group?.remove();
      }
    });

    const addGroup = document.querySelector('.add-group');
    addGroup.addEventListener('click', async function() {
      const groupIndex = document.querySelectorAll('[data-group-index]').length;

      const groupHtml = `
    <div class="row mb-3" data-group-index="${groupIndex}">
      <div class="col-md-5">
        <label class="form-label">Industria <span>*</span></label>
        <select class="form-control industry-select" data-group-index="${groupIndex}" required>
          <option></option>
          ${industries.map(ind => 
            `<option value="${ind.id}">${ind.label}</option>`
          ).join('')}
        </select>
      </div>
      <div class="col-md-5">
        <label class="form-label">Segmentos <span>*</span></label>
        <select class="form-control segments-select" multiple data-group-index="${groupIndex}" required>
        </select>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button type="button" class="btn btn-danger rounded-0 remove-group">
          <i class="fa-solid fa-trash-can"></i>
        </button>
      </div>
    </div>
  `;

      container.insertAdjacentHTML("beforeend", groupHtml);

      // Inicializa Select2 en industria
      const industrySelect = $(`.industry-select[data-group-index="${groupIndex}"]`);
      industrySelect.select2({
        placeholder: "Selecciona una industria",
        allowClear: true
      });

      // Inicializa Select2 en segmentos
      const segmentSelect = $(`.segments-select[data-group-index="${groupIndex}"]`);
      segmentSelect.select2({

        allowClear: true
      });

      // Evento: cuando se seleccione una industria, cargar segmentos
      industrySelect.on('change', async function() {
        const industryId = $(this).val();
        segmentSelect.empty().append('<option>Cargando...</option>').trigger('change');

        try {
          const resp = await fetch(`/supplier/register/getsegments/?industryId=${industryId}`);
          const list = await resp.json();

          segmentSelect.empty();
          list.forEach(s => {
            const opt = new Option(s.name, s.id, false, false);
            segmentSelect.append(opt);
          });

          segmentSelect.trigger('change'); // refrescar Select2 con nuevas opciones
        } catch (err) {

        }
      });
    });

  });
</script>
<style>  .completitud {
    color: rgb(55, 122, 190);
    font-weight: bold;
  }

  /* Estilos para Select2 */
  .select2-container {
    width: 100% !important;
    /* margin-bottom: .5rem !important; */
    font-size: 13px !important;

  }

  .select2-container--default .select2-selection--multiple {
    border-color: rgb(172, 172, 172) !important;
    border-image: initial !important;
    border-radius: 0.375rem !important;
    font-size: 13px !important;

  }

  .select2-selection--multiple {
    min-height: 38px;
    padding: 5px;
    font-size: 13px !important;

  }

  .select2-container .select2-selection--single {
    height: auto !important;
    border-color: rgb(172, 172, 172) !important;
    border-image: initial !important;
    border-radius: 0.375rem !important;
    font-size: 13px !important;
  }

  /* Estilos para botones */
  .btn.bg-slate-900 {
    background-color: #1e293b;
    color: white;
  }

  .btn.bg-orange {
    background-color: #f97316;
    color: white;
  }

  .btn.rounded-0 {
    border-radius: 0;
  }

  .select2-container--default .select2-search--inline .select2-search__field {
    line-height: auto !important;
  }

</style>