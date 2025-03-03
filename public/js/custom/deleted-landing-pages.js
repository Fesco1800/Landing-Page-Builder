document.addEventListener("DOMContentLoaded", () => {
  let deletedPagesButton = document.getElementById("deleted-pages-button");
  let landingPagesButton = document.getElementById("landing-pages-button-2");

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
    const res = await fetchData("landing-page-builder/getDeletedLandingPages");
    if (res) updateLinks(res);
  }

  function updateLinks(response) {
    const vendorLinksContainer = document.getElementById("deletedVendorLinks");
    const signupLinksContainer = document.getElementById("deletedSignupLinks");

    if (response.vendorLinks) {
      vendorLinksContainer.innerHTML = response.vendorLinks;
      restore(vendorLinksContainer);
      formSubmisions(vendorLinksContainer);
      formEnquiriesAction(vendorLinksContainer);
    } else {
      vendorLinksContainer.innerHTML =
        '<div style="text-align: center;"><span style="color: #ffffff;">No vendor intro links found</span></div>';
    }

    if (response.signupLinks) {
      signupLinksContainer.innerHTML = response.signupLinks;
      restore(signupLinksContainer);
      formSubmisions(signupLinksContainer);
      formEnquiriesAction(signupLinksContainer);
    } else {
      signupLinksContainer.innerHTML =
        '<div style="text-align: center;"><span style="color: #ffffff;">No signup links found</span></div>';
    }
  }

  function formSubmisions(container) {
    const cards = container.querySelectorAll("form");
    cards.forEach((card) => {
      const submissionButton = card.querySelector(
        ".landing-page-form-submission-button"
      );
      if (!submissionButton) return;
      submissionButton.addEventListener("click", async () => {
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
        if (resData) formResponse(resData, card, pageId, logo, brand);
      });
    });
  }

  function formResponse(resData, card, pageId, logo, brand) {
    landingPagesButton.classList.add("d-none");
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
      landingPagesButton.classList.remove("d-none");
      modalBody
        .querySelectorAll(".deleted-page-links")
        .forEach((col) => col.classList.remove("d-none"));
    });
  }

  function formEnquiriesAction(container) {
    container.addEventListener("click", (e) => {
      const gearBtn = e.target.closest(".gear-button");
      const card = e.target.closest(".landing-page-card");

      if (gearBtn) {
        e.stopPropagation();
        const id = card.querySelector(".page_id").value;
        const cardType = card.classList.contains("signup-card")
          ? "signup"
          : "vendor";

        Swal.fire({
          icon: "warning",
          title: "Perform an Action",
          html: `
          <h5>Do not store submitted contact form enquiries in system for deleted landing pages</h5>
          <div class="sweet-alert-container">
            <div class="form-check sweet-alert-input">
                <input class="form-check-input" type="radio" name="choice" id="store" value="no" checked="checked">
                <label class="form-check-label" for="store">Store Contact Form Enquiries (Restore Possible)</label>
            </div>
            <div class="form-check sweet-alert-input">
                <input class="form-check-input" type="radio" name="choice" id="delete" value="yes">
                <label class="form-check-label" for="delete">Delete Contact Form Enquiries Permanently</label>
            </div>
          </div>
        `,
          showCancelButton: true,
          confirmButtonText: "Submit",
          preConfirm: () => {
            const choice = document.querySelector(
              'input[name="choice"]:checked'
            );
            if (!choice) {
              Swal.showValidationMessage("Please select an option");
              return false;
            }
            return choice.value;
          },
        }).then(async (result) => {
          if (result.isConfirmed) {
            const choice = result.value;
            console.log("Submit action:", choice);
            if (choice === "yes") {
              gearBtn.remove();
            }
            const formData = new FormData();
            formData.append("cardType", cardType);
            formData.append("landingPageId", id);
            formData.append("action", choice);

            const resData = await fetchData(
              "landing-page-builder/formEnquiryAction",
              formData
            );
            if (resData) {
              console.log(resData);
            }
          }
        });
      }
    });
  }

  function restore(container) {
    container.addEventListener("click", (e) => {
      const restoreBtn = e.target.closest(".restore-btn");
      const card = e.target.closest(".landing-page-card");

      if (restoreBtn) {
        e.stopPropagation();
        const id = card.querySelector(".page_id").value;
        const cardType = card.classList.contains("signup-card")
          ? "signup"
          : "vendor";

        $("#confirmDialog").fadeIn(100);
        $("#confirmYes")
          .off("click")
          .on("click", async () => {
            const formData = new FormData();
            formData.append("cardType", cardType);
            formData.append("landingPageId", id);

            const resData = await fetchData(
              "landing-page-builder/restoreLandingPage",
              formData
            );
            if (resData) {
              card.remove();
              $("#confirmDialog").fadeOut(100);
            }
          });

        $("#confirmNo")
          .off("click")
          .on("click", () => $("#confirmDialog").fadeOut(100));
      }
    });
  }

  const modalTitle = document
    .getElementById("landing-page-list-modal")
    .querySelector(".modal-title");
  const refreshBtn = document.getElementById("refreshButton");

  deletedPagesButton.addEventListener("click", () => {
    modalTitle.textContent = "Deleted Pages";
    deletedPagesButton.classList.add("d-none");
    landingPagesButton.classList.remove("d-none");
    refreshBtn.classList.add("d-none");
    document
      .querySelector(".deleted-pages-container")
      .classList.remove("d-none");
    document
      .querySelectorAll(".page-links")
      .forEach((col) => col.classList.add("d-none"));
    loadData();
  });

  landingPagesButton.addEventListener("click", () => {
    modalTitle.textContent = "Landing Pages";
    deletedPagesButton.classList.remove("d-none");
    landingPagesButton.classList.add("d-none");
    refreshBtn.classList.remove("d-none");
    document.querySelector(".deleted-pages-container").classList.add("d-none");
    document
      .querySelectorAll(".page-links")
      .forEach((col) => col.classList.remove("d-none"));
  });

  restore(document);
});
