<?php
 
include (APPROOT .'/libraries/phpqrcode/qrlib.php');
 class QRCodeController {
	
    public static function generateQr($id, $tool_id)
	{

          $tempDir = PUBLICPATH."/uploads/qrcode/".$id."/";
          $fileName = $tool_id.'.png';

          if(!is_dir($tempDir)){
            mkdir($tempDir, 0755, true);
            }

          $pngAbsoluteFilePath = $tempDir . $fileName;
          $urlRelativeFilePath = URLROOT."/file.php?path=/uploads/qrcode/".$id."/" . $fileName;

          QRcode::png( URLROOT .'/'.$id, $pngAbsoluteFilePath, 'H', 4, 2);

		return true;
	}
}

?>