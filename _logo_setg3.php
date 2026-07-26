<?php
$brandDir = __DIR__.'/storage/app/public/brand';
$src = imagecreatefrompng("$brandDir/logo-g3.png");
$gw = imagesx($src);
function mc($s){$c=imagecreatetruecolor($s,$s);imagealphablending($c,false);imagesavealpha($c,true);imagefilledrectangle($c,0,0,$s,$s,imagecolorallocatealpha($c,0,0,0,127));return $c;}
function sw($si,$ss,$t,$p,$q=88){$c=mc($t);imagealphablending($c,false);imagecopyresampled($c,$si,0,0,0,0,$t,$t,$ss,$ss);imagewebp($c,$p,$q);imagedestroy($c);}
copy("$brandDir/logo-g3.png","$brandDir/logo-light.png");
copy("$brandDir/logo-g3.png","$brandDir/logo-light@2x.png");
sw($src,$gw,512,"$brandDir/logo-light.webp");
sw($src,$gw,1024,"$brandDir/logo-light@2x.webp");
echo "white-theme logo set to g3 (golden #977228)\n";
