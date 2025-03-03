// color picker
document.querySelector(".editor-container-row").addEventListener("input", function (event) {
  if (event.target.type === "color") {
      console.log("Running: color input field event listener");

      const targets = event.target.getAttribute("data-targets");
      if (targets) {
          const targetElementIds = targets.split(",");

          targetElementIds.forEach((targetElementId) => {
              const targetElement = document.getElementById(targetElementId.trim());
              if (targetElement) {
                  targetElement.style.color = event.target.value;
              }
          });
      } else {
          const targetElementId = event.target.getAttribute("data-target");
          if (targetElementId) {
              const targetElement = document.getElementById(targetElementId.trim());
              if (targetElement) {
                  if (targetElement.classList.contains("footer")) {
                      targetElement.style.backgroundColor = event.target.value;
                  } else {
                      targetElement.style.color = event.target.value;
                  }
              }
          }
      }
  }
});


//paste only plain text || prevent other elements to be pasted
document
  .querySelector(".editor-container-row")
  .addEventListener("paste", function (event) {
    event.preventDefault();
    console.log("paste only plain text");
    var text = (event.clipboardData || window.clipboardData).getData("text");
    document.execCommand("insertText", false, text);
  });
