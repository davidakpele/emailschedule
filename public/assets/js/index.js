
document.getElementById("scheduleEmailForm").addEventListener("submit", function(event) {
    event.preventDefault(); 

    // Clear previous error messages
    document.getElementById("email-error").innerHTML = "";
    document.getElementById("subject-error").innerHTML = "";
    document.getElementById("body-error").innerHTML = "";
    document.getElementById("time-error").innerHTML = "";

    // Get form values
    let recipient = document.getElementById("recipient").value;
    let subject = document.getElementById("subject").value;
    let body = document.getElementById("body").value;
    let scheduleTime = document.getElementById("schedule_time").value;
    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    // Validation flags
    let isValid = true;

    // Email validation
    if (recipient =="") {
        document.getElementById("email-error").innerHTML = "Email address require.";
        isValid = false;
    }else if (!emailPattern.test(recipient)) {
        document.getElementById("email-error").innerHTML = "Please enter a valid email address.";
        isValid = false;
    }

    // Subject validation
    if (subject.trim() == "") {
        document.getElementById("subject-error").innerHTML = "Subject is required.";
        isValid = false;
    }

    // Body validation
    if (body.trim() == "") {
        document.getElementById("body-error").innerHTML = "Email body is required.";
        isValid = false;
    }

    // Scheduled time validation (must be a future date)
    let now = new Date();
    let scheduledDate = new Date(scheduleTime);
    if (scheduleTime == "" || scheduledDate <= now) {
        document.getElementById("time-error").innerHTML = "Please enter a valid future time.";
        isValid = false;
    }
 
    if (isValid) {
        // Proceed with AJAX form submission
        let formData = {"recipient":recipient.trim(), "subject":subject, "body":body, "scheduleTime":scheduleTime}

        fetch('index', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(formData),
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error("Error:", error);
        });
    }
});
