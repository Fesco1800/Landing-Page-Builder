if (builderMode === "create") {
  const initialIntroSteps = [
    {
      title: "Welcome to the Landing Page Builder",
      intro:
        "This guide will walk you through creating a Landing Page step by step.",
    },

    {
      element: document.querySelector(".image-upload"),
      intro:
        "Here, you can input your page title, upload your page logo, and set a banner image for your landing page.",
    },

    {
      element: document.querySelector("#logoFile"),
      intro:
        "Upload your page logo here. Accepted image formats include PNG and JPEG.",
    },

    {
      element: document.querySelector("#brand"),
      intro: "Enter your page title here.",
    },

    {
      element: document.querySelector("#bannerFile"),
      intro:
        "Upload your banner image here. Accepted image formats include PNG and JPEG.",
    },

    {
      element: document.querySelector("#top-section-container"),
      intro:
        "The logo, page title, and banner will be previewed in this section.",
    },

    {
      element: document.querySelector(".logo-placeholder"),
      intro: "The uploaded logo will be previewed/displayed here",
    },

    {
      element: document.querySelector(".page-title-placeholder"),
      intro:
        "Once you type any text in the Page Title above, this part will be updated and allows you to preview the Page Title",
    },

    {
      element: document.querySelector("#heading-drop-area"),
      intro:
        'To add a heading, just click the "Add Heading" button above this area',
    },

    {
      element: document.querySelector(".logo-resize-container"),
      intro: "This toolbox will resize the logo",
    },

    {
      element: document.querySelector(".page-title-edit-container"),
      intro: "This toolbar will format the Page Title",
    },

    {
      element: document.querySelector(".top-section-switch-btn"),
      intro:
        "Click this button to switch between Photo Editor and Top Section Preview modes",
    },

    {
      element: document.querySelector("#title-2-drag-drop-area"),
      intro:
        'To add an element in this section, just click the "Add Product Highlights" button above this area',
    },

    {
      element: document.querySelector("#edit-button"),
      intro:
        'After adding an element using the "Add Product Highlights" button, click this button to modify the contents ',
    },

    {
      element: document
        .querySelector(".title-2")
        .querySelector(".image-gallery-btn"),
      intro:
        'To add this section background, you can either use the "Background Image" field to upload an image or "Image Gallery" to select predefined background',
    },

    {
      element: document.querySelector("#contact-form-drag-drop-area"),
      intro: "To set this bottom section you can use the following: ",
    },

    {
      element: document
        .querySelector(".bottom-section")
        .querySelector(".image-upload").children[0],
      intro:
        "Background Image: You can use this field to upload a backgroud image for the bottom section ",
    },

    {
      element: document
        .querySelector(".bottom-section")
        .querySelector(".image-upload").children[1],
      intro:
        "Mailto: Enter an email address where you want to receive Signup or Contact Form submissions from the landing page you are creating",
    },

    {
      element: document
        .querySelector(".bottom-section")
        .querySelector(".image-gallery-btn"),
      intro:
        "Image Gallery: Use this to select a predefined background for bottom section",
    },

    {
      element: document.querySelector("#add-signup-form"),
      intro: "Add Signup Form: Use this button to add a Signup form below",
    },

    {
      element: document.querySelector("#add-contact-form"),
      intro: "Add Contact Form: Use this button to add a Signup form below",
    },
  ];

  introJs().setOptions({ steps: initialIntroSteps }).start();

  document
    .querySelector(".top-section-switch-btn")
    .addEventListener("click", function () {
      setTimeout(function () {
        const photoEditorElement = document.querySelector(
          "#photo-editor-iframe-container"
        );

        const isPhotoEditorVisible =
          window.getComputedStyle(photoEditorElement).display !== "none";

        if (isPhotoEditorVisible) {
          introJs()
            .setOptions({
              steps: [
                {
                  element: photoEditorElement,
                  intro:
                    "Use this photo editor to create a top banner or banner image for your landing page. Click the download button in the photo editor to save the banner image.",
                },
              ],
            })
            .start();
        }
      }, 100);
    });
}

if (builderMode === "update") {
  const updateIntroSteps = [
    {
      title: "Updating your Landing Page",
      intro:
        "This guide will walk you through updating your existing Landing Page step by step.",
    },

    {
      element: document.querySelector(".update-logo-preview"),
      intro:
        "General Reminder: Images like this logo, the banner, the mid and bottom section backgrounds are just displayed as a preview. You can upload or choose other images if you want to change them. To keep the images, just leave the upload fields blank",
    },
  ];
  introJs().setOptions({ steps: updateIntroSteps }).start();
}

if (builderMode === "template") {
  const templateIntroSteps = [
    {
      title: "Using a Landing Page Template",
      intro:
        "This guide will walk you through using a predefined template to create a Landing Page step by step.",
    },

    {
      element: document.querySelector(".update-logo-preview"),
      intro:
        "General Reminder: Images like this logo, the banner, the mid and bottom section backgrounds are just a sample images and will not reflect to the Landing Page. You still need to upload or select other images to set the logo, banner, mid and bottom section bakcgrounds.",
    },
  ];
  introJs().setOptions({ steps: templateIntroSteps }).start();
}
