<?php

abstract class LogController{

    public function __construct(){
      if(!isLoggedIn()){
        redirect('users/login');
      }
    }

    public function Log($message){

        $user_id = $_SESSION['user_id'] ?? ""; 
        $user_lang = $_SESSION['lang'] ?? "";
        $firstname = $_SESSION['firstname'] ?? ""; 
        $lastname = $_SESSION['lastname'] ?? ""; 

        // Check message
        if($message == '') {
          return array(status => false, message => 'Message is empty');
        }

        // Get IP address
        if( ($remote_addr = $_SERVER['REMOTE_ADDR']) == '') {
          $remote_addr = "REMOTE_ADDR_UNKNOWN";
        }

        // Get requested script
        if( ($request_uri = $_SERVER['REQUEST_URI']) == '') {
          $request_uri = "REQUEST_URI_UNKNOWN";
        }

        // Escape values
        $message     = htmlspecialchars(strip_tags($message));
        $remote_addr = htmlspecialchars(strip_tags($remote_addr));
        $request_uri = htmlspecialchars(strip_tags($request_uri));
      
        $data = [
          'user_id' => htmlspecialchars(strip_tags($user_id)),
          'firstname' => htmlspecialchars(strip_tags($firstname)),
          'lastname' => htmlspecialchars(strip_tags($lastname)),
          'message' => $message,
          'remote_addr' => $remote_addr,
          'request_uri' => $request_uri
        ];
        $this->logModel = $this->model('Log');
        $this->logModel->addLog($data);     
    }
}

?>