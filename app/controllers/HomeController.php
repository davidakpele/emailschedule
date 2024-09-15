<?php

use Request\RequestHandler;
use Exception\RequestException;
use Session\UserSessionManager;
use Custom\Mailer;

final class HomeController extends Controller
{
    private $repository;
    private $schedule;
    private $session;

    public function __construct() {
       $this->session= new UserSessionManager();
       $this->repository = $this->loadModel('User');
       $this->schedule = $this->loadModel('Schedule');
    }

    public function index(){
        $requestException = new RequestException();
        $authClass= new UserSessionManager;
        $requestHandler = new RequestHandler($requestException);

        // Handle POST request
        if ($requestHandler->isRequestMethod('POST')) {
            $postRequest = $requestHandler->handleRequest('POST');
            $response = array();
            if (isset($postRequest['error'])) {
                // Handle CORS or validation errors
                echo json_encode(['error' => $postRequest['error']]);
            } else {
                // Sanitize input fields
                $recipientEmail = $requestHandler->sanitizeField($postRequest['recipient']);
                $subject = $requestHandler->sanitizeField($postRequest['subject'], FILTER_SANITIZE_STRING);
                $body = $requestHandler->sanitizeField($postRequest['body'], FILTER_SANITIZE_STRING);
                $schedule_time = $requestHandler->sanitizeField($postRequest['scheduleTime']);
                
                if (empty($recipientEmail) || $recipientEmail ==null) {
                    $response= array('status'=>'error','message' =>"Email address is require.");
                    http_response_code(400);
                }else if (!filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
                    $response = array('status' => 'error', 'message' => "Invalid email address.");
                    http_response_code(400);
                }
                
                if (empty($subject) || $subject ==null) {
                    $response= array('status'=>'error','message' =>"Subject is require.");
                    http_response_code(400);
                }
                
                if (empty($body) || $body ==null) {
                    $response= array('status'=>'error','message' =>"Email body is require.");
                    http_response_code(400);
                }
                
                if (empty($schedule_time) || $schedule_time ==null) {
                    $response= array('status'=>'error','message' =>"Schedule time is require.");
                    http_response_code(400);
                }
                if (!empty($recipientEmail) && !empty($subject) && !empty($body) && !empty($schedule_time)) {
                    $user_id = $_SESSION['id'];
                    if ($this->schedule->createSchedule($recipientEmail, $subject, $body, $schedule_time, $user_id)) {
                        $response= array('status'=>'success','message' =>"Email scheduled successfully!");
                        http_response_code(200);
                    }else{
                        $response= array('status'=>'error','message' =>"Error scheduling email.");
                        http_response_code(400);
                    }
                }
               echo json_encode($response);
            }
        } else {
           if (!$authClass->authCheck()) {
                redirect('auth/login');
            }else{
                $data = array(
                    'page_title'=>'Default',
                    'session'=>true,
                    'username'=>(isset($_SESSION['username'])?$_SESSION['username']:''),
                    'userId'=>(isset($_SESSION['id'])?$_SESSION['id']:''),
                );
                $this->view("index", $data); 
            } 
        }
        
              
    }

}
