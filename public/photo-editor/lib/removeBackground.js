/**
 * Define action to upload, drag & drop images into the canvas
 */
(function () {
  var uploadRemove = function (canvas) {
    const _self = this;
    this.openDragDropPanelRemove = function () {
      console.log("open drag drop panel");
      $("body").append(`<div class="custom-modal-container">
        <div class="custom-modal-content">
          <div class="drag-drop-input">
            <div>Drag & drop files<br>or click to browse.<br>JPG, PNG or SVG only!</div>
          </div>
        </div>
      </div>`);
      $(".custom-modal-container").click(function () {
        $(this).remove();
      });

      $(".drag-drop-input").click(function () {
        console.log("click drag drop");
        $(`${_self.containerSelector} #btn-image-remove`).click();
      });

      $(".drag-drop-input").on("dragover", function (event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).addClass("dragging");
      });

      $(".drag-drop-input").on("dragleave", function (event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).removeClass("dragging");
      });

      $(".drag-drop-input").on("drop", function (event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).removeClass("dragging");
        if (event.originalEvent.dataTransfer) {
          if (event.originalEvent.dataTransfer.files.length) {
            let files = event.originalEvent.dataTransfer.files;
            processFiles(files);
            $(".custom-modal-container").remove();
          }
        }
      });
    };

    const processFiles = (files) => {
      if (files.length === 0) return;
      const allowedTypes = ["image/jpeg", "image/png", "image/svg+xml"];

      for (let file of files) {
        // check type
        if (!allowedTypes.includes(file.type)) continue;

        let reader = new FileReader();

        // handle svg
        if (file.type === "image/svg+xml") {
          reader.onload = (f) => {
            fabric.loadSVGFromString(f.target.result, (objects, options) => {
              let obj = fabric.util.groupSVGElements(objects, options);
              obj
                .set({
                  left: 0,
                  top: 0,
                })
                .setCoords();
              canvas.add(obj);

              canvas.renderAll();
              canvas.trigger("object:modified");
            });
          };
          reader.readAsText(file);
          continue;
        }

        // handle image, read file, add to canvas
        reader.onload = (f) => {};

        reader.readAsDataURL(file);
      }
    };

    this.containerEl.append(
      `<input id="btn-image-remove" type="file" accept="image/*" multiple hidden>`
    );

    // Add an event listener for file input change
    document
      .querySelector(`${_self.containerSelector} #btn-image-remove`)
      .addEventListener("change", async function (e) {
        if (e.target.files.length === 0) return;

        processFiles(e.target.files);

        const canvasContainer = document.querySelector(".canvas-container");
        canvasContainer.style.opacity = "0.5";
        const loaderContainer = document.createElement("div");
        loaderContainer.classList.add("loader-container");
        const loadingSpinner = document.createElement("span");
        loadingSpinner.classList.add("loader");
        canvasContainer.appendChild(loaderContainer);
        loaderContainer.appendChild(loadingSpinner);

        // Send the selected image to the route for background removal
        const serverUrl = "http://127.0.0.1:3000"; //Nodejs server

        const formData = new FormData();
        formData.append("imageData", e.target.files[0]);

        // remove-background is a route name
        const response = await fetch(`${serverUrl}/remove-background`, {
          method: "POST",
          body: formData,
        });

        if (response.ok) {
          const processedImageURL = await response.text();

          // Load the processed image
          const img = new Image();
          img.src = processedImageURL;
          img.onload = function () {
            const fabricImage = new fabric.Image(img);
            fabricImage.scaleX = 0.1;
            fabricImage.scaleY = 0.1;
            canvasContainer.removeChild(loaderContainer);
            canvasContainer.style.opacity = "1";
            canvas.add(fabricImage);
            canvas.renderAll();
          };
        }
      });
  };

  window.ImageEditor.prototype.initializeUploadRemove = uploadRemove;
})();
