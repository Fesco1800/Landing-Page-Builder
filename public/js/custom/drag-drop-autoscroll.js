var photoIframe = document.getElementById("photo-editor-iframe-container");
var dropArea1 = document.getElementById("title-2-drag-drop-area");
var dropArea2 = document.getElementById("contact-form-drag-drop-area");
var dropOccurred = false;

window.addEventListener("scroll", () => {}, { passive: true });

function handleDragOverScroll(e) {
  photoIframe.style.display = "none";

  var mouseY = e.clientY;
  var windowHeight = window.innerHeight;
  var scrollThreshold = 20;

  if (mouseY < scrollThreshold) {
    window.scrollBy(0, -80);
  } else if (mouseY > windowHeight - scrollThreshold) {
    window.scrollBy(0, 80);
  }
}

function handleDragEnter(dropArea) {
  dropArea.style.border = "2px dashed #09a9f7";
  dropArea.style.opacity = "0.6";
  //   dropArea.style.background = "#fcfcfc";
}

function handleDragLeave(dropArea) {
  dropArea.style.border = "2px dashed #09a9f7";
  //   dropArea.style.background = "transparent";
  dropArea.style.opacity = "1";
}

function resetDropAreaStyles(dropArea) {
  dropArea.style.border = "2px dashed #09a9f7";
  //   dropArea.style.background = "transparent";
  dropArea.style.opacity = "1";
  photoIframe.style.display = "block";
}

function attachEventListeners(dropArea) {
  dropArea.addEventListener("dragenter", function () {
    handleDragEnter(dropArea);
  });
  dropArea.addEventListener("dragleave", function () {
    handleDragLeave(dropArea);
  });
  dropArea.addEventListener("dragend", (event) => {
    resetDropAreaStyles(dropArea);
    console.log("Drag end");
  });
  dropArea.addEventListener("drop", (event) => {
    resetDropAreaStyles(dropArea);
    dropOccurred = true;
    console.log("Drag success");
  });
}

attachEventListeners(dropArea1);
attachEventListeners(dropArea2);

document.addEventListener("dragover", handleDragOverScroll);

document.addEventListener("dragend", function (event) {
  dropOccurred = false;
  photoIframe.style.display = "block";
});
