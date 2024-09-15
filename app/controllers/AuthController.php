<?php 

use Request\RequestHandler;
use Exception\RequestException;
use Session\UserSessionManager;
use Custom\Mailer;

final class AuthController extends Controller
{
    private $repository;
    private $session;

    public function __construct() {
       $this->session= new UserSessionManager();
       $this->repository = $this->loadModel('User');
    }

    public function login() {
        // Create an instance of RequestException
        $requestException = new RequestException();

        // Handle POST request
        if (RequestHandler::isRequestMethod('POST')) {
            
            // Handle CORS Headers
            if ($requestException->CorsHeader()) {
                $response = array();
                // Validate API request headers
                if (!$requestException->validata_api_request_header()) {
                    // Log error if headers are invalid
                    $response['error'] = $requestException->error_log_auth();
                } else {
                    // Process the login
                    $jsonString = file_get_contents("php://input");
                    $postRequest = json_decode($jsonString, true);
                    
                    $username = strip_tags(trim(filter_var($postRequest["username"], FILTER_SANITIZE_STRING)));
                    $password = strip_tags(trim(filter_var($postRequest["password"], FILTER_SANITIZE_STRING)));
                    if (empty($username)) {
                        $response= array('status'=>'error','message' =>"Username is require.");
                        http_response_code(400);
                    }

                    if (empty($password)) {
                        $response= array('status'=>'error','message' =>"Password is require.");
                        http_response_code(400);
                    }

                    if (!empty($username) && !empty($password)) {
                        $user = $this->repository->process_login($username, $password);
                        // Check if login was successful
                        if (!$user) {
                            $response= array('status'=>'error','message' =>"Invalid credentials provided..!");
                            http_response_code(400);
                        } else {

                            $this->session->set('id', $user->id);
                            $this->session->set('username', $user->username); 
                            $this->session->set('email', $user->email);
                                
                            $response['message'] = 'Login successful!';
                            http_response_code(200);
                        }
                    }
                }
                echo json_encode($response);
            }
        }

        // Handle GET request
        elseif (RequestHandler::isRequestMethod('GET')) {
            // Verify if the user is authenticated
            if (!$this->session->authCheck()) {
                $data = array("page_title" => 'Login');
                $this->view("auth/login", $data);
            } else {
                redirect('index'); 
            }
        }
    }

    public function register(){
        $requestException = new RequestException();
        if (RequestHandler::isRequestMethod('POST')) {
            if ($requestException->CorsHeader()) {
                $response = array();
                if (!$requestException->validata_api_request_header()) {
                    $response['error'] = $requestException->error_log_auth();
                } else {
                    $jsonString = file_get_contents("php://input");
                    $postRequest = json_decode($jsonString, true);
                    
                    $email = strip_tags(trim(filter_var($postRequest["email"], FILTER_VALIDATE_EMAIL)));
                    $username = strip_tags(trim(filter_var($postRequest["username"], FILTER_SANITIZE_STRING)));
                    $mobile = strip_tags(trim(filter_var($postRequest["mobile"], FILTER_SANITIZE_STRING)));
                    $password = strip_tags(trim(filter_var($postRequest["password"], FILTER_SANITIZE_STRING)));
                    $mobile = strip_tags(trim(filter_var($postRequest["mobile"], FILTER_SANITIZE_STRING)));
                    
                    if (empty($email) || $email ==null) {
                        $response= array('status'=>'error','message' =>"Email address is require.");
                        http_response_code(400);
                    }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $response = array('status' => 'error', 'message' => "Invalid email address.");
                        http_response_code(400);
                    }else if($this->repository->verifyEmail($email)){
                        $response= array('status'=>'error','message' =>"Email already been useed by another user.!");
                        http_response_code(400); 
                    }
                     // Stop further execution if there's an error with the email
                    if (!empty($response['status']) && $response['status'] == 'error') {
                        echo json_encode($response);
                        die();
                    }
                    if (empty($username) || $username ==null) {
                        $response= array('status'=>'error','message' =>"Username is require.");
                        http_response_code(400);
                    }else if($this->repository->verifyUsername($username)){
                        $response= array('status'=>'error','message' =>"Username already been useed by another user.!");
                        http_response_code(400); 
                    }

                    // Stop further execution if there's an error with the username
                    if (!empty($response['status']) && $response['status'] == 'error') {
                        echo json_encode($response);
                        die(); 
                    }

                    if (empty($mobile) || $mobile ==null) {
                        $response= array('status'=>'error','message' =>"Mobiel number is require.");
                        http_response_code(400);
                    }

                    if (empty($password) || $password ==null) {
                        $response= array('status'=>'error','message' =>"Password is require.");
                        http_response_code(400);
                    }
                    else{
                        if (!empty($email) && !empty($username) && !empty($password)) {
                            $hash_password = password_hash($password, PASSWORD_ARGON2ID);
                            if (!$this->repository->process_registration($email, $username, $mobile, $hash_password)) {
                                $response= array('status'=>'success','message' =>"Something went wrong.");
                                http_response_code(400);
                            } else {
                                $response['message'] = 'Account successfully created.!';
                                http_response_code(200);
                            }
                        }
                    }
                }
                echo json_encode($response);
            }
        }

        // Handle GET request
        elseif (RequestHandler::isRequestMethod('GET')) {
            // Verify if the user is authenticated
            if (!$this->session->authCheck()) {
                $data = array("page_title" => 'Login');
                $this->view("auth/register", $data);
            } else {
                redirect('Default');  // Redirect to some page if already authenticated
            }
        }
    }
  
    public function logout(){
        if ($this->session->destroy()) {
            redirect('auth/login'); 
        } else {
            redirect('Default'); 
        }
    }
}
