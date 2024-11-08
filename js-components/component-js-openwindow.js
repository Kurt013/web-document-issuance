function changePic(openTab) {
   // Define the dimensions of the popup window
    var width = 800;
    var height = 600;

    // Calculate the position to place the window in the center
    var left = (window.screen.width - width) / 2;
    var top = (window.screen.height - height) / 2;

    // Open the popup window in the center with defined features
    var mywindow = window.open(
        openTab,
        'Take a pic',
        `width=${width},height=${height},top=${top},left=${left},scrollbars=no,resizable=no`
    );

    // Ensure the popup is focused
    if (mywindow) {
        mywindow.focus();
    } else {
        alert("Popup blocked! Please allow popups for this website.");
    }

    return true;
}
