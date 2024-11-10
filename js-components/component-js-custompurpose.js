function toggleCustomPurpose() {
    var purposeDropdown = document.getElementById("purpose");
    var customPurposeContainer = document.getElementById("customPurposeContainer");
    
    // Show or hide the custom purpose field based on selection
    if (purposeDropdown.value === "Other") {
        customPurposeContainer.style.display = "block";
        document.getElementById("custom_purpose").required = true;
    } else {
        customPurposeContainer.style.display = "none";
        document.getElementById("custom_purpose").required = false;
    }
}