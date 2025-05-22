<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>
<form id="legal-representative-form" class="supplier-register-form form-bx">


  <div class="text-end mb-2" style="display: none;" id="section-progress-cert">
    Haz completado el <span class="completitud" id="completitud8">-%</span> de esta sección
  </div>

  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Certificado de existencia</span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
      <div class="mb-3">
        <label for="issue_date" class="form-label">Nombre del documento <span>*</span></label>
        <input type="text" class="form-control" id="certificate_issue_name" name="certificate_issue_name" required />

      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3">
        <label for="trade_registry" class="form-label">Adjuntar documento</label>
        <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control" id="trade_registry" name="trade_registry" />

      </div>
    </div>
    <div class="col-md-2 mt-7">

      <div id="trade-registry-download-container" class="mb-3">
        <?php if ($this->supplier->trade_registry && file_exists(FILE_PATH . $this->supplier->trade_registry)) { ?>
          <a href="<?= FILE_PATH . $this->supplier->trade_registry ?>" target="_blank" class="btn bg-blue text-white rounded-0 mt-4">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        <?php } ?>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="mb-3">
        <label for="issue_date" class="form-label">Fecha expedición certificado <span>*</span></label>
        <input type="date" class="form-control" id="issue_date" max="<?= date('Y-m-d') ?>" min="1950-01-01" name="certificate_issue_date" required />

      </div>
    </div>

    <div class="col-12 col-md-3">
      <div class="mb-3">
        <label for="company_date" class="form-label">Fecha de constitución de la empresa <span>*</span></label>
        <input type="date" class="form-control" id="company_date" name="company_date" required />

      </div>
    </div>

    <div class="col-12 col-md-3">
      <div class="mb-3">
        <label for="company_validity" class="form-label">Fecha de expiración de la sociedad</label>
        <input type="date" class="form-control" id="company_validity" name="company_validity" />

      </div>
    </div>

    <div class="col-12 col-md-3" id="company_validity-wrapper">
      <div class="mb-3 mt-4">
        <label for="company_validity2" class="form-label"></label>
        <input type="checkbox" class="form-control1" id="company_validity2" name="company_validity2" />
        Vigencia indefinida
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-md-4" id="registry_country-wrapper">
      <div class="mb-3">
        <label for="registry_country" class="form-label">País de registro<span>*</span></label>
        <select class="form-control" id="registry_country" name="registry_country" required>
          <option value="">Seleccione un país</option>
          <?php foreach ($this->list_country as $c): ?>
            <option value="<?= $c['name'] ?>"><?= $c['name'] ?></option>
          <?php endforeach; ?>
        </select>

      </div>
    </div>
    <div class="col-12 col-md-4" id="registry_state-wrapper">
      <div class="mb-3">
        <label for="registry_state" class="form-label">Departamento/Estado de registro<span>*</span></label>
        <select class="form-control" id="registry_state" name="registry_state" required>
          <option value="" disabled selected>Seleccione un estado</option>
        </select>

      </div>
    </div>

    <div class="col-12 col-md-4" id="registry_city-wrapper">
      <div class="mb-3">
        <label for="registry_city" class="form-label">Ciudad de registro <span>*</span></label>
        <select class="form-control" id="registry_city" name="registry_city" required>
          <option value="" selected>Seleccione una ciudad</option>
        </select>
      </div>
    </div>




  </div>

  <!-- Bloque oculto: Certificado de incorporación -->
  <div class="col-12 py-3 pt-4 d-none">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Certificado de incorporación</span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div>

  <div class="row d-none">
    <div class="col-md-6">
      <div class="mb-3">
        <label for="incorporation_certificate" class="form-label">Documento adjunto</label>
        <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control" id="incorporation_certificate" name="incorporation_certificate" />

      </div>
    </div>

    <div class="col-md-2 mt-7">
      <!-- Vue: v-if="supplier.incorporation_certificate" -->
      <a class="btn bg-blue text-white rounded-0" id="download_incorporation_certificate" style="display: none;" href="#" target="_blank">
        <i class="fa-solid fa-download"></i> Descargar
      </a>
    </div>
  </div>

  <!-- Certificado RUT -->
  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Certificado del Registro Único Tributario (RUT)</span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 col-md-4">
      <div class="mb-3">
        <label for="rut_certificate_name" class="form-label">Nombre del documento</label>
        <input type="text" class="form-control" id="rut_certificate_name" name="rut_certificate_name" />
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="mb-3">
        <label for="rut_certificate" class="form-label">Adjuntar documento</label>
        <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control" id="rut_certificate" name="rut_certificate" />
      </div>
    </div>

    <div class="col-12 col-md-2 mt-7">
      <div id="rut-certificate-download-container" class="mb-3">
        <?php if ($this->supplier->rut_certificate && file_exists(FILE_PATH . $this->supplier->rut_certificate)) { ?>
          <a href="<?= FILE_PATH . $this->supplier->rut_certificate ?>" target="_blank" class="btn bg-blue text-white rounded-0 mt-4">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        <?php } ?>

      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="mb-3">
        <label for="rut_certificate_date_expedition" class="form-label">Fecha de expedición del documento</label>
        <input type="date" class="form-control" id="rut_certificate_date_expedition" max="<?= date('Y-m-d') ?>" min="1950-01-01" name="rut_certificate_date_expedition" />
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-4">
        <div class="mb-3">
          <label for="rut_certificate_country" class="form-label">País<span></span></label>
          <select class="form-control" id="rut_certificate_country" name="rut_certificate_country">
            <option value="" selected>Seleccione un país</option>
            <?php foreach ($this->list_country as $c): ?>
              <option value="<?= $c['name'] ?>"><?= $c['name'] ?></option>
            <?php endforeach; ?>

          </select>

        </div>
      </div>
      <div class="col-12 col-md-4 " id="rut_certificate_state-wrapper">
        <div class="mb-3">
          <label for="rut_certificate_state" class="form-label">Departamento/Estado de registro<span></span></label>
          <select class="form-control" id="rut_certificate_state" name="rut_certificate_state">
            <option value="" selected>Seleccione un estado</option>

          </select>

        </div>
      </div>

      <div class="col-12 col-md-4" id="rut_certificate_city-wrapper">
        <div class="mb-3">
          <label for="rut_certificate_city" class="form-label">Ciudad<span></span></label>
          <select class="form-control" id="rut_certificate_city" name="rut_certificate_city">
            <option value="" selected>Seleccione una ciudad</option>

          </select>

        </div>
      </div>

      <div class="col-12 d-flex justify-content-center">
        <button type="submit" class="btn bg-orange text-white rounded-0">Guardar Información</button>
      </div>
    </div>
  </div>
