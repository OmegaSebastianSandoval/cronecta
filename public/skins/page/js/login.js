  document.addEventListener('DOMContentLoaded', () => {
    const pwdInput = document.getElementById('password');
    const toggle = document.querySelector('.password-eye');
    const icon = toggle.querySelector('i');

    toggle.addEventListener('click', () => {
      if (pwdInput.type === 'password') {
        pwdInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        pwdInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    });
  });
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("supplierLoginForm");

  form.addEventListener("submit", async (e) => {
    e.preventDefault(); // evitamos el envío normal
    const response = grecaptcha.getResponse();
    if (response.length === 0) {
      showAlert({
        title: "Error",
        text: "Por favor, verifica que no eres un robot.",
        icon: "error",
        showCancel: false,
        confirmButtonText: "Continuar",
      });
      grecaptcha.reset();
      return;
    }

    const btn = document.getElementById("btnSubmitLogin");

    const formData = new FormData(form);

    try {
      btn.disabled = true;
      btn.innerHTML = `Validando...`;

      // response = grecaptcha.getResponse();
      const resp = await fetch(form.action, {
        method: "POST",
        body: formData,
        headers: {},
      });
      if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
      const json = await resp.json();
      if (json.captchaReset) {
        grecaptcha.reset();
        return;
      }
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
      btn.innerHTML = `Ingresar`;
    }
  });
});
