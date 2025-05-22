document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("#submit-information-update");
  const btnSubmit = document.getElementById("btnSubmitInfo");
  const touched = {};

  // === [1] PREVIEW Y CANCELACIÓN DE LOGO ===
  const previewImg = document.getElementById("preview-logo");
  const inputFile = document.getElementById("supplier_image");
  const cancelContainer = document.getElementById("cancel-logo-container");
  let originalLogoSrc = previewImg?.src;

  window.previewSupplierLogo = function (input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = (e) => {
        previewImg.src = e.target.result;
        cancelContainer.style.display = "block";
      };
      reader.readAsDataURL(input.files[0]);
    }
  };

  window.cancelSupplierLogo = function () {
    inputFile.value = "";
    previewImg.src = originalLogoSrc;
    cancelContainer.style.display = "none";
  };

  // === [2] TOGGLE DE VISIBILIDAD ===
  const visibilityStatus = document.getElementById("visibility_status");
  visibilityStatus?.addEventListener("change", async function () {
    const id = visibilityStatus.getAttribute("data-id");
    const value = visibilityStatus.value == 1 ? 0 : 1;

    try {
      const resp = await fetch(
        `/supplier/profile/updatevisibilitystatus?id=${id}&visibility_status=${value}`,
        { method: "POST" }
      );
      if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
      const json = await resp.json();
      if (json.success) {
        visibilityStatus.value = value;
        showAlert({ title: "Éxito", text: json.text, icon: "success" });
      } else {
        showAlert({
          title: "Error",
          text: "Error al actualizar la visibilidad",
          icon: "error",
        });
      }
    } catch (err) {
      console.error("Error en visibilidad:", err);
    }
  });

  // === [3] VALIDACIÓN DE CAMPOS ===
  function getErrorContainer(el) {
    let err = el.parentNode.querySelector(".error-msg");
    if (!err) {
      err = document.createElement("small");
      err.className = "text-danger error-msg";
      el.parentNode.appendChild(err);
    }
    return err;
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

  function isFormValid() {
    return (
      validateCompanyName(false) &&
      validatePhone(false) &&
      validateBirthCountryStateCity(false)
    );
  }

  function toggleSubmit() {
    btnSubmit.disabled = !isFormValid();
  }

  const fieldValidators = {
    company_name: validateCompanyName,
    phone: validatePhone,
    birth_country: validateBirthCountryStateCity,
    birth_state: validateBirthCountryStateCity,
    birth_city: validateBirthCountryStateCity,
  };

  Object.keys(fieldValidators).forEach((id) => {
    const el = form.querySelector(`#${id}`);
    if (!el) return;
    const ev =
      el.tagName === "SELECT" || el.type === "checkbox" ? "change" : "input";

    el.addEventListener(ev, () => {
      touched[id] = true;
      fieldValidators[id](true);
      toggleSubmit();
    });
  });

  // === [4] VALIDACIÓN AJAX DE RAZÓN SOCIAL ===
  const companyField = document.getElementById("company_name");

  function debounce(fn, delay) {
    let timeout;
    return function (...args) {
      clearTimeout(timeout);
      timeout = setTimeout(() => fn.apply(this, args), delay);
    };
  }

  async function doAjaxValidateCompanyName(value, id) {
    const err = getErrorContainer(companyField);
    if (!value) {
      err.textContent = "";
      err.classList.add("d-none");
      return;
    }

    try {
      const response = await fetch(
        `/supplier/register/validatecompany?name=${encodeURIComponent(
          value
        )}&id=${id}`
      );
      if (!response.ok) throw new Error(`HTTP ${response.status}`);

      const data = await response.json();
      if (!data.valid) {
        err.textContent = data.message || "Esta razón social ya existe.";
        err.classList.remove("d-none");
        err.classList.add("d-block");
        toggleSubmit();
      } else if (touched.company_name) {
        err.textContent = "";
        err.classList.add("d-none");
        toggleSubmit();
      }
    } catch (e) {
      console.error("Error validando razón social:", e);
    }
  }

  const debouncedCompany = debounce(doAjaxValidateCompanyName, 500);
  companyField?.addEventListener("input", (e) => {
    touched.company_name = true;
    debouncedCompany(e.target.value.trim(), e.target.getAttribute("data-id"));
  });

  companyField?.addEventListener("blur", (e) => {
    const cleaned = e.target.value.trim().toUpperCase();
    e.target.value = cleaned;

    doAjaxValidateCompanyName(cleaned, e.target.getAttribute("data-id"));
  });

  // Validación inicial
  toggleSubmit();
});
