<style>
input.is-invalid,
textarea.is-invalid,
select.is-invalid,
input[type="file"].is-invalid {
  border-left: 4px solid #ff0000 !important;
  border-color: #ff0000 !important;
}

.invalid-feedback {
    font-family: "PMedium";
    color: red;
    font-size: 0.8rem;
    width: 80%;
    margin-top: 1px;
}


</style>

<script src="assets/index.umd.js"></script>
<script>
  const tr = new Trivule();
  tr.init();
</script>
<script>
    function capitalizeName(inputElement) {
        inputElement.addEventListener('input', function () {
            // Allow spaces between words, but remove leading and trailing spaces
            let value = this.value;

            // Remove the leading space if it exists
            if (this.value.startsWith(' ')) {
                this.value = this.value.substring(1);
            }

            

            // Capitalize the first letter of each word and make the rest lowercase
            this.value = this.value
                .replace(/\s+/g, ' ') // Replace multiple spaces in between with a single space
                .split(' ') // Split the input by spaces
                .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()) // Capitalize each word
                .join(' '); // Join the words back with a single space

                
            return;
        });
    }

    function capitalizeNameNoSpace(inputElement) {
        inputElement.addEventListener('input', function () {
            // Allow spaces between words, but remove leading and trailing spaces
            let value = this.value;

            // Remove the leading space if it exists


            

            // Capitalize the first letter of each word and make the rest lowercase
            this.value = this.value
                .trim()
                .split(' ') // Split the input by spaces
                .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()) // Capitalize each word
                .join(' '); // Join the words back with a single space

                return;
        });
    }

    function trimStart(inputElement) {
        inputElement.addEventListener('textarea', function () {
            // Allow spaces between words, but remove leading and trailing spaces
            let value = this.value;

            

            // Capitalize the first letter of each word and make the rest lowercase
            this.value = this.value.trimStart()

                return;
        });
    }


    function noSpace(inputElement) {
        inputElement.addEventListener('input', function () {
            // Allow spaces between words, but remove leading and trailing spaces
            let value = this.value;

            // Remove the leading space if it exists
            if (this.value.startsWith(' ')) {
                this.value = this.value.substring(1);
            }

            

            // Capitalize the first letter of each word and make the rest lowercase
            this.value = this.value
                .trim()
                .split(' ') // Split the input by spaces
                .join(' '); // Join the words back with a single space

                return;
        });
    }
    function capitalizeFirstWord(inputElement) {
        inputElement.addEventListener('input', function () {
            // let value = this.value;

            // // Capitalize the first letter of the first word and leave the rest unchanged
            // this.value = this.value
            // .trim()
            // .replace(/^\w/, letter => letter.toUpperCase());

            // return;
        });
    }

    // Apply the capitalize function to both first name and last name
    capitalizeName(document.getElementById('fname'));
    capitalizeName(document.getElementById('lname'));
    capitalizeNameNoSpace(document.getElementById('nationality'));
    capitalizeName(document.getElementById('mi'));
    capitalizeName(document.getElementById('street'));
    capitalizeName(document.getElementById('houseno'));

    capitalizeName(document.getElementById('inc_fname'));
    capitalizeName(document.getElementById('inc_lname'));
    capitalizeName(document.getElementById('inc_mi'));
    capitalizeName(document.getElementById('inc_houseno'));
    capitalizeName(document.getElementById('inc_street'));
    capitalizeName(document.getElementById('inc_brgy'));
    capitalizeName(document.getElementById('inc_city'));
    capitalizeName(document.getElementById('inc_municipality'));

    capitalizeFirstWord(document.getElementById('custom_purpose'));
    


    capitalizeNameNoSpace(document.getElementById('contact'));
    noSpace(document.getElementById('username'));
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const textarea = document.getElementById('announcement');

    // Add event listener for input
    textarea.addEventListener('input', function() {
        let value = this.value;
        
        // Trim leading spaces only
        this.value = value.trimStart();  // Using trimStart to remove leading spaces
    });
});
</script>


    <script>
