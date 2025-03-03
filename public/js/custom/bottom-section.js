let bottomSectionArea = document.getElementById("contact-form-drag-drop-area");
let bottomSectionFormId = document.getElementById("bottom_section_id");
let addSignupFormButton = document.getElementById("add-signup-form");
let addContactFormButton = document.getElementById("add-contact-form");
/*
    Mailto
*/

const mailto = document.getElementById("mailto");
const fe = document.querySelector(".footer-email");

mailto.addEventListener("input", function (e) {
  if (mailto.value != "") {
    fe.textContent = mailto.value;
  }
});

/**
 * Footer
 * */
// if (builderMode === "update") {
//   const footerLogoPlaceholder = document.querySelector(
//     ".footer-logo-placeholder"
//   );
//   const topSectionPreviewLogo = document.querySelector(".update-logo-preview");
//   const footerLogo = footerLogoPlaceholder.querySelector("img");

//   footerLogo.src = topSectionPreviewLogo.src;
// }
// if (builderMode === "template") {
//   const footerLogoPlaceholder = document.querySelector(
//     ".footer-logo-placeholder"
//   );
//   const topSectionPreviewLogo = document.querySelector(
//     ".template-logo-preview"
//   );
//   const footerLogo = footerLogoPlaceholder.querySelector("img");

//   footerLogo.src = topSectionPreviewLogo.src;
// }

/*
    Add Signup and Contact Forms
*/
let quillInstances = {};

function contactForm() {
  createForm("contact");
}

function signupForm() {
  createForm("signup");
}

// Main form creation
function createForm(formType) {
  let formConfig = getFormConfig(formType);

  let droppedContent = document.createElement("div");
  droppedContent.classList.add(
    "form-group",
    "form-container",
    `${formType}-form-delete`,
    "w-50",
    "w-md-50"
  );

  let buttonElement = createDeleteButton(droppedContent, "bi-x-lg", formType); // Pass formType to delete button

  let titleElement = createEditableElement(
    "div", // Changed from h3 to div so Quill can target it
    `${formType}-form-title`,
    "",
    "mb-5"
  );

  let nameInputGroup = createInputGroup("text", "name", "Name");
  let emailInputGroup = createInputGroup("email", "email", "Email");
  let phoneInputGroup = createInputGroup("tel", "phone", "Contact Number");
  let remarksInputGroup = createTextareaGroup("remarks", "Remarks");

  let formContent = document.createElement("div");
  formContent.id = `${formType}-form-div`;

  let [row1, row2, row3] = createRowsWithColumns([
    [nameInputGroup, emailInputGroup],
    [phoneInputGroup],
    [remarksInputGroup],
  ]);

  appendChildren(droppedContent, [
    buttonElement,
    titleElement,
    row1,
    row2,
    row3,
    formContent,
  ]);
  bottomSectionArea.appendChild(droppedContent);

  setFormDraggable(false, "signup-form", "contact-form");

  bottomSectionFormId.value = formContent.id;
  console.log(`Dropped ${formConfig.name}`);

  // Directly initialize Quill after adding the title element to the DOM
  initializeQuillOnElement(titleElement, formType);
}

// Editable element creation
function createEditableElement(tag, id, textContent, className) {
  let element = document.createElement(tag);
  element.style.fontSize = "1.75rem";
  element.style.fontWeight = "bold";
  element.id = id;
  element.textContent = textContent;
  // element.contentEditable = true;
  element.classList.add(...className.split(" "));

  return element;
}

// Create delete button
function createDeleteButton(
  parentElement,
  iconClass = "bi-dash-circle",
  formType
) {
  let buttonElement = document.createElement("button");
  buttonElement.type = "button";
  buttonElement.classList.add(
    "bottom-section-delete-button",
    "btn",
    "btn-primary",
    "no-bg"
  );
  buttonElement.setAttribute("data-toggle", "tooltip");
  buttonElement.setAttribute("data-placement", "top");
  buttonElement.setAttribute("title", "Delete this");

  let iconElement = document.createElement("i");
  iconElement.classList.add("bi", iconClass);
  iconElement.style.color = "#d11a2a";
  iconElement.style.fontSize = "20px";
  buttonElement.appendChild(iconElement);

  buttonElement.addEventListener("click", () => {
    destroyQuill(formType); // Destroy Quill for the specific form type
    parentElement.remove();
    updateLayout();
    addContactFormButton.disabled = false;
    addSignupFormButton.disabled = false;
    bottomSectionFormId.value = "";
  });

  return buttonElement;
}

