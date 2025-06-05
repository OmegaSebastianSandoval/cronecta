document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("profileForm");

  form.addEventListener("submit", async (e) => {
    e.preventDefault(); // evitamos el envío normal
    const btn = document.getElementById("btnSubmit");

    //tinymce.triggerSave(); // sincroniza contenido en el <textarea>
    // construye un FormData con TODO el formulario (campos + file inputs)
    const formData = new FormData(form);

    try {
      //btn.disabled = true; // inhabilitamos para evitar dobles envíos
      //btn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Enviando...`; // cambiamos el texto del botón

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
          text: json.text || "Guardado correctamente",
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
      //btn.disabled = false;
      //btn.innerHTML = `<i class="fas fa-paper-plane"></i> Enviar`; // restauramos el texto del botón
    }
  });



//documentos
  const form_documents = document.getElementById("documentsForm");

  form_documents.addEventListener("submit", async (e) => {
    e.preventDefault(); // evitamos el envío normal
    const btn = document.getElementById("btnSubmit_documents");

    //tinymce.triggerSave(); // sincroniza contenido en el <textarea>
    // construye un FormData con TODO el formulario (campos + file inputs)
    const formData = new FormData(form_documents);

    try {
      //btn.disabled = true; // inhabilitamos para evitar dobles envíos
      //btn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Enviando...`; // cambiamos el texto del botón

      const resp = await fetch(form_documents.action, {
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
          text: json.text || "Guardado correctamente",
          icon: json.icon || "success",
          showCancel: false,
          confirmButtonText: "Continuar",
          html: json.html || null,
          redirect: json.redirect,
        });

        //cambiar enlace de descarga
        if(json.rut!=""){
          document.getElementById('enlace_rut').href='/files/'+json.rut;
        }
        if(json.commerce!=""){
          document.getElementById('enlace_commerce').href='/files/'+json.commerce;
        }

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
      //btn.disabled = false;
      //btn.innerHTML = `<i class="fas fa-paper-plane"></i> Enviar`; // restauramos el texto del botón
    }
  });


//cambio contraseña
  const form_changepass = document.getElementById("change_passwordForm");

  form_changepass.addEventListener("submit", async (e) => {
    e.preventDefault(); // evitamos el envío normal
    const btn = document.getElementById("btnSubmit_documents");

    //tinymce.triggerSave(); // sincroniza contenido en el <textarea>
    // construye un FormData con TODO el formulario (campos + file inputs)
    const formData = new FormData(form_changepass);

    try {
      //btn.disabled = true; // inhabilitamos para evitar dobles envíos
      //btn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Enviando...`; // cambiamos el texto del botón

      const resp = await fetch(form_changepass.action, {
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
          text: json.text || "Guardado correctamente",
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
      //btn.disabled = false;
      //btn.innerHTML = `<i class="fas fa-paper-plane"></i> Enviar`; // restauramos el texto del botón
    }
  });  


});
