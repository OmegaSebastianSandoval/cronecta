var videos = [];
$(document).ready(function () {
  $(".dropdown-toggle").dropdown();
  $(".carouselsection").carousel({
    quantity: 4,
    sizes: {
      900: 3,
      500: 1,
    },
  });

  $(".banner-video-youtube").each(function () {
    // console.log($(this).attr('data-video'));
    const datavideo = $(this).attr("data-video");
    const idvideo = $(this).attr("id");
    const playerDefaults = {
      autoplay: 0,
      autohide: 1,
      modestbranding: 0,
      rel: 0,
      showinfo: 0,
      controls: 0,
      disablekb: 1,
      enablejsapi: 0,
      iv_load_policy: 3,
    };
    const video = {
      videoId: datavideo,
      suggestedQuality: "hd1080",
    };
    videos[videos.length] = new YT.Player(idvideo, {
      videoId: datavideo,
      playerVars: playerDefaults,
      events: {
        onReady: onAutoPlay,
        onStateChange: onFinish,
      },
    });
  });

  function onAutoPlay(event) {
    event.target.playVideo();
    event.target.mute();
  }

  function onFinish(event) {
    if (event.data === 0) {
      event.target.playVideo();
    }
  }
  const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
  );
  const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
  );

  $(".file-image").fileinput({
    maxFileSize: 10000,
    previewFileType: "image",
    allowedFileExtensions: ["jpg", "jpeg", "gif", "png", "ico"],
    browseClass: "btn  btn-verde",
    showUpload: false,
    showRemove: false,
    browseIcon: '<i class="fas fa-image"></i> ',
    browseLabel: "Imagen",
    language: "es",
    dropZoneEnabled: false,
  });

  $(".file-document").fileinput({
    maxFileSize: 2048,
    previewFileType: "image",
    browseLabel: "Archivo",
    browseClass: "btn  btn-cafe",
    allowedFileExtensions: ["pdf", "xlsx", "xls", "doc", "docx", "ico"],
    showUpload: false,
    showRemove: false,
    browseIcon: '<i class="fas fa-folder-open"></i> ',
    language: "es",
    dropZoneEnabled: false,
  });

  const maxChars = 700;
  const commercialActivity = document.getElementById("commercial_activity");
  const charCount = document.getElementById("char-count");

  // Initial character count on page load
  if (commercialActivity && charCount) {
    const content = commercialActivity.value;
    charCount.innerText = `${content.length}/${maxChars}`;
  }

  tinymce.init({
    selector: "textarea.tinyeditor-simple",
    plugins: ["lists"],
    menubar: false, // 👈 esto oculta el menú superior
    toolbar: "bold italic underline | bullist numlist | removeformat",
    paste_as_text: true, // 👈 fuerza pegar como texto plano
    language: "es",
    browser_spellcheck: true,
    contextmenu: false,
    skin: "oxide-dark",
    content_css: "tinymce-5",
    setup: function (editor) {
      editor.on("init", function () {
        const content = editor.getContent({ format: "text" });
        charCount.innerText = `${content.length}/${maxChars}`;
      });

      editor.on("input", function () {
        const content = editor.getContent({ format: "text" });
        if (content.length > maxChars) {
          editor.setContent(content.substring(0, maxChars)); // corta el texto si se pasa
          alert(`Máximo ${maxChars} caracteres permitidos.`);
        }
        document.getElementById(
          "char-count"
        ).innerText = `${content.length}/${maxChars}`;
      });
      editor.on("change keyup", () => {
        tinymce.triggerSave(); // sincroniza contenido en el <textarea>
        // validateCommercialActivity(false); // re­valida sin pintar errores
        // toggleSubmit(); // y habilita/deshabilita el botón
      });
    },
  });

  $(".selec-multiple").select2({
    width: "100%",
    tags: true,
    placeholder: "Seleccione uno o más segmentos",
  });

  $(".selec-search").select2({
    width: "100%",
    placeholder: "Busca una industria",
    // allowClear: true,
  });
});

