// START: SAVE - Chunked File Upload and Non-File Fields Submission

document.getElementById("submit-page").addEventListener("click", saveAsPage);

function saveAsPage() {
  showLoader();

  const form = document.getElementById("submit-form");
  const sections = [
    "headings-container",
    "title-2-drag-drop-area",
    "contact-form-drag-drop-area",
  ];
  const hiddenFields = [
    "top_section_content",
    "mid_section_content",
    "bottom_section_content",
  ];

  // Extract and convert HTML content to JSON
  sections.forEach((section, index) => {
    const content =
      document.querySelector(`.${section}`)?.innerHTML ||
      document.getElementById(section)?.innerHTML ||
      "";
    document.getElementById(hiddenFields[index]).value = JSON.stringify({
      content,
    });
  });

  // Collect file inputs
  const files = {
    logoFile: document.getElementById("logoFile").files[0],
    bannerFile: document.getElementById("bannerFile").files[0],
    midSecBackgroundFile: document.getElementById("midSecBackgroundFile").files[0],
    bottomSecBackgroundFile: document.getElementById("bottomsecBackgroundFile").files[0],
  };

  // Process and submit files in chunks
  processFileChunks(files, form);
}

async function processFileChunks(files, form) {
  try {
    for (const [key, file] of Object.entries(files)) {
      if (file) {
        const uploadResponse = await uploadFileInChunks(file, key);
        if (!uploadResponse.success) {
          throw new Error(`Failed to upload ${key}`);
        }
      }
    }

    // After successful file upload, submit non-file fields
    submitNonFileFields(form);
  } catch (error) {
    hideLoader();
    console.error("Error in file upload:", error);
    alert("Error uploading files. Please try again.");
  }
}

function uploadFileInChunks(file, fieldName) {
  const chunkSize = 64 * 1024; // 2MB
  const totalChunks = Math.ceil(file.size / chunkSize);
  const uploadEndpoint = `${url}landing-page-builder/save`;

  return new Promise(async (resolve) => {
    for (let i = 0; i < totalChunks; i++) {
      const chunk = file.slice(i * chunkSize, (i + 1) * chunkSize);
      const formData = new FormData();
      formData.append("chunk", chunk);
      formData.append("fieldName", fieldName);
      formData.append("chunkIndex", i);
      formData.append("totalChunks", totalChunks);

      const response = await fetch(uploadEndpoint, {
        method: "POST",
        body: formData,
      });

      const result = await response.json();
      if (!result.success) {
        resolve({ success: false });
        return;
      }
    }
    resolve({ success: true });
  });
}

function submitNonFileFields(form) {
  const formData = new FormData(form);

  // Remove file fields as they've already been uploaded
  [
    "logoFile",
    "bannerFile",
    "midSecBackgroundFile",
    "bottomsecBackgroundFile",
  ].forEach((field) => formData.delete(field));

  // Submit the form
  const savePageEndpoint = `${url}landing-page-builder/save`;

  fetch(savePageEndpoint, {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
      return response.json();
    })
    .then((data) => {
      hideLoader();
      if (data.error) {
        alert(data.error);
      } else {
        window.location.href = data.redirect;
      }
    })
    .catch((error) => {
      hideLoader();
      console.error("Submission error:", error);
      alert("An error occurred while submitting the page. Please try again.");
    });
}
// END SAVE - Chunked File Upload and Non-File Fields Submission


