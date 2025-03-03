document.addEventListener("DOMContentLoaded", () => {
  let deletedPagesButton = document.getElementById("deleted-pages-button");
  async function fetchData(endpoint, formData = null, method = "POST") {
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

  async function loadData() {
    const res = await fetchData("landing-page-builder/getLandingPages");
    if (res) {
      if (res.vendorLinks) {
        document.getElementById("vendorLinks").innerHTML = res.vendorLinks;
        linkEvnt("vendorLinks");
      }
      if (res.signupLinks) {
        document.getElementById("signupLinks").innerHTML = res.signupLinks;
        linkEvnt("signupLinks");
      }
      const modalBody = document.getElementById("landing-page-list-modalBody");
      if (modalBody) {
        modalBody.querySelectorAll(".landing-page-card").forEach((card) => {
          formSubmisions(card);
          deletePage(card);
        });
      }
    }
  }

  function linkEvnt(containerId) {
    document.getElementById(containerId).addEventListener("click", (e) => {
      const copyBtn = e.target.closest(".bi-clipboard");
      const imgEl = e.target.closest(".img-fluid");
      const card = e.target.closest(".card");

      if (copyBtn) {
        e.stopPropagation();
        const link = card.querySelector(".card-link").getAttribute("href");
        copyToClipboard(link);
        updateClipboardIcon(copyBtn);
      }

      if (imgEl) {
        e.preventDefault();
        const link = card.querySelector(".card-link").getAttribute("href");
        if (link && link !== "#") window.open(link, "_blank");
      }
    });
  }

  function formSubmisions(card) {
    card
      .querySelector(".landing-page-form-submission-button")
      .addEventListener("click", async () => {
        const type = card.classList.contains("signup-card")
          ? "signup"
          : "vendor";
        const pageId = card.querySelector(".page_id").value;
        const logo = card.querySelector(".page-logo").src;
        const brand = card.querySelector(".page-brand-complete").value;

        const formData = new FormData();
        formData.append("cardType", type);
        formData.append("landingPageId", pageId);
        formData.append("logo", logo);
        formData.append("brand", brand);

        const resData = await fetchData(
          "landing-page-builder/landingPageFormSubmissions",
          formData
        );
        if (resData) formResponse(resData, card, logo, brand);
      });
  }

  function formResponse(resData, card, logo, brand) {
    deletedPagesButton.classList.add("d-none");
    const modalBody = document.getElementById("landing-page-list-modalBody");
    modalBody
      .querySelectorAll(".col-md-6")
      .forEach((col) => col.classList.add("d-none"));

    const tableContainer = document.getElementById("tableContainer");
    tableContainer.classList.remove("d-none");
    tableContainer.innerHTML = "";

    const returnIcon = document.createElement("i");
    returnIcon.classList.add("bi", "bi-arrow-return-left");
    tableContainer.appendChild(returnIcon);

    const table = document.createElement("table");
    table.classList.add("table", "table-striped", "table-hover");

    const caption = document.createElement("caption");
    caption.innerHTML = `<img src="${logo}"> ${brand} form submissions`;
    table.appendChild(caption);

    const thead = document.createElement("thead");
    thead.classList.add("table-light");
    const headerRow = document.createElement("tr");
    Object.keys(resData[0] || {}).forEach((key) => {
      const th = document.createElement("th");
      th.textContent = key;
      headerRow.appendChild(th);
    });
    thead.appendChild(headerRow);
    table.appendChild(thead);

    const tbody = document.createElement("tbody");
    if (resData.message === "No results found") {
      const warningMsg = document.createElement("div");
      warningMsg.classList.add("alert", "alert-warning");
      warningMsg.textContent = `No form submissions from ${brand}`;
      tableContainer.appendChild(warningMsg);
    } else {
      resData.forEach((entry) => {
        const row = document.createElement("tr");
        Object.values(entry).forEach((val) => {
          const cell = document.createElement("td");
          cell.textContent = val;
          row.appendChild(cell);
        });
        tbody.appendChild(row);
      });
      table.appendChild(tbody);

      const datatable = new DataTable(table, {
        /* options */
      });
    }
    tableContainer.appendChild(table);

    returnIcon.addEventListener("click", () => {
      tableContainer.classList.add("d-none");
      deletedPagesButton.classList.remove("d-none");
      modalBody
        .querySelectorAll(".col-md-6")
        .forEach((col) => col.classList.remove("d-none"));
    });
  }

  function deletePage(card) {
    card.querySelector("#delete-page-button").addEventListener("click", () => {
      $("#confirmDialog").fadeIn(100);
      $("#confirmYes")
        .off("click")
        .on("click", async () => {
          const type = card.classList.contains("signup-card")
            ? "signup"
            : "vendor";
          const pageId = card.querySelector(".page_id").value;

          const formData = new FormData();
          formData.append("cardType", type);
          formData.append("landingPageId", pageId);

          const resData = await fetchData(
            "landing-page-builder/deleteLandingPage",
            formData
          );
          if (resData) card.remove();
          $("#confirmDialog").fadeOut(100);
        });

      $("#confirmNo")
        .off("click")
        .on("click", () => $("#confirmDialog").fadeOut(100));
    });
  }

  function modalShown() {
    const modalBody = document.getElementById("landing-page-list-modalBody");
    if (!modalBody) return;

    modalBody.querySelectorAll(".landing-page-card").forEach((card) => {
      formSubmisions(card);
      deletePage(card);
    });
  }

  $("#landing-page-list-modal").on("show.bs.modal", loadData);

  document
    .querySelector(".landing-pages-button")
    ?.addEventListener("click", () => {
      $("#landing-page-list-modal")
        .on("shown.bs.modal", modalShown)
        .modal("show");
    });

  document.getElementById("refreshButton").addEventListener("click", loadData);
});
