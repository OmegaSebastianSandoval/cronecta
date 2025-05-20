<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>
<div class="text-end mb-2 d-none">Haz completado el <span class="completitud" id="completitud2">-%</span> de esta sección</div>
<form action="" method="post" class="supplier-register-form form-bx">

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
// Variables globales
let supplierGroups = [];
let industries = [];

// Función para inicializar el componente
document.addEventListener('DOMContentLoaded', function() {
  // Cargar industrias al inicio
  // fetchIndustries();

  // Agregar el primer grupo
  addGroup();

  // Cargar grupos existentes
  // fetchGroups();

  // Configurar evento para el botón de enviar
  document.getElementById('submitForm')?.addEventListener('click', submitForm);
  
  // Configurar evento para el botón de agregar (único)
  document.querySelector('.add-group')?.addEventListener('click', addGroup);
});

// Función para cargar industrias desde la API
async function fetchIndustries() {
  try {
    const response = await axios.get("/api/industries");
    industries = response.data;

    // Configurar Select2 para industrias
    $('.industry-select').select2({
      placeholder: "Selecciona una opción",
      allowClear: true,
      data: industries.map(ind => ({
        id: ind.id,
        text: ind.label
      }))
    }).on('change', function(e) {
      const groupIndex = $(this).data('group-index');
      fetchSegments(groupIndex);
    });
  } catch (error) {
    console.error("Error loading industries data:", error);
  }
}

// Función para agregar un nuevo grupo
function addGroup() {
  const groupIndex = supplierGroups.length;
  supplierGroups.push({
    industry: null,
    segments: [],
    industrySegments: [],
    industryError: null,
    segmentsError: null
  });

  // Crear HTML para el nuevo grupo (sin botón de agregar)
  const groupHtml = `
    <div class="row mb-3" data-group-index="${groupIndex}">
      <div class="col-md-5">
        <div class="mb-2">
          <label class="form-label"><span>*</span> Industria</label>
          <select class="form-control industry-select selec-search" data-group-index="${groupIndex}" required>
            <option></option>
          </select>
          <small class="text-danger industry-error" style="display: none;"></small>
        </div>
      </div>

      <div class="col-md-5">
        <div class="mb-2">
          <label class="form-label"><span>*</span> Segmentos</label>
          <select class="form-control segments-select" multiple="multiple" data-group-index="${groupIndex}" required>
            <option></option>
          </select>
          <small class="text-danger segments-error" style="display: none;"></small>
        </div>
      </div>

      <div class="col-md-2 d-flex align-items-center gap-2 pt-1">
        <button type="button" class="btn btn-danger rounded-0 text-white remove-group">
          <i class="fa-solid fa-trash"></i>
        </button>
      </div>
    </div>
  `;

  // Agregar al contenedor
  document.getElementById('supplierGroupsContainer').insertAdjacentHTML('beforeend', groupHtml);

  // Inicializar Select2 para segmentos
  $(`.segments-select[data-group-index="${groupIndex}"]`).select2({
    placeholder: "Selecciona uno o más segmentos",
    allowClear: true
  });

  // Configurar eventos para los botones
  const groupElement = document.querySelector(`[data-group-index="${groupIndex}"]`);
  groupElement.querySelector('.remove-group')?.addEventListener('click', () => removeGroup(groupIndex));
}

// Función para eliminar un grupo
function removeGroup(index) {
  if (supplierGroups.length <= 1) {
    alert("Debe haber al menos un grupo");
    return;
  }

  supplierGroups.splice(index, 1);

  // Reconstruir toda la vista para actualizar los índices
  rebuildView();
}

