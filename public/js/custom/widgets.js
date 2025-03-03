let ckEditorContent = "";

function productHighlights() {
  try {
    let textContent = document.createElement("div");
    textContent.id = "text-content";
    textContent.textContent =
      "Click the 'Edit' button placed above this section to edit this text.";

    let dropArea = document.getElementById("title-2-drag-drop-area");
    dropArea.innerHTML = "";
    dropArea.appendChild(textContent);
    dropArea.classList.add("editable-content");
  } catch {
    console.error("Error handling the drop.");
  }
  console.log("Dropped Product Highlights");
}

// Mid Section Edit Button
document.getElementById("edit-button").addEventListener("click", function () {
  let dropArea = document.getElementById("title-2-drag-drop-area");
  let dropAreaContent = dropArea.innerHTML;
  let dropAreaTextContent =
    "Click the 'Edit' button placed above this section to edit this text.";

  if (dropArea.children.length > 0) {
    let warningText = document.getElementById("warning-text");
    let saveButton = document.getElementById("save-changes-button");
    saveButton.style.display = "block";
    if (warningText) {
      warningText.style.display = "none";
    }
    let existingEditor = window.ckeditorInstance;

    if (existingEditor) {
      existingEditor
        .destroy()
        .then(() => {
          console.log("CKEditor instance destroyed");
          createCKEditor("ckeditor-modal-body", dropAreaContent);
        })
        .catch((error) => {
          console.error("Error destroying CKEditor instance:", error);
        });
    } else {
      createCKEditor("ckeditor-modal-body", dropAreaContent);
    }
  } else {
    let modalBody = document.getElementById("ckeditor-modal-body");
    let saveButton = document.getElementById("save-changes-button");
    modalBody.innerHTML =
      "<div class='alert alert-warning text-center' id='warning-text' role='alert'>Please add 'Product Highlights' widget here.</div>";
    saveButton.style.display = "none";
  }
});

function createCKEditor(containerId, initialContent) {
  let editorContainer = document.createElement("div");
  editorContainer.id = "ckeditor-modal-editor";
  document.getElementById(containerId).appendChild(editorContainer);

  ClassicEditor.create(editorContainer, {
    toolbar: {
      removeItems: [
        "strikethrough",
        "subscript",
        "superscript",
        "specialCharacters",
        "removeFormat",
      ],
    },

    image: {
      toolbar: [
        "toggleImageCaption",
        "imageTextAlternative",
        "imageStyle:inline",
        "imageStyle:block",
        "imageResize",
        "imageStyle:alignLeft",
        "imageStyle:alignCenter",
        "imageStyle:alignRight",
      ],
      styles: ["full", "alignLeft", "alignCenter", "alignRight"],
    },
    simpleUpload: {
      uploadUrl: url + "ck-image-upload/uploadImage",
      withCredentials: true,
      headers: {
        "X-CSRF-TOKEN": "CSRF-Token",
        Authorization: "Bearer <JSON Web Token>",
      },
    },
    removePlugins: ["MediaEmbedToolbar"],
  })
    .then((editor) => {
      editor.setData("");
      editor.setData(initialContent);
      window.ckeditorInstance = editor;

      // Adding custom upload listeners for debugging
      editor.plugins.get("FileRepository").createUploadAdapter = (loader) => {
        return new MyUploadAdapter(loader);
      };
    })
    .catch((error) => {
      console.error("CKEditor initialization failed:", error);
    });
}

class MyUploadAdapter {
  constructor(loader) {
    this.loader = loader;
    this.chunkSize = 64 * 1024; // 64kb
    this.uploadUrl = url + "ck-image-upload/uploadImage"; // Use the same endpoint for all uploads
    this.currentChunk = 0;
    this.totalChunks = 0;
    this.file = null;
  }

  upload() {
    return this.loader.file.then((file) => {
      this.file = file;
      this.totalChunks = Math.ceil(file.size / this.chunkSize);
      return new Promise((resolve, reject) => {
        this.uploadNextChunk(resolve, reject);
      });
    });
  }

