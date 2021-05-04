<?php

class IMGBB
{

    function uploadImage($image,$name = null){
        $API_KEY = IMGBB_API_KEY;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.imgbb.com/1/upload?key='.$API_KEY);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
        //$extension = pathinfo(time(),PATHINFO_EXTENSION);
        $file_name = time() ;
        $data = array('image' => $this->insert_base64_encoded_image($image), 'name' => $file_name);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return 'Error:' . curl_error($ch);
        }else{
            return json_decode($result, true);
        }
    }

    function insert_base64_encoded_image($img, $echo = false){
        $imageSize = getimagesize($img);
        $imageData = base64_encode(file_get_contents($img));
        return $imageData;
    }

}