// Función para reconstruir la vista (necesario después de eliminar)
function rebuildView() {
  const container = document.getElementById('supplierGroupsContainer');
  container.innerHTML = '';

  supplierGroups.forEach((group, index) => {
    const groupHtml = `
      <div class="row mb-3" data-group-index="${index}">
        <div class="col-md-5">
          <div class="mb-2">
            <label class="form-label"><span>*</span> Industria</label>
            <select class="form-control industry-select" data-group-index="${index}" required>
              <option></option>
              ${industries.map(ind => 
                `<option value="${ind.id}" ${group.industry?.id === ind.id ? 'selected' : ''}>${ind.label}</option>`
              ).join('')}
            </select>
            <small class="text-danger industry-error" style="display: none;"></small>
          </div>
        </div>

        <div class="col-md-5">
          <div class="mb-2">
            <label class="form-label"><span>*</span> Segmentos</label>
            <select class="form-control segments-select" multiple="multiple" data-group-index="${index}" required>
              <option></option>
              ${group.industrySegments.map(seg => 
                `<option value="${seg.value}" ${group.segments.some(s => s.value === seg.value) ? 'selected' : ''}>${seg.label}</option>`
              ).join('')}
            </select>
            <small class="text-danger segments-error" style="display: none;"></small>
          </div>
        </div>

        <div class="col-md-2 d-flex align-items-center gap-2 pt-1">
          <button type="button" class="btn btn-danger rounded-0 text-white remove-group">
            <i class="fa-solid fa-trash"></i>
          </button>
        </div>
      </div>
    `;

    container.insertAdjacentHTML('beforeend', groupHtml);

    // Inicializar Select2
    $(`.industry-select[data-group-index="${index}"]`).select2({
      placeholder: "Selecciona una opción",
      allowClear: true,
      data: industries.map(ind => ({
        id: ind.id,
        text: ind.label
      }))
    }).on('change', function(e) {
      fetchSegments(index);
    });

    $(`.segments-select[data-group-index="${index}"]`).select2({
      placeholder: "Selecciona uno o más segmentos",
      allowClear: true
    });

    // Configurar eventos para los botones
    const groupElement = document.querySelector(`[data-group-index="${index}"]`);
    groupElement.querySelector('.remove-group')?.addEventListener('click', () => removeGroup(index));
  });
}

// Función para cargar segmentos de una industria
async function fetchSegments(groupIndex) {
  const selectElement = $(`.industry-select[data-group-index="${groupIndex}"]`);
  const industryId = selectElement.val();

  if (!industryId) {
    supplierGroups[groupIndex].industrySegments = [];
    supplierGroups[groupIndex].segments = [];
    $(`.segments-select[data-group-index="${groupIndex}"]`).empty().trigger('change');
    return;
  }

  try {
    const response = await axios.get(`/api/industry-segments/${industryId}`);
    supplierGroups[groupIndex].industrySegments = response.data.map(seg => ({
      value: seg.id,
      label: seg.label
    }));

    // Actualizar el select de segmentos
    const segmentsSelect = $(`.segments-select[data-group-index="${groupIndex}"]`);
    segmentsSelect.empty();

    response.data.forEach(seg => {
      const option = new Option(seg.label, seg.id, false, false);
      segmentsSelect.append(option);
    });

    // Restaurar selecciones previas si las hay
    const selectedSegments = supplierGroups[groupIndex].segments;
    if (selectedSegments && selectedSegments.length > 0) {
      segmentsSelect.val(selectedSegments.map(s => s.value)).trigger('change');
    }

    segmentsSelect.trigger('change');
  } catch (error) {
    console.error("Error loading segments data:", error);
  }
}

// Función para cargar grupos existentes
async function fetchGroups() {
  try {
    const response = await axios.post(
      "/api/supplier/getIndustriesAndSegments", 
      {},
      {
        headers: {
          "Authorization": `Bearer ${localStorage.getItem("supplier_token")}`
        }
      }
    );

    const fetchedGroups = response.data.industries;

    // Limpiar grupos existentes
    supplierGroups = [];

    // Procesar cada grupo
    for (const group of fetchedGroups) {
      const newGroup = {
        industry: industries.find(ind => ind.id === group.industry_id) || null,
        segments: group.segments.map(seg => ({
          value: seg.segment_id,
          label: seg.segment_name
        })),
        industrySegments: [],
        industryError: null,
        segmentsError: null
      };

      supplierGroups.push(newGroup);

      // Si hay industria, cargar sus segmentos
      if (newGroup.industry) {
        const response = await axios.get(`/api/industry-segments/${newGroup.industry.id}`);
        newGroup.industrySegments = response.data.map(seg => ({
          value: seg.id,
          label: seg.label
        }));
      }
    }

    // Si no hay grupos, agregar uno vacío
    if (supplierGroups.length === 0) {
      addGroup();
    } else {
      // Reconstruir la vista con los grupos cargados
      rebuildView();
    }

    // Actualizar completitud
    updateCompleteness();
  } catch (error) {
    console.error("Error loading groups data:", error);
  }
}

