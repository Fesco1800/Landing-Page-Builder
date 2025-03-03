/*
 * Top Section Scripts
 * Switch between Image Editor and Top Banner View
 */

// Display Uploaded images to placeholders
const logo = document.getElementById("logoFile");
const banner = document.getElementById("bannerFile");
const pageTitle = document.getElementById("brand");
const lp = document.querySelector(".logo-placeholder").querySelector("img");
const hp = document.querySelector(".hero-placeholder");
const tp = document.querySelector(".page-title-placeholder");
// const flp = document
//   .querySelector(".footer-logo-placeholder")
//   .querySelector("img");
// const fptp = document.querySelector(".footer-page-title-placeholder");

logo.addEventListener("change", function () {
  if (logo.files && logo.files[0]) {
    const reader = new FileReader();
    reader.onload = function (e) {
      lp.src = e.target.result;
    //   flp.src = e.target.result;
      lp.style.width = "45px";
    //   flp.style.width = "100px";
    //   flp.style.height = "100px";
    //   flp.style.objectFit = "contain";
    //   flp.style.borderRadius = "none";
    };
    reader.readAsDataURL(logo.files[0]);
  }
});

banner.addEventListener("change", function () {
  if (banner.files && banner.files[0]) {
    const reader = new FileReader();
    reader.onload = function (e) {
      hp.style.backgroundImage = `url('${e.target.result}')`;
    };
    reader.readAsDataURL(banner.files[0]);
  }
});

pageTitle.addEventListener("input", function () {
  if (pageTitle.value !== "") {
    tp.textContent = pageTitle.value;
    // fptp.textContent = pageTitle.value;
  } else {
    tp.textContent = "";
    // fptp.textContent = "";
  }
});

//Switch
document
  .querySelector(".top-section-switch-btn")
  .addEventListener("click", () => {
    const p = document.getElementById("photo-editor-iframe-container");
    const t = document.getElementById("top-section-container");
    const h = document.querySelector(".top-section-title");

    p.classList.contains("d-none")
      ? (p.classList.remove("d-none"),
        t.classList.add("d-none"),
        (h.textContent = "Photo Editor"))
      : (p.classList.add("d-none"),
        t.classList.remove("d-none"),
        (h.textContent = "Top Section"));
  });

//Logo set height
document.getElementById("previewLogoImage").onload = function () {
  this.style.width = "85px";
  this.style.borderRadius = "0";
};

/**
 * Logo Resize function
 */

// Logo Resize
const resizeLogo = document.getElementById("previewLogoImage");
const increaseBtn = document.getElementById("logoIncreaseBtn");
const decreaseBtn = document.getElementById("logoDecreaseBtn");
const logoStyles = document.getElementById("logoStyles");

// Size increment
const sizeStep = 20;
const minSize = 50;
const maxSize = 350;

// Update hidden field with computed logo styles
function updateLogoStyles() {
  const computedLogoStyles = window.getComputedStyle(resizeLogo);
  logoStyles.value = JSON.stringify({
    width: computedLogoStyles.width,
  });
}

// Increase
increaseBtn.addEventListener("click", () => {
  const currentWidth = resizeLogo.offsetWidth;
  if (currentWidth + sizeStep <= maxSize) {
    resizeLogo.style.width = currentWidth + sizeStep + "px";
    updateLogoStyles(); // Update hidden input value with computed styles
  }
});

// Decrease
decreaseBtn.addEventListener("click", () => {
  const currentWidth = resizeLogo.offsetWidth;
  if (currentWidth - sizeStep >= minSize) {
    resizeLogo.style.width = currentWidth - sizeStep + "px";
    updateLogoStyles(); // Update hidden input value with computed styles
  }
});

// Initial update of the hidden field with the computed logo size
updateLogoStyles();

/**
 * End of Logo Resize function
 */

/**
 * Page Title Toolbar
 */

// Hidden input to store the page title styles
const pageTitleStyles = document.getElementById("pageTitleStyles");

// Function to update the hidden field with the computed page title styles
function updatePageTitleStyles() {
  const computedTitleStyles = window.getComputedStyle(tp);
  pageTitleStyles.value = JSON.stringify({
    fontWeight: computedTitleStyles.fontWeight,
    fontStyle: computedTitleStyles.fontStyle,
    textDecoration: computedTitleStyles.textDecoration,
    fontFamily: computedTitleStyles.fontFamily,
    fontSize: computedTitleStyles.fontSize,
    color: computedTitleStyles.color,
  });
}

// Bold button
document.getElementById("pageTitleBold").addEventListener("click", function () {
  const currentFontWeight = tp.style.fontWeight;
  tp.style.fontWeight = currentFontWeight === "bold" ? "normal" : "bold";
  updatePageTitleStyles(); // Update hidden input after change
});

// Italic button
document
  .getElementById("pageTitleItalic")
  .addEventListener("click", function () {
    const currentFontStyle = tp.style.fontStyle;
    tp.style.fontStyle = currentFontStyle === "italic" ? "normal" : "italic";
    updatePageTitleStyles(); // Update hidden input after change
  });

// Underline button
document
  .getElementById("pageTitleUnderline")
  .addEventListener("click", function () {
    const currentTextDecoration = tp.style.textDecoration;
    tp.style.textDecoration =
      currentTextDecoration === "underline" ? "none" : "underline";
    updatePageTitleStyles(); // Update hidden input after change
  });

// Font Style button
document
  .getElementById("pageTitleFontStyle")
  .addEventListener("click", function () {
    const currentFont = tp.style.fontFamily;
    if (currentFont === "Arial") {
      tp.style.fontFamily = "Courier New";
    } else if (currentFont === "Courier New") {
      tp.style.fontFamily = "Georgia";
    } else {
      tp.style.fontFamily = "Arial";
    }
    updatePageTitleStyles(); // Update hidden input after change
  });

// Font Size button
document
  .getElementById("pageTitleFontSize")
  .addEventListener("click", function () {
    const currentSize = window.getComputedStyle(tp).fontSize;
    if (currentSize === "32px") {
      tp.style.fontSize = "40px"; // Larger size
    } else if (currentSize === "40px") {
      tp.style.fontSize = "24px"; // Smaller size
    } else {
      tp.style.fontSize = "32px"; // Default size
    }
    updatePageTitleStyles(); // Update hidden input after change
  });

// Color picker
document
  .getElementById("pageTitleTextColor")
  .addEventListener("input", function (event) {
    const selectedColor = event.target.value;
    tp.style.color = selectedColor;
    updatePageTitleStyles(); // Update hidden input after change
  });

// Initial update of the hidden field with computed page title styles
updatePageTitleStyles();

/**
 * End of Page Title Toolbar
 */
