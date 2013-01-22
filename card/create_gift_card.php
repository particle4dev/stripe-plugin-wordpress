<?php

function create_gift_card($img_bg,$to,$from,$money,$note,$gift_code){
	require_once(STRIPE_BASE_DIR . '/card/captcha/captcha.php');
	$outputImage = imagecreatefromjpeg($img_bg);
	
	// Draw a white rectangle	
	$white = imagecolorallocate($outputImage, 255, 255, 255);
	imagefilledrectangle($outputImage, 450, 415, 675, 510, $white);

	$captcha = new SimpleCaptcha();
	if($gift_code == 0){
		$captcha->CreateImage();
		imagecopymerge($outputImage,$captcha->im,470,425,0,0, 200, 70,100);
	}
	else{
		
		require_once(STRIPE_BASE_DIR . '/card/barcode/class/BCGFontFile.php');
		require_once(STRIPE_BASE_DIR . '/card/barcode/class/BCGColor.php');
		require_once(STRIPE_BASE_DIR . '/card/barcode/class/BCGDrawing.php');


		// Including the barcode technology
		require_once(STRIPE_BASE_DIR . '/card/barcode/class/BCGcode39.barcode.php');

		// Loading Font
		$font = new BCGFontFile(STRIPE_BASE_DIR . '/card/barcode/font/Arial.ttf', 18);

		$text = $captcha->GetCaptchaText();

		// The arguments are R, G, B for color.
		$color_black = new BCGColor(0, 0, 0);
		$color_white = new BCGColor(255, 255, 255);

		$drawException = null;
		try {
			$code = new BCGcode39();
			$code->setScale(2); // Resolution
			$code->setThickness(30); // Thickness
			$code->setForegroundColor($color_black); // Color of bars
			$code->setBackgroundColor($color_white); // Color of spaces
			$code->setFont($font); // Font (or 0)
			$code->parse($text); // Text
		} catch(Exception $exception) {
			$drawException = $exception;
		}

		/* Here is the list of the arguments
		1 - Filename (empty : display on screen)
		2 - Background color */
		$drawing = new BCGDrawing('', $color_white);
		if($drawException) {
			$drawing->drawException($drawException);
		} else {
			$drawing->setBarcode($code);
			$drawing->draw();
		}

		imagecopymerge($outputImage,$drawing->get_im(),470,425,0,0, $drawing->getW(), $drawing->getH(),100);
	}
	// Make the background transparent
	$black = imagecolorallocate($outputImage, 0, 0, 0);
	imagecolortransparent($outputImage, $black);


	$b = imagecolorallocate($outputImage, 131, 80, 42);
	$yellow = imagecolorallocate($outputImage, 186, 148, 52);

	$font = STRIPE_BASE_DIR . '/card/arial.ttf';
	$font_static = STRIPE_BASE_DIR . '/card/Allura-Regular.ttf';
	$font_d = STRIPE_BASE_DIR . '/card/GreatVibes-Regular.otf';
	$y = 250;
	imagettftext($outputImage, 32, 0, 340, $y, $yellow, $font_static, "To");
	$outputImage = print_line($outputImage,$to,20,480,$y,$font_d,20,$b);

	imagettftext($outputImage, 32, 0, 340, $y, $yellow, $font_static, "From");
	$outputImage = print_line($outputImage,$from,20,480,$y,$font_d,20,$b);
	
	imagettftext($outputImage, 32, 0, 340, $y, $yellow, $font_static, "Amount");
	$outputImage = print_line($outputImage,$money."$",20,480,$y,$font_d,20,$b);
	
	imagettftext($outputImage, 32, 0, 340, $y, $yellow, $font_static, "Note");
	$outputImage = print_line($outputImage,$note,23,480,$y,$font_d,15,$b,29);

	//header("Content-type: image/jpeg"); 
	$name = STRIPE_BASE_DIR . '/card/captcha/card-gift'.time().'.jpg';	  
	
	//imagejpeg($captcha->im,$name,80);
	imagejpeg($outputImage,$name);
	
	//file_put_contents($name , file_get_contents($outputImage));
	imagedestroy($outputImage);
	if($gift_code == 0){
		$captcha->Cleanup();
	}
	//unset($_SESSION['captcha']);
	return $name;
}
function print_line($source_img,$text,$len,$x,&$y,$font,$font_size,$font_color,$line_height = 33){
	// Break it up into pieces 125 characters long
	$lines = explode('|', wordwrap($text, $len, '|'));

	// Starting Y position

	// Loop through the lines and place them on the image
	foreach ($lines as $line)
	{
	    imagettftext($source_img, $font_size, 0, $x, $y, $font_color, $font, $line);

	    // Increment Y so the next line is below the previous line
	    $y += $line_height;
	}
	return $source_img;
}
