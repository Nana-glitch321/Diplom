<?php
$generated_image = imagecreate(32, 32);
imagecolorallocate($generated_image, 0, 255, 0);  // #00FF00 Green

$text_color = imagecolorallocate($generated_image, 0, 0, 255); // #0000FF Blue
imagestring($generated_image, 5, 12, 8,  '!', $text_color);

header('Content-Type: image/png');
imagepng($generated_image); // Write binary data to output stream
imagedestroy($generated_image); // Ensure memory is freed