// Función para enviar el formulario
async function submitForm() {
  try {
    // Validar antes de enviar
    if (!validateForm()) {
      return;
    }

    // Preparar datos para enviar
    const payload = {
      groups: supplierGroups.map(group => ({
        industry_id: $(`.industry-select[data-group-index="${supplierGroups.indexOf(group)}"]`).val(),
        segments: $(`.segments-select[data-group-index="${supplierGroups.indexOf(group)}"]`).val() || []
      }))
    };

    // Enviar al servidor
    const response = await axios.post(
      "/api/supplier/updateIndustriesAndSegments",
      payload,
      {
        headers: {
          "Authorization": `Bearer ${localStorage.getItem("supplier_token")}`
        }
      }
    );

    // Mostrar mensaje de éxito
    alert("¡Éxito! " + response.data.message);
  } catch (error) {
    console.error("Error enviando el formulario:", error);
    alert("Error al guardar los datos");
  }
}

// Función para validar el formulario
function validateForm() {
  let isValid = true;

  supplierGroups.forEach((group, index) => {
    const industrySelect = $(`.industry-select[data-group-index="${index}"]`);
    const segmentsSelect = $(`.segments-select[data-group-index="${index}"]`);

    // Validar industria
    if (!industrySelect.val()) {
      $(`.industry-error[data-group-index="${index}"]`).text("Debes seleccionar una industria").show();
      isValid = false;
    } else {
      $(`.industry-error[data-group-index="${index}"]`).hide();
    }

    // Validar segmentos
    if (!segmentsSelect.val() || segmentsSelect.val().length === 0) {
      $(`.segments-error[data-group-index="${index}"]`).text("Debes seleccionar al menos un segmento").show();
      isValid = false;
    } else {
      $(`.segments-error[data-group-index="${index}"]`).hide();
    }
  });

  return isValid;
}

// Función para actualizar el porcentaje de completitud
function updateCompleteness() {
  let filledCount = 0;
  const totalCount = supplierGroups.length * 2; // Industria + segmentos por cada grupo

  supplierGroups.forEach(group => {
    const industrySelected = group.industry !== null;
    const segmentsSelected = group.segments.length > 0;

    if (industrySelected) filledCount++;
    if (segmentsSelected) filledCount++;
  });

  const percentage = Math.round((filledCount / totalCount) * 100);
  document.getElementById('completitud2').textContent = `${percentage}%`;
}

// Configurar eventos para actualizar el modelo cuando cambian las selecciones
$(document).on('change', '.industry-select', function() {
  const groupIndex = $(this).data('group-index');
  const selectedId = $(this).val();
  supplierGroups[groupIndex].industry = industries.find(ind => ind.id == selectedId) || null;
  updateCompleteness();
});

$(document).on('change', '.segments-select', function() {
  const groupIndex = $(this).data('group-index');
  const selectedValues = $(this).val() || [];

  supplierGroups[groupIndex].segments = supplierGroups[groupIndex].industrySegments
    .filter(seg => selectedValues.includes(seg.value.toString()));

  updateCompleteness();
});
</script>

<style>
.completitud {
  color: rgb(55, 122, 190);
  font-weight: bold;
}

/* Estilos para Select2 */
.select2-container {
  width: 100% !important;
  margin-bottom: .5rem !important;
  font-size: 13px !important;

}
.select2-container--default .select2-selection--multiple{
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
.select2-container .select2-selection--single{
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
.select2-container--default .select2-search--inline .select2-search__field{
    line-height: auto !important;
}
</style>