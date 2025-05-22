// console.log("segments-tab.js");
document.addEventListener("DOMContentLoaded", function () {
  const container = document.getElementById("supplierGroupsContainer");

  const industries = Object.entries(industriesFromServer).map(
    ([id, label]) => ({ id, label })
  );
  const supplierGroups = supplierGroupsFromServer.map((group) => ({
    industryId: group.industry_id,
    segments: group.segments.map((s) => s.segment_id),
  }));

  function getGroupHTML(index, industryId = "", segments = []) {
    const options = industries
      .map(
        (ind) =>
          `<option value="${ind.id}" ${
            ind.id == industryId ? "selected" : ""
          }>${ind.label}</option>`
      )
      .join("");

    return `
      <div class="row mb-3" data-group-index="${index}">
        <div class="col-md-5">
          <label class="form-label">Industria <span>*</span></label>
          <select class="form-control industry-select" name="industry[${index}]" data-group-index="${index}" required>
            <option></option>
            ${options}
          </select>
        </div>
        <div class="col-md-5">
          <label class="form-label">Segmentos <span>*</span></label>
          <select class="form-control segments-select" name="segment[${index}][]" multiple data-group-index="${index}" required>
            <option>Cargando...</option>
          </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button type="button" class="btn btn-danger rounded-0 remove-group">
            <i class="fa-solid fa-trash-can"></i>
          </button>
        </div>
      </div>`;
  }

  async function fetchAndRenderSegments(
    industryId,
    groupIndex,
    selectedSegments = []
  ) {
    const segmentSelect = $(
      `.segments-select[data-group-index="${groupIndex}"]`
    );
    try {
      const resp = await fetch(
        `/supplier/register/getsegments/?industryId=${industryId}`
      );
      const list = await resp.json();
      segmentSelect.empty();
      list.forEach((s) => {
        const selected = selectedSegments.includes(s.id);
        const opt = new Option(s.name, s.id, selected, selected);
        segmentSelect.append(opt);
      });
      segmentSelect.select2({
        placeholder: "Selecciona uno o más segmentos",
        allowClear: true,
      });
    } catch (err) {
      console.error("Error cargando segmentos:", err);
    }
  }

  async function renderInitialGroups() {
    container.innerHTML = "";
    for (let i = 0; i < supplierGroups.length; i++) {
      const { industryId, segments } = supplierGroups[i];
      container.insertAdjacentHTML(
        "beforeend",
        getGroupHTML(i, industryId, segments)
      );
      $(`.industry-select[data-group-index="${i}"]`).select2({
        placeholder: "Selecciona una industria",
        allowClear: true,
      });
      await fetchAndRenderSegments(industryId, i, segments);
    }
  }

  renderInitialGroups();

  container.addEventListener("click", function (e) {
    if (e.target.closest(".remove-group")) {
      const group = e.target.closest("[data-group-index]");
      if (container.querySelectorAll("[data-group-index]").length > 1) {
        group.remove();
      }
    }
  });
  function updateIndustryOptions() {
    // Recolectar todas las industrias ya seleccionadas
    const selectedIndustries = Array.from(
      document.querySelectorAll(".industry-select")
    )
      .map((select) => select.value)
      .filter((val) => val !== "");

    document.querySelectorAll(".industry-select").forEach((select) => {
      const currentValue = select.value;

      // Recorremos cada opción
      Array.from(select.options).forEach((option) => {
        if (option.value === "") return; // ignorar opción vacía

        // Solo deshabilitar si no es la opción actual del select
        if (
          option.value !== currentValue &&
          selectedIndustries.includes(option.value)
        ) {
          option.disabled = true;
        } else {
          option.disabled = false;
        }
      });
    });
  }

  const addGroup = document.querySelector(".add-group");
  addGroup.addEventListener("click", function () {
    const groupIndex = document.querySelectorAll("[data-group-index]").length;
    container.insertAdjacentHTML("beforeend", getGroupHTML(groupIndex));
    const industrySelect = $(
      `.industry-select[data-group-index="${groupIndex}"]`
    );
    const segmentSelect = $(
      `.segments-select[data-group-index="${groupIndex}"]`
    );

    industrySelect.select2({
      placeholder: "Selecciona una industria",
      allowClear: true,
    });
    updateIndustryOptions();

    segmentSelect.select2({
      allowClear: true,
    });

    industrySelect.on("change", async function () {
      const industryId = $(this).val();
      await fetchAndRenderSegments(industryId, groupIndex);
      updateIndustryOptions();
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const formSegments = document.getElementById("form-segments");

  formSegments.addEventListener("submit", async function (e) {
    e.preventDefault(); // evitar envío por defecto

    const btn = document.getElementById("submitFormSegments");

    const formData = new FormData(formSegments);
    console.log(formData);
    try {
      btn.disabled = true; // inhabilitamos para evitar dobles envíos
      btn.innerHTML = `Enviando...`; // cambiamos el texto del botón

      const resp = await fetch(formSegments.action, {
        method: "POST",
        body: formData, // multipart/form-data automáticamente
        headers: {
          // no pongas Content-Type manualmente: Fetch lo asigna con boundary
        },
      });
      if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
      const json = await resp.json();

      if (json.success) {
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
      btn.innerHTML = `Guardar Industrias y segmentos`; // restauramos el texto del botón
    }
    // Aquí va el envío AJAX si todo está válido
    // Por ahora no se envía nada
    // console.log("Formulario válido. Aquí puedes iniciar el envío AJAX.");
  });
});
