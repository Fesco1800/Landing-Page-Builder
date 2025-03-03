function allowDrop(ev) {
  ev.preventDefault();
}

function handleDrop(ev) {
  ev.preventDefault();
  var droppedType = ev.dataTransfer.getData("text/plain");
  var dropAreaId = ev.target.id;

  // Check the type and drop area compatibility
  if (
    (droppedType === "product-highlights" &&
      dropAreaId !== "title-2-drag-drop-area") ||
    (droppedType === "promo-offer" &&
      dropAreaId !== "title-2-drag-drop-area") ||
    (droppedType === "contact-form" &&
      dropAreaId !== "contact-form-drag-drop-area")
  ) {
    console.error(
      "Incompatible drop: " +
        droppedType +
        " cannot be dropped in " +
        dropAreaId
    );
    return;
  }

  // Check the type and call the corresponding drop function
  switch (droppedType) {
    case "product-highlights":
      productHighlights();
      break;

    case "promo-offer":
      promoOffer();
      break;

    case "contact-form":
      contactForm();
      isContactFormDropped = true;
      break;

    case "signup-form":
      signupForm();
      isSignupFormDropped = true;
      break;

    case "heading":
      heading();
      break;

    case "sub-heading":
      subHeading();
      break;

    case "title":
      title();
      break;

    case "body-text":
      bodyText();
      break;

    case "text-field":
      textField();
      break;

    case "select-field":
      selectField();
      break;

    default:
      console.error("Unsupported content type");
      break;
  }
}

function drag(ev) {
  ev.dataTransfer.setData("text/plain", ev.target.id);
}

function deleteElement(element) {
  element.remove();
}
