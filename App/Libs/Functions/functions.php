<?php

function mb_ucfirst($string, $encoding = 'UTF-8')
{
    $strlen = mb_strlen($string, $encoding);
    $firstChar = mb_substr($string, 0, 1, $encoding);
    $then = mb_substr($string, 1, $strlen - 1, $encoding);
    return mb_strtoupper($firstChar, $encoding) . $then;
}

function isCountry($name)
{
    $xml = new SimpleXMLElement(file_get_contents(CONTENT . 'country.xml'));
    foreach ($xml->country as $country) {
        if ($name == $country->name) {
            return true;
        }
    }
    return false;
}

function isFace($image_path)
{
    $face_detect = new svay\FaceDetector(CONTENT . 'detection.dat');
    $detect = $face_detect->faceDetect($image_path);
//    $face_detect->toJpeg();
//    $json = $face_detect->toJson();
//    $array = $face_detect->getFace();
    if (empty($detect)) {
        return false;
    }
    return true;
}