// START: SAVE AS TEMPLATE
async function saveAsTemplate() {
    showLoader();
    const form = document.getElementById("submit-form");

    // const templateName = document.getElementById("template-name").value;
    // if (!templateName) {
    //     hideLoader();
    //     alert("Missing Template Name. Please provide a name and try again.");
    //     return;
    // }

    // Convert each section content separately
    const topSectionContentJSON = JSON.stringify({
        content: document.querySelector(".headings-container").innerHTML,
    });

    const midSectionContentJSON = JSON.stringify({
        content: document.getElementById("title-2-drag-drop-area").innerHTML,
    });

    const bottomSectionContentJSON = JSON.stringify({
        content: document.getElementById("contact-form-drag-drop-area").innerHTML,
    });

    const brandName = document.getElementById("brand").value;
    const bottomSectionIdConfirmed = checkIdExists("signup-form-div")
        ? "signup-form-div"
        : checkIdExists("contact-form-div")
        ? "contact-form-div"
        : "";
    const mailto = document.getElementById("mailto").value;

    const logoStyles = document.getElementById("logoStyles").value;
    const pageTitleStyles = document.getElementById("pageTitleStyles").value;

    const midBgColorGradient = document.getElementById("mid_bg_color_gradient").value;
    const midBgAbstract = document.getElementById("mid_bg_abstract").value;
    const midBgIndustry = document.getElementById("mid_bg_industry").value;
    
    const bottomBgColorGradient = document.getElementById("bottom_bg_color_gradient").value;
    const bottomBgAbstract = document.getElementById("bottom_bg_abstract").value;
    const bottomBgIndustry = document.getElementById("bottom_bg_industry").value;

    const files = {
        logoFile: document.getElementById("logoFile").files[0],
        bannerFile: document.getElementById("bannerFile").files[0],
        midSecFile: document.getElementById("midSecBackgroundFile").files[0],
        bottomSecFile: document.getElementById("bottomsecBackgroundFile").files[0],
    };

    const chunkSize = 64 * 1024; // 64KB chunk size
    for (const [key, file] of Object.entries(files)) {
        if (file) {
            const totalChunks = Math.ceil(file.size / chunkSize);
            for (let i = 0; i < totalChunks; i++) {
                const chunk = file.slice(i * chunkSize, (i + 1) * chunkSize);
                const formData = new FormData();
                formData.append("chunk", chunk);
                formData.append("fieldName", key);
                formData.append("chunkIndex", i);
                formData.append("totalChunks", totalChunks);
                formData.append("fileName", file.name);

                try {
                    const response = await fetch(`${url}landing-page-builder/saveAsTemplate`, {
                        method: "POST",
                        body: formData,
                    });
                    const result = await response.json();
                    if (!result.success) {
                        throw new Error(`Failed to upload chunk ${i} of ${key}`);
                    }
                } catch (error) {
                    console.error(`Error uploading chunk ${i} of ${key}:`, error);
                    hideLoader();
                    alert("An error occurred while uploading files. Please try again.");
                    return;
                }
            }
        }
    }

    // Proceed with non-file form submission
    const formData = new FormData();
    formData.append("logoStyles", logoStyles);
    formData.append("pageTitleStyles", pageTitleStyles);
    formData.append("topSectionContent", topSectionContentJSON);
    formData.append("midSectionContent", midSectionContentJSON);
    formData.append("midBgColorGradient", midBgColorGradient || "");
    formData.append("midBgAbstract", midBgAbstract || "");
    formData.append("midBgIndustry", midBgIndustry || "");
    formData.append("bottomSectionContent", bottomSectionContentJSON);
    formData.append("brandName", brandName);
    formData.append("bottomSectionIdConfirmed", bottomSectionIdConfirmed);
    formData.append("mailto", mailto);
    formData.append("bottomBgColorGradient", bottomBgColorGradient || "");
    formData.append("bottomBgAbstract", bottomBgAbstract || "");
    formData.append("bottomBgIndustry", bottomBgIndustry || "");

    // Remove file inputs before submitting form data
    ["logoFile", "bannerFile", "midSecFile", "bottomSecFile"].forEach((field) => formData.delete(field));

    try {
        const response = await fetch(`${url}landing-page-builder/saveAsTemplate`, {
            method: "POST",
            body: formData,
        });
        const data = await response.json();
        hideLoader();

        if (!data.success) {
            alert(data.message);
        } else {
            const successModal = new bootstrap.Modal(
                document.getElementById("success_tic")
            );
            successModal.show();
        }
    } catch (error) {
        hideLoader();
        console.error("Error:", error);
        alert("An error occurred while saving the template. Please try again.");
    }
}
// END: SAVE AS TEMPLATE

