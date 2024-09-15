import api from './api'

const password_input = document.querySelector("#password_input");
const password_eye = document.querySelector("#password_eye");

password_eye.addEventListener('click',()=>{
    if(password_input.type=="password"){
    password_input.type="text";
    password_eye.classList.add("fa-eye");
    password_eye.classList.remove("fa-eye-slash");


    }else if(password_input.type=="text"){
    password_input.type="password";
    password_eye.classList.add("fa-eye-slash");
    password_eye.classList.remove("fa-eye");
    }
});

$('#loginForm').submit(function (e) {
    e.preventDefault()
    // Get the form values
    let username = document.getElementById("username").value;
    let password = document.getElementById("password_input").value;
    
    if(username ==""){
        document.querySelector("#username-error").innerHTML = "Username require.";
        return;
    } else {
        document.querySelector("#username-error").innerHTML = "";
    }

    if (password =="") {
        document.querySelector("#password-error").innerHTML = "Password is require.*";
        return;
    }else {
        document.querySelector("#password-error").innerHTML = "";
    }
    if (username !="" && password !="") {
        const apiService = new api();
        apiService.login({ "username": username.trim(), "password": password.trim() })          
    }
    
});

$('#registerForm').submit(function (e) {
    e.preventDefault()
    $(".success").hide();
    // Get the form values
    let email = document.getElementById("email").value;
    let username = document.getElementById("username").value;
    let tel = document.getElementById("tel").value;
    let password = document.getElementById("password_input").value;
    
    // Email and Password validation
    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    
    if(email ==""){
        document.querySelector("#email-error").innerHTML = "Email address require.";
        return;
    }else if (!emailPattern.test(email)) {
        document.querySelector("#email-error").innerHTML = "Please enter a valid email address.";
        return;
    } else {
        document.querySelector("#email-error").innerHTML = "";
    }

    if(username ==""){
        document.querySelector("#username-error").innerHTML = "Username require.";
        return;
    }else {
        document.querySelector("#username-error").innerHTML = "";
    }

    if (tel =="") {
        document.querySelector("#tel-error").innerHTML = "Mobile number is require.*";
        return;
    }else {
        document.querySelector("#tel-error").innerHTML = "";
    }

    if (password =="") {
        document.querySelector("#password-error").innerHTML = "Password is require.*";
        return;
    }else {
        document.querySelector("#password-error").innerHTML = "";
    }
    if (emailPattern.test(email) && password !="") {
        // If validation passes, proceed with AJAX
        const apiService = new api();
        apiService.register({ "email": email.trim(), "username": username.trim(), "mobile":tel.trim(), "password": password.trim() })          
    }
    
});