  uploadNextChunk(resolve, reject) {
    const start = this.currentChunk * this.chunkSize;
    const end = Math.min(start + this.chunkSize, this.file.size);
    const chunk = this.file.slice(start, end);

    const formData = new FormData();
    formData.append("upload", chunk);
    formData.append("fileName", this.file.name);
    formData.append("chunkIndex", this.currentChunk);
    formData.append("totalChunks", this.totalChunks);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", this.uploadUrl, true);
    xhr.responseType = "json";

    xhr.addEventListener("load", () => {
        if (xhr.status === 200) {
            // Handle intermediate and final responses separately
            if (this.currentChunk < this.totalChunks - 1) {
                console.log(xhr.response.message); // Log intermediate chunk success messages
                this.currentChunk++;
                this.uploadNextChunk(resolve, reject);
            } else if (xhr.response.url) {
                // Final chunk response with URL
                console.log("Upload complete:", xhr.response.message);
                resolve({ default: xhr.response.url });
            } else {
                reject("Final upload response is invalid.");
            }
        } else {
            reject(xhr.response.error || "Upload failed.");
        }
    });

    xhr.addEventListener("error", () => {
        reject("Chunk upload failed.");
    });

    xhr.addEventListener("abort", () => {
        reject("Upload aborted.");
    });

    xhr.send(formData);
}
  abort() {
    console.warn("Upload aborted.");
  }
}

function processOEmbedElements() {
  let dropArea = document.getElementById("title-2-drag-drop-area");
  let oembedElements = dropArea.querySelectorAll("oembed");

  oembedElements.forEach(function (oembedElement) {
    let url = oembedElement.getAttribute("url");

    if (isYouTubeUrl(url)) {
      fetchAndEmbedVideo(url, oembedElement, "youtube");
    } else if (isVimeoUrl(url)) {
      fetchAndEmbedVideo(url, oembedElement, "vimeo");
    } else {
      console.error("Unsupported video provider for URL:", url);
    }
  });
}

function isYouTubeUrl(url) {
  return url.includes("youtube.com") || url.includes("youtu.be");
}

function isVimeoUrl(url) {
  return url.includes("vimeo.com");
}

function fetchAndEmbedVideo(url, oembedElement, provider) {
  let oEmbedEndpoint;

  switch (provider) {
    case "youtube":
      oEmbedEndpoint =
        "https://www.youtube.com/oembed?url=" +
        encodeURIComponent(url) +
        "&format=json";
      break;
    case "vimeo":
      oEmbedEndpoint =
        "https://vimeo.com/api/oembed.json?url=" + encodeURIComponent(url);
      break;
    default:
      throw new Error("Unsupported video provider: " + provider);
  }

  fetch(oEmbedEndpoint)
    .then(function (response) {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then(function (oEmbedData) {
      if (oEmbedData && oEmbedData.html) {
        let container = document.createElement("div");
        container.style.textAlign = "center";
        container.style.width = "600px";
        container.style.height = "300px";
        container.innerHTML = oEmbedData.html;

        let videoElement = container.querySelector("iframe");
        if (videoElement) {
          videoElement.style.width = "100%";
          videoElement.style.height = "100%";
        }

        oembedElement.parentNode.replaceChild(container, oembedElement);
      }
    })
    .catch(function (error) {
      console.error("Error fetching oEmbed data:", error);
    });
}

// Save Changes
document
  .getElementById("save-changes-button")
  .addEventListener("click", function () {
    let editor = window.ckeditorInstance;
    let updatedContent = editor.getData();

    ckEditorContent = updatedContent;

    let dropArea = document.getElementById("title-2-drag-drop-area");
    dropArea.innerHTML = updatedContent;
    processOEmbedElements();

    let textContentDiv = document.getElementById("text-content");
    if (textContentDiv) {
      textContentDiv.parentNode.removeChild(textContentDiv);
    }
  });

function promoOffer() {
  console.log("Dropped Promo Offer");
}