</form>












<form id="supplier-shareholders-form" class="supplier-register-form form-bx">


  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Accionistas </span>
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
    Agregar Accionista
  </button>

  <!-- <div class="d-flex justify-content-center">
    <button type="submit" class="btn bg-orange text-white rounded-0">
      Guardar Composición Accionaria
    </button>
  </div> -->


  <!-- Vue: v-if="esPruebas" -->
  <div class="text-end mb-2" style="display: none;" id="section-progress">
    Haz completado el <span class="completitud" id="completitud3">-%</span> de esta sección
  </div>

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
        <input type="text" class="form-control" id="representative_name" name="representative_name" required />
        <!-- Vue: v-model="representative.representative_name" -->
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_type" class="form-label">Tipo de documento <span>*</span></label>
        <select class="form-control" id="document_type" name="document_type" required>
          <option value="CC">Cédula de Ciudadanía</option>
          <option value="CE">Cédula de Extranjería</option>
          <option value="TI">Tarjeta de Identidad</option>
          <option value="PASAPORTE">Pasaporte</option>
          <option value="PPT">Permiso de Protección Temporal</option>

        </select>
        <!-- Vue: v-model="representative.document_type" -->
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_number" class="form-label">Número de documento <span>*</span></label>
        <input type="text" class="form-control only_numbers" id="document_number" name="document_number" required onblur="formatNumber()" />
        <!-- Vue: v-model="representative.document_number", @blur="formatNumber()" -->
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_issue_place" class="form-label">Lugar de expedición <span>*</span></label>
        <input type="text" class="form-control" id="document_issue_place" name="document_issue_place" required />
        <!-- Vue: v-model="representative.document_issue_place" -->
      </div>
    </div>



    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_issue_date" class="form-label">Fecha de expedición <span>*</span></label>
        <input type="date" class="form-control" id="document_issue_date" name="document_issue_date" max="<?= date('Y-m-d') ?>" min="1950-01-01" required />
        <!-- Vue: v-model="representative.document_issue_date" -->
      </div>
    </div>
    <div class="col-md-3">
      <div class="mb-3">
        <label for="representative_birth_country" class="form-label">Nacionalidad <span>*</span></label>
        <select class="form-control" id="representative_birth_country" name="representative_birth_country" required>
          <option value="" disabled selected>Seleccione un país</option>
          <?php foreach ($this->list_country as $c): ?>
              <option value="<?= $c['name'] ?>"><?= $c['name'] ?></option>
            <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3">
        <label for="legal_representative_id" class="form-label">Copia de documento de identidad</label>
        <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control" id="legal_representative_id" name="legal_representative_id" onchange="handleFileUpload2('legal_representative_id', event)" />
        <!-- Vue: @change="handleFileUpload2('legal_representative_id', $event)" -->
      </div>
    </div>

    <div class="col-md-2 mt-7">
      <!-- Vue: v-if="representative.legal_representative_id" -->
      <a class="btn bg-blue text-white rounded-0" id="download_file_1" style="display: none;" href="#" target="_blank">
        <i class="fa-solid fa-download"></i> Descargar
      </a>
    </div>
  </div>

  <!-- Representante suplente -->

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
        <input type="text" class="form-control" id="representative_name2" name="representative_name2" required />
        <!-- Vue: v-model="representative.representative_name2" -->
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_type2" class="form-label">Tipo de documento <span>*</span></label>
        <select class="form-control" id="document_type2" name="document_type2" required>
          <option value="CC">Cédula de Ciudadanía</option>
          <option value="CE">Cédula de Extranjería</option>
          <option value="TI">Tarjeta de Identidad</option>
          <option value="PASAPORTE">Pasaporte</option>
          <option value="PPT">Permiso de Protección Temporal</option>
        </select>
        <!-- Vue: v-model="representative.document_type2" -->
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_number2" class="form-label">Número de documento <span>*</span></label>
        <input type="text" class="form-control" id="document_number2" name="document_number2" required />
        <!-- Vue: v-model="representative.document_number2" -->
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_issue_place2" class="form-label">Lugar de expedición <span>*</span></label>
        <input type="text" class="form-control" id="document_issue_place2" name="document_issue_place2" required />
        <!-- Vue: v-model="representative.document_issue_place2" -->
      </div>
    </div>



    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_issue_date2" class="form-label">Fecha de expedición <span>*</span></label>
        <input type="date" class="form-control" id="document_issue_date2" name="document_issue_date2" max="<?= date('Y-m-d') ?>" min="1950-01-01" required />
        <!-- Vue: v-model="representative.document_issue_date2" -->
      </div>
    </div>
    <div class="col-md-3">
      <div class="mb-3">
        <label for="representative_birth_country2" class="form-label">Nacionalidad <span>*</span></label>
        <select class="form-control" id="representative_birth_country2" name="representative_birth_country2" required>
          <option value="" disabled selected>Seleccione un país</option>
          <?php foreach ($this->list_country as $c): ?>
              <option value="<?= $c['name'] ?>"><?= $c['name'] ?></option>
            <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3">
        <label for="legal_representative_id2" class="form-label">Copia de documento de identidad</label>
        <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control" id="legal_representative_id2" name="legal_representative_id2" onchange="handleFileUpload2('legal_representative_id2', event)" />
        <!-- Vue: @change="handleFileUpload2('legal_representative_id2', $event)" -->
      </div>
    </div>

    <div class="col-md-2 mt-7">
      <!-- Vue: v-if="representative.legal_representative_id2" -->
      <a class="btn bg-blue text-white rounded-0" id="download_file_2" style="display: none;" href="#" target="_blank">
        <i class="fa-solid fa-download"></i> Descargar
      </a>
    </div>
  </div>

  <div class="d-flex justify-content-center">
    <button type="submit" class="btn bg-orange text-white rounded-0">Guardar Información</button>
  </div>
