<?php
  class Documents extends Controller {
    public function __construct(){
        $this->aclModel = $this->model('Acl');
        $this->userModel = $this->model('User');
        $this->documentModel = $this->model('Document');
        $this->partnerModel = $this->model('Partner');
    }

    public function add(){

       if (!$this->check_acl('')){
           redirect('noaccess');
        } else{ 
  
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  
            $data = [
              'p_id'             => htmlspecialchars(strip_tags($_POST['partners'])),
              'doc_kind'         => htmlspecialchars(strip_tags($_POST['doc_kind'])),
              'doc_number'       => htmlspecialchars(strip_tags($_POST['doc_number'])),
              'doc_date'         => htmlspecialchars(strip_tags($_POST['date'])),
              'due_date'         => htmlspecialchars(strip_tags($_POST['delivery_date'])),
              'intro'            => htmlspecialchars(strip_tags($_POST['intro'])),
              'terms_payment'    => htmlspecialchars(strip_tags($_POST['top'])),
              'follow_up'        => htmlspecialchars(strip_tags($_POST['remark'])),
              'tax_rates'        => html_entity_decode(htmlentities($_POST['tax_rates_prepared'],ENT_QUOTES),ENT_QUOTES),
              'sub_netto'        => htmlspecialchars(strip_tags($_POST['sub_netto'])),
              'total'            => htmlspecialchars(strip_tags($_POST['total'])),
              'serial_document'  => '0',
              'payment_link'     => '',
              'c_uid'            => $_SESSION['user_id'],
              'top_err'           => '',
              'partner_err'       => '',
              'doc_kind_err'      => '',
              'doc_number_err'    => '',
              'date_err'          => '',
              'delivery_date_err' => ''
            ];
  
            // Validate data
            if(empty($data['p_id'])){
              $data['partner_err'] = 'Pflichtfeld';
            }
            if(empty($data['doc_kind'])){
              $data['doc_kind_err'] = 'Pflichtfeld';
            }
            if(empty($data['doc_number'])){
              $data['doc_number_err'] = 'Pflichtfeld';
            }
            if(empty($data['doc_date'])){
              $data['date_err'] = 'Pflichtfeld';
            }
            if(empty($data['due_date'])){
              $data['delivery_date_err'] = 'Pflichtfeld';
            }
            if(empty($data['terms_payment'])){
              $data['top_err'] = 'Pflichtfeld';
            }
            
            // Make sure no errors
            if(empty($data['partner_err']) && empty($data['doc_kind_err']) && empty($data['doc_number_err']) && empty($data['date_err']) && empty($data['delivery_date_err']) && empty($data['top_err'])){
  
              // Validated
              if($this->documentModel->addDocument($data)){

                // Create log
                $this->log('New Document => ' . $data['p_id'] . '');

                // count positions
                $cnt = count($_POST['pos']);
                for($i=0;$i<$cnt;$i++){

                    $position_data = [
                      'pos'             => htmlspecialchars(strip_tags($_POST['pos'][$i])),
                      'amount'          => htmlspecialchars(strip_tags($_POST['amount'][$i])),
                      'unit'            => htmlspecialchars(strip_tags($_POST['unit'][$i])),
                      'price'           => htmlspecialchars(strip_tags($_POST['price_pos'][$i])),
                      'tax'             => htmlspecialchars(strip_tags($_POST['tax_pos_'][$i])),
                      'discount'        => htmlspecialchars(strip_tags($_POST['discount'][$i])),
                      'whole'           => htmlspecialchars(strip_tags($_POST['whole'][$i])),
                    ];
                    if (!empty($_POST['pos'][$i])){
                      if($this->documentModel->addPosition($position_data)){
                      }
                    }
                }                           
  
                flash('message', '');
                redirect('documents/add');
              } else {
                die('Es ist ein Fehler aufgetreten');
              }
            } else {
              // Load view with errors
              $partners = $this->partnerModel->getPartners();
              $data['partners'] = $partners;
              $this->view('documents/add', $data);
            }
  
          } else {
            $partners = $this->partnerModel->getPartners();
            $data = [
              'partners'         => $partners,
              'doc_kind'         => '',
              'doc_number'       => '',
              'doc_date'         => '',
              'due_date'         => '',
              'intro'            => '',
              'terms_payment'    => '',
              'follow_up'        => '',
              'payment_link'     => ''
            ];
      
            $this->view('documents/add', $data);
          }
        } 
      }

    // Export Function
    public function exportpdf($id = null){
      if (!$this->check_acl('Export PDF')){
        redirect('users/login');
      } else{ 

        if ( (!ctype_digit($id)) || !ctype_digit($id) && (int)$id < 0 ) {
          DIE('No valid ID');
        }

        $document   = $this->documentModel->getDocumentById($id);
        $positions  = $this->documentModel->getDocumentPositionsById($document->id);
        $partner    = $this->partnerModel->getPartnerById($document->p_nr);
        $mysettings   = $this->userModel->getCompanySettingsByCompanyId($document->c_id);

        $data = [
          'id'        => $id,
          'partner'   => $partner,
          'document'  => $document,
          'positions' => $positions,
          'mysettings'  => $mysettings
        ];

        $this->view('documents/exportpdf', $data);

      }

    // Logo Upload
    public function fileUpload($id){

      if ( (!ctype_digit($id)) || !ctype_digit($id) && (int)$id < 0 ) {
        DIE('No valid ID');
      }
  
        // Create Array to keep filenames
        $uploaded_files = array();
        $comma_separated = implode(",", $uploaded_files);
  
          // File Upload Settings
          if($_SERVER['REQUEST_METHOD'] == 'POST'){

              // Sanitize
              $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
              $data = [
                'upload_err' => ''
              ];

              $target_directory = PUBLICPATH."/uploads"."/".$id; //ToolID
              // Loop all files
              // for($i=0;$i<$countfiles;$i++){
                  if(!is_dir($target_directory)){
                  mkdir($target_directory, 0744, true);
                  }
                  // File name
                  $filename = $_FILES['logo']['name'];
                  $shafilename = sha1_file($_FILES['logo']['tmp_name']) . "-" . date('d-m-Y-H-i-s') . "-" . basename($_FILES['logo']["name"]);
                  // Check File size
                  $check = getimagesize($_FILES['logo']["tmp_name"]);
                  $file_size = $_FILES['logo']['size'];
                  // Get extension
                  // Old Version with PHP Error => $ext = end((explode(".", $filename)));
                  $tmpend = explode(".", $filename);
                  $ext = end($tmpend);

                  // Valid File extension, all allowed extensions
                  $valid_ext = array('jpg','JPG','jpeg','JPEG','png','PNG','gif','GIF');
                
                  // Max File size 10 MB
                  if(!empty($_FILES['logo']["tmp_name"])){
                   
                      if($file_size > 10485760){
                        // Set Error if file to big
                        $data['upload_err'] = _file_size_err;
                      }   
                  // Valid Image extension, used for image manipulation
                  $valid_ext_img = array('jpg','JPG','jpeg','JPEG','png','PNG','gif','GIF');

                  // If Image, manipulate it
                  if(in_array($ext, $valid_ext_img)){

                      // Max Image dimensions
                      $maxDim = 600;
                      $file_name = $_FILES['logo']['tmp_name'];
                      list($width, $height, $type, $attr) = getimagesize( $file_name );
                      $info = getimagesize($file_name);
                      $mime = $info['mime'];
                          if ( $width > $maxDim || $height > $maxDim ) {
                          $target_filename = $file_name;
                          $ratio = $width/$height;
                          if( $ratio > 1) {
                              $new_width = $maxDim;
                              $new_height = $maxDim/$ratio;
                          } else {
                              $new_width = $maxDim*$ratio;
                              $new_height = $maxDim;
                          }
                          $src = imagecreatefromstring( file_get_contents( $file_name ) );
                          $dst = imagecreatetruecolor( $new_width, $new_height );
                          imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
                          imagedestroy( $src );
                          // Try to rotate from mobile cams
                          $exif = exif_read_data($file_name);
                          if (!empty($exif['Orientation'])) {
                              switch ($exif['Orientation']) {
                              case 3:
                                  $dst = imagerotate($dst, 180, 0);
                                  break;
                              case 6:
                                  $dst = imagerotate($dst, -90, 0);
                                  break;
                              case 8:
                                  $dst = imagerotate($dst, 90, 0);
                                  break;
                              }
                          }
                          switch ($mime) {
                          case 'image/jpeg':
                              imagejpeg( $dst, $target_filename ); // adjust format as needed
                              break;
                          case 'image/JPEG':
                              imagejpeg( $dst, $target_filename ); // adjust format as needed
                              break;
                          case 'image/jpg':
                              imagejpeg( $dst, $target_filename ); // adjust format as needed
                              break;
                          case 'image/JPG':
                              imagejpeg( $dst, $target_filename ); // adjust format as needed
                              break;
                          case 'image/png':
                              imagepng( $dst, $target_filename ); // adjust format as needed
                              break;
                          case 'image/PNG':
                              imagepng( $dst, $target_filename ); // adjust format as needed
                              break;
                          case 'image/gif':
                              imagegif( $dst, $target_filename ); // adjust format as needed
                              break;
                          case 'image/GIF':
                              imagegif( $dst, $target_filename ); // adjust format as needed
                              break;
                          default: 
                              throw new Exception('Unknown image type.');
                          }
                          imagedestroy( $dst );
                      }
                  }
                  if(in_array($ext, $valid_ext)){

                      // Do some things with additionale file extenstions like PDF, Excel, Word ....
;
                  }
                  else{
                      // If file extensions is not allowed set error
                       $data['upload_err'] = _ext_err;
                  }
                  // Validate => There was an error, print it
                  if(!empty($data['upload_err'])){
                      flash('file_upload_message', _problems_info . '</br>' . $data['upload_err'], $class = 'alert alert-danger');
                  }       
                  // Validate => If everything is fine and no erros was set
                  if(empty($data['upload_err'])){

                          // Upload file by ftp
                          if(move_uploaded_file($_FILES['logo']['tmp_name'],$target_directory."/".$shafilename)){
                              // Prepare Data to Model
                              $data = [
                                  'id' => $id,
                                  'image' => 'uploads/'.$id.'/'.$shafilename, //ToolID
                                  'imagename' => $shafilename,
                                  'upload_err' => ''
                                ];
                                // Push Filenames to array
                                array_push($uploaded_files, $filename);
                                // $count++;
                                // Send to Model
                                $this->userModel = $this->model('User');
                                $this->userModel->fileUpload($data);  
                          }
                      }
                } 
        flash('tool_upload_message', _upload_success . json_encode($uploaded_files), $class = 'alert alert-success');
      } // End if Server method is post
      } 
  }
