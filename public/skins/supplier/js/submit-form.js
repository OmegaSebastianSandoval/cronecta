document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("supplierForm");

  form.addEventListener("submit", async (e) => {
    e.preventDefault(); // evitamos el envío normal
    const btn = document.getElementById("btnSubmit");
    btn.disabled = true; // inhabilitamos para evitar dobles envíos
    tinymce.triggerSave(); // sincroniza contenido en el <textarea>
    // construye un FormData con TODO el formulario (campos + file inputs)
    const formData = new FormData(form);
    console.log("FormData:", formData);

    try {
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
        // alert("Proveedor registrado correctamente");
        showAlert({
          title: json.title || "Éxito",
          text: json.text || "Proveedor registrado correctamente",
          icon: json.icon || "success",
          showCancel: false,
          confirmButtonText: "Continuar",
          html: json.html || null,
          redirect: json.redirect || null,
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
    }
  });
});
