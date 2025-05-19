document.addEventListener("DOMContentLoaded", () => {
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
});
