function heading() {
  console.log("Dropped Heading");

  let droppedContent = document.createElement("div");
  droppedContent.classList.add("top-section-heading-container");

  let deleteBtn = document.createElement("button");
  deleteBtn.type = "button";
  deleteBtn.classList.add(
    "bottom-section-delete-button",
    "btn",
    "btn-primary",
    "no-bg"
  );
  deleteBtn.setAttribute("data-toggle", "tooltip");
  deleteBtn.setAttribute("data-placement", "top");
  deleteBtn.setAttribute("title", "Delete this");

  let iconElement = document.createElement("i");
  iconElement.classList.add("bi", "bi-dash-circle");
  iconElement.style.color = "#d11a2a";
  iconElement.style.fontSize = "20px";
  deleteBtn.appendChild(iconElement);

  let heading = document.createElement("div");
  heading.id = "top-section-heading";
  // heading.contentEditable = true;

  droppedContent.appendChild(deleteBtn);
  droppedContent.appendChild(heading);

  let dropArea = document.getElementById("heading-drop-area");
  dropArea.style.width = "unset";
  dropArea.classList.remove("placeholder", "placeholder-wave", "bg-secondary");
  dropArea.querySelector("h1").classList.add("d-none");
  dropArea.appendChild(droppedContent);

  // Initialize Quill for the heading
  initializeQuillOnElement(heading, "heading");

  // Add delete button event listener to destroy Quill instance and remove the heading
  deleteBtn.addEventListener("click", function () {
    destroyQuill("heading"); // Destroy the Quill instance for the heading
    droppedContent.remove();
    dropArea.style.width = "  70%";
    dropArea.classList.add("placeholder", "placeholder-wave", "bg-secondary");
    dropArea.querySelector("h1").classList.remove("d-none");
  });
}

// Subheading
function subHeading() {
  console.log("Dropped Subheading");
  let droppedContent = document.createElement("div");
  droppedContent.classList.add("top-section-heading-container");

  let deleteBtn = document.createElement("button");
  deleteBtn.type = "button";
  deleteBtn.classList.add(
    "bottom-section-delete-button",
    "btn",
    "btn-primary",
    "no-bg"
  );
  deleteBtn.setAttribute("data-toggle", "tooltip");
  deleteBtn.setAttribute("data-placement", "top");
  deleteBtn.setAttribute("title", "Delete this");

  let iconElement = document.createElement("i");
  iconElement.classList.add("bi", "bi-dash-circle");
  iconElement.style.color = "#d11a2a";
  iconElement.style.fontSize = "20px";
  deleteBtn.appendChild(iconElement);

  let heading = document.createElement("p");
  heading.textContent = "Sub-heading";
  heading.id = "top-section-sub-heading";
  heading.contentEditable = true;

  let colorPicker = document.createElement("input");
  colorPicker.type = "color";
  colorPicker.id = "bottom-form-title-color-picker";
  colorPicker.dataset.target = heading.id;

  //   colorPicker.addEventListener("input", function () {
  //     heading.style.color = colorPicker.value;
  //   });

  droppedContent.appendChild(deleteBtn);
  droppedContent.appendChild(heading);
  droppedContent.appendChild(colorPicker);

  let dropArea = document.getElementById("sub-heading-drop-area");
  dropArea.style.width = "unset";
  dropArea.classList.remove("placeholder", "placeholder-wave", "bg-secondary");
  dropArea.querySelector("p").classList.add("d-none");
  dropArea.appendChild(droppedContent);

  deleteBtn.addEventListener("click", function () {
    droppedContent.remove();
    dropArea.style.width = "70%";
    dropArea.classList.add("placeholder", "placeholder-wave", "bg-secondary");
    dropArea.querySelector("p").classList.remove("d-none");
  });
}
