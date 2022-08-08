<?php 

trait Uploader {
    public function photo_uploader(iterable $data){
        if($data['error'] > 0 ) {
            $_SESSION['error'] = 'deine Eingaben sind leider falsch';
        }
       
        $name = $data['name'];
        $array = explode('.', $name);
        $ext = end($array);
        $valid_ext = ['jpg','png','jpeg'];
        if(!in_array($ext, $valid_ext)){
            $_SESSION['error'] = 'es dürfen nur jpg, png, jpeg hochgeladen werden';
            return false;
        }
        $new_name = md5(uniqid().rand(9999,9999999)).'.'.$ext;
        // upload in Verzeichnis 
        $upload_dir = "uploads/";
        $path = $upload_dir.$new_name;
    
        if(move_uploaded_file($data['tmp_name'],$path)){
            return $new_name;
        }else{
            $_SESSION['error'] = "Hochladen ist leider gescheitert";
            return false;
        }
        
    }
}