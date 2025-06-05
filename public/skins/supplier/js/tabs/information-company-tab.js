// console.log("information-company-tab.js");

// ——— 3) PAÍS / ESTADO / CIUDAD ———
document.addEventListener("DOMContentLoaded", function () {
  function initCountryStateCity({
    countryId,
    stateId,
    cityId,
    stateWrapperId,
    cityWrapperId,
    defaultCountry = "",
    defaultState = "",
    defaultCity = "",
  }) {
    // console.log(defaultCountry, defaultState, defaultCity);
    const countryEl = document.getElementById(countryId);
    const stateEl = document.getElementById(stateId);
    const cityEl = document.getElementById(cityId);
    const sw = document.getElementById(stateWrapperId);
    const cw = document.getElementById(cityWrapperId);

    // Inicializa Select2 en los tres selects
    $(`#${countryId}`).select2({ placeholder: "Seleccione país" });
    $(`#${stateId}`).select2({ placeholder: "Seleccione estado" });
    $(`#${cityId}`).select2({ placeholder: "Seleccione ciudad" });
    // console.log(countryEl);

    $(countryEl).trigger("change");

    const colombiaName = countriesData.find(
      (c) => c.name.toLowerCase() === "colombia"
    )?.name;

    $(`#${countryId}`).trigger("change");

    $(countryEl).val(defaultCountry).trigger("change");

    // Llenar departamentos si Colombia está seleccionado
    if (defaultCountry === "Colombia") {
      const countryData = countriesData.find((c) => c.name === "Colombia");
      if (countryData?.states?.length) {
        $(stateEl).empty().append('<option value="">Seleccione...</option>');
        countryData.states.forEach((s) => {
          $(stateEl).append(new Option(s.name, s.name));
        });
        $(stateEl).val(defaultState).trigger("change");
        sw.classList.remove("d-none");

        // Llenar ciudades si estado coincide
        const state = countryData.states.find((s) => s.name === defaultState);
        if (state?.cities?.length) {
          $(cityEl).empty().append('<option value="">Seleccione...</option>');
          state.cities.forEach((c) => {
            $(cityEl).append(new Option(c.name, c.name));
          });
          $(cityEl).val(defaultCity).trigger("change");
          cw.classList.remove("d-none");
        }
      }
    }

    $(`#${countryId}`).on("change", function () {
      const sel = this.value;
      // console.log(sel);
      // Limpiar selects de estado y ciudad
      $(stateEl)
        .empty()
        .append('<option value="">Seleccione...</option>')
        .trigger("change");
      $(cityEl)
        .empty()
        .append('<option value="">Seleccione...</option>')
        .trigger("change");
      sw.classList.add("d-none");
      cw.classList.add("d-none");

      if (sel === colombiaName) {
        const countryData = countriesData.find((c) => c.name === sel);

        if (countryData?.states?.length) {
          countryData.states.forEach((s) => {
            const o = new Option(s.name, s.name, false, false);
            $(stateEl).append(o);
          });
          $(stateEl).trigger("change"); // Refresca Select2
          sw.classList.remove("d-none");

          stateEl.setAttribute("required", "required");
          cityEl.setAttribute("required", "required");
        }
      } else {
        //  Si NO es Colombia, quitar los "required"
        stateEl.removeAttribute("required");
        cityEl.removeAttribute("required");
      }
    });

    $(`#${stateId}`).on("change", function () {
      const sid = this.value;
      const cid = countryEl.value;
      // const sid = stateEl.value;

      $(cityEl)
        .empty()
        .append('<option value="">Seleccione...</option>')
        .trigger("change");
      cw.classList.add("d-none");

      if (cid === colombiaName && sid) {
        const country = countriesData.find((c) => c.name === cid);
        const state = country.states.find((s) => s.name === sid);
        if (state?.cities?.length) {
          state.cities.forEach((ct) => {
            const o = new Option(ct.name, ct.name, false, false);
            $(cityEl).append(o);
          });
          $(cityEl).trigger("change"); // Refresca Select2
          cw.classList.remove("d-none");
        }
      }
    });
  }


  initCountryStateCity({
    countryId: "birth_country",
    stateId: "birth_state",
    cityId: "birth_city",
    stateWrapperId: "birth_state-wrapper",
    cityWrapperId: "birth_city-wrapper",
    defaultCountry: selectedCountryInfo,
    defaultState: selectedStateInfo,
    defaultCity: selectedCityInfo,
  });


  function initFlexibleLocationSelects({
    countryId,
    stateId,
    cityId,
    stateWrapperId,
    cityWrapperId,
    defaultCountry = "",
    defaultState = "",
    defaultCity = "",
    allFields = false,
  }) {
    const countryEl = document.getElementById(countryId);
    const stateEl = document.getElementById(stateId);
    const cityEl = document.getElementById(cityId);
    const sw = document.getElementById(stateWrapperId);
    const cw = document.getElementById(cityWrapperId);

    // Activar Select2
    $(`#${countryId}`).select2({ placeholder: "Seleccione país" });
    $(`#${stateId}`).select2({ placeholder: "Seleccione estado" });
    $(`#${cityId}`).select2({ placeholder: "Seleccione ciudad" });

    // Set valores por defecto
    $(countryEl).val(defaultCountry).trigger("change");

    // Llenar estados si el país por defecto tiene datos
    const initialCountry = countriesData.find((c) => c.name === defaultCountry);
    if (initialCountry?.states?.length) {
      $(stateEl).empty().append('<option value="">Seleccione...</option>');
      initialCountry.states.forEach((s) => {
        $(stateEl).append(new Option(s.name, s.name));
      });
      $(stateEl).val(defaultState).trigger("change");
      sw.classList.remove("d-none");

      // Llenar ciudades si estado tiene datos
      const foundState = initialCountry.states.find(
        (s) => s.name === defaultState
      );
      if (foundState?.cities?.length) {
        $(cityEl).empty().append('<option value="">Seleccione...</option>');
        foundState.cities.forEach((c) => {
          $(cityEl).append(new Option(c.name, c.name));
        });
        $(cityEl).val(defaultCity).trigger("change");
        cw.classList.remove("d-none");
      }
    }

    // Evento cambio de país
    $(`#${countryId}`).on("change", function () {
      const selectedCountry = this.value;
      const countryData = countriesData.find((c) => c.name === selectedCountry);

      // Limpiar y ocultar
      $(stateEl)
        .empty()
        .append('<option value="">Seleccione...</option>')
        .trigger("change");
      $(cityEl)
        .empty()
        .append('<option value="">Seleccione...</option>')
        .trigger("change");
      sw.classList.add("d-none");
      cw.classList.add("d-none");

      if (countryData?.states?.length) {
        countryData.states.forEach((s) => {
          $(stateEl).append(new Option(s.name, s.name));
        });
        $(stateEl).trigger("change");
        sw.classList.remove("d-none");

        if (allFields || selectedCountry.toLowerCase() === "colombia") {
          stateEl.setAttribute("required", "required");
          cityEl.setAttribute("required", "required");
        }
      } else if (allFields) {
        sw.classList.remove("d-none");
        cw.classList.remove("d-none");
      } else {
        stateEl.removeAttribute("required");
        cityEl.removeAttribute("required");
      }
    });

    // Evento cambio de estado
    $(`#${stateId}`).on("change", function () {
      const selectedState = this.value;
      const selectedCountry = countryEl.value;
      const countryData = countriesData.find((c) => c.name === selectedCountry);
      const stateData = countryData?.states?.find(
        (s) => s.name === selectedState
      );

      $(cityEl)
        .empty()
        .append('<option value="">Seleccione...</option>')
        .trigger("change");
      cw.classList.add("d-none");

      if (stateData?.cities?.length) {
        stateData.cities.forEach((c) => {
          $(cityEl).append(new Option(c.name, c.name));
        });
        $(cityEl).trigger("change");
        cw.classList.remove("d-none");
      } else if (allFields) {
        cw.classList.remove("d-none");
      }
    });
  }

  initFlexibleLocationSelects({
    countryId: "registry_country",
    stateId: "registry_state",
    cityId: "registry_city",
    stateWrapperId: "registry_state-wrapper",
    cityWrapperId: "registry_city-wrapper",
    allFields: true,
  });
  initFlexibleLocationSelects({
    countryId: "rut_certificate_country",
    stateId: "rut_certificate_state",
    cityId: "rut_certificate_city",
    stateWrapperId: "rut_certificate_state-wrapper",
    cityWrapperId: "rut_certificate_city-wrapper",
    allFields: true,

  });

  initFlexibleLocationSelects({
    countryId: "country-information",
    stateId: "state-information",
    cityId: "city-information",
    stateWrapperId: "state-wrapper-information",
    cityWrapperId: "city-wrapper-information",
    defaultCountry: selectedCountry,
    defaultState: selectedState,
    defaultCity: selectedCity,
    allFields: true,
  });

  initFlexibleLocationSelects({
    countryId: "registry_country-cert-exist",
    stateId: "registry_state-cert-exist",
    cityId: "registry_city-cert-exist",
    stateWrapperId: "registry_state-cert-exist-wrapper",
    cityWrapperId: "registry_city-cert-exist-wrapper",
    defaultCountry: selectedCountryExist,
    defaultState: selectedStateExist,
    defaultCity: selectedCityExist,
    allFields: true,
  });
  initFlexibleLocationSelects({
    countryId: "rut_certificate_country",
    stateId: "rut_certificate_state",
    cityId: "rut_certificate_city",
    stateWrapperId: "rut_certificate_state-wrapper",
    cityWrapperId: "rut_certificate_city-wrapper",
    defaultCountry: selectedCountryRut,
    defaultState: selectedStateRut,
    defaultCity: selectedCityRut,
    allFields: true,
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("submitSupplierInfo");

  form.addEventListener("submit", async function (e) {
    e.preventDefault(); // evitar envío por defecto

    const requiredFields = form.querySelectorAll("[required]");
    let valid = true;

    // console.log(requiredFields);

    requiredFields.forEach((field) => {
      const value = field.value.trim();
      const isSelectInvalid = field.tagName === "SELECT" && value === "";
      const isEmpty = !value || isSelectInvalid;

      // Verificar validez
      if (isEmpty) {
        valid = false;
        field.classList.add("is-invalid");

        // Agregar mensaje si no existe
        let error = field.nextElementSibling;
        if (!error || !error.classList.contains("invalid-feedback")) {
          error = document.createElement("div");
          error.classList.add("invalid-feedback");
          error.textContent = "Este campo es obligatorio.";
          field.insertAdjacentElement("afterend", error);
        }
        error.classList.remove("d-none");
      } else {
        field.classList.remove("is-invalid");
        const error = field.nextElementSibling;
        if (error && error.classList.contains("invalid-feedback")) {
          error.classList.add("d-none");
        }
      }
    });

    if (!valid) {
      // Mostrar alerta de campos obligatorios (ya está en el HTML como `.alert-warning`)
      window.scrollTo({ top: form.offsetTop, behavior: "smooth" });
      return;
    }
    const btn = document.getElementById("btnSubmitSupplierInfo");

    const formData = new FormData(form);
    try {
      btn.disabled = true; // inhabilitamos para evitar dobles envíos
      btn.innerHTML = `Enviando...`; // cambiamos el texto del botón

      const resp = await fetch(form.action, {
        method: "POST",
        body: formData, // multipart/form-data automáticamente
        headers: {
          // no pongas Content-Type manualmente: Fetch lo asigna con boundary
        },
      });
      if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
      const json = await resp.json();

      if (json.success) {
        // Mostrar el enlace de descarga si se subió brochure
        if (json.brochure) {
          const brochureContainer = document.getElementById(
            "brochure-download-container"
          );
          if (brochureContainer) {
            brochureContainer.innerHTML = `
              <a href="${json.brochure}" target="_blank" class="btn bg-blue text-white rounded-0 mt-4">
                <i class="fa-solid fa-download"></i> Descargar
              </a>
            `;
          }
        }
        if (json.company_size_certificate) {
          const companySizeCertificateContainer = document.getElementById(
            "company-size-certificate-download-container"
          );
          if (companySizeCertificateContainer) {
            companySizeCertificateContainer.innerHTML = `
              <a href="${json.company_size_certificate}" target="_blank" class="btn bg-blue text-white rounded-0 mt-4">
                <i class="fa-solid fa-download"></i> Descargar
              </a>
            `;
          }
        }

        // alert("Proveedor registrado correctamente");
        showAlert({
          title: json.title || "Éxito",
          text: json.text || "Proveedor registrado correctamente",
          icon: json.icon || "success",
          showCancel: false,
          confirmButtonText: "Continuar",
          html: json.html || null,
          redirect: json.redirect,
        });
        // redirigir o limpiar form…
        completitud2();
      } else {
        // muestra errores recibidos, p.ej.
        // alert("Error: " + (json.error || "Revisa los datos"));
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
      console.error(err);
      // alert("No se pudo comunicar con el servidor.");
      showAlert({
        title: "Error",
        text: "No se pudo comunicar con el servidor.",
        icon: "error",
        showCancel: false,
        confirmButtonText: "Continuar",
      });
    } finally {
      btn.disabled = false;
      btn.innerHTML = `Guardar Información del Proveedor`; // restauramos el texto del botón
    }
  });
});
