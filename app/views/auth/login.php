<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="robots" content="index,follow"/>
    <meta name="theme-color" content="#ffffff"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="format-detection" content="telephone=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Security-Policy" content="">
    <meta name="description" content=""/>
    <meta name="fragment" content="!" />
    <link rel="stylesheet" href="<?=ASSETS?>css/style.css">
    <link rel="stylesheet" href="<?=ASSETS?>fontawesome/css/all.css">
    <script src="<?=ASSETS?>js/jquery-3.2.1.slim.min.js"></script>
    <title><?=(isset($data['page_title']))? $data['page_title']: APP_NAME;?></title>
</head>
<body class="auth_page">
    <div class="container">
        <div class="login-form">
            <div class="headings">
                <h3>Welcome Back</h3>
            </div>
            <div class="text-center mb-5">
                <p>Login Account</p>
            </div>
            <form id="loginForm" method="post">
                <div class="inputs">
                    <input autocomplete='chrome-off' class="input-group" id="username" type="text" placeholder="Username">
                    <span id="username-error" class="error"></span>
                </div>
                <div class="inputs password-input"> 
                    <input autocomplete='chrome-off' class="input-group" id="password_input" type="password" placeholder="Password">
                    <i id="password_eye" class="fa fa-eye-slash"></i>
                </div>  
                <span id="password-error" class="error"></span>
          
                <button class="login-button">Login Now</button>
                <span class="text-center mt-5">
                    Don't have an account? 
                    <a href="register" class="a-tag">Signup</a>
                </span>
            </form>
        </div>
    </div>
<script type="module" src="<?=ASSETS?>js/auth.js"></script>
</body>
</html>