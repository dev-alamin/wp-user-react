jQuery(document).ready(function($) {
    // Add click event to copy button
    $('#copy-button').click(function() {
        // Get the text from the copy target
        var copyText = $('#copy-target').text();
        
        // Create a temporary input element to copy the text
        var tempInput = document.createElement('input');
        tempInput.style = 'position: absolute; left: -1000px; top: -1000px';
        tempInput.value = copyText;
        document.body.appendChild(tempInput);
        
        // Select and copy the text
        tempInput.select();
        document.execCommand('copy');
        
        // Remove the temporary input element
        document.body.removeChild(tempInput);
        
        // Show a success message
        $('#copy-success').fadeIn().delay(1000).fadeOut();
    });
});