/**
 * Muestra una alerta usando SweetAlert2.
 *
 * @param {Object} opts
 * @param {string} [opts.title='']         — Título de la alerta.
 * @param {string} [opts.text='']          — Texto/descrición.
 * @param {('success'|'error'|'warning'|'info'|'question')} [opts.icon='info']
 * @param {boolean} [opts.showCancel=false]        — Mostrar botón de cancelar.
 * @param {string} [opts.confirmButtonText='OK']   — Texto del botón de confirmar.
 * @param {string} [opts.cancelButtonText='Cancelar'] — Texto del botón de cancelar.
 * @param {number|null} [opts.timer=null]           — Auto‐cerrar tras ms (null = no auto).
 * @param {string|null} [opts.redirect=null]        — URL a la que redirigir si confirman.
 * @returns {Promise<SweetAlertResult>}
 */
function showAlert(opts = {}) {
  const {
    title = "",
    text = "",
    icon = "info",
    showCancel = false,
    confirmButtonText = "OK",
    cancelButtonText = "Cancelar",
    confirmButtonColor = "#204697",
    timer = null,
    redirect = null,
    allowOutsideClick = false,
    html = null,
  } = opts;

  return Swal.fire({
    title,
    text,
    icon,
    showCancelButton: showCancel,
    confirmButtonColor: confirmButtonColor,
    cancelButtonText,
    timer,
    allowOutsideClick: allowOutsideClick,
    confirmButtonText,
    html,
    // opcional: estilos, posicion, etc.
    // position: 'top',
    // customClass: { popup: 'my-popup' },
  }).then((result) => {
    if (result.isConfirmed && redirect) {
      window.location = redirect;
    }
    return result;
  });
}

document.addEventListener("DOMContentLoaded", () => {
  const toggleButton = document.getElementById("toggle-btn");
  const sidebar = document.getElementById("sidebar");
  const body = document.body;
  const headerInfoContainer = document.getElementById("header-info-container");

  /*  const mainGeneral = document.getElementById("main-general");
  const footer = document.querySelector("footer"); */
  // console.log(footer);

  function toggleSidebar() {
    sidebar.classList.toggle("close");
    toggleButton.classList.toggle("rotate");
    body.classList.toggle("expanded");
    headerInfoContainer.classList.toggle("expanded");
    /* mainGeneral.classList.toggle("expanded");
    footer.classList.toggle("expanded"); */
    closeAllSubMenus();
  }

  function toggleSubMenu(btn) {
    if (!btn.nextElementSibling.classList.contains("show")) {
      closeAllSubMenus();
    }
    btn.nextElementSibling.classList.toggle("show");
    btn.classList.toggle("rotate");
    if (sidebar.classList.contains("close")) {
      sidebar.classList.toggle("close");
      toggleButton.classList.toggle("rotate");
    }
  }

  function closeAllSubMenus() {
    Array.from(sidebar.querySelectorAll(".sub-menu.show")).forEach((ul) => {
      ul.classList.remove("show");
      ul.previousElementSibling.classList.remove("rotate");
    });
  }

  // Bindear eventos
  toggleButton?.addEventListener("click", toggleSidebar);
  sidebar
    ?.querySelectorAll(".dropdown-btn")
    ?.forEach((btn) => btn?.addEventListener("click", () => toggleSubMenu(btn)));
});
/**
 * Función para inicializar y manejar campos numéricos dinámicos
 * @param {string} inputClass - Clase CSS que identifica los campos numéricos (default: 'only_numbers')
 * @param {boolean} allowDecimal - Permite números decimales (default: true)
 * @param {boolean} allowNegative - Permite números negativos (default: false)
 */