// input groups
function createInputGroup(type, id, placeholder) {
  let inputGroup = document.createElement("div");
  inputGroup.classList.add("input-group", "mb-3");

  let input = document.createElement("input");
  input.type = type;
  input.id = id;
  input.name = id;
  input.classList.add("form-control");
  input.placeholder = placeholder;

  let inputGroupAppend = document.createElement("div");
  inputGroupAppend.classList.add("input-group-append");

  let deleteButton = createDeleteButton(inputGroup);

  inputGroupAppend.appendChild(deleteButton);
  inputGroup.appendChild(input);
  inputGroup.appendChild(inputGroupAppend);

  return inputGroup;
}

// textarea groups
function createTextareaGroup(id, placeholder) {
  let inputGroup = document.createElement("div");
  inputGroup.classList.add("input-group", "mb-3");

  let textarea = document.createElement("textarea");
  textarea.classList.add("form-control");
  textarea.name = id;
  textarea.id = id;
  textarea.placeholder = placeholder;
  textarea.style.height = "10em";

  let inputGroupAppend = document.createElement("div");
  inputGroupAppend.classList.add("input-group-append");

  let deleteButton = createDeleteButton(inputGroup);

  inputGroupAppend.appendChild(deleteButton);
  inputGroup.appendChild(textarea);
  inputGroup.appendChild(inputGroupAppend);

  return inputGroup;
}

// with columns
function createRowsWithColumns(columnsArray) {
  return columnsArray.map((columns) => {
    let row = document.createElement("div");
    row.classList.add("row", "mb-3");
    columns.forEach((colContent) => {
      let col = document.createElement("div");
      col.classList.add(
        `col-12`,
        `col-md-${12 / columns.length}`,
        "input-column"
      );
      col.appendChild(colContent);
      row.appendChild(col);
    });
    return row;
  });
}

// append multiple children to a parent
function appendChildren(parent, children) {
  children.forEach((child) => parent.appendChild(child));
}

// set form draggable state
function setFormDraggable(state, ...formIds) {
  formIds.forEach((id) => {
    let form = document.getElementById(id);
    form.draggable = state;
    form.style.opacity = state ? 1 : 0.5;
  });
}

// get form configuration
function getFormConfig(formType) {
  return {
    name: formType === "contact" ? "Contact Form" : "Signup Form",
    titleId: `${formType}-form-title`,
    subtitleId: `${formType}-form-subtitle`,
    contentId: `${formType}-form-div`,
  };
}

// update layout after delete
function updateLayout() {
  let row = document.querySelector(".row.mb-3");
  let inputColumns = row.querySelectorAll(".input-column");

  let activeColumns = Array.from(inputColumns).filter(
    (column) => column.children.length > 0
  );

  activeColumns.forEach((column) => {
    column.className = `col-${12 / activeColumns.length} input-column`;
  });
}

/*
  Editable Form Heading
*/

// Initialize Quill for the specific element
function initializeQuillOnElement(element, formType) {
  console.log("Element passed to initializeQuillOnElement: " + element);
  if (!element || !(element instanceof HTMLElement)) {
    console.error("Invalid element for Quill initialization");
    console.log("Element passed to initializeQuillOnElement: " + element);
    return;
  }

  // Check if a Quill instance for this formType already exists
  if (quillInstances[formType]) {
    console.warn(`Quill is already initialized for ${formType}`);
    return;
  }

  let Font = Quill.import("formats/font");
  Font.whitelist = [
    "sans-serif",
    "serif",
    "monospace",
    "roboto",
    "arial",
    "courier",
  ]; // Add custom fonts here
  Quill.register(Font, true);

  // Initialize Quill for the specific element
  quillInstances[formType] = new Quill(element, {
    theme: "snow",
    modules: {
      toolbar: [
        [{ header: [1, 2, 3, 4, 5, 6, false] }],
        ["bold", "italic", "underline"],
        [{ font: [] }],
        [{ align: [] }],
        [{ color: [] }, { background: [] }],
        ["clean"],
      ],
    },
    placeholder: `${formType.charAt(0).toUpperCase() + formType.slice(1)}...`,
  });

  console.log(`Quill initialized on ${formType}`);
}

