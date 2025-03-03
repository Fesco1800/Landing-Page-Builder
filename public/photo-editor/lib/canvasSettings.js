/**
 * initialize canvas setting panel
 */
(function () {
  "use strict";
  var canvasSettings = function () {
    const _self = this;

    $(document).ready(function () {
      setDimension();
    });

    $(`${this.containerSelector} .main-panel`).append(
      `<div class="toolpanel" id="background-panel"><div class="content"><p class="title">Canvas Settings</p></div></div>`
    );

    // set dimension section
    // Function to set the canvas size based on user selection
    function setDimension() {
      const selectedDimension = $("#input-dimensions").val();

      // Define the allowed dimensions
      const allowedDimensions = [
        { width: 1280, height: 720 },
        { width: 1920, height: 1080 },
        { width: 2560, height: 1440 },
        { width: 3840, height: 2160 },
      ];

      // Parse the selected dimension
      const [width, height] = selectedDimension.split("x").map(Number);

      // Set the canvas size to the selected dimension
      _self.canvas.setWidth(width);
      _self.canvas.originalW = width;
      _self.canvas.setHeight(height);
      _self.canvas.originalH = height;
      _self.canvas.renderAll();
      _self.canvas.trigger("object:modified");

      // Added code to save the dimensions
      saveInBrowser.save("canvasWidth", width);
      saveInBrowser.save("canvasHeight", height);
    }

    // Append the HTML structure for Dimension section
    $(`${this.containerSelector} .toolpanel#background-panel .content`).append(`
        <div class="canvas-size-setting">
            <p>Canvas Size</p>
            <div class="input-container">
            <label>Dimensions</label>
            <select class="form-select form-select-sm" aria-label=".form-select-sm" id="input-dimensions">
                <option value="720x360" selected="selected">720x360 (Default)</option>
                <option value="1280x720">1280x720 (HD)</option>
                <option value="1920x1080">1920x1080 (Full HD)</option>
                <option value="2560x1440">2560x1440 (2k)</option>
                <option value="3840x2160">3840x2160 (4k)</option>
            </select>
            </div>
        </div>
        `);

    // Attach the change event listener to the select element
    $(
      `${this.containerSelector} .toolpanel#background-panel .content #input-dimensions`
    ).on("change", setDimension);

    // end set dimension section

    // background color
    (() => {
      $(`${this.containerSelector} .toolpanel#background-panel .content`)
        .append(`
      <div class="color-settings">
        <div class="tab-container">
          <div class="tabs">
            <div class="tab-label" data-value="color-fill" style="margin-right: 5px;">Color</div>
            <div class="tab-label" data-value="gradient-fill">Gradient</div>
          </div>
          <div class="tab-content" data-value="color-fill">
            <input id="color-picker" value='black'/><br>
          </div>
          <div class="tab-content" data-value="gradient-fill">
            <div id="gradient-picker"></div>

            <div class="gradient-orientation-container">
              <div class="input-container">
                <label>Orientation</label>
                <select id="select-orientation">
                  <option value="linear">Linear</option>
                  <option value="radial">Radial</option>
                </select>
              </div>
              <div id="angle-input-container" class="input-container">
                <label>Angle</label>
                <div class="custom-number-input">
                  <button class="decrease">-</button>
                  <input type="number" min="0" max="360" value="0" id="input-angle">
                  <button class="increase">+</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    `);

      $(
        `${this.containerSelector} .toolpanel#background-panel .content .tab-label`
      ).click(function () {
        $(
          `${_self.containerSelector} .toolpanel#background-panel .content .tab-label`
        ).removeClass("active");
        $(this).addClass("active");
        let target = $(this).data("value");
        $(this).closest(".tab-container").find(".tab-content").hide();
        $(this)
          .closest(".tab-container")
          .find(`.tab-content[data-value=${target}]`)
          .show();

        if (target === "color-fill") {
          let color = $(
            `${_self.containerSelector} .toolpanel#background-panel .content #color-picker`
          ).val();
          try {
            _self.canvas.backgroundColor = color;
            _self.canvas.renderAll();
          } catch (_) {
            console.log("can't update background color");
          }
        } else {
          updateGradientFill();
        }
      });

      $(
        `${this.containerSelector} .toolpanel#background-panel .content .tab-label[data-value=color-fill]`
      ).click();

      $(
        `${this.containerSelector} .toolpanel#background-panel .content #color-picker`
      ).spectrum({
        flat: true,
        showPalette: false,
        showButtons: false,
        type: "color",
        showInput: "true",
        allowEmpty: "false",
        move: function (color) {
          let hex = "transparent";
          color && (hex = color.toRgbString()); // #ff0000
          _self.canvas.backgroundColor = hex;
          _self.canvas.renderAll();
        },
      });

      const gp = new Grapick({
        el: `${this.containerSelector} .toolpanel#background-panel .content #gradient-picker`,
        colorEl: '<input id="colorpicker"/>', // I'll use this for the custom color picker
      });

      gp.setColorPicker((handler) => {
        const el = handler.getEl().querySelector("#colorpicker");
        $(el).spectrum({
          showPalette: false,
          showButtons: false,
          type: "color",
          showInput: "true",
          allowEmpty: "false",
          color: handler.getColor(),
          showAlpha: true,
          change(color) {
            handler.setColor(color.toRgbString());
          },
          move(color) {
            handler.setColor(color.toRgbString(), 0);
          },
        });
      });

      gp.addHandler(0, "red");
      gp.addHandler(100, "blue");

      const updateGradientFill = () => {
        let stops = gp.getHandlers();
        let orientation = $(
          `${this.containerSelector} .toolpanel#background-panel .content .gradient-orientation-container #select-orientation`
        ).val();
        let angle = parseInt(
          $(
            `${this.containerSelector} .toolpanel#background-panel .content .gradient-orientation-container #input-angle`
          ).val()
        );

        let gradient = generateFabricGradientFromColorStops(
          stops,
          _self.canvas.width,
          _self.canvas.height,
          orientation,
          angle
        );
        _self.canvas.setBackgroundColor(gradient);
        _self.canvas.renderAll();
      };

      // Do stuff on change of the gradient
      gp.on("change", (complete) => {
        updateGradientFill();
      });

      $(
        `${this.containerSelector} .toolpanel#background-panel .content .gradient-orientation-container #select-orientation`
      ).change(function () {
        let type = $(this).val();
        if (type === "radial") {
          $(this)
            .closest(".gradient-orientation-container")
            .find("#angle-input-container")
            .hide();
        } else {
          $(this)
            .closest(".gradient-orientation-container")
            .find("#angle-input-container")
            .show();
        }
        updateGradientFill();
      });

      $(
        `${this.containerSelector} .toolpanel#background-panel .content .gradient-orientation-container #input-angle`
      ).change(function () {
        updateGradientFill();
      });
    })();
  };

  window.ImageEditor.prototype.initializeCanvasSettingPanel = canvasSettings;
})();
