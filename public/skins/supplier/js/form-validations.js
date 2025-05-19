document.addEventListener("DOMContentLoaded", function () {
  // ——— 1) PREVIEW / CANCEL IMAGE ———
  const originalImageSrc = document.getElementById("preview-avatar")?.src;

  window.previewImage = function (input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = (e) => {
        document.getElementById("preview-avatar").src = e.target.result;
        document.getElementById("cancel-btn-container").style.display = "block";
      };
      reader.readAsDataURL(input.files[0]);
    }
  };

  window.cancelImage = function () {
    const input = document.getElementById("image");
    input.value = "";
    document.getElementById("preview-avatar").src = originalImageSrc;
    document.getElementById("cancel-btn-container").style.display = "none";
  };

  // ——— 2) VALIDACIÓN DE NIT ———
  const nitInput = document.getElementById("identification_nit");
  const nitType = document.getElementById("nit_type");
  const nitError = document.getElementById("nit-error");

  nitType?.addEventListener("change", function () {
    if (this.value) {
      nitInput.disabled = false;
    } else {
      nitInput.disabled = true;
      nitInput.value = "";
      nitError.classList.add("d-none");
      nitError.innerText = "";
    }
    if (nitInput.value.trim() !== "") validateNIT();
  });

  window.validateNIT = function () {
    let v = nitInput.value.replace(/[^0-9-]/g, "");
    nitInput.value = v;
    nitError.classList.add("d-none");
    nitError.innerText = "";

    if (!v) return;
    if (nitType.value === "colombian" && !/^\d+-\d$/.test(v)) {
      nitError.innerText =
        'El NIT de Colombia debe tener el formato "12345678-9".';
      nitError.classList.remove("d-none");
    } else if (nitType.value === "foreign" && !/^\d+$/.test(v)) {
      nitError.innerText = "El NIT extranjero debe contener solo números.";
      nitError.classList.remove("d-none");
    }
  };

  // ——— 3) PAÍS / ESTADO / CIUDAD ———
  function initCountryStateCity({
    countryId,
    stateId,
    cityId,
    stateWrapperId,
    cityWrapperId,
  }) {
    const countryEl = document.getElementById(countryId);
    const stateEl = document.getElementById(stateId);
    const cityEl = document.getElementById(cityId);
    const sw = document.getElementById(stateWrapperId);
    const cw = document.getElementById(cityWrapperId);
    const colombiaId = countriesData.find(
      (c) => c.name.toLowerCase() === "colombia"
    )?.id;

    countryEl?.addEventListener("change", () => {
      const sel = parseInt(countryEl.value, 10);
      stateEl.innerHTML = '<option value="">Seleccione...</option>';
      cityEl.innerHTML = '<option value="">Seleccione...</option>';
      sw.classList.add("d-none");
      cw.classList.add("d-none");

      if (sel === colombiaId) {
        const country = countriesData.find((c) => c.id === sel);
        country.states?.forEach((s) => {
          const o = new Option(s.name, s.name);
          stateEl.appendChild(o);
        });
        sw.classList.remove("d-none");
      }
    });

    stateEl?.addEventListener("change", () => {
      const cid = parseInt(countryEl.value, 10);
      const sid = parseInt(stateEl.value, 10);
      cityEl.innerHTML = '<option value="">Seleccione...</option>';
      cw.classList.add("d-none");

      if (cid === colombiaId && sid) {
        const country = countriesData.find((c) => c.id === cid);
        const state = country.states.find((s) => s.id === sid);
        state.cities?.forEach((ct) => {
          const o = new Option(ct.name, ct.name);
          cityEl.appendChild(o);
        });
        cw.classList.remove("d-none");
      }
    });
  }

  initCountryStateCity({
    countryId: "country",
    stateId: "state",
    cityId: "city",
    stateWrapperId: "state-wrapper",
    cityWrapperId: "city-wrapper",
  });
  initCountryStateCity({
    countryId: "birth_country",
    stateId: "birth_state",
    cityId: "birth_city",
    stateWrapperId: "birth-state-wrapper",
    cityWrapperId: "birth-city-wrapper",
  });

  // ——— 4) TOGGLE CONTRASEÑA ———
  document.querySelectorAll("input.toggle-password").forEach((input) => {
    const wrapper = input.closest(".form-group");
    const toggle = wrapper.querySelector(".password-eye");
    const icon = toggle.querySelector("i");
    toggle.addEventListener("click", () => {
      if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
      } else {
        input.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
      }
      input.focus();
      input.setSelectionRange(input.value.length, input.value.length);
    });
  });

  // ——— 5) VALIDACIÓN DE FORMULARIO ———
  const form = document.querySelector(".supplier-register-form form");
  const btnSubmit = form.querySelector('button[type="submit"]');
  const touched = {};

  function getErrorContainer(el) {
    let err = el.parentNode.querySelector(".error-msg");
    if (!err) {
      err = document.createElement("small");
      err.className = "text-danger error-msg";
      el.parentNode.appendChild(err);
    }
    return err;
  }

  function validateIsLegalEntity(showError = false) {
    const el = form.querySelector("#is_legal_entity");
    const err = getErrorContainer(el);
    if (!el.value) {
      if (showError) err.textContent = "Selecciona tipo de persona.";
      return false;
    }
    err.textContent = "";
    return true;
  }

  function validateCompanyName(showError = false) {
    const inp = form.querySelector("#company_name");
    const v = inp.value;
    const err = getErrorContainer(inp);

    if (!v.trim()) {
      if (showError) err.textContent = "La razón social es obligatoria.";
      return false;
    }

    if (err.textContent) return false;
    err.textContent = "";
    return true;
  }

  function validateNITField(showError = false) {
    const inp = nitInput;
    const err = getErrorContainer(inp);
    window.validateNIT();
    if (!inp.value.trim()) {
      if (showError) err.textContent = "El NIT es obligatorio.";
      return false;
    }
    if (!nitError.classList.contains("d-none")) {
      return false;
    }
    if (err.textContent) {
      return false;
    }
    err.textContent = "";
    return true;
  }

  function validateEmail(showError = false) {
    const inp = form.querySelector("#email");
    const v = inp.value.trim();
    const err = getErrorContainer(inp);
    const forbidden = [
      "gmail.com",
      "hotmail.com",
      "yahoo.com",
      "outlook.com",
      "msn.com",
    ];
    const domain = v.split("@")[1] || "";
    if (!v.includes("@") || forbidden.includes(domain)) {
      if (showError) err.textContent = "Usa un correo corporativo válido.";
      return false;
    }
    err.textContent = "";
    return true;
  }

  function validateEmailConfirmation(showError = false) {
    const inp = form.querySelector("#email_confirmation");
    const err = getErrorContainer(inp);
    if (inp.value.trim() !== form.querySelector("#email").value.trim()) {
      if (showError) err.textContent = "Los correos no coinciden.";
      return false;
    }
    err.textContent = "";
    return true;
  }

  function validatePassword(showError = false) {
    const inp = form.querySelector("#password");
    const err = getErrorContainer(inp);
    const v = inp.value;
    const msgs = [];
    if (v.length < 8 || v.length > 15) msgs.push("8–15 caracteres");
    if (!/[A-Z]/.test(v)) msgs.push("1 letra mayúscula");
    if (!/\d/.test(v)) msgs.push("1 número");
    if (!/[!@#$%^&*(),.?\":{}|<>-]/.test(v)) msgs.push("1 carácter especial");
    if (msgs.length) {
      if (showError)
        err.textContent = "La contraseña debe tener: " + msgs.join(", ");
      return false;
    }
    err.textContent = "";
    return true;
  }

  function validatePasswordConfirmation(showError = false) {
    const inp = form.querySelector("#password_confirmation");
    const err = getErrorContainer(inp);
    if (inp.value !== form.querySelector("#password").value) {
      if (showError) err.textContent = "Las contraseñas no coinciden.";
      return false;
    }
    err.textContent = "";
    return true;
  }

  function validatePhone(showError = false) {
    const inp = form.querySelector("#phone");
    const err = getErrorContainer(inp);
    const nums = inp.value.replace(/\D/g, "");
    inp.value = nums;
    if (!/^\d{7,15}$/.test(nums)) {
      if (showError) err.textContent = "Teléfono inválido.";
      return false;
    }
    err.textContent = "";
    return true;
  }

  function validateCommercialActivity(showError = false) {
    const ta = form.querySelector("#commercial_activity");
    const cnt = document.getElementById("char-count");
    const len = ta.value.length;
    cnt.textContent = `${len}/700`;
    if (len > 700) {
      if (showError) cnt.classList.add("text-danger");
      return false;
    }
    cnt.classList.remove("text-danger");
    return true;
  }

  function validateCountryStateCity(showError = false) {
    let ok = true;
    const colombiaId = countriesData.find(
      (c) => c.name.toLowerCase() === "colombia"
    )?.id;
    const c = form.querySelector("#country");
    if (!c.value) {
      ok = false;
      if (showError) getErrorContainer(c).textContent = "Selecciona país.";
    } else getErrorContainer(c).textContent = "";
    if (parseInt(c.value, 10) === colombiaId) {
      const s = form.querySelector("#state"),
        y = form.querySelector("#city");
      if (!s.value) {
        ok = false;
        if (showError) getErrorContainer(s).textContent = "Selecciona estado.";
      } else getErrorContainer(s).textContent = "";
      if (!y.value) {
        ok = false;
        if (showError) getErrorContainer(y).textContent = "Selecciona ciudad.";
      } else getErrorContainer(y).textContent = "";
    }
    return ok;
  }

  function validateBirthCountryStateCity(showError = false) {
    let ok = true;
    const colombiaId = countriesData.find(
      (c) => c.name.toLowerCase() === "colombia"
    )?.id;
    const bc = form.querySelector("#birth_country");
    if (!bc.value) {
      ok = false;
      if (showError) getErrorContainer(bc).textContent = "Selecciona país.";
    } else getErrorContainer(bc).textContent = "";
    if (parseInt(bc.value, 10) === colombiaId) {
      const bs = form.querySelector("#birth_state"),
        by = form.querySelector("#birth_city");
      if (!bs.value) {
        ok = false;
        if (showError) getErrorContainer(bs).textContent = "Selecciona estado.";
      } else getErrorContainer(bs).textContent = "";
      if (!by.value) {
        ok = false;
        if (showError) getErrorContainer(by).textContent = "Selecciona ciudad.";
      } else getErrorContainer(by).textContent = "";
    }
    return ok;
  }

  function validateIndustryGroups(showError = false, targetGroup = null) {
    let ok = true;
    document.querySelectorAll(".industry-group").forEach((group) => {
      // si targetGroup viene definido y no es este grupo, lo saltamos
      if (targetGroup && group !== targetGroup) return;
      const groupOk = validateIndustryGroup(group, showError);
      if (!groupOk) ok = false;
    });
    return ok;
  }
  function validateIndustryGroup(groupEl, showError = false) {
    let ok = true;
    const ind = groupEl.querySelector(".industry-select");
    const seg = groupEl.querySelector(".segment-select");
    // console.log($(seg).val());
    const ie = getErrorContainer(ind);
    const se = getErrorContainer(seg);

    // industria
    if (!ind.value) {
      ok = false;
      if (showError) ie.textContent = "Selecciona industria.";
    } else {
      ie.textContent = "";
    }

    // segmentos
    const datos = $(seg).select2("data"); // array de objetos { id, text, … }
    if (datos.length === 0) {
      ok = false;
      if (showError) se.textContent = "Selecciona al menos un segmento.";
    } else {
      se.textContent = "";
    }

    return ok;
  }

  function validatePolicies() {
    return Array.from(
      form.querySelectorAll('input[type="checkbox"][name^="policy"]')
    ).every((cb) => cb.checked);
  }

  const fieldValidators = {
    is_legal_entity: validateIsLegalEntity,
    company_name: validateCompanyName,
    identification_nit: validateNITField,
    email: validateEmail,
    email_confirmation: validateEmailConfirmation,
    password: validatePassword,
    password_confirmation: validatePasswordConfirmation,
    phone: validatePhone,
    commercial_activity: validateCommercialActivity,
    country: validateCountryStateCity,
    state: validateCountryStateCity,
    city: validateCountryStateCity,
    birth_country: validateBirthCountryStateCity,
    birth_state: validateBirthCountryStateCity,
    birth_city: validateBirthCountryStateCity,
  };

  function isFormValid() {
    return (
      validateIsLegalEntity(false) &&
      validateCompanyName(false) &&
      validateNITField(false) &&
      validateEmail(false) &&
      validateEmailConfirmation(false) &&
      validatePassword(false) &&
      validatePasswordConfirmation(false) &&
      validatePhone(false) &&
      validateCommercialActivity(false) &&
      validateCountryStateCity(false) &&
      validateBirthCountryStateCity(false) &&
      validateIndustryGroups(false) &&
      validatePolicies()
    );
  }

  function toggleSubmit() {
    btnSubmit.disabled = !isFormValid();
  }

  // ——— 6) “TOUCH” Y EVENT LISTENERS DE CAMPOS ———
  Object.keys(fieldValidators).forEach((id) => {
    const el = form.querySelector(`#${id}`);
    if (!el) return;
    const ev =
      el.tagName === "SELECT" || el.type === "checkbox" ? "change" : "input";
    el.addEventListener(ev, () => {
      touched[id] = true;
      fieldValidators[id](true);
      if (id === "email" && touched.email_confirmation)
        validateEmailConfirmation(true);
      if (id === "password" && touched.password_confirmation)
        validatePasswordConfirmation(true);
      toggleSubmit();
    });
  });

  // valida Tipo de Persona al cambiar
  form.querySelector("#is_legal_entity").addEventListener("change", () => {
    touched.is_legal_entity = true;
    validateIsLegalEntity(true);
    toggleSubmit();
  });

  // valida checkboxes de políticas
  form
    .querySelectorAll('input[type="checkbox"][name^="policy"]')
    .forEach((cb) => cb.addEventListener("change", toggleSubmit));

  // bloquea submit si no es válido
  form.addEventListener("submit", (e) => {
    if (!isFormValid()) e.preventDefault();
  });

  // ——— 7) GRUPOS DINÁMICOS DE INDUSTRIA Y SEGMENTOS ———
  let groupIndex = 1;
  const containerEl = document.getElementById("industry-groups-container");
  let industryOptionsHTML = "";

  const first = document.querySelector(".industry-select");
  industryOptionsHTML = first ? first.innerHTML : "";
  window.addIndustryGroup = function () {
    const newGroup = document.createElement("div");
    newGroup.className = "industry-group mb-3";
    newGroup.dataset.index = groupIndex;
    newGroup.innerHTML = `
      <div class="row">
        <div class="col-md-4 form-group">
          <label class="control-label">Industria <span>*</span></label>
          <select name="groups[${groupIndex}][industry]" class="form-control industry-select  selec-search" required>
           ${industryOptionsHTML}
          </select>
          <small class="error-msg text-danger"></small>
        </div>
        <div class="col-md-4 form-group">
          <label class="control-label">Segmentos <span>*</span></label>
          <select name="groups[${groupIndex}][segments][]" multiple
                  class="form-control segment-select selec-multiple" required>
          </select>
          <small class="error-msg text-danger"></small>
        </div>
        <div class="col-md-2 form-group">
          <label class="control-label">&nbsp;</label>
          <button type="button" class="btn btn-danger rounded-0 mb-2 text-white"
                  onclick="removeIndustryGroup(this)">
          
            Eliminar
          </button>
        </div>
      </div>
    `;
    containerEl.appendChild(newGroup);
    $(newGroup).find(".selec-search").select2({
      width: "100%",
      placeholder: "Busca una industria",
      // allowClear: true,
    });

    attachIndustryChangeHandlers(newGroup);
    groupIndex++;
  };

  // ——— FUNCIÓN PARA REMOVER UN GRUPO DINÁMICO ———
  window.removeIndustryGroup = function (button) {
    // button es el <button> clicado
    const group = button.closest(".industry-group");
    if (!group) return;
    group.remove(); // elimina todo el bloque
    toggleSubmit(); // revalida el formulario y el estado del submit
  };

  function attachIndustryChangeHandlers(scope) {
    const industrySelect = scope.querySelector(".industry-select");
    const segmentSelect = scope.querySelector(".segment-select");
    const $ind = $(industrySelect);

    // init select2
    if ($(segmentSelect).hasClass("selec-multiple")) {
      if ($(segmentSelect).hasClass("select2-hidden-accessible")) {
        $(segmentSelect).select2("destroy");
      }
      $(segmentSelect).select2({
        width: "100%",
        tags: true,
        placeholder: "Seleccione uno o más segmentos",
      });

      // al cambiar segmentos → update tags + validar
      $(segmentSelect).on("change", () => {
        // updateSegmentTags();
        validateIndustryGroups(true, scope);
        toggleSubmit();
      });
    }

    // contenedor de tags
    /* let tagsContainer = scope.querySelector(".segment-tags");
    if (!tagsContainer) {
      tagsContainer = document.createElement("div");
      tagsContainer.className = "segment-tags mb-2";
      segmentSelect.parentNode.appendChild(tagsContainer);
    } */

    /* function updateSegmentTags() {
      tagsContainer.innerHTML = "";
      Array.from(segmentSelect.selectedOptions).forEach((opt) => {
        const badge = document.createElement("span");
        badge.className = "badge bg-secondary me-1";
        badge.textContent = opt.text;
        const btn = document.createElement("button");
        btn.type = "button";
        btn.className = "btn-close btn-close-white btn-sm ms-1";
        btn.setAttribute("aria-label", "Remove");
        btn.addEventListener("click", () => {
          opt.selected = false;
          $(segmentSelect).trigger("change");
          updateSegmentTags();
          validateIndustryGroups(true);
          toggleSubmit();
        });
        badge.appendChild(btn);
        tagsContainer.appendChild(badge);
      });
    } */

    // al cambiar industria → fetch segmentos
    $ind.off("change.industry").on("change.industry", async function () {
      const id = $(this).val();
      segmentSelect.innerHTML = "<option>Cargando…</option>";
      try {
        const resp = await fetch(
          `/supplier/register/getsegments/?industryId=${id}`
        );
        const list = await resp.json();
        segmentSelect.innerHTML = "";
        list.forEach((s) =>
          segmentSelect.appendChild(new Option(s.name, s.id))
        );
        $(segmentSelect).trigger("change");
      } catch {
        segmentSelect.innerHTML = "<option>Error al cargar</option>";
      }
      // updateSegmentTags();
      validateIndustryGroups(true, scope);
      toggleSubmit();
    });

    // init
    // updateSegmentTags();
  }

  // engancha primer grupo del DOM
  document.querySelectorAll(".industry-group").forEach((el) => {
    attachIndustryChangeHandlers(el);
  });

  // ——— 9) AJAX VALIDATION CON DEBOUNCE ———
  function debounce(fn, delay) {
    let timeout;
    return function (...args) {
      clearTimeout(timeout);
      timeout = setTimeout(() => fn.apply(this, args), delay);
    };
  }

  const nitField = document.getElementById("identification_nit");
  const companyField = document.getElementById("company_name");

  // ——— AJAX VALIDACIÓN DEL NIT ———
  async function doAjaxValidateNIT(value) {
    const err = getErrorContainer(nitField);
    // limpio si no hay texto
    if (!value) {
      err.textContent = "";
      err.classList.add("d-none");

      toggleSubmit();
      return;
    }
    try {
      const response = await fetch(
        `/supplier/register/validatenit?nit=${encodeURIComponent(value)}`
      );
      if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
      }
      // ¡UNA SOLA LECTURA!
      const data = await response.json();
      if (data.valid === false) {
        err.textContent = data.message || "Este NIT ya está registrado.";
        err.classList.remove("d-none");
        err.classList.add("d-block");
      } else if (touched.identification_nit) {
        err.textContent = "";
        err.classList.add("d-none");
      }
    } catch (e) {
      console.error("Error validando NIT:", e);
      // opcional: mostrar un mensaje genérico
      // err.textContent = "No fue posible validar NIT ahora.";
    }
    toggleSubmit();
  }

  // ——— AJAX VALIDACIÓN DE RAZÓN SOCIAL ———
  async function doAjaxValidateCompanyName(value) {
    const err = getErrorContainer(companyField);
    // console.log("validando NIT", value);
    // console.log("validando errNIT", err);
    if (!value) {
      err.textContent = "";
      err.classList.add("d-none");
      toggleSubmit();
      return;
    }
    try {
      const response = await fetch(
        `/supplier/register/validatecompany?name=${encodeURIComponent(value)}`
      );
      if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
      }
      // ¡UNA SOLA LECTURA!
      const data = await response.json();

      if (!data.valid) {
        err.textContent = data.message || "Esta razón social ya existe.";
        err.classList.remove("d-none");
        err.classList.add("d-block");
      } else if (touched.company_name) {
        err.textContent = "";
        err.classList.add("d-none");
      }
    } catch (e) {
      console.error("Error validando razón social:", e);
      // opcional: err.textContent = "No fue posible validar ahora.";
    }
    toggleSubmit();
  }

  // ——— DEBOUNCERS Y LISTENERS ———
  const debouncedNIT = debounce(doAjaxValidateNIT, 500);
  const debouncedCompany = debounce(doAjaxValidateCompanyName, 500);

  nitField?.addEventListener("input", (e) => {
    touched.identification_nit = true;
    debouncedNIT(e.target.value.trim());
  });

  nitField?.addEventListener("blur", (e) => {
    doAjaxValidateNIT(e.target.value.trim());
  });

  companyField?.addEventListener("input", (e) => {
    touched.company_name = true;
    debouncedCompany(e.target.value.trim());
  });
  companyField?.addEventListener("blur", (e) => {
    const cleaned = e.target.value.trim().toUpperCase();
    e.target.value = cleaned;
    doAjaxValidateCompanyName(cleaned);
  });
});