function initNumberInputs(
  inputClass = "only_numbers",
  allowDecimal = true,
  allowNegative = false
) {
  // Expresión regular para validación
  const regexPattern = allowDecimal
    ? allowNegative
      ? /^-?\d*\.?\d*$/
      : /^\d*\.?\d*$/
    : allowNegative
    ? /^-?\d*$/
    : /^\d*$/;

  // Función para sanitizar el valor
  const sanitizeValue = (value) => {
    // Eliminar caracteres no numéricos excepto punto decimal y signo negativo si están permitidos
    let sanitized = value.replace(/[^\d.-]/g, "");

    // Permitir solo un punto decimal si está permitido
    if (!allowDecimal) {
      sanitized = sanitized.replace(/\./g, "");
    } else {
      const parts = sanitized.split(".");
      if (parts.length > 2) {
        sanitized = parts[0] + "." + parts.slice(1).join("");
      }
    }

    // Permitir solo un signo negativo al inicio si está permitido
    if (!allowNegative) {
      sanitized = sanitized.replace(/-/g, "");
    } else {
      sanitized = sanitized.replace(/(.)-/g, "$1"); // Eliminar signos negativos que no estén al inicio
      if ((sanitized.match(/-/g) || []).length > 1) {
        sanitized = "-" + sanitized.replace(/-/g, "");
      }
    }

    return sanitized;
  };

  // Función para validar el input
  const validateInput = (input) => {
    const value = input.value;
    const selectionStart = input.selectionStart;
    const sanitized = sanitizeValue(value);

    // Solo actualizar si hubo cambio
    if (value !== sanitized) {
      input.value = sanitized;
      // Mantener la posición del cursor
      const diff = value.length - sanitized.length;
      input.setSelectionRange(selectionStart - diff, selectionStart - diff);
    }
  };

  // Manejador de eventos
  const handleInputEvents = (input) => {
    // Validar al escribir
    input.addEventListener("input", (e) => {
      validateInput(input);
    });

    // Validar al pegar
    input.addEventListener("paste", (e) => {
      e.preventDefault();
      const pastedText = (e.clipboardData || window.clipboardData).getData(
        "text"
      );
      const sanitized = sanitizeValue(pastedText);

      // Insertar el texto sanitizado
      document.execCommand("insertText", false, sanitized);
    });

    // Prevenir teclas no deseadas
    input.addEventListener("keydown", (e) => {
      // Permitir teclas de control (tab, borrar, flechas, etc.)
      if (
        [
          "Tab",
          "Backspace",
          "Delete",
          "ArrowLeft",
          "ArrowRight",
          "ArrowUp",
          "ArrowDown",
          "Home",
          "End",
        ].includes(e.key)
      ) {
        return;
      }

      // Permitir punto decimal si está permitido
      if (allowDecimal && e.key === "." && !input.value.includes(".")) {
        return;
      }

      // Permitir signo negativo si está permitido y está al inicio
      if (
        allowNegative &&
        e.key === "-" &&
        input.selectionStart === 0 &&
        !input.value.includes("-")
      ) {
        return;
      }

      // Permitir solo números
      if (!e.key.match(/^\d$/)) {
        e.preventDefault();
      }
    });
  };

  // Observador de mutación para manejar elementos dinámicos
  const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      mutation.addedNodes.forEach((node) => {
        if (node.nodeType === 1) {
          // Solo elementos
          const inputs =
            node.classList && node.classList.contains(inputClass)
              ? [node]
              : node.querySelectorAll(`.${inputClass}`);

          inputs.forEach((input) => {
            if (
              input.tagName === "INPUT" &&
              !input.hasAttribute("data-number-handled")
            ) {
              input.setAttribute("data-number-handled", "true");
              input.type = "text"; // Forzar tipo texto
              input.inputMode = "numeric"; // Mostrar teclado numérico en móviles
              handleInputEvents(input);
            }
          });
        }
      });
    });
  });

  // Configurar e iniciar el observador
  observer.observe(document.body, {
    childList: true,
    subtree: true,
  });

  // Inicializar elementos existentes
  document.querySelectorAll(`.${inputClass}`).forEach((input) => {
    if (
      input.tagName === "INPUT" &&
      !input.hasAttribute("data-number-handled")
    ) {
      input.setAttribute("data-number-handled", "true");
      input.type = "text"; // Forzar tipo texto
      input.inputMode = "numeric"; // Mostrar teclado numérico en móviles
      handleInputEvents(input);
    }
  });

  // Retornar función para limpiar (opcional)
  return () => {
    observer.disconnect();
    document
      .querySelectorAll(`.${inputClass}[data-number-handled]`)
      .forEach((input) => {
        input.removeEventListener("input", validateInput);
        input.removeEventListener("paste", validateInput);
        input.removeEventListener("keydown", validateInput);
        input.removeAttribute("data-number-handled");
      });
  };
}

