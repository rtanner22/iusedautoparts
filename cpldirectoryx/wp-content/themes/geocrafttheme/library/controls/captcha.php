<?php
// Captcha image size
$imageWidth = 220;
$imageHeight= 40;

// Number of characters in captcha image - captcha length
$charsNumber=8;
// Random characters array
$characters=array_merge(range(0,9),range('A','Z'));
// Shuffle the array a little bit :)
shuffle($characters);

// Create captcha image
$captchaImage = imageCreateTrueColor($imageWidth, $imageHeight);
$bg = imageColorAllocate($captchaImage, 243, 243, 243);
imagefill($captchaImage, 0, 0, $bg);

// Set noisy background :) - set random color for each pixel in the image
// For each pixel in the image...
/*for ( $pixelX=0; $pixelX < $imageWidth; $pixelX++) {
	for ( $pixelY=0; $pixelY < $imageHeight; $pixelY++) {
		// ... generate random pixel color					  // R			  // G			  // B
		$randomPixelColor = imageColorAllocate($captchaImage, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
		// Set captcha's background pixel color
		imageSetPixel( $captchaImage, $pixelX, $pixelY , $randomPixelColor);
	}
}*/

// Captcha text generation
$captchaText = "";	// Full captcha text

// This is the step by which we increase the point of writing each random letter
// to the captcha image.
$charImageStep = $imageWidth/($charsNumber+2);

// Current point in image width where we will write captcha character
$charWritePoint= $charImageStep;

// Write captcha characters to the image
for( $i=0; $i < $charsNumber; $i++) {
	// Get the random character from shuffeled characters array
	$nextChar = $characters[mt_rand(0, count($characters)-1)];
	// join character to captcha string
	$captchaText .= $nextChar;
	
	// Write next char to image
	// Font properties
	$randomFontSize = 15;	// Random character size to spice things a little bit :)
	$randomFontAngle = 16;	// Twist the character a little bit
	$fontType = "fonts/Sansation_Bold.ttf";	// This is the font we are using - we need to point to the ttf file here
	
	// Pixels
	$pixelX = $charWritePoint; // We will write a character at this X point
	//$pixelY = mt_rand($imageHeight/2, $imageHeight - $randomFontSize); // We will write a character at this Y point
	$pixelY = 30;
	// Random character color								  // R			  // G			  // B			  // Alpha
	//$randomCharColor = imageColorAllocateAlpha($captchaImage, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255), mt_rand(0,25));
$fg = imagecolorallocate($captchaImage, 1, 1, 1);//text color white	
	// Write a character to the image
	imageTtfText($captchaImage, $randomFontSize, $randomFontAngle, $pixelX, $pixelY, $fg, $fontType, $nextChar);
	
	// Increase captcha step
	$charWritePoint += $charImageStep;
}

// Add captcha text to session
session_start();
// Add currently generated captcha text to the session
$_SESSION['captcha'] = $captchaText;

// Return the image
return imagePng($captchaImage);
// Destroy captcha image
imageDestroy($captchaImage);
?>