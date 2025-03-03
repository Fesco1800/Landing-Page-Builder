/**
 * Define actions to manage tip section
 */
(function () {
  "use strict";

  function tipPanel() {
    const defaultTips = [
      "Tip: use arrows to move a selected object by 1 pixel!",
      "Tip: Shift + Click to select and modify multiple objects!",
      "Tip: hold Shift when rotating an object for 15° angle jumps!",
      "Tip: hold Shift when drawing a line for 15° angle jumps!",
      "Tip: Ctrl +/-, Ctrl + wheel to zoom in and zoom out!",
    ];
    const _self = this;
    $(`${this.containerSelector} .canvas-holder .content`).append(`
    <div id="tip-container">
    <a href="https://www.flaticon.com/free-icons/idea" title="idea icons"
       style=" outline: none !important;color:none important; text-decoration: none !important;">
    <img src="./icons/idea.png" style="width: 50px; height: 50px;"></img>
    </a>
    ${defaultTips[parseInt(Math.random() * defaultTips.length)]}
    </div>`);
    this.hideTip = function () {
      $(
        `${_self.containerSelector} .canvas-holder .content #tip-container`
      ).hide();
    };

    this.showTip = function () {
      $(
        `${_self.containerSelector} .canvas-holder .content #tip-container`
      ).show();
    };

    this.updateTip = function (str) {
      if (typeof str === "string") {
        const iconHTML = `
      <a href="https://www.flaticon.com/free-icons/idea" title="idea icons"
         style=" outline: none !important;color:none important; text-decoration: none !important;">
        <img src="./icons/idea.png" style="width: 50px; height: 50px;">
      </a>
    `;

        const tipContainer = document.querySelector(
          `${_self.containerSelector} .canvas-holder .content #tip-container`
        );

        // Update the tip message while keeping the icon
        tipContainer.innerHTML = iconHTML + " " + str;
      }
    };
  }

  window.ImageEditor.prototype.initializeTipSection = tipPanel;
})();
