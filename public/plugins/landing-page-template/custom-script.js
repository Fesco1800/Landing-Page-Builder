//Banner Image Responsive, Maintain aspect ratio in any screen size

function adjustHeroHeight() {
  let hero = document.getElementById("hero");
  let heroStyle = getComputedStyle(hero);
  let backgroundImage = heroStyle.backgroundImage;

  if (backgroundImage !== "none") {
    let imageUrl = backgroundImage.slice(5, -2);

    let img = new Image();
    img.src = imageUrl;

    img.onload = function () {
      let aspectRatio = img.height / img.width;
      hero.style.height = hero.offsetWidth * aspectRatio + "px";
    };
  }
}

adjustHeroHeight();
window.addEventListener("resize", adjustHeroHeight);

// Form Submission
document.addEventListener("DOMContentLoaded", function () {
  let loader = document.getElementById("loader");
  var startTime = Date.now();
  const signupSubmitBtn = document.getElementById("signup-submit-btn");
  const vendorIntroSubmitBtn = document.getElementById(
    "vendor-intro-submit-btn"
  );

  // Form submit (Vendor Intro)
  if (vendorIntroSubmitBtn) {
    vendorIntroSubmitBtn.addEventListener("click", function (event) {
      event.preventDefault();
      document.getElementById("error-message").classList.add("d-none");

      // Time validation for spam bot
      var submitTime = Date.now();
      var elapsedTime = submitTime - startTime;
      console.log(elapsedTime);
      if (elapsedTime < 1000) {
        // 1 sec
        errorMessage(
          "Form submission suspected to be automated. Please try again."
        );
        return;
      }
      // Iframe check for spam bot
      if (window.self !== window.top) {
        errorMessage(
          "Form submission suspected to be automated. Please try again."
        );
        return;
      }
      var formData = new FormData(document.getElementById("vendor-intro-form"));
      loader.classList.remove("d-none");
      var xhr = new XMLHttpRequest();
      xhr.open("POST", url + "submit-landing-page/submitVendorIntro", true);
      xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
      xhr.onload = function () {
        loader.classList.add("d-none");
        if (xhr.status >= 200 && xhr.status < 400) {
          var response = JSON.parse(xhr.responseText);
          if (!response.success) {
            errorMessage(response.message);
          } else {
            document.getElementById("error-message").classList.add("d-none");
            successMessage(response.message);
          }
        }
      };
      xhr.onerror = function () {
        loader.classList.add("d-none");
        console.error("Error occurred during AJAX request.");
      };
      xhr.send(formData);
    });
  }

  // Form submit (Signup Form)
  if (signupSubmitBtn) {
    signupSubmitBtn.addEventListener("click", function (event) {
      event.preventDefault();
      document.getElementById("error-message").classList.add("d-none");

      // Time validation for spam bot
      var submitTime = Date.now();
      var elapsedTime = submitTime - startTime;
      console.log(elapsedTime);
      if (elapsedTime < 1000) {
        // 1 sec
        errorMessage(
          "Form submission suspected to be automated. Please try again."
        );
        return;
      }
      // Iframe check for spam bot
      if (window.self !== window.top) {
        errorMessage(
          "Form submission suspected to be automated. Please try again."
        );
        return;
      }
      var formData = new FormData(document.getElementById("signup-form"));
      loader.classList.remove("d-none");
      var xhr = new XMLHttpRequest();
      xhr.open("POST", url + "submit-landing-page/submitSignup", true);
      xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
      xhr.onload = function () {
        loader.classList.add("d-none");
        if (xhr.status >= 200 && xhr.status < 400) {
          var response = JSON.parse(xhr.responseText);
          if (!response.success) {
            errorMessage(response.message);
          } else {
            document.getElementById("error-message").classList.add("d-none");
            successMessage(response.message);
          }
        }
      };
      xhr.onerror = function () {
        loader.classList.add("d-none");
        console.error("Error occurred during AJAX request.");
      };
      xhr.send(formData);
    });
  }

  // error message
  function errorMessage(message) {
    var errorMessage = document.getElementById("error-message");
    errorMessage.textContent = message;
    errorMessage.classList.remove("d-none");
    setTimeout(function () {
      location.reload();
    }, 2000);
  }

  // success message
  function successMessage(message) {
    var successMessage = document.getElementById("success-message");
    successMessage.textContent = message;
    successMessage.classList.remove("d-none");
    setTimeout(function () {
      location.reload();
    }, 2000);
  }
});

// Set elements contentEditable attribute to false
let editableElements = document.querySelectorAll('[contentEditable="true"]');
editableElements.forEach((element) => {
  element.setAttribute("contentEditable", false);
});

// Function to remove Quill and hide bottom section
function disableFormQuill(formHeading) {
  if (formHeading) {
    formHeading.classList.remove("ql-container", "ql-bubble");

    let editor = formHeading.querySelector(".ql-editor");
    let tooltip = formHeading.querySelector(".ql-tooltip");
    let toolbar = document.querySelector(".ql-toolbar");

    // Check if the editor and tooltip exist before manipulating them
    if (editor) {
      editor.classList.remove("ql-editor");
    }
    if (tooltip) {
      tooltip.style.display = "none";
    }
    if (toolbar) {
      toolbar.style.display = "none";
    }
  }
}

// Get form headings
let signupFormHeading = document.getElementById("signup-form-title");
let contactFormHeading = document.getElementById("contact-form-title");

// Apply the function to both forms if they exist
disableFormQuill(signupFormHeading);
disableFormQuill(contactFormHeading);

// Set footer logo
let logo = footerLogo;
let flp = document.querySelector(".footer-logo-placeholder");
let img = flp.querySelector("img");
img.src = url + "file/builder-uploads/" + logo;
