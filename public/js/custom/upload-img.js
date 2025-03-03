$(document).ready(function () {
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $("#img-upload").attr("src", e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#imgInp").change(function () {
    readURL(this);
  });

  $("#dropcontainer").on("dragover", function (e) {
    e.preventDefault();
    e.stopPropagation();
  });

  $("#dropcontainer").on("dragenter", function (e) {
    e.preventDefault();
    e.stopPropagation();
  });

  $("#dropcontainer").on("drop", function (e) {
    e.preventDefault();
    e.stopPropagation();
    var files = e.originalEvent.dataTransfer.files;
    if (files.length > 0) {
      $("#imgInp")[0].files = files;
      readURL($("#imgInp")[0]);
    }
  });
});