// START: UPDATE PAGE
async function updatePage() {
    showLoader();
    const form = document.getElementById("submit-form");
    const pageId = document.getElementById("update-id").value;

    if (!pageId) {
        hideLoader();
        alert("Missing Page ID. Please refresh and try again.");
        return;
    }

    // Convert each section content separately
    const topSectionContentJSON = JSON.stringify({
        content: document.querySelector(".headings-container").innerHTML,
    });

    const midSectionContentJSON = JSON.stringify({
        content: document.getElementById("title-2-drag-drop-area").innerHTML,
    });

    const bottomSectionContentJSON = JSON.stringify({
        content: document.getElementById("contact-form-drag-drop-area").innerHTML,
    });

    const brandName = document.getElementById("brand").value;
    const bottomSectionIdConfirmed = checkIdExists("signup-form-div")
        ? "signup-form-div"
        : checkIdExists("contact-form-div")
        ? "contact-form-div"
        : "";
    const mailto = document.getElementById("mailto").value;

    const logoStyles = document.getElementById("logoStyles").value;
    const pageTitleStyles = document.getElementById("pageTitleStyles").value;

    const midSectionArea = document.getElementById("title-2-drag-drop-area");
    const midBgColorGradient = document.getElementById("mid_bg_color_gradient").value;
    const midBgAbstract = document.getElementById("mid_bg_abstract").value;
    const midBgIndustry = document.getElementById("mid_bg_industry".value);
    
    const bottomSectionArea = document.getElementById("contact-form-drag-drop-area");
    const bottomBgColorGradient = document.getElementById("bottom_bg_color_gradient").value;
    const bottomBgAbstract = document.getElementById("bottom_bg_abstract").value;
    const bottomBgIndustry = document.getElementById("bottom_bg_industry").value;

    const files = {
        logoFile: document.getElementById("logoFile").files[0],
        bannerFile: document.getElementById("bannerFile").files[0],
        midSecFile: document.getElementById("midSecBackgroundFile").files[0],
        bottomSecFile: document.getElementById("bottomsecBackgroundFile").files[0],
    };

    const chunkSize = 64 * 1024; // 64KB chunk size
    for (const [key, file] of Object.entries(files)) {
        if (file) {
            const totalChunks = Math.ceil(file.size / chunkSize);
            for (let i = 0; i < totalChunks; i++) {
                const chunk = file.slice(i * chunkSize, (i + 1) * chunkSize);
                const formData = new FormData();
                formData.append("chunk", chunk);
                formData.append("fieldName", key);
                formData.append("chunkIndex", i);
                formData.append("totalChunks", totalChunks);
                formData.append("fileName", file.name);

                try {
                    const response = await fetch(`${url}landing-page-builder/updateLandingPage`, {
                        method: "POST",
                        body: formData,
                    });
                    const result = await response.json();
                    if (!result.success) {
                        throw new Error(`Failed to upload chunk ${i} of ${key}`);
                    }
                } catch (error) {
                    console.error(`Error uploading chunk ${i} of ${key}:`, error);
                    hideLoader();
                    alert("An error occurred while uploading files. Please try again.");
                    return;
                }
            }
        }
    }

    // Proceed with non-file form submission
    const formData = new FormData();
    formData.append("logoStyles", logoStyles);
    formData.append("pageTitleStyles", pageTitleStyles);
    formData.append("topSectionContent", topSectionContentJSON);
    formData.append("midSectionContent", midSectionContentJSON);
    formData.append("midBgColorGradient", midBgColorGradient || "");
    formData.append("midBgAbstract", midBgAbstract || "");
    formData.append("midBgIndustry", midBgIndustry || "");
    formData.append("bottomSectionContent", bottomSectionContentJSON);
    formData.append("brandName", brandName);
    formData.append("pageId", pageId);
    formData.append("bottomSectionIdConfirmed", bottomSectionIdConfirmed);
    formData.append("mailto", mailto);
    formData.append("bottomBgColorGradient", bottomBgColorGradient || "");
    formData.append("bottomBgAbstract", bottomBgAbstract || "");
    formData.append("bottomBgIndustry", bottomBgIndustry || "");
    
    // Remove file inputs before submitting form data
    ["logoFile", "bannerFile", "midSecFile", "bottomSecFile"].forEach((field) => formData.delete(field));

    try {
        const response = await fetch(`${url}landing-page-builder/updateLandingPage`, {
            method: "POST",
            body: formData,
        });
        const data = await response.json();
        hideLoader();

        if (!data.success) {
            alert(data.message);
        } else {
            // window.location.href = data.redirect;
            const successModal = new bootstrap.Modal(
            document.getElementById("success_tic")
          );
          successModal.show();
        }
    } catch (error) {
        hideLoader();
        console.error("Error:", error);
        alert("An error occurred while updating the page. Please try again.");
    }
}
// END: UPDATE PAGE

function showLoader() {
  const loader = document.querySelector(".loader");
  loader.classList.remove("d-none");
}

function hideLoader() {
  const loader = document.querySelector(".loader");
  loader.classList.add("d-none");
}

function compressAndEncode(data) {
  const compressedData = pako.gzip(data, { level: 9 });
  const uint8Data = new Uint8Array(compressedData);
  const encodedData = btoa(String.fromCharCode.apply(null, uint8Data));
  return encodedData;
}

function checkIdExists(id) {
  const contactDropZone = document.getElementById(
    "contact-form-drag-drop-area"
  );
  const formId = contactDropZone.querySelector("#" + id);
  return formId !== null;
}

// Prevent form submission on "Enter"
let form = document.getElementById("submit-form");

form.addEventListener("keypress", function (event) {
  const isInCKEditor =
    window.ckeditorInstance &&
    window.ckeditorInstance.ui.view.editable.element.contains(
      document.activeElement
    );

  // Check if the active element is within the Quill editor
  const isQuillSignup = document
    .querySelector("#signup-form-title")
    .contains(document.activeElement);
  const isQuillContact = document
    .querySelector("#contact-form-title")
    .contains(document.activeElement);
  const isQuillTopHeading = document
    .querySelector("#top-section-heading")
    .contains(document.activeElement);

  // Only prevent form submission if "Enter" is pressed outside CKEditor and Quill
  if (
    event.key === "Enter" &&
    !isInCKEditor &&
    !isQuillSignup &&
    !isQuillContact &&
    !isQuillTopHeading
  ) {
    event.preventDefault();
    console.log("You pressed the ENTER key and prevented form submission");
  } else if (isInCKEditor) {
    console.log("You pressed the ENTER key in CKEditor");
  } else if (isQuill) {
    console.log("You pressed the ENTER key in Quill, new line created");
  }
});