/**
 * Destroy Quill for a specific form
 */
function destroyQuill(formType) {
  if (quillInstances[formType]) {
    quillInstances[formType] = null;
    console.log(`Quill destroyed for ${formType} form`);
  }
}
/**
 * End of Destroy Quill for a specific form
 */

/* 
  Enable Disable "Add Signup Form" and "Add Contact Form" Buttons
*/

function enableDisableForms() {
  addSignupFormButton.addEventListener("click", function () {
    addContactFormButton.disabled = true;
    addSignupFormButton.disabled = true;
  });
  addContactFormButton.addEventListener("click", function () {
    addSignupFormButton.disabled = true;
    addContactFormButton.disabled = true;
  });
}
enableDisableForms();

/* 
  End of:
  Enable Disable "Add Signup Form" and "Add Contact Form" Buttons
*/

/**
 * End of
 * Initialize the Quill on update and template mode
 * Set bottomSectionId's during Update and Template Mode
 * Disable "Add Signup Form" and "Add Contact Form" Buttons
 * Activate Form Buttons
 */
if (builderMode === "update" || builderMode === "template") {
  // Initialize Quill
  const elementsToInitialize = [
    {
      element: document.getElementById("top-section-heading"),
      formType: "heading",
    },
    {
      element: document.getElementById("contact-form-title"),
      formType: "contact",
    },
    {
      element: document.getElementById("signup-form-title"),
      formType: "signup",
    },
  ];

  elementsToInitialize.forEach(({ element, formType }) => {
    if (element) {
      // Check if there's any toolbar left over from the saved HTML
      const existingToolbar =
        element.parentElement.querySelector(".ql-toolbar");
      if (existingToolbar) {
        // Remove the toolbar if it's just a leftover from the saved HTML
        existingToolbar.remove();
        console.log(`Removed leftover toolbar for ${formType}`);
      }

      // Now, initialize a fresh Quill instance on the element
      initializeQuillOnElement(element, formType);
      // console.log(`Quill initialized on ${formType}`);

      // Delete extra ql-editor new lines
      const qlEditor = element.querySelector(".ql-editor");
      if (qlEditor) {
        const paragraphs = qlEditor.querySelectorAll("p");
        paragraphs.forEach((paragraph) => {
          if (
            paragraph.innerHTML.trim() === "<br>" ||
            paragraph.textContent.trim() === ""
          ) {
            paragraph.remove();
          }
        });
      }
    }
  });

  console.log("Initialized Quill on update or template mode");

  // Check form id
  const hasSignUpFormDiv = bottomSectionArea.querySelector("#signup-form-div");
  const hasContactFormDiv =
    bottomSectionArea.querySelector("#contact-form-div");

  if (hasSignUpFormDiv) {
    bottomSectionFormId.value = "signup-form-div ";
  }
  if (hasContactFormDiv) {
    bottomSectionFormId.value = "contact-form-div ";
  }

  // Disable Add Form buttons
  addSignupFormButton.disabled = true;
  addContactFormButton.disabled = true;

  //Delete button eventlistener | to make the form delete button to work
  document.addEventListener("click", function (event) {
    // Ensure that the clicked element is the button or its child elements
    const deleteButton = event.target.closest(".bottom-section-delete-button");

    if (deleteButton) {
      const parentElement = deleteButton.parentElement;
      const childElement = deleteButton.children[0];
      if (childElement.classList.contains("bi-x-lg")) {
        deleteButton.parentElement.remove();
        bottomSectionFormId.value = "";
        addSignupFormButton.disabled = false;
        addContactFormButton.disabled = false;
        if (parentElement.classList.contains("signup-form-delete")) {
          destroyQuill("signup");
        }
        if (parentElement.classList.contains("contact-form-delete")) {
          destroyQuill("contact");
        }
        updateLayout();
        // console.log("X Large delete entire form");
      }
      if (childElement.classList.contains("bi-dash-circle")) {
        const deleteElement = event.target.closest(".input-group");
        deleteElement.remove();
        updateLayout();
        // console.log("Dash Circle delete input field");
      }
    }
  });
}
/**
 * End of:
 * Initialize the Quill on update and template mode
 * Set bottomSectionId's during Update and Template Mode
 */