document.addEventListener("DOMContentLoaded", () => {
    const archiveBtn = document.querySelector('.add-staff-btn');
    const popup = document.getElementById('popup-add-staff');
    const confirmBtn = document.getElementById('confirm-btn-ads');
    const cancelBtn = document.getElementById('cancel-btn-ads');
    const hiddenSubmitBtn = document.getElementById('hiddenAddStaff');
    const requiredFields = document.querySelectorAll('.form-input[required], .form-control[required]');
    const errorMessage = document.getElementById("error-message");
    const contactno = document.getElementById('contact');

    // Function to validate the form and focus on the first field with feedback-error
    function validateForm() {
        let isValid = true;
        let firstInvalidField = null;

        const feedbackErrors = document.querySelectorAll(".feedback-error");
        for (const error of feedbackErrors) {
            if (error.textContent.trim() !== "") {
                isValid = false;
                const relatedField = error.previousElementSibling; // Assuming the input is right before the feedback-error
                if (relatedField && !firstInvalidField) {
                    firstInvalidField = relatedField;
                }
            }
        }

        for (const field of requiredFields) {
            if (!field.value.trim()) {
                isValid = false;
                if (!firstInvalidField) {
                    firstInvalidField = field;
                }
                field.style.borderColor = ""; // Optional: Highlight the field with a red border
            } else {
                field.style.borderColor = ""; // Reset border color if not empty
            }
        }

        // Focus on the first invalid or empty field
        if (firstInvalidField) {
            firstInvalidField.focus();
            contactno.focus();
            
        }
        return isValid;
    }




    // Event listener for the archive button to validate form and trigger focus
    archiveBtn.addEventListener('click', function () {
        if (validateForm()) {
            popup.classList.remove('hidden');
            if (errorMessage) {
                errorMessage.style.display = 'block';
            }
        } else {
            if (errorMessage) {
                errorMessage.innerText = "Please resolve all errors before proceeding.";
                errorMessage.style.display = 'block';
            }
        }
    });

    // Real-time validation while the user is typing
    requiredFields.forEach(field => {
        field.addEventListener('input', () => {
            const feedbackError = field.nextElementSibling; // Assuming .feedback-error is right after the input
            if (feedbackError) {
                if (field.value.trim()) {
                    field.style.borderColor = ''; // Reset border color
                } else {
                    feedbackError.textContent = "This field is required.";
                    field.style.borderColor = 'red'; // Highlight border
                }
            }

            if (errorMessage) {
                errorMessage.style.display = 'block';
            }
        });
    });

    // Close popup when Cancel is clicked
    cancelBtn.addEventListener('click', () => {
        popup.classList.add('hidden');
    });

    // Confirm action and submit form when Confirm is clicked
    confirmBtn.addEventListener('click', () => {
        hiddenSubmitBtn.click();
        popup.classList.add('hidden');
    });
});
</script>

<script>
function togglePopup() {
    const overlay = document.getElementById('popupOverlay');
    overlay.classList.toggle('show');
    
    // Wait until the popup is shown, then focus on all fields
}

    </script>



<script>
document.addEventListener("DOMContentLoaded", () => {
    const postBtn = document.querySelector('.post-announcement-btn');
    const popup = document.getElementById('popup-post-ann');
    const confirmBtn = document.getElementById('confirm-btn-ann');
    const cancelBtn = document.getElementById('cancel-btn-ann');
    const hiddenSubmitBtn = document.getElementById('hiddenPostAnn');
    const requiredFields = document.querySelectorAll('.form-input[required], .form-control[required]');
    const errorMessage = document.getElementById("error-message");

    // Function to validate the form and focus on the first field with feedback-error
    function validateAnnouncement() {
        let isAnnValid = true;
        let InvalidField = null;

        const feedbackErrors = document.querySelectorAll(".feedback-error");
        for (const error of feedbackErrors) {
            if (error.textContent.trim() !== "") {
                isAnnValid = false;
                const relatedField = error.previousElementSibling; // Assuming the input is right before the feedback-error
                if (relatedField && !InvalidField) {
                    InvalidField = relatedField;
                }
            }
        }


            // Check for required fields that are empty
            for (const field of requiredFields) {
            if (!field.value.trim()) {
                isAnnValid = false;
                if (!InvalidField) {
                    InvalidField = field;
                }
                field.style.borderColor = "red"; // Optional: Highlight the field with a red border
            } else {
                field.style.borderColor = ""; // Reset border color if not empty
            }
        }

        // Focus on the first invalid or empty field
        if (InvalidField) {
            InvalidField.focus();
        }

        return isAnnValid;
    }


    
    function focusAllFields() {
    // Get all required fields that are invalid

    // Focus all invalid fields at once
    requiredFields.forEach(field => {
        field.focus();

    });
}

    // Event listener for the archive button to validate form and trigger focus
    postBtn.addEventListener('click', function () {
        if (validateAnnouncement()) {
            popup.classList.remove('hidden');
            if (errorMessage) {
                errorMessage.style.display = 'block';
            }
        } else {
            if (errorMessage) {
                errorMessage.innerText = "Please resolve all errors before proceeding.";
                errorMessage.style.display = 'block';
            }
        }
    });

    // Real-time validation while the user is typing
    
    requiredFields.forEach(field => {
        field.addEventListener('input', () => {
            const feedbackError = field.nextElementSibling; // Assuming .feedback-error is right after the input
            if (feedbackError) {
                if (field.value.trim()) {
                    field.style.borderColor = ''; // Reset border color
                } else {
                    feedbackError.textContent = "This field is required.";
                    field.style.borderColor = 'red'; // Highlight border
                }
            }

            if (errorMessage) {
                errorMessage.style.display = 'block';
            }
        });
    });
    

    // Close popup when Cancel is clicked
    cancelBtn.addEventListener('click', () => {
        popup.classList.add('hidden');
    });

    // Confirm action and submit form when Confirm is clicked
    confirmBtn.addEventListener('click', () => {
        hiddenSubmitBtn.click();
        popup.classList.add('hidden');
    });
});
</script>
<script>
function goback() {
    const announcement = document.getElementById('announcement');

    announcement.focus();
    
}
</script>
<script>
    
    // Show feedback only when input is focused
