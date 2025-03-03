document.addEventListener("DOMContentLoaded", () => {
  async function fetchRequest(endpoint, formData = null, method = "POST") {
    try {
      const res = await fetch(url + endpoint, {
        method,
        body: formData,
      });
      if (!res.ok) {
        console.error("Request failed:", res.status, res.statusText);
        throw new Error("Request failed");
      }
      return await res.json();
    } catch (err) {
      console.error(err);
      return null;
    }
  }
  async function loadTemplates() {
    console.log("loadTemplates()");
    const res = await fetchRequest("landing-page-builder/getTemplates");
    if (res && res.template) {
      document.querySelector(".templates-container").innerHTML = res.template;
    } else {
      document.querySelector(".templates-container").innerHTML =
        '<div style="text-align: center;"><span style="color: #ffffff;">No templates found</span></div>';
    }
  }
  $("#page-templates-modal").on("show.bs.modal", loadTemplates);
});

function useTemplate(id, url) {
  let xhr = new XMLHttpRequest();

  xhr.open("POST", url + "landing-page-builder/getTemplateRow", true);

  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (xhr.status >= 200 && xhr.status < 300) {
      try {
        let response = JSON.parse(xhr.responseText);
        if (response.status === "success") {
          window.location.href = response.redirect;
        } else {
          console.log("Error:", response.message);
        }
      } catch (e) {
        console.log("Error parsing JSON response:", e);
      }
    } else {
      console.log("Error:", xhr.statusText);
    }
  };

  xhr.onerror = function () {
    console.log("Request failed");
  };

  var data = "template-id=" + encodeURIComponent(id);

  xhr.send(data);
}