// Uso básico - inicializar en el DOM ready
document.addEventListener("DOMContentLoaded", function () {
  // Campos con decimales
  initNumberInputs("only_numbers", true, false);

  // Campos enteros (sin decimales)
  initNumberInputs("only_integers", false, false);

  // Campos que permiten negativos
  initNumberInputs("numbers_with_negatives", true, true);
});

document.addEventListener("DOMContentLoaded", () => {
  const inputs = document.querySelectorAll(".ajax-validate");

  inputs.forEach(input => {
    input.addEventListener("input", debounce(async () => {
      await validateField(input);
    }, 500)); // evitar muchas peticiones
  });

  async function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.dataset.validate;
    const id = field.dataset.id || "";
    const errorContainer = document.getElementById(`error-${fieldName}`);

    if (!value) {
      errorContainer.textContent = "";
      errorContainer.classList.add("d-none");
      return;
    }

    try {
      const response = await fetch(`/supplier/register/validatefield?field=${encodeURIComponent(fieldName)}&value=${encodeURIComponent(value)}&id=${id}`);
      const data = await response.json();

      if (!response.ok || data.valid === false) {
        errorContainer.textContent = data.message || "Dato inválido.";
        errorContainer.classList.remove("d-none");
        field.classList.add("is-invalid");
      } else {
        errorContainer.textContent = "";
        errorContainer.classList.add("d-none");
        field.classList.remove("is-invalid");
      }
    } catch (e) {
      console.error("Error validando campo:", e);
    }
  }

  function debounce(func, wait) {
    let timeout;
    return function () {
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(this, arguments), wait);
    };
  }
});

function initPhoneInputs(inputClass = "is_phone") {
  const isValidPhone = (value) => /^\d{7,10}$/.test(value);
  const sanitizePhone = (value) => value.replace(/\D/g, "").slice(0, 10);

  const validateInput = (input) => {
    const raw = input.value;
    const clean = sanitizePhone(raw);
    input.value = clean;

    let errorContainer = input.nextElementSibling;
    const needsError =
      !errorContainer || !errorContainer.classList.contains("invalid-feedback");

    if (needsError) {
      errorContainer = document.createElement("div");
      errorContainer.classList.add("invalid-feedback");
      input.insertAdjacentElement("afterend", errorContainer);
    }

    if (clean.length > 0 && (clean.length < 7 || clean.length > 10)) {
      input.classList.add("is-invalid");
      errorContainer.textContent = "El teléfono debe tener entre 7 y 10 dígitos.";
      errorContainer.classList.remove("d-none");
    } else {
      input.classList.remove("is-invalid");
      errorContainer.textContent = "";
      errorContainer.classList.add("d-none");
    }
  };

  const handleInputEvents = (input) => {
    input.addEventListener("input", () => {
      validateInput(input);
    });

    input.addEventListener("paste", (e) => {
      e.preventDefault();
      const pasted = (e.clipboardData || window.clipboardData).getData("text");
      const sanitized = sanitizePhone(pasted);
      document.execCommand("insertText", false, sanitized);
    });

    input.addEventListener("keydown", (e) => {
      const allowed = [
        "Backspace", "Tab", "Delete",
        "ArrowLeft", "ArrowRight", "Home", "End"
      ];
      if (allowed.includes(e.key)) return;
      if (!/^\d$/.test(e.key)) e.preventDefault();
    });
  };

  const initExistingInputs = () => {
    document.querySelectorAll(`.${inputClass}`).forEach((input) => {
      if (
        input.tagName === "INPUT" &&
        !input.hasAttribute("data-phone-handled")
      ) {
        input.setAttribute("data-phone-handled", "true");
        input.type = "text";
        input.inputMode = "numeric";
        handleInputEvents(input);
      }
    });
  };

  const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      mutation.addedNodes.forEach((node) => {
        if (node.nodeType === 1) {
          const inputs =
            node.classList && node.classList.contains(inputClass)
              ? [node]
              : node.querySelectorAll(`.${inputClass}`);

          inputs.forEach((input) => {
            if (
              input.tagName === "INPUT" &&
              !input.hasAttribute("data-phone-handled")
            ) {
              input.setAttribute("data-phone-handled", "true");
              input.type = "text";
              input.inputMode = "numeric";
              handleInputEvents(input);
            }
          });
        }
      });
    });
  });

  observer.observe(document.body, {
    childList: true,
    subtree: true,
  });

  initExistingInputs();

  return () => {
    observer.disconnect();
  };
}

