function updateClipboardIcon(target) {
  target.classList.remove("bi-clipboard");
  target.classList.add("bi-clipboard-check");

  setTimeout(function () {
    target.classList.remove("bi-clipboard-check");
    target.classList.add("bi-clipboard");
  }, 2000);
}

function copyToClipboard(text) {
  navigator.clipboard
    .writeText(text)
    .then(() => {
      console.log("Link copied to clipboard: " + text);
    })
    .catch((error) => {
      console.error("Unable to copy to clipboard", error);
    });
}
