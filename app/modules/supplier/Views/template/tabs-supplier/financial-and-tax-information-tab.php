<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>
<form id="financialForm" method="POST" action="/supplier/profile/updatefinancialinfo" enctype="multipart/form-data" class="supplier-register-form form-bx">
  <input type="hidden" name="id" value="<?= $this->supplier->id ?>">
  <input type="hidden" name="id-user" value="<?= $this->userSupplier->id ?>">
  <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
  <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
  <div class="row">
    <?php
    echo "<pre>";
    // print_r($this->supplier);
    echo "</pre>";
    ?>
    <div class="col-12 py-3 pt-4">
      <div class="row align-items-center">
        <div class="col-4 pe-0">
          <span class="text-lg text-slate-800 font-medium">Información financiera</span>
        </div>
        <div class="col-8">
          <hr>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="mb-3">
        <label class="form-label">Origen de los recursos <span>*</span></label>
        <input type="text" class="form-control" name="income_origin" value="<?= $this->supplier->income_origin ?>" required />
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="currency_type" class="form-label">Tipo de moneda <span>*</span></label>
        <select class="form-control" id="currency_type" name="currency_type" required>
          <option value="COP" <?= $this->supplier->currency_type == "COP" ? "selected" : "" ?>>COP</option>
          <option value="USD" <?= $this->supplier->currency_type == "USD" ? "selected" : "" ?>>USD</option>
          <option value="EUR" <?= $this->supplier->currency_type == "EUR" ? "selected" : "" ?>>EUR</option>
        </select>
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="equity" class="form-label">Patrimonio <span>*</span></label>
        <input type="text" class="form-control only_numbers_price" id="equity" name="equity" value="<?= $this->supplier->equity ?>" required />
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="assets" class="form-label">Activos corrientes <span>*</span></label>
        <input type="text" class="form-control only_numbers_price" id="assets" name="assets" value="<?= $this->supplier->assets ?>" required />
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="liabilities" class="form-label">Pasivos corrientes <span>*</span></label>
        <input type="text" class="form-control only_numbers_price" id="liabilities" name="liabilities" value="<?= $this->supplier->liabilities ?>" required />
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="assets_total" class="form-label">Activos totales <span>*</span></label>
        <input type="text" class="form-control only_numbers_price" id="assets_total" name="assets_total" value="<?= $this->supplier->assets_total ?>" required />
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="liabilities_total" class="form-label">Pasivos totales <span>*</span></label>
        <input type="text" class="form-control only_numbers_price" id="liabilities_total" name="liabilities_total" value="<?= $this->supplier->liabilities_total ?>" required />
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="income" class="form-label">Ingresos <span>*</span></label>
        <input type="text" class="form-control only_numbers_price" id="income" name="income" value="<?= $this->supplier->income ?>" required />
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="expenses" class="form-label">Egresos operacionales <span>*</span></label>
        <input type="text" class="form-control only_numbers_price" id="expenses" name="expenses" value="<?= $this->supplier->expenses ?>" required />
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="income_other" class="form-label">Otros ingresos <span>*</span></label>
        <input type="text" class="form-control only_numbers_price" id="income_other" name="income_other" value="<?= $this->supplier->income_other ?>" required />
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="expenses_other" class="form-label">Otros egresos <span>*</span></label>
        <input type="text" class="form-control only_numbers_price" id="expenses_other" name="expenses_other" value="<?= $this->supplier->expenses_other ?>" required />
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="income_total" class="form-label">Total ingresos <span>*</span></label>
        <input type="text" class="form-control only_numbers_price" id="income_total" name="income_total" value="<?= $this->supplier->income_total ?>" required />
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="expenses_total" class="form-label">Total egresos <span>*</span></label>
        <input type="text" class="form-control only_numbers_price" id="expenses_total" name="expenses_total" value="<?= $this->supplier->expenses_total ?>" required />
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="utility" class="form-label">Utilidad operacional <span>*</span></label>
        <input type="text" class="form-control only_numbers_price" id="utility" name="utility" value="<?= $this->supplier->utility ?>" required />
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="utility_total" class="form-label">Utilidad neta antes de impuestos <span>*</span></label>
        <input type="text" class="form-control only_numbers_price" id="utility_total" name="utility_total" value="<?= $this->supplier->utility_total ?>" required />
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="financial_expenses" class="form-label">Gastos intereses financieros <span>*</span></label>
        <input type="text" class="form-control only_numbers_price" id="financial_expenses" name="financial_expenses" value="<?= $this->supplier->financial_expenses ?>" required />
      </div>
    </div>

    <div class="col-md-12">
      <div class="mb-3">
        <label for="income_other_concept" class="form-label">Concepto otros ingresos</label>
        <input type="text" class="form-control" id="income_other_concept" name="income_other_concept" value="<?= $this->supplier->income_other_concept ?>" />
      </div>
    </div>

    <div class="col-md-4">
      <div class="mb-3">
        <label class="form-label">Documento adjunto estados financieros</label>
        <input type="file" name="eeff" accept="application/pdf, image/png, image/jpeg" class="form-control" />
      </div>
    </div>

    <div class="col-md-2">
      <div class="mb-3" id="eeff-download-container">
        <?php if ($this->supplier->eeff && file_exists(FILE_PATH . $this->supplier->eeff)) { ?>
          <a href="/files/<?= $this->supplier->eeff ?>" target="_blank" class="btn bg-blue text-white rounded-0 mt-4"><i class="fa-solid fa-download"></i> Descargar</a>
        <?php } ?>
      </div>
    </div>

    <div class="col-md-3">
      <div class="mb-3">
        <label for="eeff_year" class="form-label">Año de los estados financieros</label>
        <input type="number" class="form-control" id="eeff_year" name="eeff_year" min="2000" max="2100" value="<?= $this->supplier->eeff_year ?>" />
      </div>
    </div>

  </div>

  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Operaciones internacionales</span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="mb-3">
        <label class="form-label">¿Realiza operaciones en moneda extranjera? <span>*</span></label>
        <select class="form-control" name="foreign_currency" id="foreign_currency" required>
          <option value="" selected>Seleccione una opción</option>
          <option <?= $this->supplier->foreign_currency == 1 ? 'selected' : '' ?> value="1">Sí</option>
          <option <?= $this->supplier->foreign_currency == 0 ? 'selected' : '' ?> value="0">No</option>
        </select>
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="which_foreign_currency" class="form-label">¿Cuál?</label>
        <input type="text" class="form-control" id="which_foreign_currency" value="<?= $this->supplier->which_foreign_currency ?>" name="which_foreign_currency" />
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label class="form-label">¿Posee productos financieros en el exterior y/o cuentas en moneda extranjera? <span>*</span></label>
        <select class="form-control" name="foreign_products" id="foreign_products" required>
          <option value="" selected>Seleccione una opción</option>
          <option <?= $this->supplier->foreign_products == 1 ? 'selected' : '' ?> value="1">Sí</option>
          <option <?= $this->supplier->foreign_products == 0 ? 'selected' : '' ?> value="0">No</option>
        </select>
      </div>
    </div>

    <div class="col-md-6">
      <div class="mb-3">
        <label for="which_foreign_products" class="form-label">¿Cuál?</label>
        <input type="text" class="form-control" id="which_foreign_products" value="<?= $this->supplier->which_foreign_products ?>" name="which_foreign_products" />
      </div>
    </div>
  </div>

  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Responsabilidades tributarias</span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="mb-3">
        <label for="tax_liabilities" class="form-label"></label>
      </div>
    </div>
  </div>

  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Agente de retencion exento <span>*</span></span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="mb-3">
        <label class="form-label"></label>
        <select class="form-control" name="nontaxable_agent" id="nontaxable_agent" required>
          <option value="" disabled selected>Seleccione una opción</option>
          <option <?= $this->supplier->nontaxable_agent == 1 ? 'selected' : '' ?> value="1">Sí</option>
          <option <?= $this->supplier->nontaxable_agent == 0 ? 'selected' : '' ?> value="0">No</option>
        </select>
      </div>
    </div>
  </div>

  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Responsabilidad de ICA</span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div>

  <div class="row" id="icaLiabilitiesContainer">
    <div class="col-md-3">
      <button type="button" class="btn btn-secondary mb-3 text-white" id="addIcaLiability">Agregar responsabilidad ICA</button>
    </div>
  </div>

  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Ley o Régimen Tributario Especial</span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="mb-3">
        <label class="form-label"></label>
        <select class="form-control" name="tax_regime" id="tax_regime" required>
          <option value="" disabled selected>Seleccione una opción</option>

          <option <?= $this->supplier->tax_regime == 1 ? 'selected' : '' ?> value="1">Si</option>
          <option <?= $this->supplier->tax_regime == 0 ? 'selected' : '' ?> value="0">No</option>
        </select>
      </div>
    </div>
  </div>

  <div class="col-12 py-3 pt-4">
    <div class="row align-items-center">
      <div class="col-4 pe-0">
        <span class="text-lg text-slate-800 font-medium">Declaración de renta</span>
      </div>
      <div class="col-8">
        <hr>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-3">
      <div class="mb-3">
        <label for="tax_declaration_year" class="form-label">Año de la declaración de renta</label>
        <input type="number" class="form-control" id="tax_declaration_year" name="tax_declaration_year" min="2000" max="2100" value="<?= $this->supplier->tax_declaration_year ?>" />
      </div>
    </div>

    <div class="col-md-4">
      <div class="mb-3">
        <label class="form-label">Declaración de renta</label>
        <input type="file" name="tax_declaration" accept="application/pdf, image/png, image/jpeg" class="form-control" />
      </div>
    </div>

    <div class="col-md-2">
      <div class="mb-3" id="tax_declaration-download-container">
        <?php if ($this->supplier->tax_declaration && file_exists(FILE_PATH . $this->supplier->tax_declaration)) { ?>
          <a href="/files/<?= $this->supplier->tax_declaration ?>" target="_blank" class="btn bg-blue text-white rounded-0 mt-4"><i class="fa-solid fa-download"></i> Descargar</a>
        <?php } ?>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-center">
    <button type="submit" class="bg-orange text-white rounded-0">Guardar Información Financiera</button>
  </div>
