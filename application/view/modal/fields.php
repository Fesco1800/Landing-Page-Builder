<!-- Text field modal -->
<div class="modal fade" id="textFieldModal" tabindex="-1" aria-labelledby="textFieldModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="textFieldModalLabel">Enter Text Field Details</h5>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="placeholderInput" class="form-label">Placeholder:</label>
                    <input type="text" class="form-control" id="placeholderInput">
                </div>
                <div class="mb-3">
                    <label for="inputTypeInput" class="form-label">Input Type (text, phone, or email):</label>
                    <input type="text" class="form-control" id="inputTypeInput">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="addFieldButton">Add Field</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="fieldsErrorMessageModal" tabindex="-1" aria-labelledby="fieldsErrorMessageModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fieldsErrorMessageModalLabel">Error</h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                    Please add either a sign-up form or a contact form before adding a text field.
                </div>
            </div>
        </div>
    </div>
</div>