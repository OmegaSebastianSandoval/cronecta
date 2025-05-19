document.addEventListener("DOMContentLoaded", () => {
  const visibilityStatus = document.getElementById("visibility_status");
  if (!visibilityStatus) return;

  visibilityStatus.addEventListener("change", async function () {
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
        showAlert({ title: "Error", text: "Error al actualizar la visibilidad", icon: "error" });
      }
    } catch (err) {
      console.error("Error:", err);
    }
  });
});
