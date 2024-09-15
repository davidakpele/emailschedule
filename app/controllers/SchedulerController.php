<?php
use Request\RequestHandler;
use Exception\RequestException;
use Session\UserSessionManager;
use Custom\Mailer;

class SchedulerController extends Controller
{
    private $repository;
    private $schedule;
    private $session;

    public function __construct() {
       $this->session= new UserSessionManager();
       $this->repository = $this->loadModel('User');
       $this->schedule = $this->loadModel('Schedule');
    }

    public function send() {
        $response = [];
        $pendingEmails = $this->schedule->getPendingEmails();
        $requestException = new RequestException();
        
        $requestHandler = new RequestHandler($requestException);

        // Handle POST request
        if ($requestHandler->isRequestMethod('POST')) {
            foreach ($pendingEmails as $email) {
                $mail = new Mailer();
                $emailId = $email['id'];
                if ($mail->sendEmail($email['recipient_email'], $email['subject'], $email['body'])) {
                    // Mark the email as 'sent' if successful
                    $logDir = 'C:/xampp/htdocs/assignment/logs/';
                    $logFile = $logDir . 'task_log.txt';

                    // Check if the directory exists, if not create it
                    if (!is_dir($logDir)) {
                        mkdir($logDir, 0777, true); 
                    }

                    // Log the date and time to task_log.txt
                    file_put_contents($logFile, "Task triggered at: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

                    $this->schedule->updateEmailStatus($emailId, 'sent');
                    $response= array('status'=>'success','message' =>"Email sent successfully.");
                    http_response_code(200);
                } else {
                    // Retry logic for failed emails
                    $attempts = $email['attempts'] + 1;
                    if ($attempts >= 3) {
                        $this->schedule->updateEmailStatus($emailId, 'failed');
                        $response= array('status'=>'error','message' =>"Fail to send Email.");
                        http_response_code(400);
                    } else {
                        // Increment the attempts count
                        $this->schedule->updateAttempt($attempts, $emailId);
                    }
                    
                }
            }
            echo json_encode($response);
        }else{
            $response= array('status'=>'error','message' =>"Method not allowed.");
            http_response_code(405);
        }
    }
}
