let headingButton = document.getElementById("add-heading");
let subheadingButton = document.getElementById("add-sub-heading");
let productHighlightsButton = document.getElementById(
  "add-product-highlights-button"
);
let signupFromButton = document.getElementById("add-signup-form");
let contactFormButton = document.getElementById("add-contact-form");

productHighlightsButton.addEventListener("click", function () {
  productHighlights();
});

signupFromButton.addEventListener("click", function () {
  signupForm();
});

contactFormButton.addEventListener("click", function () {
  contactForm();
});

headingButton.addEventListener("click", function () {
  heading();
});

// subheadingButton.addEventListener("click", function() {
//     subHeading();
// });
