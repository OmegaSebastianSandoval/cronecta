<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>
<form id="experience-form" class="supplier-register-form form-bx">
  <!-- Vue: @submit.prevent="submitExperience" -->

  <!-- Contenedor donde se agregan dinámicamente las experiencias -->
  <div id="experience-container">
    <!-- Este bloque debe clonarse dinámicamente con JavaScript -->
    <!-- Vue: v-for="(experience, index) in experiences" :key="index" -->
    <div class="experience-item mb-3">
      <div class="row">
        <div class="col-12 col-md-4">
          <div class="mb-3">
            <label class="form-label">Nombre empresa cliente</label>
            <input type="text" class="form-control" name="company_name[]" required />
            <!-- Vue: v-model="experience.company_name" -->
          </div>
        </div>

        <div class="col-12 col-lg-4">
          <div class="form-group mb-2">
            <label class="form-label">Industria <span>*</span></label>
            <select class="form-control" name="industry[]" required onchange="getSegments(this)">
              <option value="" selected disabled>Seleccione...</option>
              <!-- Vue: v-for="industry in industries_exp" -->
              <!-- <option :value="industry.id">{{ industry.label }}</option> -->
            </select>
            <!-- Vue: v-model="experience.industry", @change="getSegments(experience);" -->
          </div>
        </div>

        <div class="col-12 col-lg-4">
          <div class="mb-3">
            <label class="form-label">Segmento <span>*</span></label>
            <select class="form-control" name="segment[]" required disabled>
              <option value="" disabled selected>Seleccione un segmento</option>
              <!-- Vue: v-for="segment in experience.industrySegments" -->
              <!-- <option :value="segment.id">{{ segment.label }}</option> -->
            </select>
            <!-- Vue: v-model="experience.segments" :disabled="!experience.industry" -->
          </div>
        </div>
      </div>
      <div class="row">

        <div class="col-12 col-lg-4">
          <div class="mb-3">
            <label class="form-label">País <span>*</span></label>
            <select class="form-control" name="country[]" required>
              <option value="" disabled selected>Seleccione un país</option>
              <!-- Vue: v-for="country in sortedCountries" -->
              <!-- <option :value="country.name">{{ country.name }}</option> -->
            </select>
            <!-- Vue: v-model="experience.country" -->
          </div>
        </div>

        <div class="col-12 col-lg-4">
          <div class="mb-3">
            <label class="form-label">Departamento/Estado <span>*</span></label>
            <select class="form-control" name="state[]" required disabled>
              <option value="" disabled selected>Seleccione un estado</option>
              <!-- Vue: v-for="state in getStates_exp(experience.country)" -->
              <!-- <option :value="state.name">{{ state.name }}</option> -->
            </select>
            <!-- Vue: v-model="experience.state" :disabled="!experience.country" -->
          </div>
        </div>

        <div class="col-12 col-lg-4">
          <div class="mb-3">
            <label class="form-label">Ciudad</label>
            <select class="form-control" name="city[]" disabled>
              <option value="" disabled selected>Seleccione una ciudad</option>
              <!-- Vue: v-for="city in getCities_exp(experience.country, experience.state)" -->
              <!-- <option :value="city.name">{{ city.name }}</option> -->
            </select>
            <!-- Vue: v-model="experience.city" :disabled="!experience.state" -->
          </div>
        </div>
      </div>
      <div class="row">

        <div class="col-12 col-lg-3">
          <div class="mb-3">
            <label class="form-label">Objeto contractual <span>*</span></label>
            <input type="text" class="form-control" name="contract_object[]" required />
            <!-- Vue: v-model="experience.contract_object" -->
          </div>
        </div>

        <div class="col-12 col-lg-3">
          <div class="mb-3">
            <label class="form-label">Valor del contrato <span>*</span></label>
            <input type="text" class="form-control" name="contract_value[]" required onblur="formatPesos2(this)" />
            <!-- Vue: v-model="experience.contract_value", @onblur="formatPesos2(index)" -->
          </div>
        </div>

        <div class="col-12 col-lg-3">
          <div class="mb-3">
            <label class="form-label">Moneda <span>*</span></label>
            <select class="form-control" name="currency[]" required>
              <option value="" disabled selected>Seleccione una moneda</option>
              <option value="USD">USD</option>
              <option value="COP">COP</option>
              <option value="EUR">EUR</option>
            </select>
            <!-- Vue: v-model="experience.currency" -->
          </div>
        </div>

        <div class="col-12 col-lg-3">
          <div class="mb-3">
            <label class="form-label">Fecha de inicio contrato <span>*</span></label>
            <input type="date" class="form-control" name="contract_start_date[]" required />
            <!-- Vue: v-model="experience.contract_start_date" -->
            </select>
            <!-- Vue: v-model="experience.contract_start_year" -->
          </div>
        </div>

        <div class="col-12 col-lg-3">
          <div class="mb-3">
            <label class="form-label">Fecha de fin contrato <span>*</span></label>
            <input type="date" class="form-control" name="contract_end_date[]" required />
            <!-- Vue: v-model="experience.contract_end_date" -->
          </div>
        </div>

        <div class="col-12 col-md-3">
          <div class="mb-3 mt-9">
            <label for="" class="form-label"></label>
            <input type="checkbox" class="form-control1" name="contract_current[]" onclick="validar()" />
            <!-- Vue: v-model="supplier.company_validity2", @click="validar_sin_definir" -->
            Actualmente vigente
          </div>
        </div>




        <div class="col-12 col-lg-3">
          <div class="mb-3">
            <label class="form-label">Documento adjunto</label>
            <input type="file" accept="application/pdf, image/png, image/jpeg" class="form-control" name="document_file[]" onchange="handleFileUpload9(this)" />
            <!-- Vue: @change="handleFileUpload9('document_file', $event, index)" -->
          </div>
        </div>

        <div class="col-12 col-lg-3">
          <!-- Vue: v-if="experience.document_file" -->
          <a class="btn bg-blue text-white rounded-0" href="#" target="_blank" style="display: none;">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        </div>
      </div>

      <button type="button" class="btn btn-danger mb-3 text-white remove-experience">
        Eliminar Experiencia
        <!-- Vue: @click="removeExperience(index)" -->
      </button>
      <hr />


      <button type="button" class="btn btn-secondary mb-3 text-white" id="add-experience-btn">
        Agregar Experiencia
        <!-- Vue: @click="addExperience" -->
      </button>

      <div class="d-flex justify-content-center">
        <button type="submit" class="btn bg-orange text-white rounded-0">
          Guardar Experiencias
        </button>
      </div>
    </div>
  </div>
</form>