document.addEventListener("DOMContentLoaded", () => {
  initPhoneInputs("is_phone");
});
function initEmailInputs(inputClass = "is_email") {
  const isValidEmail = (value) => {
    // Validación básica de email tipo texto@texto.texto
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
  };

  const sanitizeEmail = (value) => {
    return value.replace(/\s/g, ""); // Eliminar espacios
  };

  const validateInput = (input) => {
    const raw = input.value;
    const clean = sanitizeEmail(raw);
    input.value = clean;

    let errorContainer = input.nextElementSibling;
    const needsError =
      !errorContainer || !errorContainer.classList.contains("invalid-feedback");

    if (needsError) {
      errorContainer = document.createElement("div");
      errorContainer.classList.add("invalid-feedback");
      input.insertAdjacentElement("afterend", errorContainer);
    }

    if (clean && !isValidEmail(clean)) {
      input.classList.add("is-invalid");
      errorContainer.textContent = "El correo electrónico no es válido.";
      errorContainer.classList.remove("d-none");
    } else {
      input.classList.remove("is-invalid");
      errorContainer.textContent = "";
      errorContainer.classList.add("d-none");
    }
  };

  const handleInputEvents = (input) => {
    input.addEventListener("input", () => {
      validateInput(input);
    });

    input.addEventListener("paste", (e) => {
      e.preventDefault();
      const pasted = (e.clipboardData || window.clipboardData).getData("text");
      const sanitized = sanitizeEmail(pasted);
      document.execCommand("insertText", false, sanitized);
    });

    // Permitir teclas normales, pero eliminar espacios
    input.addEventListener("keydown", (e) => {
      if (e.key === " ") {
        e.preventDefault(); // no permitir espacios
      }
    });
  };

  const initExistingInputs = () => {
    document.querySelectorAll(`.${inputClass}`).forEach((input) => {
      if (
        input.tagName === "INPUT" &&
        !input.hasAttribute("data-email-handled")
      ) {
        input.setAttribute("data-email-handled", "true");
        input.type = "email";
        handleInputEvents(input);
      }
    });
  };

  const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      mutation.addedNodes.forEach((node) => {
        if (node.nodeType === 1) {
          const inputs =
            node.classList && node.classList.contains(inputClass)
              ? [node]
              : node.querySelectorAll(`.${inputClass}`);

          inputs.forEach((input) => {
            if (
              input.tagName === "INPUT" &&
              !input.hasAttribute("data-email-handled")
            ) {
              input.setAttribute("data-email-handled", "true");
              input.type = "email";
              handleInputEvents(input);
            }
          });
        }
      });
    });
  });

  observer.observe(document.body, {
    childList: true,
    subtree: true,
  });

  initExistingInputs();

  return () => {
    observer.disconnect();
  };
}

document.addEventListener("DOMContentLoaded", () => {
  initEmailInputs("is_email");
});
