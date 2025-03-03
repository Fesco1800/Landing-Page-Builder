// Bottom Section Image Gallery
document.addEventListener("DOMContentLoaded", function () {
  const originalBackground = `url('${url}img/landing-page-builder/svg-flip.png')`;
  const abstractFolderPath = `${url}img/contact-background/abstract/compressed/`;
  const imageCategorySelect = document.getElementById("imageCategory");
  const gradientColorInput = document.getElementById("gradientColorInput");
  const abstractInput = document.querySelector(".abstractInput");
  const loader = document.querySelector(".image-gallery-loader");
  const imageGalleryModalContent = document.getElementById(
    "imageGalleryModalContent"
  );
  const bottomSectionFile = document.getElementById("bottomsecBackgroundFile");
  const bottomSectionAbstract = document.getElementById("bottom_bg_abstract");
  const bottomSectionIndustry = document.getElementById("bottom_bg_industry");
  const bottomsecBgColorGradient = document.getElementById(
    "bottom_bg_color_gradient"
  );
  const bottomsecArea = document.getElementById("contact-form-drag-drop-area");
  let gp = null;

  const bottomPredefinedGradientColor = document.querySelector(
    ".bottom-predefined-colors-gradients"
  );
  const bottomColorBoxes = document.querySelectorAll(
    ".bottom-gradient, .bottom-solid"
  );

  const okayIcon = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.2s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg>`;

  imageCategorySelect.addEventListener("change", changeCategory);

  function changeCategory() {
    const selectedCategory = imageCategorySelect.value;
    gradientColorInput.style.display =
      selectedCategory === "color-gradient" ? "block" : "none";
    abstractInput.style.display =
      selectedCategory === "abstract" ? "block" : "none";

    switch (selectedCategory) {
      case "select":
        originalModalBg();
        removeAbstract();
        removeIndustry();
        break;
      case "industry":
        originalModalBg();
        industry();
        removeAbstract();
        break;
      case "color-gradient":
        gradient();
        removeAbstract();
        removeIndustry();
        break;
      case "abstract":
        originalModalBg();
        removeIndustry();
        abstract();
        break;
    }
  }

  function originalModalBg() {
    imageGalleryModalContent.style.backgroundImage = originalBackground;
  }

  // Grapick - Color-Gradient
  function gradient() {
    if (!gp) {
      var copyTxt = document.querySelector(".txt-value");
      var gp = new Grapick({
        el: "#grapick",
        direction: "right",
        min: 1,
        max: 99,
      });
      gp.addHandler(1, "#085078", 1);
      gp.addHandler(99, "#85D8CE", 1, { keepSelect: 1 });
      gp.on("change", function (complete) {
        const value = gp.getValue();
        imageGalleryModalContent.style.backgroundImage = value;
        copyTxt.value = value;
        //   console.log("BG value", value, { complete });
      });
      gp.emit("change");

      var swType = document.getElementById("switch-type");
      var swAngle = document.getElementById("switch-angle");
      var grpSelectBtn = document.querySelector(".grp-select-btn");
      var bottomsecArea = document.getElementById(
        "contact-form-drag-drop-area"
      );
      swType.addEventListener("change", function (e) {
        gp.setType(this.value || "linear");
      });

      swAngle.addEventListener("change", function (e) {
        gp.setDirection(this.value || "right");
      });

      grpSelectBtn.addEventListener("click", function (e) {
        e.preventDefault();
        const originalSvg = grpSelectBtn.innerHTML;
        grpSelectBtn.innerHTML = okayIcon;
        bottomsecArea.style.background = copyTxt.value;
        bottomsecBgColorGradient.value = copyTxt.value;
        bottomSectionFile.value = "";
        bottomSectionAbstract.value = "";
        bottomSectionIndustry.value = "";
        console.log("Select button is clicked");
        setTimeout(function () {
          grpSelectBtn.innerHTML = originalSvg;
        }, 2000);
      });
    }
  }

  // Separate functionality for applying pre-defined gradients and solid colors
  function setBottomGradientColorBackground(style) {
    bottomsecArea.style.background = style;
    bottomsecBgColorGradient.value = style;
    bottomSectionFile.value = "";
    bottomSectionAbstract.value = "";
    bottomSectionIndustry.value = "";
  }

  bottomColorBoxes.forEach((box) => {
    box.addEventListener("click", function () {
      const backgroundStyle = this.style.background;
      setBottomGradientColorBackground(backgroundStyle);
    });
  });

  // Grid Gallery - Abstract
  function abstract() {
    loader.classList.remove("d-none");
    const ggBox = document.querySelector(".gg-box");
    const numImages = 40;

    for (let i = 1; i <= numImages; i++) {
      const { ggBoxImgCon, ggBoxImg, ggBoxImgBtn } = abstractElements();

      ggBoxImg.src = `${abstractFolderPath}abstract${i}.png`;
      urlImgExists(ggBoxImg.src)
        .then((exists) => {
          if (exists) {
            const smallImageUrl = ggBoxImg.src
              .replace("/compressed/", "/small/")
              .replace(/\.png$/, "-small.png");
            ggBoxImgCon.style.backgroundImage = `url('${smallImageUrl}')`;
            console.log("PNG image exists: ", smallImageUrl);
          } else {
            // If PNG doesn't exist, try JPG
            ggBoxImg.src = `${abstractFolderPath}abstract${i}.jpg`;
            const smallImageUrl = ggBoxImg.src
              .replace("/compressed/", "/small/")
              .replace(/\.jpg$/, "-small.jpg");
            ggBoxImgCon.style.backgroundImage = `url('${smallImageUrl}')`;
            console.log("JPG image exists: ", smallImageUrl);
          }
        })
        .catch((error) => {
          console.error("Error checking PNG image:", error);
        });

      ggBox.appendChild(ggBoxImgCon);
      loader.classList.add("d-none");
      const imgconForLoad = document.querySelectorAll(".gg-box-img-container");
      imageLoad(imgconForLoad);

      ggBoxImgBtn.addEventListener("click", function (e) {
        e.preventDefault();
        bottomsecArea.style.background = `url('${ggBoxImg.src}')`;
        bottomsecArea.style.backgroundSize = "cover";
        bottomSectionAbstract.value = ggBoxImg.src;
        bottomSectionFile.value = "";
        bottomsecBgColorGradient.value = "";
        bottomSectionIndustry.value = "";
        ggBoxImgBtn.innerHTML = "Selected";
        console.log("Select button is clicked");
        setTimeout(function () {
          ggBoxImgBtn.innerHTML = "Select";
        }, 2000);
      });
    }
  }

  function abstractElements() {
    const ggBoxImgCon = document.createElement("div");
    const ggBoxImg = document.createElement("img");
    const ggBoxImgBtnCon = document.createElement("div");
    const ggBoxImgBtn = document.createElement("button");

    ggBoxImgCon.classList.add("gg-box-img-container");
    ggBoxImg.setAttribute("loading", "lazy");
    ggBoxImgBtn.innerHTML = "Select";
    ggBoxImgBtn.classList.add("gg-box-select-btn");
    ggBoxImgBtnCon.classList.add("gg-box-img-button-container");

    ggBoxImgBtnCon.appendChild(ggBoxImgBtn);
    ggBoxImgCon.appendChild(ggBoxImg);
    ggBoxImgCon.appendChild(ggBoxImgBtnCon);

    return { ggBoxImgCon, ggBoxImg, ggBoxImgBtn };
  }

  // Grid Gallery - Industry
  async function industry() {
    loader.classList.remove("d-none");
    const industries = {
      agriculture: 4,
      chemical: 4,
      commerce: 3,
      construction: 3,
      education: 4,
      finance: 3,
      food: 3,
      technology: 4,
      medical: 4,
      technical: 3,
      tourism: 3,
    };

    const industryImages = {};

    for (const industry in industries) {
      if (industries.hasOwnProperty(industry)) {
        const count = industries[industry];
        const imageUrlPromises = Array.from({ length: count }, async (_, i) => {
          const num = i + 1;
          const path = `${url}img/contact-background/industry/${industry}/compressed`;
          const jpgUrl = `${path}/${industry}${num}.jpg`;
          const pngUrl = `${path}/${industry}${num}.png`;
          const exists = await urlImgExists(jpgUrl);
          return exists ? jpgUrl : pngUrl;
        });
        industryImages[industry] = await Promise.all(imageUrlPromises);
      }
    }

    const industryParentContainer = document.querySelector(
      ".gg-industry-container"
    );

    for (const industry in industryImages) {
      if (industryImages.hasOwnProperty(industry)) {
        const industryContainer = document.createElement("div");
        industryContainer.classList.add(
          "gg-box",
          `gg-box-${industry}`,
          "gg-box-industry-parent-img-container"
        );

        const hr = document.createElement("hr");
        hr.classList.add("bg-white");

        const title = document.createElement("h6");
        title.classList.add("text-start");
        const capitalizedFirstLetter =
          industry.charAt(0).toUpperCase() + industry.slice(1);
        title.textContent = capitalizedFirstLetter;

        const industryImagesArray = industryImages[industry];
        industryImagesArray.forEach((imageUrl) => {
          //   console.log("Image Url: ", imageUrl);
          const smallImageUrl = imageUrl.endsWith(".jpg")
            ? imageUrl
                .replace("/compressed/", "/small/")
                .replace(/\.jpg$/, "-small.jpg")
            : imageUrl
                .replace("/industry/", "/small/")
                .replace(/\.png$/, "-small.png");

          const imgContainer = document.createElement("div");
          imgContainer.classList.add(
            "gg-box-img-container",
            "gg-box-industry-img-container",
            "mb-4"
          );
          imgContainer.style.backgroundImage = `url('${smallImageUrl}')`;

          const img = document.createElement("img");
          img.src = imageUrl;
          img.setAttribute("loading", "lazy");

          const btnContainer = document.createElement("div");
          btnContainer.classList.add("gg-box-img-button-container");

          const selectBtn = document.createElement("button");
          selectBtn.classList.add(
            "gg-box-select-btn",
            "gg-box-industry-select-btn"
          );
          selectBtn.textContent = "Select";

          imgContainer.appendChild(img);
          imgContainer.appendChild(btnContainer);
          btnContainer.appendChild(selectBtn);

          selectBtn.addEventListener("click", function (e) {
            e.preventDefault();
            bottomsecArea.style.background = `url('${img.src}')`;
            bottomsecArea.style.backgroundSize = "cover";
            bottomSectionIndustry.value = img.src;
            bottomSectionFile.value = "";
            bottomsecBgColorGradient.value = "";
            bottomSectionAbstract.value = "";
            selectBtn.innerHTML = "Selected";
            console.log("Select button is clicked");
            setTimeout(function () {
              selectBtn.innerHTML = "Select";
            }, 2000);
          });

          industryContainer.appendChild(imgContainer);
        });

        industryParentContainer.appendChild(hr);
        industryParentContainer.appendChild(title);
        industryParentContainer.appendChild(industryContainer);
        loader.classList.add("d-none");
        const imgconForLoad = document.querySelectorAll(
          ".gg-box-industry-img-container"
        );

        imageLoad(imgconForLoad);
      }
    }
  }

  function removeAbstract() {
    const abstract = document.querySelector(".gg-box-abstract");
    if (abstract) {
      while (abstract.firstChild) {
        abstract.removeChild(abstract.firstChild);
      }
    }
  }

  function removeIndustry() {
    const industry = document.querySelector(".gg-industry-container");
    if (industry) {
      while (industry.firstChild) {
        industry.removeChild(industry.firstChild);
      }
    }
  }

  function urlImgExists(url) {
    return new Promise((resolve, reject) => {
      const image = new Image();
      image.onload = function () {
        resolve(true);
        // console.log("Image URL exists");
      };
      image.onerror = function () {
        resolve(false);
        // console.error("Image URL don't exists");
      };
      image.src = url;
    });
  }
});

// Mid Section Image Gallery:
document.addEventListener("DOMContentLoaded", function () {
  const originalBackground = `url('${url}img/landing-page-builder/svg-flip.png')`;
  const abstractFolderPath = `${url}img/contact-background/abstract/compressed/`;
  const imageCategorySelect = document.getElementById("midImageCategory");
  const gradientColorInput = document.getElementById("midGradientColorInput");

  const abstractInput = document.querySelector(".midAbstractInput");
  const loader = document.querySelector(".image-gallery-loader");
  const imageGalleryModalContent = document.getElementById(
    "midImageGalleryModalContent"
  );
  const midSectionFile = document.getElementById("midSecBackgroundFile");
  const midSectionAbstract = document.getElementById("mid_bg_abstract");
  const midSectionIndustry = document.getElementById("mid_bg_industry");
  const midSecBgColorGradient = document.getElementById(
    "mid_bg_color_gradient"
  );
  const midSecArea = document.getElementById("title-2-drag-drop-area");
  let gp = null;

  const midColorBoxes = document.querySelectorAll(".mid-gradient, .mid-solid");

  const okayIcon = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.2s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/></svg>`;

  imageCategorySelect.addEventListener("change", changeCategory);

  function changeCategory() {
    const selectedCategory = imageCategorySelect.value;
    gradientColorInput.style.display =
      selectedCategory === "color-gradient" ? "block" : "none";
    abstractInput.style.display =
      selectedCategory === "abstract" ? "block" : "none";

    switch (selectedCategory) {
      case "select":
        originalModalBg();
        removeAbstract();
        removeIndustry();
        break;
      case "industry":
        originalModalBg();
        industry();
        removeAbstract();
        break;
      case "color-gradient":
        gradient();
        removeAbstract();
        removeIndustry();
        break;
      case "abstract":
        originalModalBg();
        removeIndustry();
        abstract();
        break;
    }
  }

  function originalModalBg() {
    imageGalleryModalContent.style.backgroundImage = originalBackground;
  }

  // Grapick - Color-Gradient
  function gradient() {
    if (!gp) {
      var copyTxt = document.getElementById("mid-txt-value");
      var gp = new Grapick({
        el: ".mid-grapick",
        direction: "right",
        min: 1,
        max: 99,
      });
      gp.addHandler(1, "#085078", 1);
      gp.addHandler(99, "#85D8CE", 1, { keepSelect: 1 });
      gp.on("change", function (complete) {
        const value = gp.getValue();
        imageGalleryModalContent.style.backgroundImage = value;
        copyTxt.value = value;
        //   console.log("BG value", value, { complete });
      });
      gp.emit("change");

      var swType = document.getElementById("mid-switch-type");
      var swAngle = document.getElementById("mid-switch-angle");
      var grpSelectBtn = document.getElementById("mid-grp-select-btn");
      var midSecArea = document.getElementById("title-2-drag-drop-area");
      swType.addEventListener("change", function (e) {
        gp.setType(this.value || "linear");
      });

      swAngle.addEventListener("change", function (e) {
        gp.setDirection(this.value || "right");
      });

      grpSelectBtn.addEventListener("click", function (e) {
        e.preventDefault();
        const originalSvg = grpSelectBtn.innerHTML;
        grpSelectBtn.innerHTML = okayIcon;
        midSecArea.style.background = copyTxt.value;
        midSecBgColorGradient.value = copyTxt.value;
        midSectionFile.value = "";
        midSectionAbstract.value = "";
        midSectionIndustry.value = "";
        console.log("Select button is clicked");
        setTimeout(function () {
          grpSelectBtn.innerHTML = originalSvg;
        }, 2000);
      });
    }
  }

  // Separate functionality for applying pre-defined gradients and solid colors
  function setMidGradientColorBackground(style) {
    midSecArea.style.background = style;
    midSecBgColorGradient.value = style;
    midSectionFile.value = "";
    midSectionAbstract.value = "";
    midSectionIndustry.value = "";
  }

  midColorBoxes.forEach((box) => {
    box.addEventListener("click", function () {
      const backgroundStyle = this.style.background;
      setMidGradientColorBackground(backgroundStyle);
    });
  });

  // Grid Gallery - Abstract
  function abstract() {
    loader.classList.remove("d-none");
    const midAbstractInput = document.querySelector(".midAbstractInput");
    const ggBox = midAbstractInput.querySelector(".gg-box");
    const numImages = 40;

    for (let i = 1; i <= numImages; i++) {
      const { ggBoxImgCon, ggBoxImg, ggBoxImgBtn } = abstractElements();

      ggBoxImg.src = `${abstractFolderPath}abstract${i}.png`;
      urlImgExists(ggBoxImg.src)
        .then((exists) => {
          if (exists) {
            const smallImageUrl = ggBoxImg.src
              .replace("/compressed/", "/small/")
              .replace(/\.png$/, "-small.png");
            ggBoxImgCon.style.backgroundImage = `url('${smallImageUrl}')`;
            console.log("PNG image exists: ", smallImageUrl);
          } else {
            // If PNG doesn't exist, try JPG
            ggBoxImg.src = `${abstractFolderPath}abstract${i}.jpg`;
            const smallImageUrl = ggBoxImg.src
              .replace("/compressed/", "/small/")
              .replace(/\.jpg$/, "-small.jpg");
            ggBoxImgCon.style.backgroundImage = `url('${smallImageUrl}')`;
            console.log("JPG image exists: ", smallImageUrl);
          }
        })
        .catch((error) => {
          console.error("Error checking PNG image:", error);
        });

      ggBox.appendChild(ggBoxImgCon);
      loader.classList.add("d-none");
      const imgconForLoad = document.querySelectorAll(".gg-box-img-container");
      imageLoad(imgconForLoad);

      ggBoxImgBtn.addEventListener("click", function (e) {
        e.preventDefault();
        midSecArea.style.background = `url('${ggBoxImg.src}')`;
        midSecArea.style.backgroundSize = "cover";
        midSectionAbstract.value = ggBoxImg.src;
        midSectionFile.value = "";
        midSecBgColorGradient.value = "";
        midSectionIndustry.value = "";
        ggBoxImgBtn.innerHTML = "Selected";
        console.log("Select button is clicked");
        setTimeout(function () {
          ggBoxImgBtn.innerHTML = "Select";
        }, 2000);
      });
    }
  }

  function abstractElements() {
    const ggBoxImgCon = document.createElement("div");
    const ggBoxImg = document.createElement("img");
    const ggBoxImgBtnCon = document.createElement("div");
    const ggBoxImgBtn = document.createElement("button");

    ggBoxImgCon.classList.add("gg-box-img-container");
    ggBoxImg.setAttribute("loading", "lazy");
    ggBoxImgBtn.innerHTML = "Select";
    ggBoxImgBtn.classList.add("gg-box-select-btn");
    ggBoxImgBtnCon.classList.add("gg-box-img-button-container");

    ggBoxImgBtnCon.appendChild(ggBoxImgBtn);
    ggBoxImgCon.appendChild(ggBoxImg);
    ggBoxImgCon.appendChild(ggBoxImgBtnCon);

    return { ggBoxImgCon, ggBoxImg, ggBoxImgBtn };
  }

  // Grid Gallery - Industry
  async function industry() {
    loader.classList.remove("d-none");
    const industries = {
      agriculture: 4,
      chemical: 4,
      commerce: 3,
      construction: 3,
      education: 4,
      finance: 3,
      food: 3,
      technology: 4,
      medical: 4,
      technical: 3,
      tourism: 3,
    };

    const industryImages = {};

    for (const industry in industries) {
      if (industries.hasOwnProperty(industry)) {
        const count = industries[industry];
        const imageUrlPromises = Array.from({ length: count }, async (_, i) => {
          const num = i + 1;
          const path = `${url}img/contact-background/industry/${industry}/compressed`;
          const jpgUrl = `${path}/${industry}${num}.jpg`;
          const pngUrl = `${path}/${industry}${num}.png`;
          const exists = await urlImgExists(jpgUrl);
          return exists ? jpgUrl : pngUrl;
        });
        industryImages[industry] = await Promise.all(imageUrlPromises);
      }
    }

    const midIndustryInput = document.querySelector(".midIndustryInput");
    const industryParentContainer = midIndustryInput.querySelector(
      ".gg-industry-container"
    );

    for (const industry in industryImages) {
      if (industryImages.hasOwnProperty(industry)) {
        const industryContainer = document.createElement("div");
        industryContainer.classList.add(
          "gg-box",
          `gg-box-${industry}`,
          "gg-box-industry-parent-img-container"
        );

        const hr = document.createElement("hr");
        hr.classList.add("bg-white");

        const title = document.createElement("h6");
        title.classList.add("text-start");
        const capitalizedFirstLetter =
          industry.charAt(0).toUpperCase() + industry.slice(1);
        title.textContent = capitalizedFirstLetter;

        const industryImagesArray = industryImages[industry];
        industryImagesArray.forEach((imageUrl) => {
          //   console.log("Image Url: ", imageUrl);
          const smallImageUrl = imageUrl.endsWith(".jpg")
            ? imageUrl
                .replace("/compressed/", "/small/")
                .replace(/\.jpg$/, "-small.jpg")
            : imageUrl
                .replace("/industry/", "/small/")
                .replace(/\.png$/, "-small.png");

          const imgContainer = document.createElement("div");
          imgContainer.classList.add(
            "gg-box-img-container",
            "gg-box-industry-img-container",
            "mb-4"
          );
          imgContainer.style.backgroundImage = `url('${smallImageUrl}')`;

          const img = document.createElement("img");
          img.src = imageUrl;
          img.setAttribute("loading", "lazy");

          const btnContainer = document.createElement("div");
          btnContainer.classList.add("gg-box-img-button-container");

          const selectBtn = document.createElement("button");
          selectBtn.classList.add(
            "gg-box-select-btn",
            "gg-box-industry-select-btn"
          );
          selectBtn.textContent = "Select";

          imgContainer.appendChild(img);
          imgContainer.appendChild(btnContainer);
          btnContainer.appendChild(selectBtn);

          selectBtn.addEventListener("click", function (e) {
            e.preventDefault();
            midSecArea.style.background = `url('${img.src}')`;
            midSecArea.style.backgroundSize = "cover";
            midSectionIndustry.value = img.src;
            midSectionFile.value = "";
            midSecBgColorGradient.value = "";
            midSectionAbstract.value = "";
            selectBtn.innerHTML = "Selected";
            console.log("Select button is clicked");
            setTimeout(function () {
              selectBtn.innerHTML = "Select";
            }, 2000);
          });

          industryContainer.appendChild(imgContainer);
        });

        industryParentContainer.appendChild(hr);
        industryParentContainer.appendChild(title);
        industryParentContainer.appendChild(industryContainer);
        loader.classList.add("d-none");
        const imgconForLoad = document.querySelectorAll(
          ".gg-box-industry-img-container"
        );

        imageLoad(imgconForLoad);
      }
    }
  }

  function removeAbstract() {
    const midAbstractInput = document.querySelector(".midAbstractInput");
    const abstract = midAbstractInput.querySelector(".gg-box-abstract");
    if (abstract) {
      while (abstract.firstChild) {
        abstract.removeChild(abstract.firstChild);
      }
    }
  }

  function removeIndustry() {
    const midIndustryInput = document.querySelector(".midIndustryInput");
    const industry = midIndustryInput.querySelector(".gg-industry-container");
    if (industry) {
      while (industry.firstChild) {
        industry.removeChild(industry.firstChild);
      }
    }
  }

  function urlImgExists(url) {
    return new Promise((resolve, reject) => {
      const image = new Image();
      image.onload = function () {
        resolve(true);
        // console.log("Image URL exists");
      };
      image.onerror = function () {
        resolve(false);
        // console.error("Image URL don't exists");
      };
      image.src = url;
    });
  }
});

function imageLoad(imgcon) {
  const imageContainer = imgcon;
  imageContainer.forEach((container) => {
    const img = container.querySelector("img");
    function loaded() {
      container.classList.add("loaded");
    }

    if (img.complete) {
      console.log("image compete");
      loaded();
    } else {
      img.addEventListener("load", loaded);
    }
  });
}