</form>
<script>
  function initializeMaskMoney(currencyType) {
    const settings = {
      'COP': {
        prefix: '$ ',
        suffix: '',
        thousands: '.',
        decimal: ',',
        precision: 0,
        allowZero: true,
        allowNegative: false
      },
      'USD': {
        prefix: '$ ',
        suffix: '',
        thousands: ',',
        decimal: '.',
        precision: 0,
        allowZero: true,
        allowNegative: false
      },
      'EUR': {
        prefix: '€ ',
        suffix: '',
        thousands: '.',
        decimal: ',',
        precision: 0,
        allowZero: true,
        allowNegative: false
      }
    };

    const currencySettings = settings[currencyType];

    $('.only_numbers_price').each(function() {
      const $input = $(this);

      // Limpia el valor actual (remueve formato previo)
      const rawValue = $input.maskMoney('unmasked')[0] || 0;

      // Destruye la máscara anterior y aplica la nueva configuración
      $input.maskMoney('destroy');
      $input.maskMoney(currencySettings);

      // Establece el valor limpio y aplica la máscara
      $input.val(rawValue);
      $input.maskMoney('mask');
    });
  }

  $(document).ready(function() {
    const initialCurrency = $('#currency_type').val();
    initializeMaskMoney(initialCurrency);

    $('#currency_type').on('change', function() {
      const selectedCurrency = $(this).val();
      initializeMaskMoney(selectedCurrency);
    });

    // Función para manejar la visibilidad y requerimiento de campos
    function handleForeignFields() {
      const foreignCurrency = $('#foreign_currency').val();
      const foreignProducts = $('#foreign_products').val();

      // Manejo de campos de moneda extranjera
      const whichForeignCurrency = $('#which_foreign_currency');
      if (foreignCurrency === '1') {
        whichForeignCurrency.prop('disabled', false);
        whichForeignCurrency.prop('required', true);
      } else {
        whichForeignCurrency.prop('disabled', true);
        whichForeignCurrency.prop('required', false);
        if (foreignCurrency === '0') {
          whichForeignCurrency.val(''); // Solo limpiar si se cambia a No
        }
      }

      // Manejo de campos de productos financieros
      const whichForeignProducts = $('#which_foreign_products');
      if (foreignProducts === '1') {
        whichForeignProducts.prop('disabled', false);
        whichForeignProducts.prop('required', true);
      } else {
        whichForeignProducts.prop('disabled', true);
        whichForeignProducts.prop('required', false);
        if (foreignProducts === '0') {
          whichForeignProducts.val(''); // Solo limpiar si se cambia a No
        }
      }
    }

    // Inicializar estado de los campos al cargar la página
    handleForeignFields();

    // Manejar cambios en los selects
    $('#foreign_currency, #foreign_products').on('change', handleForeignFields);
  });
