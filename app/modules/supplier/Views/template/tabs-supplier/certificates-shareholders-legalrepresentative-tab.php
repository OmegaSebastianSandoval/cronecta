<form id="legal-representative-form" class="supplier-register-form form-bx">
  <!-- Vue: @submit.prevent="submitLegalRepresentative" -->

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
        <label for="issue_date" class="form-label">Fecha de expedición certificado de registro <span>*</span></label>
        <input type="date" class="form-control" id="issue_date" name="certificate_issue_date" required />
        <!-- Vue: v-model="supplier.certificate_issue_date" -->
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="company_date" class="form-label">Fecha de constitución de la empresa <span>*</span></label>
        <input type="date" class="form-control" id="company_date" name="company_date" required />
        <!-- Vue: v-model="supplier.company_date" -->
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="company_validity" class="form-label">Fecha de expiración de la sociedad</label>
        <input type="date" class="form-control" id="company_validity" name="company_validity" disabled />
        <!-- Vue: v-model="supplier.company_validity" :disabled="supplier.company_validity2" -->
      </div>
    </div>

    <div class="col-md-2">
      <div class="mb-3 mt-9">
        <label for="company_validity2" class="form-label"></label>
        <input type="checkbox" class="form-control1" id="company_validity2" name="company_validity2" onclick="validar_sin_definir()" />
        <!-- Vue: v-model="supplier.company_validity2", @click="validar_sin_definir" -->
        Sin definir
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="registry_state" class="form-label">Departamento/Estado de Registro<span>*</span></label>
        <select class="form-control" id="registry_state" name="registry_state" required disabled>
          <option value="" disabled selected>Seleccione un estado</option>
          <!-- Vue: v-for="state in getStates()" -->
          <!-- <option :value="state.name">{{ state.name }}</option> -->
        </select>
        <!-- Vue: v-model="supplier.registry_state" :disabled="!supplier.country" -->
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="registry_city" class="form-label">Ciudad de Registro <span>*</span></label>
        <select class="form-control" id="registry_city" name="registry_city" required disabled>
          <option value="" disabled selected>Seleccione una ciudad</option>
          <!-- Vue: v-for="city in getCities_exp(supplier.country,supplier.registry_state)" -->
          <!-- <option :value="city.name">{{ city.name }}</option> -->
        </select>
        <!-- Vue: v-model="supplier.registry_city" :disabled="!supplier.registry_state" -->
      </div>
    </div>

    <div class="col-md-4">
      <div class="mb-3">
        <label for="trade_registry" class="form-label">Documento adjunto</label>
        <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control" id="trade_registry" name="trade_registry" onchange="handleFileUpload3('trade_registry', event)" />
        <!-- Vue: @change="handleFileUpload3('trade_registry', $event)" -->
      </div>
    </div>

    <div class="col-md-2 mt-7">
      <!-- Vue: v-if="supplier.trade_registry" -->
      <a class="btn bg-blue text-white rounded-0" id="download_trade_registry" style="display: none;" href="#" target="_blank">
        <i class="fa-solid fa-download"></i> Descargar
      </a>
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
        <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control" id="incorporation_certificate" name="incorporation_certificate" onchange="handleFileUpload3('incorporation_certificate', event)" />
        <!-- Vue: @change="handleFileUpload3('incorporation_certificate', $event)" -->
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
      <div class="col-6 pe-0">
        <span class="text-lg text-slate-800 font-medium">Certificado del Registro Único Tributario (RUT)</span>
      </div>
      <div class="col-6">
        <hr>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="mb-3">
        <label for="rut_certificate" class="form-label">Documento adjunto con datos actualizados</label>
        <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control" id="rut_certificate" name="rut_certificate" onchange="handleFileUpload3('rut_certificate', event)" />
        <!-- Vue: @change="handleFileUpload3('rut_certificate', $event)" -->
      </div>
    </div>

    <div class="col-md-2 mt-7">
      <!-- Vue: v-if="supplier.rut_certificate" -->
      <a class="btn bg-blue text-white rounded-0" id="download_rut_certificate" style="display: none;" href="#" target="_blank">
        <i class="fa-solid fa-download"></i> Descargar
      </a>
    </div>
  </div>

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
        <label for="representative_name" class="form-label">Nombre del Representante <span>*</span></label>
        <input type="text" class="form-control" id="representative_name" name="representative_name" required />
        <!-- Vue: v-model="representative.representative_name" -->
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_type" class="form-label">Tipo de Documento <span>*</span></label>
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
        <label for="document_number" class="form-label">Número de Documento <span>*</span></label>
        <input type="text" class="form-control" id="document_number" name="document_number" required onblur="formatNumber()" />
        <!-- Vue: v-model="representative.document_number", @blur="formatNumber()" -->
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_issue_place" class="form-label">Lugar de Expedición <span>*</span></label>
        <input type="text" class="form-control" id="document_issue_place" name="document_issue_place" required />
        <!-- Vue: v-model="representative.document_issue_place" -->
      </div>
    </div>



    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_issue_date" class="form-label">Fecha de Expedición <span>*</span></label>
        <input type="date" class="form-control" id="document_issue_date" name="document_issue_date" required />
        <!-- Vue: v-model="representative.document_issue_date" -->
      </div>
    </div>
    <div class="col-md-3">
      <div class="mb-3">
        <label for="representative_birth_country" class="form-label">Nacionalidad <span>*</span></label>
        <select class="form-control" id="representative_birth_country" name="representative_birth_country" required>
          <option value="" disabled selected>Seleccione un país</option>
          <!-- Vue loop: v-for="country in sortedCountries" :key="country.id" -->
          <!-- <option :value="country.name">{{ country.name }}</option> -->
        </select>
        <!-- Vue: v-model="representative.representative_birth_country" -->
      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3">
        <label for="legal_representative_id" class="form-label">Copia de Documento de Identidad</label>
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
        <label for="representative_name2" class="form-label">Nombre del Representante Legal Suplente<span>*</span></label>
        <input type="text" class="form-control" id="representative_name2" name="representative_name2" required />
        <!-- Vue: v-model="representative.representative_name2" -->
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_type2" class="form-label">Tipo de Documento <span>*</span></label>
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
        <label for="document_number2" class="form-label">Número de Documento <span>*</span></label>
        <input type="text" class="form-control" id="document_number2" name="document_number2" required />
        <!-- Vue: v-model="representative.document_number2" -->
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_issue_place2" class="form-label">Lugar de Expedición <span>*</span></label>
        <input type="text" class="form-control" id="document_issue_place2" name="document_issue_place2" required />
        <!-- Vue: v-model="representative.document_issue_place2" -->
      </div>
    </div>

    

    <div class="col-md-3">
      <div class="mb-3">
        <label for="document_issue_date2" class="form-label">Fecha de Expedición <span>*</span></label>
        <input type="date" class="form-control" id="document_issue_date2" name="document_issue_date2" required />
        <!-- Vue: v-model="representative.document_issue_date2" -->
      </div>
    </div>
    <div class="col-md-3">
      <div class="mb-3">
        <label for="representative_birth_country2" class="form-label">Nacionalidad <span>*</span></label>
        <select class="form-control" id="representative_birth_country2" name="representative_birth_country2" required>
          <option value="" disabled selected>Seleccione un país</option>
          <!-- Vue loop: v-for="country in sortedCountries" -->
          <!-- <option :value="country.name">{{ country.name }}</option> -->
        </select>
        <!-- Vue: v-model="representative.representative_birth_country2" -->
      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3">
        <label for="legal_representative_id2" class="form-label">Copia de Documento de Identidad</label>
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
    <button type="submit" class="btn bg-orange text-white rounded-0">Guardar Representante Legal</button>
  </div>
</form>