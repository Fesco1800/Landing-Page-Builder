const submitIcon = document.querySelector("#submit-icon");
const inputElement = document.querySelector("#search-bar");
const outputImages = document.querySelectorAll(".output-image");
const downloadButtons = document.querySelectorAll(".output-download-button");

submitIcon.style.display = "block";

const getImages = async () => {
  const aiImgCardBody = document.querySelector(".ai-image-card-body");
  const imageCard = document.querySelector(".image-card");
  imageCard.style.opacity = "0.5";
  const loader1Container = document.createElement("div");
  loader1Container.classList.add("loader-1-container");
  const loading1Spinner = document.createElement("span");
  loading1Spinner.classList.add("loader");

  function showLoader() {
    aiImgCardBody.insertBefore(loader1Container, aiImgCardBody.firstChild);
    loader1Container.appendChild(loading1Spinner);
  }

  function removeLoader() {
    if (aiImgCardBody.contains(loader1Container)) {
      aiImgCardBody.removeChild(loader1Container);
      imageCard.style.opacity = "1";
    }
  }

  showLoader();

  const options = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      prompt: inputElement.value,
      n: 3,
      size: "1024x1024",
    }),
  };

  try {
    const response = await fetch(url + "landing-page-builder/dallE", options);
    const data = await response.json();

    if (response.ok) {
      let imagesLoaded = 0;

      data.data.forEach((imageData, index) => {
        if (imageData) {
          const imageUrl = imageData.url;
          const extension = imageUrl.split("?")[0].split(".").pop();
          const fileName = `output${index + 1}.${extension}`;
          outputImages[index].src = imageUrl;

          const images = outputImages[index];
          images.onload = function () {
            imagesLoaded++;
            if (imagesLoaded === data.data.length) {
              removeLoader();
            }
          };

          const downloadLinks = document.querySelectorAll(
            ".output-download-button"
          );
          const currentDownloadLink = downloadLinks[index];

          currentDownloadLink.addEventListener("click", async () => {
            showLoader();
            try {
              const downloadResponse = await fetch(
                url + "landing-page-builder/downloadDallEImage",
                {
                  method: "POST",
                  headers: {
                    "Content-Type": "application/json",
                  },
                  body: JSON.stringify({ imageUrl, fileName }),
                }
              );

              if (!downloadResponse.ok)
                throw new Error("Error downloading image");

              const blob = await downloadResponse.blob();
              const iurl = URL.createObjectURL(blob);

              const tempLink = document.createElement("a");
              tempLink.href = iurl;
              tempLink.download = fileName;
              document.body.appendChild(tempLink);
              tempLink.click();
              document.body.removeChild(tempLink);
              URL.revokeObjectURL(iurl);
              console.log(`Downloaded: ${fileName}`);
            } catch (error) {
              console.error("Error downloading the image:", error);
            } finally {
              removeLoader();
            }
          });
        }
      });
    } else {
      console.error(data.error);
      alert("Failed to fetch images. Please try again later.");
    }
  } catch (error) {
    console.error(error);
    alert("Taking too long? Refresh your browser!");
  }
};

submitIcon.addEventListener("click", getImages);