</script>

<script>
  // Función para crear un nuevo formulario de responsabilidad ICA
  function createIcaLiabilityForm(data = null) {
    const container = document.getElementById('icaLiabilitiesContainer');
    const newIndex = document.querySelectorAll('.ica-liability').length;

    const liabilityDiv = document.createElement('div');
    liabilityDiv.className = 'ica-liability mb-3';

    // Generar las opciones de países primero
    let countryOptions = '<option value="" disabled selected>Seleccione un país</option>';
    <?php foreach ($this->list_country as $c): ?>
      <?php
      $name = $c['name'];
      $selected = "' + (data && data.country === \"$name\" ? 'selected' : '') + '";
      ?>
      countryOptions += `<option value="<?= $name ?>" <?= $selected ?>><?= $name ?></option>`;
    <?php endforeach; ?>

    liabilityDiv.innerHTML = `
      <div class="row">
        <div class="col-md-4">
          <div class="mb-3">
            <label for="country_${newIndex}" class="form-label">País <span>*</span></label>
            <select class="form-control country-select" name="ica_liabilities[${newIndex}][country]" required>
              ${countryOptions}
            </select>
          </div>
        </div>

        <div class="col-md-4">
          <div class="mb-3">
            <label for="state_${newIndex}" class="form-label">Departamento/Estado <span>*</span></label>
            <select class="form-control state-select" name="ica_liabilities[${newIndex}][state]" required>
              <option value="" disabled selected>Seleccione un estado</option>
            </select>
          </div>
        </div>

        <div class="col-md-4">
          <div class="mb-3">
            <label for="city_${newIndex}" class="form-label">Ciudad <span>*</span></label>
            <select class="form-control city-select" name="ica_liabilities[${newIndex}][city]" required>
              <option value="" disabled selected>Seleccione una ciudad</option>
            </select>
          </div>
        </div>

        <div class="col-md-4">
          <div class="mb-3">
            <label for="code_${newIndex}" class="form-label">Código ICA <span>*</span></label>
            <input type="text" class="form-control" name="ica_liabilities[${newIndex}][code]" value="${data ? data.code : ''}" required />
          </div>
        </div>

        <div class="col-md-4">
          <div class="mb-3">
            <label for="fee_${newIndex}" class="form-label">Tarifa <span>*</span></label>
            <input type="text" class="form-control only_numbers" name="ica_liabilities[${newIndex}][fee]" value="${data ? data.fee : ''}" required />
          </div>
        </div>
      </div>
      <div class="row">

        <div class="col-md-4">
          <button type="button" class="btn btn-danger text-white remove-ica-liability">Eliminar repsonsabilidad ICA</button>
        </div>
      </div>
      <hr />
    `;

    // Insertar antes del botón de agregar
    const addButton = document.getElementById('addIcaLiability');
    container.insertBefore(liabilityDiv, addButton.parentNode);

    // Inicializar Select2 para los nuevos selects
    const countrySelect = liabilityDiv.querySelector('.country-select');
    const stateSelect = liabilityDiv.querySelector('.state-select');
    const citySelect = liabilityDiv.querySelector('.city-select');

    $(countrySelect).select2({
      placeholder: "Seleccione el país",
      allowClear: true
    });

    $(stateSelect).select2({
      placeholder: "Seleccione el departamento/estado",
      allowClear: true
    });

    $(citySelect).select2({
      placeholder: "Seleccione la ciudad",
      allowClear: true
    });

    // Manejar cambio de país
    $(countrySelect).on('change', function() {
      const selectedCountry = $(this).val();
      const country = countriesData.find(c => c.name === selectedCountry);

      // Resetear selects de estado y ciudad
      $(stateSelect).empty().append('<option value="">Seleccione un estado</option>').trigger('change');
      $(citySelect).empty().append('<option value="">Seleccione una ciudad</option>').trigger('change');

      if (country?.states?.length) {
        country.states.forEach(s => {
          const option = new Option(s.name, s.name);
          $(stateSelect).append(option);
        });
        $(stateSelect).trigger('change');
      }
    });

    // Manejar cambio de estado
    $(stateSelect).on('change', function() {
      const selectedCountry = $(countrySelect).val();
      const selectedState = $(this).val();
      const country = countriesData.find(c => c.name === selectedCountry);
      const state = country?.states?.find(s => s.name === selectedState);

      $(citySelect).empty().append('<option value="">Seleccione una ciudad</option>').trigger('change');

      if (state?.cities?.length) {
        state.cities.forEach(c => {
          const option = new Option(c.name, c.name);
          $(citySelect).append(option);
        });
        $(citySelect).trigger('change');
      }
    });

    // Agregar evento para el botón de eliminar
    liabilityDiv.querySelector('.remove-ica-liability').addEventListener('click', function() {
      liabilityDiv.remove();
    });

    // Si hay datos, cargar estado y ciudad
    if (data) {
      // Primero seleccionar el país
      if (data.country) {
        $(countrySelect).val(data.country).trigger('change');

        // Esperar a que se carguen los estados
        setTimeout(() => {
          if (data.state) {
            $(stateSelect).val(data.state).trigger('change');

            // Esperar a que se carguen las ciudades
            setTimeout(() => {
              if (data.city) {
                $(citySelect).val(data.city).trigger('change');
              }
            }, 100);
          }
        }, 100);
      }
    }
  }

  // Cargar datos al iniciar
  document.addEventListener('DOMContentLoaded', function() {
    // Cargar responsabilidades ICA existentes
    const icaLiabilities = Object.values(<?= json_encode($this->list_ica_liabilities ?? []) ?>);

    // console.log(icaLiabilities);
    if (icaLiabilities.length > 0) {
      icaLiabilities.forEach(liability => {
        createIcaLiabilityForm(liability);
      });
    }

    // Manejar el evento para agregar nueva responsabilidad
    document.getElementById('addIcaLiability').addEventListener('click', function() {
      createIcaLiabilityForm();
    });
  });
