<?php
  /*
  * Error and Exception handling
  */
  error_reporting(E_ALL);
  set_error_handler('Errorlog\Error::errorHandler');
  set_exception_handler('Errorlog\Error::exceptionHandler');

  /*
  * Base Controller
  * Loads the models and views
  */

  class Controller extends LogController {
    // Load model
    public function model($model){

      if(file_exists('../app/models/' . $model . '.php')){

        // Require model file
        require_once '../app/models/' . $model . '.php';
        // Instatiate model
        return new $model();

      } else {

       // Model does not exist
       throw new \Exception("Model: $model not found");
      }

    }

    // Load view
    public function view($view, $data = []){
      // Check for view file
      if(file_exists('../app/views/' . $view . '.php')){
        require_once '../app/views/' . $view . '.php';

      } else {
        
        // View does not exist
        throw new \Exception("View: $view not found");
      }
    }

    /*
    * Permissions
    */
    
    // Permissions Check global
    function check_acl($permission) {

      // set by login
      $group_id = $_SESSION['group_id'];

      if(!$this->group_permissions($permission,$group_id)) {
          $_SESSION['url'] = $_SERVER['REQUEST_URI']; 
          return false;
          }
        return true;
    }

    // Permissions Check global part 2
    public function group_permissions($permission,$group_id) {
        $group_id = $_SESSION['group_id'];

        // count the permissions
        $countAcl = $this->aclModel->count_group_permissions($permission,$group_id);
  
        if ($countAcl == true){

          // check again
          $permissionAcl = $this->aclModel->group_permissions($permission,$group_id);

            if (($permissionAcl == true) AND (!empty($permissionAcl->permission_name)) ){
              return true;
            } else{
              return false;
            }

        } else{
          return false;
        }
        return true;
    }

  }