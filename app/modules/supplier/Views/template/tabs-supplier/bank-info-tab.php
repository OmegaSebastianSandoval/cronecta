<div class="alert alert-warning py-2 w-100" role="alert">
  Todos los campos con (*) son obligatorios
</div>

<div class="text-end mb-2 div_completitud">Haz completado el <span class="completitud" id="completitud7">-%</span> de esta sección</div>

<div class="row mb-3 d-none">
  <div class="col-md-12">
    <div class="alert alert-secondary">
      <div class="row">
        <div class="col-md-4">
          <input
            placeholder="Buscar por banco"
            id="input_banco"
            class="form-control"
            onkeyup="buscar_info_bancaria()" />
        </div>
        <div class="col-md-4">
          <input
            placeholder="Buscar por numero de cuenta"
            id="input_cuenta"
            class="form-control"
            onkeyup="buscar_info_bancaria2()" />
        </div>
      </div>
    </div>
  </div>
</div>
<form action="/supplier/profile/savebankinfo" id="form_info_bancaria" class="supplier-register-form form-bx" method="post" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?= $this->supplier->id ?>">
  <input type="hidden" name="id-user" value="<?= $this->userSupplier->id ?>">
  <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
  <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
  <div id="bankinfo-container">
    <!-- Los elementos bancarios se agregarán aquí dinámicamente -->
  </div>

  <button type="button" class="btn btn-secondary mb-3 text-white" id="add-bankinfo-btn">
    Agregar información bancaria
  </button>

  <div class="d-flex justify-content-center">
    <button type="submit" class="bg-orange text-white rounded-0" id="submitFormBankInfo">
      Guardar información bancaria
    </button>
  </div>
