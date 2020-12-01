<?php
// Nova Função permite JPEG/JPG/PNG/GIF
function resize($newWidth, $targetFile, $originalFile) {
    $info = getimagesize($originalFile);
    $mime = $info['mime'];

    switch ($mime) {
            case 'image/jpeg':
                    $image_create_func = 'imagecreatefromjpeg';
                    $image_save_func = 'imagejpeg';
                    $new_image_ext = 'jpg';
                    break;

            case 'image/png':
                    $image_create_func = 'imagecreatefrompng';
                    $image_save_func = 'imagepng';
                    $new_image_ext = 'png';
                    break;

            case 'image/gif':
                    $image_create_func = 'imagecreatefromgif';
                    $image_save_func = 'imagegif';
                    $new_image_ext = 'gif';
                    break;

            default:
                    throw new Exception('Unknown image type.');
    }

    $img = $image_create_func($originalFile);
    list($width, $height) = getimagesize($originalFile);

    $newHeight = ($height / $width) * $newWidth;
    $tmp = imagecreatetruecolor($newWidth, $newHeight);
    /* Checando se a imagem é PNG ou GIF, então seta como transparent*/
    if(($mime == 'image/png') OR ($mime=='image/gif')){
      imagealphablending($tmp, false);
      imagesavealpha($tmp,true);
      $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
      imagefilledrectangle($tmp, 0, 0, $newWidth, $newHeight, $transparent);
    }
    imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    if (file_exists($targetFile)) {
      unlink($targetFile);
    }
    if(is_animated_gif($originalFile)!= TRUE ){
      $image_save_func($tmp, "$targetFile.$new_image_ext");
    }else{
      move_uploaded_file($originalFile, $targetFile.".".$new_image_ext);
    }

    // echo $targetFile.$new_image_ext;
}
/**
* Detects animated GIF from given file pointer resource or filename.
*
* @param resource|string $file File pointer resource or filename
* @return bool
*/
function is_animated_gif($file){
    $fp = null;

    if (is_string($file)) {
        $fp = fopen($file, "rb");
    } else {
        $fp = $file;

        /* Make sure that we are at the beginning of the file */
        fseek($fp, 0);
    }

    if (fread($fp, 3) !== "GIF") {
        fclose($fp);

        return false;
    }

    $frames = 0;

    while (!feof($fp) && $frames < 2) {
        if (fread($fp, 1) === "\x00") {
            /* Some of the animated GIFs do not contain graphic control extension (starts with 21 f9) */
            if (fread($fp, 1) === "\x21" || fread($fp, 2) === "\x21\xf9") {
                $frames++;
            }
        }
    }

    fclose($fp);

    return $frames > 1;
}
