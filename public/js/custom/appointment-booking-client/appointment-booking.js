/*
 * Appointment Booking
 */

document.addEventListener("DOMContentLoaded", () => {
  "use strict";

  const currentDate = new Date();
  const formattedDate = currentDate.toISOString().split("T")[0];
  const options = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  };

  const updateSelectedDate = (date, container) => {
    container.querySelector(".selected-date").textContent =
      date.toLocaleDateString("en-US", options);
  };

  const getEndTime = (startTime, durationMinutes) => {
    let [hour, minute] = startTime.split(":").map(Number);
    minute += durationMinutes;
    if (minute >= 60) {
      minute -= 60;
      hour += 1;
    }
    if (hour >= 12) {
      hour = hour > 12 ? hour - 12 : hour;
      return `${hour}:${minute.toString().padStart(2, "0")} PM`;
    }
    return `${hour}:${minute.toString().padStart(2, "0")} AM`;
  };

  const getAppointmentType = (container) => {
    if (!container) return "unknown";
    if (container.classList.contains("hotel-container")) {
      return "hotel";
    } else if (container.classList.contains("photographer-container")) {
      return "photographer";
    } else if (container.classList.contains("boutique-container")) {
      return "boutique";
    } else {
      return "unknown";
    }
  };

  const isBoutique = (container) =>
    container.closest(".boutique-container") !== null;

  document.querySelectorAll(".datepicker").forEach((datepicker) => {
    datepicker.setAttribute("data-date", formattedDate);
    $(datepicker)
      .datepicker({
        format: "yyyy-mm-dd",
        inline: true,
        todayHighlight: true,
      })
      .datepicker("update", formattedDate)
      .on("changeDate", (e) => {
        updateSelectedDate(new Date(e.date), datepicker.closest(".step-1"));
      });
  });

  document.querySelectorAll(".step-1").forEach((container) => {
    updateSelectedDate(currentDate, container);
  });

  document.querySelectorAll(".time-slot").forEach((element) => {
    element.addEventListener("click", () => {
      const container = element.closest(".step-1");
      container
        .querySelectorAll(".time-slot")
        .forEach((el) => el.classList.remove("selected"));
      element.classList.add("selected");
      container.querySelector(".selected-time").textContent =
        element.textContent;
    });
  });

  document.querySelectorAll(".step-1-confirm-button").forEach((button) => {
    button.addEventListener("click", () => {
      const container = button.closest(".step-1");
      const step2Container = container.parentNode.querySelector(".step-2");

      if (step2Container) {
        container.classList.add("d-none");
        step2Container.classList.remove("d-none");

        const selectedDate =
          container.querySelector(".selected-date").textContent;
        const selectedTime =
          container.querySelector(".selected-time").textContent;
        const selectedDuration =
          container.querySelector(".duration").textContent;
        const selectedTimezone =
          container.querySelector(".form-select").selectedOptions[0].text;
        const durationMinutes = isBoutique(container) ? 30 : 60;

        step2Container.querySelector(
          ".time-duration .bi-clock-fill"
        ).nextSibling.textContent = ` ${selectedDuration}`;
        step2Container.querySelector(
          ".date-time .bi-calendar"
        ).nextSibling.textContent = ` ${selectedTime} - ${getEndTime(
          selectedTime,
          durationMinutes
        )}, ${selectedDate}`;
        step2Container.querySelector(
          ".time-zone .bi-globe"
        ).nextSibling.textContent = ` ${selectedTimezone}`;
      } else {
        console.error("Step 2 container not found");
      }
    });
  });

  document.querySelectorAll(".step-2-confirm-button").forEach((button) => {
    button.addEventListener("click", (e) => {
      e.preventDefault();
      const container = button.closest(".step-2");
      const step1Container = container.closest(
        ".hotel-container, .photographer-container, .boutique-container"
      );
      const appointmentDetails = `
        <div class="text-left">
            <p><strong>Duration:</strong> ${
              container.querySelector(".time-duration").textContent
            }</p>
            <p><strong>Date and Time:</strong> ${
              container.querySelector(".date-time").textContent
            }</p>
            <p><strong>Time Zone:</strong> ${
              container.querySelector(".time-zone").textContent
            }</p>
            <p><strong>Name:</strong> ${
              container.querySelector(".fname").value
            } ${container.querySelector(".lname").value}</p>
            
            <p><strong>Email:</strong> ${
              container.querySelector(".email").value
            }</p>
            <p><strong>Phone:</strong> ${
              container.querySelector(".phone").value
            }</p>
            <p><strong>Wedding Date:</strong> ${
              container.querySelector(".wedding-date").value
            }</p>
            <p><strong>Guest Size:</strong> ${
              container.querySelector(".guest-size").value
            }</p>
            <p><strong>Remarks:</strong> ${
              container.querySelector(".remarks").value
            }</p>
            <p><strong>Appointment Type:</strong> ${getAppointmentType(
              step1Container
            )}</p>
        </div>
      `;

      Swal.fire({
        title: "Appointment Details",
        html: appointmentDetails,
        icon: "info",
        showCancelButton: true,
        confirmButtonText: "Confirm",
        cancelButtonText: "Edit",
      }).then((result) => {
        if (result.isConfirmed) {
          const formData = new FormData();
          formData.append(
            "duration",
            container.querySelector(".time-duration").textContent
          );
          const dateTimeText =
            container.querySelector(".date-time").textContent;

          const parts = dateTimeText.split(", ");
          const timePart = parts[0];
          const datePart = parts.slice(2).join(", ");

          const time = timePart.replace(/\s+/g, "");

          formData.append("date", datePart);
          formData.append("time", time);

          formData.append(
            "time_zone",
            container.querySelector(".time-zone").textContent
          );
          formData.append("fname", container.querySelector(".fname").value);
          formData.append("lname", container.querySelector(".lname").value);
          formData.append("email", container.querySelector(".email").value);
          formData.append("phone", container.querySelector(".phone").value);
          formData.append(
            "wedding_date",
            container.querySelector(".wedding-date").value
          );
          formData.append(
            "guest_size",
            container.querySelector(".guest-size").value
          );
          formData.append("remarks", container.querySelector(".remarks").value);
          formData.append(
            "appointment_type",
            getAppointmentType(step1Container)
          );

          const xhr = new XMLHttpRequest();
          xhr.open("POST", url + "appointment-booking-client/save", true);
          xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
              if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                  Swal.fire(
                    "Confirmed!",
                    "Your appointment has been set.",
                    "success"
                  );
                } else {
                  Swal.fire(
                    "Error",
                    "There was a problem with your request: " +
                      response.message,
                    "error"
                  );
                }
              } else {
                Swal.fire(
                  "Error",
                  "There was a problem with your request.",
                  "error"
                );
              }
            }
          };
          xhr.send(formData);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire(
            "Cancelled",
            "You can edit your appointment details.",
            "error"
          );
        }
      });
    });
  });

  // wedding date picker
  $(".wedding-date").datepicker({
    format: "DD, MM d, yyyy",
  });
});
