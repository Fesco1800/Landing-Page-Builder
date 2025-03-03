// BEGIN: general functions
async function post(url = "", data = null) {
  const response = await fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: data,
    // mode: "cors", // no-cors, *cors, same-origin
    // cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
    // credentials: "same-origin", // include, *same-origin, omit
    // redirect: "follow", // manual, *follow, error
    // referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
  });
  return response;
}

function isset(data) {
  return typeof data != "undefined";
}

function toCurrency(val) {
  val = parseFloat(val).toFixed(2);
  return val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}

function ucwords(str) {
  return str.toLowerCase().replace(/\b[a-z]/g, function (letter) {
    return letter.toUpperCase();
  });
}

function b64Encode(str) {
  return btoa(
    encodeURIComponent(str).replace(
      /%([0-9A-F]{2})/g,
      function toSolidBytes(match, p1) {
        return String.fromCharCode("0x" + p1);
      }
    )
  );
}

function b64Decode(str) {
  return decodeURIComponent(
    atob(str)
      .split("")
      .map(function (c) {
        return "%" + ("00" + c.charCodeAt(0).toString(16)).slice(-2);
      })
      .join("")
  );
}
// END: general functions

// BEGIN: component functions
document
  .querySelectorAll("#sidebarToggleClose, #sidebarToggleOpen")
  .forEach(function (elem) {
    elem.addEventListener("click", () =>
      document.querySelector("#sidebar").classList.toggle("toggled")
    );
  });

function overlay(act, parent = "body") {
  parent = document.querySelector(parent);
  if (act) {
    // check if overlay is already present, exit
    if (parent.querySelector(":scope > .rms-overlay")) return;

    parent.insertAdjacentHTML(
      "beforeend",
      `<div class="rms-overlay d-flex align-items-center justify-content-center">
			<div class="spinner-border text-primary" role="status">
				<span class="visually-hidden">Loading...</span>
			</div>
		</div>`
    );
  } else {
    const overlays = parent.querySelectorAll(":scope > .rms-overlay");
    if (overlays.length) {
      overlays.forEach(function (elem) {
        elem.remove();
      });
    }
  }
}

function toast(message, type = "light", params = {}) {
  let hideDelay = params.hide_delay ? params.hide_delay : 3000;
  let autoHide = isset(params.auto_hide) ? params.auto_hide : true;
  let header = params.header ? params.header : null;

  const toastCont = document.querySelector("#toast");
  let icon = "bi-info-circle";
  let defaultHeader = "Info";

  if (type === "primary") {
    icon = "bi-info-circle";
  } else if (type === "info") {
    icon = "bi-info-circle";
  } else if (type === "success") {
    icon = "bi-check-circle";
    defaultHeader = "Success";
  } else if (type === "warning") {
    icon = "bi-exclamation-circle";
    defaultHeader = "Warning";
  } else if (type === "danger") {
    icon = "bi-exclamation-triangle";
    defaultHeader = "Error";
  }

  if (!header) header = defaultHeader;

  toastCont.insertAdjacentHTML(
    "beforeend",
    `<div class="toast ms-auto mb-2 cur" role="alert"
		data-bs-autohide="${String(autoHide)}"
		${autoHide ? `data-bs-delay="${hideDelay}"` : ""}>
		<div class="toast-header text-bg-${type}">
			<span class="me-auto"><i class="bi ${icon} me-1"></i><span class="toast-header-text">${header}</span></span>
			<button type="button" class="btn-close ${
        ["primary", "success", "danger", "dark"].includes(type)
          ? "btn-close-white"
          : ""
      }" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
		<div class="toast-body">${message}</div>
	</div>`
  );

  const curToast = toastCont.querySelector(":scope > .cur");
  curToast.classList.remove("cur");

  // auto remove toast on close
  curToast.addEventListener("hidden.bs.toast", (e) => {
    e.target.remove();
  });

  const toastInstance = new bootstrap.Toast(curToast);
  toastInstance.show();
}

function confirmation(
  elem,
  content = "",
  confirmFn = null,
  btnCancelHtm = null,
  btnConfirmHtm = null
) {
  if (btnCancelHtm === null)
    btnCancelHtm =
      '<a class="btn btn-secondary cancel" role="button">Cancel</a> ';
  if (btnConfirmHtm === null)
    btnConfirmHtm =
      '<a class="btn btn-primary confirm" role="button">Confirm</a> ';

  new bootstrap.Popover(elem, {
    html: true,
    trigger: "click",
    container: "#main",
    customClass: "rm-confirmation",
    content: content + btnCancelHtm + btnConfirmHtm,
  });

  elem.addEventListener("shown.bs.popover", () => {
    const popover = bootstrap.Popover.getInstance(elem);

    // cancel event
    const btnCancel = popover.tip.querySelector(":scope .cancel");
    if (btnCancel) {
      btnCancel.addEventListener("click", () => {
        popover.hide();
      });
    }

    // submit event
    if (confirmFn !== null) {
      popover.tip
        .querySelector(":scope .confirm")
        .addEventListener("click", () => {
          popover.hide();
          confirmFn();
        });
    }
  });
}

function rmTag(text, type = "info") {
  return `<span class="px-2 bg-${type}-subtle border border-${type}-subtle rounded-2">${text}</span>`;
}
// END: component functions

// BEGIN: general events
(() => {
  const userInfoElem = document.querySelector("#userInfo");
  if (userInfoElem) {
    userInfoElem.addEventListener("click", function () {
      $(this).dropdown("toggle");
    });
  }
})();

document.addEventListener("click", function (e) {
  // popover confirmation auto close when clicked outside
  const isConfirmation = e.target.closest(".popover.rm-confirmation");
  if (!isConfirmation) {
    const shownPopovers = document
      .querySelector("#main")
      .querySelectorAll(":scope .popover.rm-confirmation");
    if (shownPopovers.length) {
      let triggerEl;
      shownPopovers.forEach(function (el) {
        triggerEl = document.querySelector(
          `[data-bs-toggle="popover"][aria-describedby="${el.id}"]`
        );
        if (triggerEl) {
          bootstrap.Popover.getInstance(triggerEl).hide();
        }
      });
    }
  }
});
// END: general events