</form>

<script>
  // Datos de países (podrían cargarse desde una API)
  const countries = [{
      id: 1,
      name: "Colombia"
    },
    {
      id: 2,
      name: "Estados Unidos"
    },
    {
      id: 3,
      name: "España"
    },
    // Agregar más países según sea necesario
  ];

  // Ordenar países alfabéticamente
  const sortedCountries = [...countries].sort((a, b) => a.name.localeCompare(b.name));

  // Array para almacenar los accionistas
  let shareholders = [];

  // Función para agregar un nuevo accionista
  function addShareholder() {
    const shareholderId = shareholders.length;
    const shareholder = {
      name: '',
      idType: 'CC',
      idNumber: '',
      percentage: '',
      country: '',
      is_legal_entity: '1',
      counterparty_type: '1',
      status: '1',
      isPEP: '0',
      shareholder_document: null,
      pep_document: null
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
              <option value="1">Persona Natural</option>
              <option value="2">Persona Jurídica</option>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">Nombre completo del accionista</label>
            <input type="text" class="form-control" name="shareholders[${shareholderId}][name]" required />
          </div>
        </div>
        
        <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">Tipo de identificación</label>
            <select class="form-control" name="shareholders[${shareholderId}][idType]" required>
              <option value="CC">Cédula de Ciudadanía</option>
              <option value="NIT">NIT</option>
              <option value="CE">Cédula de Extranjería</option>
              <option value="TI">Tarjeta de Identidad</option>
              <option value="PASAPORTE">Pasaporte</option>
              <option value="PPT">Permiso de Protección Temporal</option>
            </select>
          </div>
        </div>
        
        <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">Número de identificación</label>
            <input type="text" class="form-control only_numbers" name="shareholders[${shareholderId}][idNumber]" required />
          </div>
        </div>
        <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">Lugar de expedición</label>
            <input type="text" class="form-control" name="shareholders[${shareholderId}][place_expedition]" required />
          </div>
        </div>
        <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">Fecha de expedición</label>
            <input type="date" class="form-control" name="shareholders[${shareholderId}][id_date]" max="${new Date().toISOString().split('T')[0]}" required />
          </div>
        </div>
               
        
        <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">Nacionalidad <span>*</span></label>
            <select class="form-control" name="shareholders[${shareholderId}][country]" required>
              <option value="" disabled selected>Seleccione un país</option>
              <?php foreach ($this->list_country as $c): ?>
                  <option value="<?= $c['name'] ?>"><?= $c['name'] ?></option>
                <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">% de Participación</label>
            <input type="number" class="form-control" name="shareholders[${shareholderId}][percentage]" required />
          </div>
        </div>
         <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">Es persona expuesta políticamente (PEP)</label>
            <select class="form-control pep-select" name="shareholders[${shareholderId}][isPEP]" required>
              <option value="" disabled selected>Seleccione una opción</option>
              <option value="1">Sí</option>
              <option value="0">No</option>
            </select>
          </div>
        </div>
        
        <div class="col-md-3 pep-document-container" style="display: none;">
          <div class="mb-3">
            <label class="form-label">Documento adjunto PEP</label>
            <input type="file" class="form-control" name="shareholders[${shareholderId}][pep_document]" 
              accept="application/pdf, image/png, image/jpeg" />
          </div>
        </div>
        
        <div class="col-md-2 mt-7 pep-download-container" style="display: none;">
          <a class="btn bg-blue text-white rounded-0 download-pep-doc" 
            href="#" target="_blank">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        </div>
        
        <div class="col-md-3">
          <div class="mb-3">
            <label class="form-label">Tipo de parte relacionada <span>*</span></label>
            <select class="form-control" name="shareholders[${shareholderId}][counterparty_type]" required>
              <option value="1">Accionista</option>
              <option value="2">Junta directiva</option>
              <option value="3">Revisor fiscal</option>
              <option value="4">Beneficiario compañía</option>
            </select>
          </div>
        </div>
        
        <div class="col-md-2">
          <div class="mb-3">
            <label class="form-label">Estado <span>*</span></label>
            <select class="form-control" name="shareholders[${shareholderId}][status]" required>
              <option value="1">Activo</option>
              <option value="2">Inactivo</option>
              <option value="3">En proceso</option>
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
            <input type="file" class="form-control" name="shareholders[${shareholderId}][shareholder_document]" 
              accept="application/pdf, image/png, image/jpeg" />
          </div>
        </div>

       
        
        <div class="col-md-2 ">
          <a class="btn bg-blue text-white rounded-0 download-shareholder-doc mt-7" 
            href="#" target="_blank" style="display: none;">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        </div>

        <div class="col-md-4 ">
          <div class="mb-3">
              <label class="form-label">Fecha de expedición</label>
              <input type="date" class="form-control" name="shareholders[${shareholderId}][shareholder_document_date]" max="${new Date().toISOString().split('T')[0]}" required />
          </div>
        </div>

      
      </div>
      
      <button type="button" class="btn btn-danger mb-3 text-white remove-shareholder">
        Eliminar Accionista
      </button>
      <hr />
    </div>
  `;

    // Agregar al contenedor
    document.getElementById('shareholdersContainer').insertAdjacentHTML('beforeend', shareholderHtml);

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
      if (this.files && this.files[0]) {
        shareholderDownloadBtn.style.display = 'inline-block';
        // Aquí podrías subir el archivo y actualizar la URL de descarga
      }
    });

    const pepDocInput = shareholderElement.querySelector('input[name*="pep_document"]');
    const pepDownloadBtn = shareholderElement.querySelector('.download-pep-doc');

    pepDocInput.addEventListener('change', function(e) {
      if (this.files && this.files[0]) {
        pepDownloadBtn.style.display = 'inline-block';
        // Aquí podrías subir el archivo y actualizar la URL de descarga
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
    });
  }

  // Función para cargar accionistas existentes (si es necesario)
  async function loadExistingShareholders() {
    try {
      // Aquí harías una llamada AJAX para obtener los accionistas existentes
      // const response = await fetch('/api/shareholders');
      // const data = await response.json();

      // Ejemplo con datos de prueba:
      const data = [{
        name: "Ejemplo Accionista",
        idType: "CC",
        idNumber: "123456789",
        percentage: "30",
        country: "Colombia",
        is_legal_entity: "1",
        counterparty_type: "1",
        status: "1",
        isPEP: "0",
        shareholder_document: "/path/to/doc.pdf",
        pep_document: null
      }];

      // Limpiar contenedor
      document.getElementById('shareholdersContainer').innerHTML = '';
      shareholders = [];

      // Agregar cada accionista
      data.forEach(shareholderData => {
        addShareholder();
        const lastIndex = shareholders.length - 1;
        shareholders[lastIndex] = {
          ...shareholders[lastIndex],
          ...shareholderData
        };

        // Rellenar los campos del último accionista agregado
        const shareholderElement = document.querySelector(`[data-shareholder-id="${lastIndex}"]`);

        // Rellenar campos simples
        const fields = ['name', 'idNumber', 'percentage', 'country', 'is_legal_entity', 'counterparty_type', 'status', 'isPEP'];
        fields.forEach(field => {
          const input = shareholderElement.querySelector(`[name*="${field}"]`);
          if (input) input.value = shareholderData[field] || '';
        });

        // Seleccionar opciones en selects
        const selects = {
          idType: shareholderData.idType,
          isPEP: shareholderData.isPEP
        };

        Object.entries(selects).forEach(([name, value]) => {
          const select = shareholderElement.querySelector(`[name*="${name}"]`);
          if (select) {
            Array.from(select.options).forEach(option => {
              if (option.value === value) option.selected = true;
            });
          }
        });

        // Mostrar documentos si existen
        if (shareholderData.shareholder_document) {
          const downloadBtn = shareholderElement.querySelector('.download-shareholder-doc');
          downloadBtn.style.display = 'inline-block';
          downloadBtn.href = shareholderData.shareholder_document;
        }

        if (shareholderData.isPEP === '1' && shareholderData.pep_document) {
          const pepDownloadBtn = shareholderElement.querySelector('.download-pep-doc');
          pepDownloadBtn.style.display = 'inline-block';
          pepDownloadBtn.href = shareholderData.pep_document;
          shareholderElement.querySelector('.pep-document-container').style.display = 'block';
          shareholderElement.querySelector('.pep-download-container').style.display = 'block';
        }
      });

    } catch (error) {
      console.error('Error cargando accionistas:', error);
    }
  }

  // Configurar eventos al cargar la página
  document.addEventListener('DOMContentLoaded', function() {
    // Agregar el primer accionista
    addShareholder();

    // Configurar evento para agregar accionista
    document.getElementById('addShareholderBtn').addEventListener('click', addShareholder);

    // Configurar evento para enviar formulario
    document.getElementById('shareholdersForm').addEventListener('submit', function(e) {
      e.preventDefault();
      submitShareholders();
    });

    // Cargar accionistas existentes (si es necesario)
    // loadExistingShareholders();
  });

  // Función para enviar el formulario
  async function submitShareholders() {
    // Validar antes de enviar
    if (!validateForm()) {
      alert('Por favor complete todos los campos requeridos');
      return;
    }

    // Crear FormData para enviar archivos
    const formData = new FormData(document.getElementById('shareholdersForm'));

    try {
      // Enviar datos al servidor
      const response = await fetch('/api/shareholders', {
        method: 'POST',
        body: formData
        // headers se agregarían si es necesario (ej: para autenticación)
      });

      const data = await response.json();

      if (response.ok) {
        alert('Datos guardados correctamente');
        // Opcional: recargar los accionistas o limpiar el formulario
      } else {
        alert('Error al guardar: ' + (data.message || 'Error desconocido'));
      }
    } catch (error) {
      console.error('Error:', error);
      alert('Error al enviar el formulario');
    }
  }

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

      // Validación adicional para porcentajes (suma = 100%)
      // Podrías implementar esto según tus necesidades
    });

    return isValid;
  }
</script>



<script>
  document.addEventListener('DOMContentLoaded', function() {
    const checkVigencia = document.getElementById('company_validity2');
    const company_validity = document.getElementById('company_validity');

    checkVigencia.addEventListener('change', function() {
      if (checkVigencia.checked) {
        company_validity.disabled = true;
        company_validity.value = '';
        company_validity.removeAttribute('required');
      } else {
        company_validity.disabled = false;
        company_validity.required = true;
      }
    });


  });
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

  .mt-7 {
    margin-top: 1.75rem;
  }
</style>