</form>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Cargar datos desde la base de datos al iniciar
    loadBankDataFromDB();

    // Manejar el evento para agregar nuevos campos bancarios
    $('#add-bankinfo-btn').click(function() {
      addBankInfoItem();
    });

    // Delegación de eventos para elementos dinámicos
    $(document).on('change', '.country-select', function() {
      const country = $(this).val();
      const swiftContainer = $(this).closest('.bankinfo-item').find('.foreign-account-fields');
      const accountTypeSelect = $(this).closest('.bankinfo-item').find('[name="account_type[]"]');

      if (country !== 'Colombia') {
        swiftContainer.removeClass('d-none');
        swiftContainer.find('input').prop('required', true);
        accountTypeSelect.val('Internacional');
      } else {
        swiftContainer.addClass('d-none');
        swiftContainer.find('input').prop('required', false);
        accountTypeSelect.val('Nacional');
      }
    });

    $(document).on('click', '.remove-bankinfo', function() {
      $(this).closest('.bankinfo-item').remove();
    });
  });

  // Función para cargar datos desde la base de datos
  function loadBankDataFromDB() {
    // Este es un ejemplo con datos simulados
    const bankData = <?php echo json_encode($this->list_banks ?? []); ?>;
    // console.log(bankData);
    if (bankData.length > 0) {
      bankData.forEach(data => {
        addBankInfoItem(data);
      });
    } else {
      // Si no hay datos, agregar un formulario vacío
      addBankInfoItem();
    }
  }

  // Función para agregar un nuevo conjunto de campos bancarios
  function addBankInfoItem(data = null, returnHtml = false) {
    const newId = Date.now(); // ID único para el nuevo elemento

    // Construir el HTML de forma más segura
    let bankInfoItem = `
      <div class="fila_banco mb-3 bankinfo-item" data-id="${newId}">
        <div class="row">
          <div class="col-12 col-md-4">
            <div class="mb-3">
              <label class="form-label">País <span>*</span></label>
              <select type="text" class="form-control country-select" name="country[]" required>
            <option value="Colombia">Colombia</option>
            <option class="separador" disabled>____________________________</option>`;

    <?php
    $countryOptions = '';
    foreach ($this->list_country as $country) {
      $countryName = $country['name'];
      $countryOptions .= "`<option value=\"{$countryName}\" " .
        '${data && data.country === `' . $countryName . '` ? "selected" : ""}>' .
        "{$countryName}</option>` + ";
    }
    ?>
    bankInfoItem += <?= rtrim($countryOptions, '+ ') ?>;
    // Continuar con el resto del HTML
    bankInfoItem += `
              </select>
            </div>
          </div>

          <div class="col-12 col-md-4">
            <div class="mb-3">
              <label for="bank" class="form-label">Banco <span>*</span></label>
              <input type="text" class="form-control banco1" name="bank[]" value="${data ? (data.bank || '') : ''}" required />
            </div>
          </div>

          <div class="col-12 col-md-4">
            <div class="mb-3">
              <label for="office" class="form-label">Sucursal <span>*</span></label>
              <input type="text" class="form-control" name="office[]" value="${data ? (data.office || '') : ''}" required />
            </div>
          </div>



          <div class="col-12 col-md-4">
            <div class="mb-3">
              <label for="holder" class="form-label">Títular de la cuenta <span>*</span></label>
              <input type="text" class="form-control" name="holder[]" value="${data ? (data.holder || '') : ''}" required />
            </div>
          </div>

          <div class="col-12 col-md-4">
            <div class="mb-3">
              <label for="account_type" class="form-label">Tipo de cuenta <span>*</span></label>
              <select class="form-control" name="account_type[]" required>
                <option value="" disabled selected>Seleccione un tipo de cuenta</option>
                <option value="Ahorros" ${data && data.account_type === 'Ahorros' ? 'selected' : ''}>Ahorros</option>
                <option value="Corriente" ${data && data.account_type === 'Corriente' ? 'selected' : ''}>Corriente</option>
              </select>
            </div>
          </div>

          <div class="col-12 col-md-4">
            <div class="mb-3">
              <label for="account_number" class="form-label">Número de cuenta <span>*</span></label>
              <input type="number" class="form-control cuenta1 only_numbers" name="account_number[]" value="${data ? (data.account_number || '') : ''}" required />
            </div>
          </div>

          <div class="col-12 col-md-4">
            <div class="mb-3">
              <label for="holder" class="form-label">Fecha de certificado bancario (no mayor a 80 días)<span>*</span></label>
              <input type="date" class="form-control" name="account_certificate_udate[]" value="${data ? (data.account_certificate_udate || '') : ''}" required max="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d', strtotime('-80 days')) ?>" />
            </div>
          </div>

          <div class="col-md-4">
            <div class="mb-3">
              <label for="account_certificate" class="form-label">Certificación bancaria</label>
              <input
                type="file"
                accept="application/pdf, image/png, image/jpeg"
                class="form-control d-none"
                name="account_certificate[]" id="account_certificate${newId}" onchange="$('#account_certificate${newId}_file').val(limpiar_path(this.value));" />

                <div class="input-group">
                  <div class="input-group-prepend div-examinar">
                    <button class="btn boton-examinar" type="button" onclick="$('#account_certificate${newId}').click();">Examinar</button>
                  </div>
                  <input id="account_certificate${newId}_file" readonly type="text" class="form-control campo-examinar" onclick="$('#account_certificate${newId}').click();" value="${data.account_certificate || 'Seleccione un archivo'}" />
                </div>

            </div>
          </div>

          <div class="col-12 col-md-4 mt-4 mb-2 mb-md-0">`;

    // Botón de descarga condicional
    if (data && data.account_certificate) {
      bankInfoItem += `
            <a class="btn bg-blue text-white rounded-0" href="/files/${(data.account_certificate)}" target="_blank">
              <i class="fa-solid fa-download"></i> Descargar
            </a>`;
    }

    // Campos de cuentas extranjeras
    bankInfoItem += `
    <input type="hidden" name="existing_account_certificate[]" value="${data ? (data.account_certificate || '') : ''}">
          </div>

          <div class="row foreign-account-fields ${data && data.country === 'Colombia' ? 'd-none' : ''}">
            <div class="col-12 col-md-2">
              <div class="mb-3">
                <label for="swift_number" class="form-label">Swift Number <span>*</span></label>
                <input type="text" class="form-control" name="swift_number[]" value="${data ? (data.swift_number || '') : ''}" ${data && data.country !== 'Colombia' ? 'required' : ''} />
              </div>
            </div>

            <div class="col-12 col-md-2">
              <div class="mb-3">
                <label for="routing_number" class="form-label">Routing number <span>*</span></label>
                <input type="text" class="form-control" name="routing_number[]" value="${data ? (data.routing_number || '') : ''}" ${data && data.country !== 'Colombia' ? 'required' : ''} />
              </div>
            </div>

            <div class="col-12 col-md-4">
              <div class="mb-3">
                <label for="iban" class="form-label">IBAN (International bank account No) <span>*</span></label>
                <input type="text" class="form-control" name="iban[]" value="${data ? (data.iban || '') : ''}" ${data && data.country !== 'Colombia' ? 'required' : ''} />
              </div>
            </div>

            <div class="col-12 col-md-3">
              <div class="mb-3">
                <label for="bic" class="form-label">BIC (Bank identifier code) <span>*</span></label>
                <input type="text" class="form-control" name="bic[]" value="${data ? (data.bic || '') : ''}" ${data && data.country !== 'Colombia' ? 'required' : ''} />
              </div>
            </div>

            <div class="col-12 col-md-3">
              <div class="mb-3">
                <label for="intermediary_bank" class="form-label">Banco Intermediario / Beneficiario <span>*</span></label>
                <input type="text" class="form-control" name="intermediary_bank[]" value="${data ? (data.intermediary_bank || '') : ''}" ${data && data.country !== 'Colombia' ? 'required' : ''} />
              </div>
            </div>
          </div>
        </div>

        <button type="button" class="btn btn-danger mb-3 text-white remove-bankinfo">
          Eliminar información bancaria
        </button>

        <button type="submit" class="btn btn-confirmar bg-orange text-white rounded-0 margen1">Confirmar información bancaria</button>

        <hr />
      </div>`;
    if (returnHtml) {
      return bankInfoItem;
    } else {


      $('#bankinfo-container').append(bankInfoItem);

      // Inicializar Select2 para el nuevo elemento
      $(`[data-id="${newId}"] .country-select`).select2({
        placeholder: "Seleccione un país",
        allowClear: true
      });

      // Si hay datos, establecer el país y disparar el evento change
      if (data && data.country) {
        $(`[data-id="${newId}"] .country-select`).val(data.country).trigger('change');
      }
    }
  }

  document.addEventListener('DOMContentLoaded', async function() {
    const form = document.getElementById('form_info_bancaria');

    form.addEventListener('submit', async function(event) {
      event.preventDefault();
      const formData = new FormData(form);
      const btn = document.querySelector('#submitFormBankInfo');


      try {
        btn.disabled = true;
        btn.innerHTML = `Enviando...`;

        const resp = await fetch(form.action, {
          method: "POST",
          body: formData,
        });

        if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
        const json = await resp.json();
        // console.log(json);
        if (json.success) {
          // Actualizar la lista de cuentas bancarias con la respuesta
          if (json.accounts && json.accounts.length > 0) {
            updateBankAccountsList(json.accounts);
          }

          showAlert({
            title: json.title || "Éxito",
            text: json.text || "Información bancaria actualizada correctamente",
            icon: json.icon || "success",
            showCancel: false,
            confirmButtonText: "Continuar",
            html: json.html || null,
            redirect: json.redirect,
          });

          completitud7();

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
        // console.error(err);
        showAlert({
          title: "Error",
          text: "No se pudo comunicar con el servidor.",
          icon: "error",
          showCancel: false,
          confirmButtonText: "Continuar",
        });
      } finally {
        btn.disabled = false;
        btn.innerHTML = `Guardar información bancaria`;
      }
    });
  });
  // Función para actualizar la lista de cuentas bancarias
  function updateBankAccountsList(accounts) {
    const container = $('#bankinfo-container');
    const fragment = document.createDocumentFragment();

    // Crear elementos en un fragmento fuera del DOM
    accounts.forEach(account => {
      const item = $(addBankInfoItem(account, true)); // true para devolver el HTML en lugar de añadirlo
      fragment.appendChild(item[0]);
    });

    // Limpiar y añadir todo de una vez
    container.empty().append(fragment);

    if (accounts.length === 0) {
      addBankInfoItem();
    }
  }
</script>
<script>
  function filtrarInfoBancaria() {
    const filtroBanco = document.getElementById('input_banco').value.toLowerCase();
    const filtroCuenta = document.getElementById('input_cuenta').value.toLowerCase();

    document.querySelectorAll('.fila_banco').forEach(fila => {
      const banco = fila.querySelector('.banco1')?.value.toLowerCase() || '';
      const cuenta = fila.querySelector('.cuenta1')?.value.toLowerCase() || '';

      // Mostrar solo si coincide el filtro (banco o cuenta)
      if (
        (filtroBanco && banco.includes(filtroBanco)) ||
        (filtroCuenta && cuenta.includes(filtroCuenta))
      ) {
        fila.style.display = '';
      } else if (!filtroBanco && !filtroCuenta) {
        fila.style.display = ''; // Si no hay filtro, mostrar todas
      } else {
        fila.style.display = 'none';
      }
    });
  }

  // Eventos
  document.getElementById('input_banco').addEventListener('input', filtrarInfoBancaria);
  document.getElementById('input_cuenta').addEventListener('input', filtrarInfoBancaria);
</script>

<script type="text/javascript">
  function completitud7(){
    $.post("/supplier/profile/completitud7/",{ },function(res){
      $("#completitud7").html(res.porcentaje+"%");
      array_completitud[7]=res.porcentaje;
      completeness();
    });
  }
  completitud7();

  function limpiar_path(x){
    return x.replace("C:\\fakepath\\","");
  }  
</script>

<style type="text/css">
.select2-container--default .select2-results__option--disabled {
  padding: 0px !important;
  margin-top: -10px !important;
  margin-bottom: 5px !important;
}  

.margen1{
  margin-top:-15px;
}
.div_completitud{
  position: sticky;
  right: 0;
  top: 200px;
  z-index: 2;
  background-color: white;
}
</style>