</script>

<script>
  // Manejar el envío del formulario
  document.getElementById('financialForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const selectedCurrency = document.getElementById('currency_type').value;

    // Limpia y transforma valores de .only_numbers_price antes de enviar
    document.querySelectorAll('.only_numbers_price').forEach(input => {
      let value = input.value;

      // 1. Eliminar prefijo de moneda y espacios
      value = value.replace(/[^0-9.,]/g, '');

      // 2. Eliminar separador de miles según la moneda
      if (selectedCurrency === 'USD') {
        value = value.replace(/,/g, '');
      } else {
        value = value.replace(/\./g, '');
      }

      // 3. Eliminar decimales (si existen)
      value = value.split(/[.,]/)[0];

      // 4. Reescribir el valor limpio (solo entero)
      input.value = value;
    });

    const formData = new FormData(this);
    const submitBtn = document.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerText = 'Guardando...';

    try {
      const resp = await fetch(this.action, {
        method: 'POST',
        body: formData
      });
      const json = await resp.json();

      if (json.success) {
        // Actualizar enlaces de descarga si existen
        if (json.supplier) {
          if (json.supplier.eeff) {
            const eeffDownloadContainer = document.getElementById('eeff-download-container');
            eeffDownloadContainer.innerHTML = `
              <a href="/files/${json.supplier.eeff}" target="_blank" class="btn bg-blue text-white rounded-0 mt-4">
                <i class="fa-solid fa-download"></i> Descargar
              </a>
            `;
          }

          if (json.supplier.tax_declaration) {
            const taxDeclarationDownloadContainer = document.getElementById('tax_declaration-download-container');
            taxDeclarationDownloadContainer.innerHTML = `
              <a href="/files/${json.supplier.tax_declaration}" target="_blank" class="btn bg-blue text-white rounded-0 mt-4">
                <i class="fa-solid fa-download"></i> Descargar
              </a>
            `;
          }

          // Actualizar responsabilidades ICA si existen
          if (json.ica_liabilities) {
            const container = document.getElementById('icaLiabilitiesContainer');
            // Eliminar todos los formularios existentes excepto el botón de agregar
            const addButton = document.getElementById('addIcaLiability');
            while (container.firstChild !== addButton.parentNode) {
              container.removeChild(container.firstChild);
            }
            // Agregar los nuevos formularios
            json.ica_liabilities.forEach(liability => {
              createIcaLiabilityForm(liability);
            });
          }
        }

        showAlert({
          title: json.title || 'Listo',
          text: json.text || 'Información financiera guardada correctamente',
          icon: json.icon || 'success',
          confirmButtonText: json.confirmButtonText || 'Continuar',
          html: json.html || '',
        });
      } else {
        showAlert({
          title: json.title || 'Error',
          text: json.text || 'Revisa los datos',
          icon: json.icon || 'error',
          confirmButtonText: json.confirmButtonText || 'Continuar',
          html: json.html || '',
        });
      }
    } catch (err) {
      showAlert({
        title: 'Error',
        text: 'No se pudo guardar la información.',
        icon: 'error',
      });
    } finally {
      submitBtn.disabled = false;
      submitBtn.innerText = 'Guardar Información Financiera';

      // Reactivar las máscaras de los inputs preservando los valores
      const selectedCurrency = document.getElementById('currency_type').value;

      // Guardar los valores actuales
      const currentValues = {};
      $('.only_numbers_price').each(function() {
        const $input = $(this);
        currentValues[$input.attr('id')] = $input.val();
      });

      // Aplicar las máscaras
      initializeMaskMoney(selectedCurrency);

      // Restaurar los valores
      $('.only_numbers_price').each(function() {
        const $input = $(this);
        const savedValue = currentValues[$input.attr('id')];
        if (savedValue) {
          $input.val(savedValue);
          $input.maskMoney('mask');
        }
      });
    }
  });
</script>

<script>
  window.countriesData = <?= json_encode($this->list_country) ?>;
</script>