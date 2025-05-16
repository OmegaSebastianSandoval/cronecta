document.addEventListener("DOMContentLoaded", function () {
  const visibilityStatus = document.getElementById("visibility_status");

  visibilityStatus.addEventListener("change", async function () {
    const id = visibilityStatus.getAttribute("data-id");
    const value = visibilityStatus.value == 1 ? 0 : 1;
    try {
      // response = grecaptcha.getResponse();
      const resp = await fetch(
        `/supplier/profile/updatevisibilitystatus?id=${id}&visibility_status=${value}`,
        {
          method: "POST",
          headers: {},
        }
      );
      if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
      const json = await resp.json();
      if (json.success) {
        visibilityStatus.value = value;
        showAlert({
          title: "Éxito",
          text: json.text,
          icon: "success",
        });
      } else {
        showAlert({
          title: "Error",
          text: "Error al actualizar la visibilidad",
          icon: "error",
        });
      }
    } catch (err) {}
  });

  const previewImg = document.getElementById("preview-logo");
  const inputFile = document.getElementById("supplier_image");
  const cancelContainer = document.getElementById("cancel-logo-container");

  // 1) Guardamos el src original
  if (previewImg) {
    originalLogoSrc = previewImg.src;
  }

  // 2) Definimos las funciones y las exponemos globalmente
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
});
