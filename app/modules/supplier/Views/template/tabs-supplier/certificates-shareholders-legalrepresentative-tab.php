<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>
<?php
/* echo "<pre>";
print_r($this->supplier);
echo "</pre>"; */
?>

<div class="text-end mb-2 div_completitud">Haz completado el <span class="completitud" id="completitud4">-%</span> de esta sección</div>


<form id="certificates-shareholders-form" class="supplier-register-form form-bx" method="POST" action="/supplier/profile/savecertificates" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?= $this->supplier->id ?>">
  <input type="hidden" name="id-user" value="<?= $this->userSupplier->id ?>">
  <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
  <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">

  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Certificado de existencia representación legal</span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div>

  <div class="row">

    <div class="col-12 col-md-3">
      <div class="mb-3">
        <label for="certificate_issue_date" class="form-label">Fecha expedición certificado <span>*</span></label>
        <input type="date" class="form-control" id="certificate_issue_date" max="<?= date('Y-m-d') ?>" min="1950-01-01" name="certificate_issue_date" value="<?= $this->supplier->certificate_issue_date ?>" required />
      </div>
    </div>

    <div class="col-12 col-md-3">
      <div class="mb-3">
        <label for="company_date" class="form-label">Fecha de constitución de la empresa <span>*</span></label>
        <input type="date" class="form-control" id="company_date" name="company_date" value="<?= $this->supplier->company_date ?>" max="<?= date('Y-m-d') ?>" required />
      </div>
    </div>

    <div class="col-12 col-md-3">
      <div class="mb-3">
        <label for="company_validity" class="form-label">Fecha de expiración de la sociedad <span>*</span></label>
        <input type="date" class="form-control" id="company_validity" name="company_validity" value="<?= $this->supplier->company_validity ?>" <?= $this->supplier->company_validity2 && !$this->supplier->company_validity ? 'disabled' : '' ?> />
      </div>
    </div>

    <div class="col-12 col-md-3" id="company_validity-wrapper">
      <div class="mb-3 mt-4">
        <label for="company_validity2" class="form-label"></label>
        <input type="checkbox" class="form-control1" id="company_validity2" name="company_validity2" <?= $this->supplier->company_validity2 ? 'checked' : '' ?> />
        Vigencia indefinida
      </div>
    </div>
  </div>

  <script>
    const selectedCountryExist = decodeHtml("<?= $this->supplier->registry_country ?>");
    const selectedStateExist = decodeHtml("<?= $this->supplier->registry_state ?>");
    const selectedCityExist = decodeHtml("<?= $this->supplier->registry_city ?>");
  </script>
  <div class="row">
    <div class="col-12 col-md-4" id="registry_country-cert-exist-wrapper">
      <div class="mb-3">
        <label for="registry_country" class="form-label">País de registro<span>*</span></label>
        <select class="form-control" id="registry_country-cert-exist" name="registry_country" required>
            <option value="Colombia">Colombia</option>
            <option class="separador" disabled>____________________________</option>
          <?php foreach ($this->list_country as $c): ?>
            <option value="<?= $c['name'] ?>" <?= ($this->supplier->registry_country == $c['name']) ? 'selected' : '' ?>><?= $c['name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="col-12 col-md-4" id="registry_state-cert-exist-wrapper">
      <div class="mb-3">
        <label for="registry_state" class="form-label">Departamento/Estado de registro<span>*</span></label>
        <select class="form-control" id="registry_state-cert-exist" name="registry_state" required>
          <option value="" disabled selected>Seleccione un estado</option>
          <?php if (isset($this->list_states) && !empty($this->list_states)): ?>
            <?php foreach ($this->list_states as $s): ?>
              <option value="<?= $s['name'] ?>" <?= ($this->supplier->registry_state == $s['name']) ? 'selected' : '' ?>><?= $s['name'] ?></option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>
    </div>

    <div class="col-12 col-md-4" id="registry_city-cert-exist-wrapper">
      <div class="mb-3">
        <label for="registry_city" class="form-label">Ciudad de registro <span>*</span></label>
        <select class="form-control" id="registry_city-cert-exist" name="registry_city" required>
          <option value="" selected>Seleccione una ciudad</option>
          <?php if (isset($this->list_cities) && !empty($this->list_cities)): ?>
            <?php foreach ($this->list_cities as $c): ?>
              <option value="<?= $c['name'] ?>" <?= ($this->supplier->registry_city == $c['name']) ? 'selected' : '' ?>><?= $c['name'] ?></option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>
    </div>

    <div class="col-md-4">
      <div class="mb-3">
        <label for="certificate_issue_name" class="form-label">Nombre del documento <span>*</span></label>
        <input type="text" class="form-control" id="certificate_issue_name" name="certificate_issue_name" value="<?= $this->supplier->certificate_issue_name ?>" required />
      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3">
        <label for="trade_registry" class="form-label">Adjuntar documento</label>
        <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control d-none" id="trade_registry" name="trade_registry" onchange="$('#trade_registry_file').val(this.value.replace('C:\\fakepath\\',''));" />

        <div class="input-group">
          <div class="input-group-prepend div-examinar">
            <button class="btn boton-examinar" type="button" onclick="$('#trade_registry').click();">Examinar</button>
          </div>
          <input id="trade_registry_file" readonly type="text" class="form-control campo-examinar" onclick="$('#trade_registry').click();"<?php if($this->supplier->trade_registry==""){ echo 'value="Seleccione un archivo"'; } else { echo 'value="'.$this->supplier->trade_registry.'"'; } ?> />
        </div>

      </div>
    </div>
    <div class="col-md-2">
      <div id="trade-registry-download-container" class="mb-3">
        <?php if ($this->supplier->trade_registry && file_exists(FILE_PATH . $this->supplier->trade_registry)) { ?>
          <a href="/files/<?= $this->supplier->trade_registry ?>" target="_blank" class="btn bg-blue text-white rounded-0 mt-4 download-btn" data-file-type="trade_registry">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        <?php } ?>
      </div>
    </div>


  </div>

  <!-- Sección de Certificado RUT -->
  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Certificado del Registro Único Tributario (RUT) / Tax Id</span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 col-md-4">
      <div class="mb-3">
        <label for="rut_certificate_name" class="form-label">Entidad que lo expide <span>*</span></label>
        <input type="text" class="form-control" id="rut_certificate_name" name="rut_certificate_name" value="<?= $this->supplier->rut_certificate_name ?>" required />
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="mb-3">
        <label for="rut_certificate" class="form-label">Adjuntar documento</label>
        <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control" id="rut_certificate" name="rut_certificate" onchange="$('#rut_certificate_file').val(this.value.replace('C:\\fakepath\\',''));" />

        <div class="input-group">
          <div class="input-group-prepend div-examinar">
            <button class="btn boton-examinar" type="button" onclick="$('#rut_certificate').click();">Examinar</button>
          </div>
          <input id="rut_certificate_file" readonly type="text" class="form-control campo-examinar" onclick="$('#rut_certificate').click();"<?php if($this->supplier->rut_certificate==""){ echo 'value="Seleccione un archivo"'; } else { echo 'value="'.$this->supplier->rut_certificate.'"'; } ?> />
        </div>

      </div>
    </div>

    <div class="col-12 col-md-2 ">
      <div id="rut-certificate-download-container" class="mb-3">
        <?php if ($this->supplier->rut_certificate && file_exists(FILE_PATH . $this->supplier->rut_certificate)) { ?>
          <a href="/files/<?= $this->supplier->rut_certificate ?>" target="_blank" class="btn bg-blue text-white rounded-0 mt-4 download-btn" data-file-type="rut_certificate">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        <?php } ?>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="mb-3">
        <label for="rut_certificate_date_expedition" class="form-label">Fecha de expedición del documento <span>*</span></label>
        <input type="date" class="form-control" id="rut_certificate_date_expedition" max="<?= date('Y-m-d') ?>" min="1950-01-01" name="rut_certificate_date_expedition" value="<?= $this->supplier->rut_certificate_date_expedition ?>" />
      </div>
    </div>
  </div>
  <script>
    const selectedCountryRut = decodeHtml("<?= $this->supplier->rut_certificate_country ?>");
    const selectedStateRut = decodeHtml("<?= $this->supplier->rut_certificate_state ?>");
    const selectedCityRut = decodeHtml("<?= $this->supplier->rut_certificate_city ?>");
  </script>
  <div class="row">
    <div class="col-12 col-md-4" id="rut_certificate_country-wrapper">
      <div class="mb-3">
        <label for="rut_certificate_country" class="form-label">País<span>*</span></label>
        <select class="form-control" id="rut_certificate_country" name="rut_certificate_country" required>
            <option value="Colombia">Colombia</option>
            <option class="separador" disabled>____________________________</option>
          <?php foreach ($this->list_country as $c): ?>
            <option value="<?= $c['name'] ?>" <?= ($this->supplier->rut_certificate_country == $c['name']) ? 'selected' : '' ?>><?= $c['name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="col-12 col-md-4" id="rut_certificate_state-wrapper">
      <div class="mb-3">
        <label for="rut_certificate_state" class="form-label">Departamento/Estado de registro<span>*</span></label>
        <select class="form-control" id="rut_certificate_state" name="rut_certificate_state" required>
          <option value="" selected>Seleccione un estado</option>
          <?php if (isset($this->list_states) && !empty($this->list_states)): ?>
            <?php foreach ($this->list_states as $s): ?>
              <option value="<?= $s['name'] ?>" <?= ($this->supplier->rut_certificate_state == $s['name']) ? 'selected' : '' ?>><?= $s['name'] ?></option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>
    </div>

    <div class="col-12 col-md-4" id="rut_certificate_city-wrapper">
      <div class="mb-3">
        <label for="rut_certificate_city" class="form-label">Ciudad<span>*</span></label>
        <select class="form-control" id="rut_certificate_city" name="rut_certificate_city" required>
          <option value="" selected>Seleccione una ciudad</option>
          <?php if (isset($this->list_cities) && !empty($this->list_cities)): ?>
            <?php foreach ($this->list_cities as $c): ?>
              <option value="<?= $c['name'] ?>" <?= ($this->supplier->rut_certificate_city == $c['name']) ? 'selected' : '' ?>><?= $c['name'] ?></option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>
    </div>
  </div>

  <!-- Sección de Accionistas -->
  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Accionistas</span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div>

  <div id="shareholdersContainer">
    <!-- Los accionistas se agregarán dinámicamente aquí -->
  </div>

  <button type="button" class="btn btn-secondary mb-3 text-white" id="addShareholderBtn">
    Agregar accionista
  </button>

  <!-- Sección de Representante Legal -->
  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Representante legal principal</span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-3">
      <div class="mb-3">
        <label for="representative_name" class="form-label">Nombre del representante <span>*</span></label>
        <input type="text" class="form-control" id="representative_name" name="representative_name" value="<?= $this->supplier->representative_name ?>" required />
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_type" class="form-label">Tipo de documento <span>*</span></label>
        <select class="form-control" id="document_type" name="document_type" required>
          <option value="CC" <?= $this->supplier->document_type == 'CC' ? 'selected' : '' ?>>Cédula de Ciudadanía</option>
          <option value="CE" <?= $this->supplier->document_type == 'CE' ? 'selected' : '' ?>>Cédula de Extranjería</option>
          <option value="TI" <?= $this->supplier->document_type == 'TI' ? 'selected' : '' ?>>Tarjeta de Identidad</option>
          <option value="PASAPORTE" <?= $this->supplier->document_type == 'PASAPORTE' ? 'selected' : '' ?>>Pasaporte</option>
          <option value="PPT" <?= $this->supplier->document_type == 'PPT' ? 'selected' : '' ?>>Permiso de Protección Temporal</option>
        </select>
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_number" class="form-label">Número de documento <span>*</span></label>
        <input type="text" class="form-control only_numbers" id="document_number" name="document_number" value="<?= $this->supplier->document_number ?>" required />
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_issue_place" class="form-label">Lugar de expedición <span>*</span></label>
        <input type="text" class="form-control" id="document_issue_place" name="document_issue_place" value="<?= $this->supplier->document_issue_place ?>" required />
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_issue_date" class="form-label">Fecha de expedición <span>*</span></label>
        <input type="date" class="form-control" id="document_issue_date" name="document_issue_date" max="<?= date('Y-m-d') ?>" min="1950-01-01" value="<?= $this->supplier->document_issue_date ?>" required />
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="representative_birth_country" class="form-label">Nacionalidad <span>*</span></label>
        <select class="form-control" id="representative_birth_country" name="representative_birth_country" required>
            <option value="Colombia">Colombia</option>
            <option class="separador" disabled>____________________________</option>
          <?php foreach ($this->list_country as $c): ?>
            <option value="<?= $c['name'] ?>" <?= ($this->supplier->representative_birth_country == $c['name']) ? 'selected' : '' ?>><?= $c['name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="col-md-4">
      <div class="mb-3">
        <label for="legal_representative_id" class="form-label">Copia de documento de identidad</label>
        <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control" id="legal_representative_id" name="legal_representative_id" onchange="$('#legal_representative_id_file').val(this.value.replace('C:\\fakepath\\',''));" />

        <div class="input-group">
          <div class="input-group-prepend div-examinar">
            <button class="btn boton-examinar" type="button" onclick="$('#legal_representative_id').click();">Examinar</button>
          </div>
          <input id="legal_representative_id_file" readonly type="text" class="form-control campo-examinar" onclick="$('#legal_representative_id').click();"<?php if($this->supplier->legal_representative_id==""){ echo 'value="Seleccione un archivo"'; } else { echo 'value="'.$this->supplier->legal_representative_id.'"'; } ?> />
        </div>

      </div>
    </div>

    <div class="col-md-2">
      <div id="legal-representative-download-container" class="mb-3">
        <?php if ($this->supplier->legal_representative_id && file_exists(FILE_PATH . $this->supplier->legal_representative_id)) { ?>
          <a href="/files/<?= $this->supplier->legal_representative_id ?>" target="_blank" class="btn bg-blue text-white rounded-0 mt-4 download-btn" data-file-type="legal_representative_id">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        <?php } ?>
      </div>
    </div>
  </div>

  <!-- Sección de Representante Legal Suplente -->
  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Representante legal suplente</span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-3">
      <div class="mb-3">
        <label for="representative_name2" class="form-label">Nombre del representante legal suplente<span>*</span></label>
        <input type="text" class="form-control" id="representative_name2" name="representative_name2" value="<?= $this->supplier->representative_name2 ?>" required />
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_type2" class="form-label">Tipo de documento <span>*</span></label>
        <select class="form-control" id="document_type2" name="document_type2" required>
          <option value="CC" <?= $this->supplier->document_type2 == 'CC' ? 'selected' : '' ?>>Cédula de Ciudadanía</option>
          <option value="CE" <?= $this->supplier->document_type2 == 'CE' ? 'selected' : '' ?>>Cédula de Extranjería</option>
          <option value="TI" <?= $this->supplier->document_type2 == 'TI' ? 'selected' : '' ?>>Tarjeta de Identidad</option>
          <option value="PASAPORTE" <?= $this->supplier->document_type2 == 'PASAPORTE' ? 'selected' : '' ?>>Pasaporte</option>
          <option value="PPT" <?= $this->supplier->document_type2 == 'PPT' ? 'selected' : '' ?>>Permiso de Protección Temporal</option>
        </select>
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_number2" class="form-label">Número de documento <span>*</span></label>
        <input type="text" class="form-control" id="document_number2" name="document_number2" value="<?= $this->supplier->document_number2 ?>" required />
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_issue_place2" class="form-label">Lugar de expedición <span>*</span></label>
        <input type="text" class="form-control" id="document_issue_place2" name="document_issue_place2" value="<?= $this->supplier->document_issue_place2 ?>" required />
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_issue_date2" class="form-label">Fecha de expedición <span>*</span></label>
        <input type="date" class="form-control" id="document_issue_date2" name="document_issue_date2" max="<?= date('Y-m-d') ?>" min="1950-01-01" value="<?= $this->supplier->document_issue_date2 ?>" required />
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="representative_birth_country2" class="form-label">Nacionalidad <span>*</span></label>
        <select class="form-control" id="representative_birth_country2" name="representative_birth_country2" required>
            <option value="Colombia">Colombia</option>
            <option class="separador" disabled>____________________________</option>
          <?php foreach ($this->list_country as $c): ?>
            <option value="<?= $c['name'] ?>" <?= ($this->supplier->representative_birth_country2 == $c['name']) ? 'selected' : '' ?>><?= $c['name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="col-md-4">
      <div class="mb-3">
        <label for="legal_representative_id2" class="form-label">Copia de documento de identidad</label>
        <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control d-none" id="legal_representative_id2" name="legal_representative_id2" onchange="$('#brochure_file').val(this.value.replace('C:\\fakepath\\',''));" />

        <div class="input-group">
          <div class="input-group-prepend div-examinar">
            <button class="btn boton-examinar" type="button" onclick="$('#legal_representative_id2').click();">Examinar</button>
          </div>
          <input id="legal_representative_id2_file" readonly type="text" class="form-control campo-examinar" onclick="$('#legal_representative_id2').click();"<?php if($this->supplier->legal_representative_id2==""){ echo 'value="Seleccione un archivo"'; } else { echo 'value="'.$this->supplier->legal_representative_id2.'"'; } ?> />
        </div>

      </div>
    </div>

    <div class="col-md-2">
      <div id="legal-representative2-download-container" class="mb-3">
        <?php if ($this->supplier->legal_representative_id2 && file_exists(FILE_PATH . $this->supplier->legal_representative_id2)) { ?>
          <a href="/files/<?= $this->supplier->legal_representative_id2 ?>" target="_blank" class="btn bg-blue text-white rounded-0 mt-4 download-btn" data-file-type="legal_representative_id2">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        <?php } ?>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-center">
    <button type="submit" class="bg-orange text-white rounded-0">Guardar información</button>
  </div>
</form>

<script>
  // Array para almacenar los accionistas
  let shareholders = [];

  // Función para inicializar select2 en los campos de país
  function initializeCountrySelect2(element) {
    $(element).select2({
     
      placeholder: 'Seleccione un país',
      allowClear: true,
      language: {
        noResults: function() {
          return "No se encontraron resultados";
        },
        searching: function() {
          return "Buscando...";
        }
      }
    });
  }

  // Función para agregar un nuevo accionista
  function addShareholder(data = null) {
    const shareholderId = shareholders.length;
    const shareholder = {
      name: data?.name || '',
      id_type: data?.id_type || '',
      id_number: data?.id_number || '',
      percentage: data?.percentage || '',
      country: data?.country || '',
      is_legal_entity: data?.is_legal_entity || '1',
      counterparty_type: data?.counterparty_type || '1',
      status: data?.status || '1',
      isPEP: data?.isPEP || '0',
      shareholder_document: data?.shareholder_document || null,
      pep_document: data?.pep_document || null,
      place_expedition: data?.place_expedition || '',
      id_date: data?.id_date || '',
      shareholder_document_date: data?.shareholder_document_date || ''
    };
    shareholders.push(shareholder);

    // Crear el HTML para el nuevo accionista
    const shareholderHtml = `
    <div class="mb-3" data-shareholder-id="${shareholderId}">
      <div class="row">
        <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">Tipo de persona <span>*</span></label>
            <select class="form-control" name="shareholders[${shareholderId}][is_legal_entity]" required>
              <option value="1" ${data?.is_legal_entity === '1' ? 'selected' : ''}>Persona Natural</option>
              <option value="2" ${data?.is_legal_entity === '2' ? 'selected' : ''}>Persona Jurídica</option>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">Nombre completo del accionista <span>*</span></label>
            <input type="text" class="form-control" name="shareholders[${shareholderId}][name]" value="${data?.name || ''}" required />
          </div>
        </div>
        
        <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">Tipo de identificación <span>*</span></label>
            <select class="form-control" name="shareholders[${shareholderId}][id_type]" required>
              <option value="" disabled >Seleccione un tipo de identificación</option>
              <option value="CC" ${data?.id_type == 'CC' ? 'selected' : ''}>Cédula de Ciudadanía</option>
              <option value="NIT" ${data?.id_type == 'NIT' ? 'selected' : ''}>NIT</option>
              <option value="CE" ${data?.id_type == 'CE' ? 'selected' : ''}>Cédula de Extranjería</option>
              <option value="TI" ${data?.id_type == 'TI' ? 'selected' : ''}>Tarjeta de Identidad</option>
              <option value="PASAPORTE" ${data?.id_type == 'PASAPORTE' ? 'selected' : ''}>Pasaporte</option>
              <option value="PPT" ${data?.id_type == 'PPT' ? 'selected' : ''}>Permiso de Protección Temporal</option>
            </select>
          </div>
        </div>
        
        <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">Número de identificación <span>*</span></label>
            <input type="text" class="form-control only_numbers" name="shareholders[${shareholderId}][id_number]" value="${data?.id_number || ''}" required />
          </div>
        </div>
        <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">Lugar de expedición <span>*</span></label>
            <input type="text" class="form-control" name="shareholders[${shareholderId}][place_expedition]" value="${data?.place_expedition || ''}" required />
          </div>
        </div>
        <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">Fecha de expedición <span>*</span></label>
            <input type="date" class="form-control" name="shareholders[${shareholderId}][id_date]" max="${new Date().toISOString().split('T')[0]}" value="${data?.id_date || ''}" required />
          </div>
        </div>
               
        <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">Nacionalidad <span>*</span></label>
            <select class="form-control country-select" name="shareholders[${shareholderId}][country]" required>
            <option value="Colombia">Colombia</option>
            <option class="separador" disabled>____________________________</option>
              <?php foreach ($this->list_country as $c): ?>
                <option value="<?= $c['name'] ?>" ${data?.country === "<?= addslashes($c['name']) ?>" ? 'selected' : ''}><?= $c['name'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">% de Participación <span>*</span></label>
            <input type="number" class="form-control" name="shareholders[${shareholderId}][percentage]" min="0" max="100" value="${data?.percentage || ''}" required />
          </div>
        </div>
         <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">Es persona expuesta políticamente (PEP) <span>*</span></label>
            <select class="form-control pep-select" name="shareholders[${shareholderId}][isPEP]" required>
              <option value="" disabled selected>Seleccione una opción</option>
              <option value="1" ${data?.isPEP === '1' ? 'selected' : ''}>Sí</option>
              <option value="0" ${data?.isPEP === '0' ? 'selected' : ''}>No</option>
            </select>
          </div>
        </div>
        
        <div class="col-md-3 pep-document-container" style="display: ${data?.isPEP === '1' ? 'block' : 'none'}">
          <div class="mb-3">
            <label class="form-label">Documento adjunto PEP</label>
            <input type="file" class="form-control" name="shareholders[${shareholderId}][pep_document]" 
              accept="application/pdf, image/png, image/jpeg" />
            <input type="hidden" name="shareholders[${shareholderId}][existing_pep_document]" value="${data?.pep_document || ''}" />
          </div>
        </div>
        
        <div class="col-md-2 pep-download-container" style="display: ${data?.isPEP === '1' && data?.pep_document ? 'inline-block' : 'none'}">
          <a class="btn bg-blue text-white rounded-0 download-pep-doc  mt-4" 
            href="${data?.pep_document ? '/files/' + data.pep_document : '#'}" target="_blank">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        </div>
        
        <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">Tipo de parte relacionada <span>*</span></label>
            <select class="form-control" name="shareholders[${shareholderId}][counterparty_type]" required>
              <option value="" disabled selected>Seleccione una opción</option>
              <option value="1" ${data?.counterparty_type === '1' ? 'selected' : ''}>Accionista</option>
              <option value="2" ${data?.counterparty_type === '2' ? 'selected' : ''}>Junta directiva</option>
              <option value="3" ${data?.counterparty_type === '3' ? 'selected' : ''}>Revisor fiscal</option>
              <option value="4" ${data?.counterparty_type === '4' ? 'selected' : ''}>Beneficiario compañía</option>
            </select>
          </div>
        </div>
        
        <div class="col-md-2">
          <div class="mb-3">
            <label class="form-label">Estado <span>*</span></label>
            <select class="form-control" name="shareholders[${shareholderId}][status]" required>
              <option value="" disabled selected>Seleccione una opción</option>
              <option value="1" ${data?.status === '1' ? 'selected' : ''}>Activo</option>
              <option value="2" ${data?.status === '2' ? 'selected' : ''}>Inactivo</option>
              <option value="3" ${data?.status === '3' ? 'selected' : ''}>En proceso</option>
            </select>
          </div>
        </div>
      </div>

        <hr />
      <div class="row">
         <div class="col-12">
          <div class="alert alert-warning w-100">
          Esta certificación debe ser emitida por, Revisor Fiscal, Contador, o Ente Regulador
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Certificado de composición accionaria</label>
            <input type="file" class="form-control d-none" name="shareholders[${shareholderId}][shareholder_document]" id="shareholders${shareholderId}shareholder_document" onchange="$('#shareholders${shareholderId}_file').val(limpiar_path(this.value));"
              accept="application/pdf, image/png, image/jpeg" />
            <input type="hidden" name="shareholders[${shareholderId}][existing_shareholder_document]" value="${data?.shareholder_document || ''}" />

            <div class="input-group">
              <div class="input-group-prepend div-examinar">
                <button class="btn boton-examinar" type="button" onclick="$('#shareholders${shareholderId}shareholder_document').click();">Examinar</button>
              </div>
              <input id="shareholders${shareholderId}shareholder_document_file" readonly type="text" class="form-control campo-examinar" onclick="$('#shareholders${shareholderId}shareholder_document').click();" value="${data?.shareholder_document || 'Seleccione un archivo'}" />
            </div>

          </div>
        </div>

        <div class="col-md-2">
          <a class="btn bg-blue text-white rounded-0 download-shareholder-doc mt-4" 
            href="${data?.shareholder_document ? '/files/' + data.shareholder_document : '#'}" 
            target="_blank" 
            style="display: ${data?.shareholder_document ? 'inline-block' : 'none'}">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        </div>

        <div class="col-md-4">
          <div class="mb-3">
              <label class="form-label">Fecha de expedición <span>*</span></label>
              <input type="date" class="form-control" name="shareholders[${shareholderId}][shareholder_document_date]" 
                max="${new Date().toISOString().split('T')[0]}" 
                value="${data?.shareholder_document_date || ''}" required />
          </div>
        </div>
      </div>
      
      <button type="button" class="btn btn-danger text-white remove-shareholder">
        Eliminar accionista
      </button>

      <button type="submit" class="btn btn-confirmar bg-orange text-white rounded-0">Confirmar accionista</button>

      <hr />
    </div>
  `;

    // Agregar al contenedor
    document.getElementById('shareholdersContainer').insertAdjacentHTML('beforeend', shareholderHtml);

    // Inicializar select2 para el nuevo campo de país
    const newCountrySelect = document.querySelector(`[data-shareholder-id="${shareholderId}"] .country-select`);
    if (newCountrySelect) {
      initializeCountrySelect2(newCountrySelect);
    }

    // Configurar eventos para este accionista
    const shareholderElement = document.querySelector(`[data-shareholder-id="${shareholderId}"]`);

    // Evento para eliminar accionista
    shareholderElement.querySelector('.remove-shareholder').addEventListener('click', () => {
      if (confirm('¿Está seguro de eliminar este accionista?')) {
        shareholders.splice(shareholderId, 1);
        shareholderElement.remove();
        // Reindexar los accionistas restantes
        reindexShareholders();
      }
    });

    // Evento para mostrar/ocultar campos PEP
    const pepSelect = shareholderElement.querySelector('.pep-select');
    const pepDocumentContainer = shareholderElement.querySelector('.pep-document-container');
    const pepDownloadContainer = shareholderElement.querySelector('.pep-download-container');

    pepSelect.addEventListener('change', function() {
      if (this.value === '1') {
        pepDocumentContainer.style.display = 'block';
        pepDownloadContainer.style.display = 'block';
      } else {
        pepDocumentContainer.style.display = 'none';
        pepDownloadContainer.style.display = 'none';
      }
    });

    // Evento para manejar la subida de archivos
    const shareholderDocInput = shareholderElement.querySelector('input[name*="shareholder_document"]');
    const shareholderDownloadBtn = shareholderElement.querySelector('.download-shareholder-doc');

    shareholderDocInput.addEventListener('change', function(e) {
      const file = this.files[0];
      if (file) {
        // Validar tipo de archivo
        const allowedTypes = ['application/pdf', 'image/png', 'image/jpeg'];
        if (!allowedTypes.includes(file.type)) {
          showAlert({
            title: "Error",
            text: "Solo se permiten archivos PDF, PNG y JPEG",
            icon: "error",
            showCancel: false,
            confirmButtonText: "Continuar",
          });
          this.value = '';
          return;
        }

        // Validar tamaño (máximo 5MB)
        const maxSize = 5 * 1024 * 1024; // 5MB en bytes
        if (file.size > maxSize) {
          showAlert({
            title: "Error",
            text: "El archivo no debe superar los 5MB",
            icon: "error",
            showCancel: false,
            confirmButtonText: "Continuar",
          });
          this.value = '';
          return;
        }
      }
    });

    const pepDocInput = shareholderElement.querySelector('input[name*="pep_document"]');
    const pepDownloadBtn = shareholderElement.querySelector('.download-pep-doc');

    pepDocInput.addEventListener('change', function(e) {
      const file = this.files[0];
      if (file) {
        // Validar tipo de archivo
        const allowedTypes = ['application/pdf', 'image/png', 'image/jpeg'];
        if (!allowedTypes.includes(file.type)) {
          showAlert({
            title: "Error",
            text: "Solo se permiten archivos PDF, PNG y JPEG",
            icon: "error",
            showCancel: false,
            confirmButtonText: "Continuar",
          });
          this.value = '';
          return;
        }

        // Validar tamaño (máximo 5MB)
        const maxSize = 5 * 1024 * 1024; // 5MB en bytes
        if (file.size > maxSize) {
          showAlert({
            title: "Error",
            text: "El archivo no debe superar los 5MB",
            icon: "error",
            showCancel: false,
            confirmButtonText: "Continuar",
          });
          this.value = '';
          return;
        }
      }
    });
  }

  // Función para reindexar accionistas después de eliminar uno
  function reindexShareholders() {
    const shareholderElements = document.querySelectorAll('[data-shareholder-id]');
    shareholderElements.forEach((element, index) => {
      element.setAttribute('data-shareholder-id', index);

      // Actualizar los nombres de los campos
      const inputs = element.querySelectorAll('input, select');
      inputs.forEach(input => {
        const name = input.getAttribute('name');
        if (name) {
          input.setAttribute('name', name.replace(/shareholders\[\d+\]/, `shareholders[${index}]`));
        }
      });

      // Reinicializar select2 para el campo de país
      const countrySelect = element.querySelector('.country-select');
      if (countrySelect) {
        initializeCountrySelect2(countrySelect);
      }
    });
  }

  // Función para cargar accionistas existentes
  async function loadExistingShareholders() {
    try {
      const shareholdersData = Object.values(<?= json_encode($this->list_shareholders ?? []) ?>);
      // Limpiar contenedor
      document.getElementById('shareholdersContainer').innerHTML = '';
      shareholders = [];

      // Agregar cada accionista
      shareholdersData.forEach(shareholderData => {
        addShareholder(shareholderData);
      });

    } catch (error) {
      console.error('Error cargando accionistas:', error);
    }
  }

  // Configurar eventos al cargar la página
  document.addEventListener('DOMContentLoaded', function() {
    // Cargar accionistas existentes
    loadExistingShareholders();

    // Inicializar select2 para los campos de país existentes
    document.querySelectorAll('.country-select').forEach(select => {
      initializeCountrySelect2(select);
    });

    // Configurar evento para agregar accionista
    document.getElementById('addShareholderBtn').addEventListener('click', () => {
      addShareholder();
    });

    // Configurar evento para enviar formulario
    const form = document.getElementById('certificates-shareholders-form');
    form.addEventListener('submit', async function(e) {
      e.preventDefault();

      if (!validateForm()) {
        showAlert({
          title: "Error",
          text: "Por favor complete todos los campos obligatorios",
          icon: "error",
          showCancel: false,
          confirmButtonText: "Continuar",
        });
        return;
      }

      const formData = new FormData(form);
      const btn = form.querySelector('button[type="submit"]');

      try {
        btn.disabled = true;
        btn.innerHTML = `Enviando...`;

        const resp = await fetch(form.action, {
          method: "POST",
          body: formData,
        });

        if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
        const json = await resp.json();

        if (json.success) {
          // Actualizar los botones de descarga
          if (json.uploaded_files) {
            updateDownloadButtons(json.uploaded_files);
          }

          // Actualizar la lista de accionistas si se proporciona
          if (json.shareholders) {
            const container = document.getElementById('shareholdersContainer');
            container.innerHTML = '';
            shareholders = [];
            json.shareholders.forEach(shareholderData => {
              addShareholder(shareholderData);
            });
          }

          showAlert({
            title: json.title || "Éxito",
            text: json.text || "Información guardada correctamente",
            icon: json.icon || "success",
            showCancel: false,
            confirmButtonText: "Continuar",
            html: json.html || null,
            redirect: json.redirect,
          });

          completitud4();

        } else {
          showAlert({
            title: json.title || "Error",
            text: json.text || "Revisa los datos",
            icon: json.icon || "info",
            showCancel: false,
            confirmButtonText: "Continuar",
            html: json.html || null,
          });
        }
      } catch (err) {
        showAlert({
          title: "Error",
          text: "No se pudo comunicar con el servidor.",
          icon: "error",
          showCancel: false,
          confirmButtonText: "Continuar",
        });
      } finally {
        btn.disabled = false;
        btn.innerHTML = `Guardar información`;
      }
    });
  });

  // Función para validar el formulario
  function validateForm() {
    let isValid = true;

    // Validar cada accionista
    shareholders.forEach((_, index) => {
      const shareholderElement = document.querySelector(`[data-shareholder-id="${index}"]`);
      const requiredInputs = shareholderElement.querySelectorAll('[required]');

      requiredInputs.forEach(input => {
        if (!input.value.trim()) {
          isValid = false;
          input.classList.add('is-invalid');
        } else {
          input.classList.remove('is-invalid');
        }
      });
    });

    return isValid;
  }

  // Función para actualizar los botones de descarga
  function updateDownloadButtons(uploadedFiles) {
    if (!uploadedFiles) return;

    // Mapeo de tipos de archivo a contenedores
    const fileContainers = {
      trade_registry: 'trade-registry-download-container',
      rut_certificate: 'rut-certificate-download-container',
      legal_representative_id: 'legal-representative-download-container',
      legal_representative_id2: 'legal-representative2-download-container'
    };

    // Actualizar botones de descarga principales
    Object.entries(fileContainers).forEach(([fileType, containerId]) => {
      if (uploadedFiles[fileType]) {
        const container = document.getElementById(containerId);
        if (container) {
          container.innerHTML = `
            <a href="/files/${uploadedFiles[fileType]}" target="_blank" class="btn bg-blue text-white rounded-0 mt-4 download-btn" data-file-type="${fileType}">
              <i class="fa-solid fa-download"></i> Descargar
            </a>
          `;
        }
      }
    });

    // Actualizar documentos de accionistas
    if (uploadedFiles.shareholders) {
      Object.entries(uploadedFiles.shareholders).forEach(([index, files]) => {
        const shareholderElement = document.querySelector(`[data-shareholder-id="${index}"]`);
        if (shareholderElement) {
          // Actualizar certificado de composición accionaria
          if (files.shareholder_document) {
            const downloadBtn = shareholderElement.querySelector('.download-shareholder-doc');
            if (downloadBtn) {
              downloadBtn.href = '/files/' + files.shareholder_document;
              downloadBtn.style.display = 'inline-block';
            }
          }
          // Actualizar documento PEP
          if (files.pep_document) {
            const pepDownloadBtn = shareholderElement.querySelector('.download-pep-doc');
            if (pepDownloadBtn) {
              pepDownloadBtn.href = '/files/' + files.pep_document;
              pepDownloadBtn.style.display = 'inline-block';
            }
          }
        }
      });
    }
  }
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const checkVigencia = document.getElementById('company_validity2');
    const company_validity = document.getElementById('company_validity');

    checkVigencia.addEventListener('change', function() {
      if (checkVigencia.checked) {
        company_validity.disabled = true;
        company_validity.required = false;
        company_validity.value = '';
        company_validity.removeAttribute('required');
      } else {
        company_validity.disabled = false;
        company_validity.required = true;
        company_validity.value = '';
        company_validity.required = true;
      }
    });
  });
</script>

<script type="text/javascript">
  function completitud4(){
    $.post("/supplier/profile/completitud4/",{ },function(res){
      $("#completitud4").html(res.porcentaje+"%");
      array_completitud[4]=res.porcentaje;
      completeness();
    });
  }
  completitud4();

  function limpiar_path(x){
    return x.replace("C:\\fakepath\\","");
  }  
</script>

<style>
  /* Estilos básicos para el formulario */
  .is-invalid {
    border-color: #dc3545;
  }

  .btn.bg-blue {
    background-color: #0d6efd;
  }

  .btn.bg-orange {
    background-color: #fd7e14;
  }

  .btn.rounded-0 {
    border-radius: 0;
  }
</style>
<style type="text/css">
.select2-container--default .select2-results__option--disabled {
  padding: 0px !important;
  margin-top: -10px !important;
  margin-bottom: 5px !important;
}  
.div_completitud{
  position: sticky;
  right: 0;
  top: 200px;
  z-index: 2;
  background-color: white;
}  
</style>