document.querySelectorAll("input, textarea").forEach((field) => {
  const feedbackElement = field.closest(".form-group")?.querySelector(".invalid-feedback");

</script>


    <script>
document.addEventListener("DOMContentLoaded", () => {
    const archiveBtn = document.querySelector('.update-profile-btn');
    const popup = document.getElementById('popup-update-profile');
    const confirmBtn = document.getElementById('confirm-btn-updprof');
    const cancelBtn = document.getElementById('cancel-btn-updprof');
    const hiddenSubmitBtn = document.getElementById('hiddenUpdProf');
    const requiredFields = document.querySelectorAll('.form-input[required], .form-control[required]');
    const errorMessage = document.getElementById("error-message");
    

    // Function to validate the form and focus on the first field with feedback-error
    function validateForm() {
        let isValid = true;
        let firstInvalidField = null;

        const feedbackErrors = document.querySelectorAll(".feedback-error");
        for (const error of feedbackErrors) {
            if (error.textContent.trim() !== "") {
                isValid = false;
                const relatedField = error.previousElementSibling; // Assuming the input is right before the feedback-error
                if (relatedField && !firstInvalidField) {
                    firstInvalidField = relatedField;
                }
            }
        }

        for (const field of requiredFields) {
            if (!field.value.trim()) {
                isValid = false;
                if (!firstInvalidField) {
                    firstInvalidField = field;
                }
                field.style.borderColor = ""; // Optional: Highlight the field with a red border
            } else {
                field.style.borderColor = ""; // Reset border color if not empty
            }
        }

        // Focus on the first invalid or empty field
        if (firstInvalidField) {
            firstInvalidField.focus();
            
            
        }
        return isValid;
    }




    // Event listener for the archive button to validate form and trigger focus
    archiveBtn.addEventListener('click', function () {
        if (validateForm()) {
            popup.classList.remove('hidden');
            if (errorMessage) {
                errorMessage.style.display = 'block';
            }
        } else {
            if (errorMessage) {
                errorMessage.innerText = "Please resolve all errors before proceeding.";
                errorMessage.style.display = 'block';
            }
        }
    });

    // Real-time validation while the user is typing
    requiredFields.forEach(field => {
        field.addEventListener('input', () => {
            const feedbackError = field.nextElementSibling; // Assuming .feedback-error is right after the input
            if (feedbackError) {
                if (field.value.trim()) {
                    field.style.borderColor = ''; // Reset border color
                } else {
                    feedbackError.textContent = "This field is required.";
                    field.style.borderColor = 'red'; // Highlight border
                }
            }

            if (errorMessage) {
                errorMessage.style.display = 'block';
            }
        });
    });

    // Close popup when Cancel is clicked
    cancelBtn.addEventListener('click', () => {
        popup.classList.add('hidden');
    });

    // Confirm action and submit form when Confirm is clicked
    confirmBtn.addEventListener('click', () => {
        hiddenSubmitBtn.click();
        popup.classList.add('hidden');
    });
});
</script>

  if (feedbackElement) {
    // Add event listener for focus
    field.addEventListener("focus", () => {
      feedbackElement.style.display = "block"; // Show feedback on focus
    });

    // Add event listener for blur
    field.addEventListener("blur", () => {
      feedbackElement.style.display = "none"; // Hide feedback on blur
    });
  }
});
</script>
<script>
        function toggleNA(inputId) {
        var inputField = document.getElementById(inputId);
        var inputFeedback = document.getElementById(inputId + '-feedback');

        if (document.getElementById(inputId + '_na').checked) {
            inputField.value = 'N/A';
            inputField.readOnly = true;
            inputField.classList.remove('is-invalid');
            inputFeedback.innerHTML = '';
            
        } else {
            inputField.value = '';
            inputField.readOnly = false;
        }
    }

    
</script>
<script>
        function toggleCustomPurpose() {
            const purposeSelect = document.getElementById('purpose');
            const customPurposeContainer = document.getElementById('customPurposeContainer');
            const customPurposeInput = document.getElementById('custom_purpose');

            if (purposeSelect.value === 'Other') {
                customPurposeContainer.style.display = 'block';
                customPurposeInput.required = true;
            } else {
                customPurposeContainer.style.display = 'none';
                customPurposeInput.required = false;
            }
        }
</script>
