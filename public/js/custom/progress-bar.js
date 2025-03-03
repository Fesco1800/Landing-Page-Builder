function progressBar (i, pb, pt, f, c) {
  const fInput = i;
  const pBar = pb
  const pText = pt
  const fName = f
  const cBtn = c

  const bottomsec = document.getElementById("contact-form-drag-drop-area");
  const midsec = document.getElementById("title-2-drag-drop-area");

  fInput.addEventListener('change', (event) => {
      const file = event.target.files[0];
      if (file && file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onloadstart = () => {
              pBar.style.width = '0%';
              pText.style.display = 'block';
              pText.innerText = '0%';
              cBtn.style.display = 'none';
          };
          reader.onprogress = (event) => {
              if (event.lengthComputable) {
                  const progress = 
                      (event.loaded / event.total) * 100;
                  pBar.style.width = `${progress}%`;
                  pText.innerText = `${Math.round(progress)}%`;
              }
          };

          reader.onload = () => {
            if (fInput === document.getElementById("bottomsecBackgroundFile")) {
              const bottomSectionAbstract = document.getElementById("bottom_bg_abstract");
              const bottomSectionIndustry = document.getElementById("bottom_bg_industry");
              const bottomsecBgColorGradient = document.getElementById(
                "bottom_bg_color_gradient"
              );
              bottomsec.style.backgroundImage = `url('${reader.result}')`;
              bottomsec.style.backgroundSize = "cover";
              bottomsec.style.backgroundPosition = "center";
              bottomsec.style.backgroundRepeat = "no-repeat";
      
              bottomSectionAbstract.value = "";
              bottomSectionIndustry.value = "";
              bottomsecBgColorGradient.value = "";
            }

            if (fInput === document.getElementById("midSecBackgroundFile")) {
              midsec.style.backgroundImage = `url('${reader.result}')`;
              midsec.style.backgroundSize = "cover";
              midsec.style.backgroundPosition = "center";
              midsec.style.backgroundRepeat = "no-repeat";
            }
            const uploadTime = 4000;
            const interval = 50;
            const steps = uploadTime / interval;
            let currentStep = 0;
            const updateProgress = () => {
                const progress = (currentStep / steps) * 100;
                pBar.style.width = `${progress}%`;
                pText.innerText = `${Math.round(progress)}%`;
                currentStep++;

                if (currentStep <= steps) {
                    setTimeout(updateProgress, interval);
                } else {
                    pBar.style.width = '100%';
                    pText.innerText = '100%';
                    // fName.innerText = `File Name: ${file.name}`;
                    fName.innerText = "successfully uploaded!";
                    cBtn.style.display = 'block';
                }
            };
            setTimeout(updateProgress, interval);
          };
          reader.readAsDataURL(file);
      } else {
          alert('Please select a valid image file.');
          fInput.value = '';
      }
  });
  cBtn.addEventListener('click', (e) => {
      e.preventDefault();
      fInput.value = '';
      pBar.style.width = '0%';
      pText.style.display = 'none';
      fName.innerText = '';
      cBtn.style.display = 'none';

      if (fInput === document.getElementById("logoFile")) {
        lp.src = url + "img/landing-page-builder/photo.jpg";
      } else if (fInput === document.getElementById("bannerFile")) {
        hp.style.backgroundImage = `url('${url}img/landing-page-builder/default-bg.webp')`;
      } else if (fInput === document.getElementById("midSecBackgroundFile")) {
        midsec.style.background = "none";
      } else {
        bottomsec.style.background = "none";
      }
  });
}

//logo
progressBar(
  document.getElementById("logoFile"),
  document.getElementById("logoProgressBar"),
  document.getElementById("logoProgressText"),
  document.getElementById("logoFileName"),
  document.getElementById("logoClearButton")
);

//banner
progressBar(
  document.getElementById("bannerFile"),
  document.getElementById("bannerProgressBar"),
  document.getElementById("bannerProgressText"),
  document.getElementById("bannerFileName"),
  document.getElementById("bannerClearButton")
);

// mid section background
progressBar(
  document.getElementById("midSecBackgroundFile"),
  document.getElementById("midSecProgressBar"),
  document.getElementById("midSecProgressText"),
  document.getElementById("midSecFileName"),
  document.getElementById("midSecClearButton")
);

//bottom section background
progressBar(
  document.getElementById("bottomsecBackgroundFile"),
  document.getElementById("bottomsecProgressBar"),
  document.getElementById("bottomsecProgressText"),
  document.getElementById("bottomsecFileName"),
  document.getElementById("bottomsecClearButton")
);