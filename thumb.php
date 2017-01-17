<?php

//Your Image
if ($_GET['f']) {
	$imgSrc = 'd/'.$_GET['f'];
	$type = substr($imgSrc, strrpos( $imgSrc , '.' )+1 );
} else {
	$imgSrc = 'd/others.png';
}

//getting the image dimensions
list($width, $height) = getimagesize($imgSrc);

//saving the image into memory (for manipulation with GD Library)
switch( $type ){
    case 'jpg' : case 'jpeg' :
      $myImage = imagecreatefromjpeg( $imgSrc ); $isimg = 'yes'; break;
    case 'png' :
      $myImage = imagecreatefrompng( $imgSrc ); $isimg = 'yes'; break;
    case 'gif' :
      $myImage = imagecreatefromgif( $imgSrc ); $isimg = 'yes'; break;
	case 'zip' :
      $defaultImg = 'd/zip.png'; break;
	case 'mp4' :
      $defaultImg = 'd/video.png'; break;
	case 'mpeg' :
      $defaultImg = 'd/video.png'; break;
	case 'm4p' :
      $defaultImg = 'd/video.png'; break;
	case 'mp3' :
      $defaultImg = 'd/audio.png'; break;
	case 'ogg' :
      $defaultImg = 'd/video.png'; break;
	case 'ai' :
      $defaultImg = 'd/illustrator.png'; break;
	case 'ps' :
      $defaultImg = 'd/photoshop.png'; break;
	case 'pdf' :
      $defaultImg = 'd/pdf.png'; break;
	default:
	  $defaultImg = 'd/others.png'; break;
  }

if ($isimg) {
	// calculating the part of the image to use for thumbnail
	if ($width > $height) {
	  $y = 0;
	  $x = ($width - $height) / 2;
	  $smallestSide = $height;
	} else {
	  $x = 0;
	  $y = ($height - $width) / 2;
	  $smallestSide = $width;
	}
	
	// copying the part into thumbnail
	$thumbSize = 300;
	$thumb = imagecreatetruecolor($thumbSize, $thumbSize);
	imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);
	
	//final output
	switch( $type ){
		case 'jpg' : case 'jpeg' :
		  header('Content-type: image/jpeg');
		  imagejpeg( $thumb ); break;
		case 'png' :
		  header('Content-type: image/png');
		  imagepng( $thumb ); break;
		case 'gif' :
		  header('Content-type: image/gif');
		  imagegif( $thumb ); break;
		default:
		  header('Content-type: image/png');
		  imagepng( $thumb ); break;
	  }
	  
} else {
	header("Content-type: image/png");
	readfile($defaultImg);
	exit;
}

?>