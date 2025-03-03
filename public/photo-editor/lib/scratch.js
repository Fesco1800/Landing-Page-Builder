$(
  `${this.containerSelector} .toolpanel#select-panel .object-options #crop`
).click(() => {
  const fabricCanvas = this.canvas;
  const originalImage = this.activeSelection._element;
  const imageUrl = originalImage.src;
  const newImage = new Image();
  newImage.src = imageUrl;
  newImage.id = "cropper-image-" + new Date().getTime();
  const canvasContainer = document.querySelector(".canvas-container");
  const cropModal = document.getElementById("crop-modal");
  canvasContainer.appendChild(cropModal);
  const cropImageContainer = document.querySelector(".crop-image-container");
  cropImageContainer.appendChild(newImage);
  $("#crop-modal").modal("show");

  const cropper = new Cropper(newImage, {
    aspectRatio: 0,
    viewMode: 1,
  });

  function destroyCropper(cropperInstance, imgElement) {
    if (cropperInstance) {
      imgElement.remove();
      cropperInstance.destroy();
    }
  }

  $(".circle-crop").click(() => {
    setRoundedCrop(cropper, newImage, fabricCanvas);
  });

  $(".free-crop").click(() => {
    setDefaultCrop(cropper, newImage, fabricCanvas);
  });

  setDefaultCrop(cropper, newImage, fabricCanvas);

  function setDefaultCrop(cropper, newImage, canvas) {
    //live Preview
    newImage.addEventListener("crop", () => {
      const croppedCanvas = cropper.getCroppedCanvas({}).toDataURL();
      setPreview(croppedCanvas);
    });

    // save
    const saveBtn = document.querySelector(".save-button");
    const saveBtn1 = document.querySelector(".save-button1");
    saveBtn.style.display = "block";
    saveBtn1.style.display = "none";
    saveBtn.addEventListener("click", (e) => {
      e.preventDefault();
      const croppedCanvasSrc = cropper.getCroppedCanvas({}).toDataURL();
      setSave(canvas, croppedCanvasSrc);
      console.log("Default crop triggered!");
    });
  }

  function setRoundedCrop(cropper, newImage, canvas) {
    //
    function getRoundedCanvas(sourceCanvas) {
      const canvas = document.createElement("canvas");
      const context = canvas.getContext("2d");
      const width = sourceCanvas.width;
      const height = sourceCanvas.height;
      canvas.width = width;
      canvas.height = height;
      context.imageSmoothingEnabled = true;
      context.drawImage(sourceCanvas, 0, 0, width, height);
      context.globalCompositeOperation = "destination-in";
      context.beginPath();
      context.arc(
        width / 2,
        height / 2,
        Math.min(width, height) / 2,
        0,
        2 * Math.PI,
        true
      );
      context.fill();
      return canvas;
    }

    cropper.setAspectRatio(1);
    let cropperBox = document.querySelector(".cropper-view-box");
    let cropperFace = document.querySelector(".cropper-face");
    cropperBox.style.borderRadius = "50%";
    cropperFace.style.borderRadius = "50%";
    cropperBox.style.outline = "0";
    if (cropper.getCroppedCanvas()) {
      const croppedCanvas = cropper.getCroppedCanvas();
      const roundedCanvas = getRoundedCanvas(croppedCanvas);
      const imgSrc = roundedCanvas.toDataURL();
      setPreview(imgSrc);

      //For Live Preview
      newImage.addEventListener("crop", () => {
        const cropped = cropper.getCroppedCanvas();
        const roundCrop = getRoundedCanvas(cropped);
        const imgSrc = roundCrop.toDataURL();
        setPreview(imgSrc);
      });
      // save
      const saveBtn = document.querySelector(".save-button");
      saveBtn.style.display = "none";
      const saveBtn1 = document.querySelector(".save-button1");
      saveBtn1.style.display = "block";
      saveBtn1.addEventListener("click", (e) => {
        e.preventDefault();
        setSave(canvas, imgSrc);
        console.log("Rounded crop triggered!");
      });
    }
  }

  function setPreview(src) {
    const previewImg = document.getElementById("preview-image");
    previewImg.src = src;
  }

  function setSave(canvas, src) {
    const newObj = new Image();
    newObj.src = src;

    const newObjInstance = new fabric.Image(newObj, {
      left: 2,
      top: 2,
    });
    newObjInstance.scaleToHeight(170);
    newObjInstance.scaleToWidth(170);
    canvas.setActiveObject(newObjInstance);
    canvas.add(newObjInstance);
    $("#crop-modal").modal("hide");
  }

  $("#crop-modal").on("hidden.bs.modal", function () {
    newImage.remove();
    cropper.destroy();
    console.log("Modal Closed, Cropper Js Destroyed");
  });
});
