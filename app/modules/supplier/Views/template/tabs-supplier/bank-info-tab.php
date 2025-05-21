<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>
<div class="row mt-3 mb-5">
  <div class="col-md-12">
    <div class="alert alert-secondary">
      <div class="row">
        <div class="col-md-4">
          <label>Banco</label>
          <input
            placeholder="Buscar por banco"
            id="input_banco"
            class="form-control"
            onkeyup="buscar_info_bancaria()" />
          <!-- Vue: @keyup="buscar_info_bancaria" -->
        </div>
        <div class="col-md-4">
          <label>Numero de cuenta</label>
          <input
            placeholder="Buscar por numero de cuenta"
            id="input_cuenta"
            class="form-control"
            onkeyup="buscar_info_bancaria2()" />
          <!-- Vue: @keyup="buscar_info_bancaria2" -->
        </div>
      </div>
    </div>
  </div>
</div>
<form id="div_info_bancaria" class="supplier-register-form form-bx">
  <!-- Vue: @submit.prevent="submitBankinfo" -->

  <!-- Contenedor donde se agregan dinámicamente los bancos -->
  <div id="bankinfo-container">
    <!-- Este bloque debe clonarse dinámicamente con JS -->
    <!-- Vue: v-for="(bankinfo, index) in bankinfos" -->
    <div class="fila_banco mb-3 bankinfo-item">
      <div class="row">
        <div class="col-12 col-md-4">
          <div class="mb-3">
            <label class="form-label">País <span>*</span></label>
            <select type="text" class="form-control" name="country[]" required>
              <option value="" disabled selected>Seleccione un país</option>
              <!-- Vue: v-for="country in countries" -->
              <!-- <option :value="country.id">{{ country.name }}</option> -->
            </select>
            <!-- Vue: v-model="bankinfo.country" -->
          </div>
        </div>

        <div class="col-12 col-md-4">
          <div class="mb-3">
            <label for="bank" class="form-label">Banco <span>*</span></label>
            <input type="text" class="form-control banco1" name="bank[]" required />
            <!-- Vue: v-model="bankinfo.bank" -->
          </div>
        </div>

        <div class="col-12 col-md-4">
          <div class="mb-3">
            <label for="office" class="form-label">Sucursal <span>*</span></label>
            <input type="text" class="form-control" name="office[]" required />
            <!-- Vue: v-model="bankinfo.office" -->
          </div>
        </div>

        <div class="col-12 col-md-4">
          <div class="mb-3">
            <label for="account_type" class="form-label">Tipo de cuenta <span>*</span></label>
            <select class="form-control" name="account_type[]" required>
              <option value="Nacional">Nacional</option>
              <option value="Internacional">Internacional</option>
            </select>
            <!-- Vue: v-model="bankinfo.account_type" -->
          </div>
        </div>

        <div class="col-12 col-md-4">
          <div class="mb-3">
            <label for="holder" class="form-label">Títular de la cuenta <span>*</span></label>
            <input type="text" class="form-control" name="holder[]" required />
            <!-- Vue: v-model="bankinfo.holder" -->
          </div>
        </div>

        <div class="col-12 col-md-4">
          <div class="mb-3">
            <label for="account_number" class="form-label">Número de cuenta <span>*</span></label>
            <input type="number" class="form-control cuenta1" name="account_number[]" required />
            <!-- Vue: v-model="bankinfo.account_number" -->
          </div>
        </div>


        <div class="col-12 col-md-4">
          <div class="mb-3">
            <label for="holder" class="form-label">Fecha de certificado bancario (no mayor a 80 días)<span>*</span></label>
            <input type="date" class="form-control" name="bank_certificate_date[]" required />
            <!-- Vue: v-model="bankinfo.bank_certificate_date" -->
          </div>
        </div>

        <div class="col-md-4">
          <div class="mb-3">
            <label for="account_certificate" class="form-label">Certificación bancaria</label>
            <input
              type="file"
              accept="application/pdf, image/png, image/jpeg"
              class="form-control"
              name="account_certificate[]"
              onchange="handleFileUpload5(this)" />
            <!-- Vue: @change="handleFileUpload5('account_certificate', $event, index)" -->
          </div>
        </div>

        <div class="col-12 col-md-4 mt-7">
          <!-- Vue: v-if="bankinfo.account_certificate" -->
          <a
            class="btn bg-blue text-white rounded-0"
            style="display: none;"
            href="#"
            target="_blank">
            <i class="fa-solid fa-download"></i> Descargar
          </a>
        </div>


        <div class="col-12 col-md-2">
          <div class="mb-3">
            <label for="swift_number" class="form-label">Swift Number</label>
            <input type="text" class="form-control" name="swift_number[]" />
            <!-- Vue: v-model="bankinfo.swift_number" -->
          </div>
        </div>

        <div class="col-12 col-md-2">
          <div class="mb-3">
            <label for="routing_number" class="form-label">Routing Number</label>
            <input type="text" class="form-control" name="routing_number[]" />
            <!-- Vue: v-model="bankinfo.routing_number" -->
          </div>
        </div>

        <div class="col-12 col-md-3">
          <div class="mb-3">
            <label for="iban" class="form-label">IBAN (International Bank Account No)</label>
            <input type="text" class="form-control" name="iban[]" />
            <!-- Vue: v-model="bankinfo.iban" -->
          </div>
        </div>

        <div class="col-12 col-md-2">
          <div class="mb-3">
            <label for="bic" class="form-label">BIC (Bank Identifier Code)</label>
            <input type="text" class="form-control" name="bic[]" />
            <!-- Vue: v-model="bankinfo.bic" -->
          </div>
        </div>

        <div class="col-12 col-md-3">
          <div class="mb-3">
            <label for="beneficiary_bank" class="form-label">Banco Intermediario / Beneficiario</label>
            <input type="text" class="form-control" name="beneficiary_bank[]" />
            <!-- Vue: v-model="bankinfo.beneficiary_bank" -->
          </div>
        </div>
      </div>

      <button type="button" class="btn btn-danger mb-3 text-white remove-bankinfo">
        Eliminar Información Bancaria
        <!-- Vue: @click="removeBankinfo(index)" -->
      </button>
      <hr />


      <button type="button" class="btn btn-secondary mb-3 text-white" id="add-bankinfo-btn">
        Agregar Información Bancaria
        <!-- Vue: @click="addBankinfo" -->
      </button>

      <div class="d-flex justify-content-center">
        <button type="submit" class="btn bg-orange text-white rounded-0">
          Guardar Información Bancaria
        </button>
      </div>
    </div>
  </div>
</form>