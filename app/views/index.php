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
    <link rel="stylesheet" href="<?=ASSETS?>css/nav.css">
    <link rel="stylesheet" href="<?=ASSETS?>css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=ASSETS?>fonts/icomoon/style.css">
    <link rel="stylesheet" href="<?=ASSETS?>css/bootstrap.css">
    <link rel="stylesheet" href="<?=ASSETS?>fontawesome/css/all.css">
    <script src="<?=ASSETS?>js/jquery-3.2.1.slim.min.js"></script>
    <title><?=(isset($data['page_title']))? $data['page_title']: APP_NAME;?></title>
    <style>
        .hero {
            position: relative;
            background-size: cover;
            background-position: center;
        }

        .form-container {
            position: absolute;
            top: 60%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 500px; 
            text-align: center;
        }

        .form-container h1 {
            margin-bottom: 20px;
        }

        .form-container input,
        .form-container textarea {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            border-radius: 5px;
        }

        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
</style>

</head>
<body>
 <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->
    

    <!-- NAVBAR -->
    <header class="site-navbar mt-3">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="site-logo col-6"><a href="<?=ROOT?>">Brand</a></div>

          <nav class="mx-auto site-navigation">
            <ul class="site-menu js-clone-nav d-none d-xl-block ml-0 pl-0">
              <li><a href="<?=ROOT?>" class="nav-link active">Home</a></li>
              <li><a href="<?=ROOT?>">About</a></li>
              <li class="has-children">
                <a href="<?=ROOT?>">Job Listings</a>
                <ul class="dropdown">
                  <li><a href="<?=ROOT?>">Job Single</a></li>
                  <li><a href="<?=ROOT?>">Post a Job</a></li>
                </ul>
              </li>
              <li><a href="contact.html">Contact</a></li>
              <li class="d-lg-none"><a href="post-job.html"><span class="mr-2">+</span> Post a Job</a></li>
              <?php if(!$data['session']):?>
              <li class="d-lg-none"><a href="login.html">Log In</a></li>
              <?php  else:?>
              <li class="d-lg-none"><a href="<?=ROOT?>"><?=$data['username']?></a></li>
               <?php endif;?>
            </ul>
          </nav>
          
          <div class="right-cta-menu text-right d-flex aligin-items-center col-6">
            <div class="ml-auto">
             <?php if(!$data['session']):?>
              <a href="login" class="btn btn-primary border-width-2 d-none d-lg-inline-block"><span class="mr-2 icon-lock_outline"></span>Log In</a>
            <?php  else:?>
                <a href="post-job.html" class="btn btn-outline-white border-width-2 d-none d-lg-inline-block"><span class="mr-2 icon-add"></span>Post a Job</a>
                <a href="profile" class="btn btn-primary border-width-2 d-none d-lg-inline-block"><span class="mr-2 icon-user"></span><?=$data['username']?></a>
                 <a href="auth/logout" class="btn btn-outline-white border-width-2 d-none d-lg-inline-block"><span class="mr-2 icon-sign-out"></span>Logout</a>
                
                 <?php endif;?>
            </div>
            <a href="#" class="site-menu-toggle js-menu-toggle d-inline-block d-xl-none mt-lg-2 ml-3"><span class="icon-menu h3 m-0 p-0 mt-2"></span></a>
          </div>

        </div>
      </div>
    </header>

    <div class="hero" style="background-image: url('<?= ASSETS ?>images/hero_1.jpg');">
        <div class="form-container">
            <h1>Schedule an Email</h1>
            <form id="scheduleEmailForm" method="POST">
                <label for="recipient">Recipient Email:</label>
                <input type="email" id="recipient" name="recipient" value="<?=(isset($_POST['recipient'])?$_POST['recipient']:'')?>"><br>
                <span id="email-error" style="color: red;"></span><br>

                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" value="<?=(isset($_POST['subject'])?$_POST['subject']:'')?>"><br>
                <span id="subject-error" style="color: red;"></span><br>

                <label for="body">Email Body:</label>
                <textarea id="body" name="body" value="<?=(isset($_POST['body'])?$_POST['body']:'')?>"></textarea><br>
                <span id="body-error" style="color: red;"></span><br>

                <label for="schedule_time">Scheduled Time (YYYY-MM-DD HH:MM:SS):</label>
                <input type="datetime-local" id="schedule_time" name="schedule_time"><br>
                <span id="time-error" style="color: red;"></span><br>

                <button type="submit" class="login-button w-100">Schedule Email</button>
            </form>

        </div>
    </div>
    <script src="<?=ASSETS?>js/jquery.sticky.js"></script>
    <script src="<?=ASSETS?>js/main.js"></script>
    <script type="module" src="<?=ASSETS?>js/index.js"></script>
  </body>
</html>