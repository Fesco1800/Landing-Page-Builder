<?php
$imageFolder = URL . 'img/appointment-booking/';
?>
<div class="boutique-container step-1 container-fluid mt-3 mb-3">
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="left-container p-3 bg-white">
                <div class="text-center">
                    <div class="hotel-logo-container mb-2">
                        <img class="img-fluid rounded-circle" src="<?= $imageFolder ?>boutique-appointment-logo.png" alt="Hotel Logo" style="width: 200px;">
                    </div>
                    <div class="hotel-text-container">
                        <span>Perfect Bridal</span>
                        <h5>Appointment</h5>
                        <div class="clock-time my-2">
                            <i class="bi bi-clock-fill"></i> <span class="ms-2 duration">30 min</span>
                        </div>
                        <div class="container-fluid p-5">
                            <div class="notes-container my-4">
                                <h5 class="notes-header">Schedule a Visit</h5>
                                <p class="notes-item">• Complimentary site tour</p>
                                <p class="notes-item">• Q&A and consultation on wedding venue services and packages</p>
                            </div>
                            <div class="notes-container">
                                <h5 class="notes-header">Helpful Tips:</h5>
                                <p class="notes-item">• We recommend scheduling your appointment at least 10 months prior to your wedding day.</p>
                                <p class="notes-item">• To avoid overlapping bookings, in the event of multiple appointments, we will prioritize the later appointment and release the remaining slots.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 mb-3 p-0" style="padding-right: 10px !important;">
            <div class="right-container p-3 bg-white">
                <i class="bi bi-x-lg float-end"></i>
                <div class="text-center">
                    <h3 class="mt-5">Select your</h3>
                    <h3>Preferred Meeting Date & Time</h3>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="calendar mt-5">
                                <div class="datepicker appointment-date" id='datepicker'></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="time-selection mt-5">
                                <h5 class="selected-date text-center"></h5>
                                <div class="d-flex justify-content-center">
                                    <select class="form-select w-100" aria-label="Default select example">
                                        <option selected>(UTC +08:00) Singapore</option>
                                        <option value="1">(UTC +00:00) London</option>
                                        <option value="2">(UTC -05:00) New York</option>
                                        <option value="3">(UTC +09:00) Tokyo</option>
                                    </select>
                                </div>
                                <div class="selected-time-and-confirm d-flex mt-4">
                                    <div class="selected-time w-50 me-1 text-center">11:30</div>
                                    <button class="btn step-1-confirm-button w-50">Confirm</button>
                                </div>
                                <div class="time-slots mt-4">
                                    <div class="time-slot selected text-center">11:30</div>
                                    <div class="time-slot text-center">12:30</div>
                                    <div class="time-slot text-center">13:30</div>
                                    <div class="time-slot text-center">14:30</div>
                                    <div class="time-slot text-center">15:30</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="boutique-container step-2 container-fluid mt-3 mb-3 d-none">
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="left-container p-3 bg-white">
                <div class="text-center">
                    <div class="hotel-logo-container mb-5">
                        <img class="img-fluid rounded-circle" src="<?= $imageFolder ?>boutique-appointment-logo.png" alt="Hotel Logo" style="width: 200px;">
                    </div>
                    <div class="hotel-text-container">
                        <span>Perfect Bridal</span>
                        <h5>Appointment</h5>
                        <div class="p-4" style="padding-top: 10px !important;">
                            <div class="appointment-details time-duration mb-2 text-left">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <div class="appointment-details date-time mb-2 text-left">
                                <i class="bi bi-calendar"></i>
                            </div>
                            <div class="appointment-details time-zone text-left">
                                <i class="bi bi-globe"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 mb-3 p-0" style="padding-right: 10px !important;">
            <div class="right-container p-3 bg-white">
                <i class="bi bi-x-lg float-end"></i>
                <h4 class="text-center mb-4">Enter details</h4>
                <form class="details-form">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control fname" placeholder="First Name*" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control lname" placeholder="Last Name*" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="email" class="form-control email" placeholder="Email*" required>
                        </div>
                        <div class="col-md-6">
                            <input type="tel" class="form-control phone" placeholder="Phone Number*" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control wedding-date" placeholder="Your Wedding Date (if decided)">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control guest-size" placeholder="Estimated Guest List Size">
                        </div>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control remarks" rows="3" placeholder="Remarks"></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn step-2-confirm-button">Set Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>