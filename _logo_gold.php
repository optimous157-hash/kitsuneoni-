<?php
$src = __DIR__.'/storage/app/public/brand/logo.png';
$brandDir = __DIR__.'/storage/app/public/brand';
$in = imagecreatefrompng($src);
$W=imagesx($in);$H=imagesy($in);
$maxL=1;
for($x=0;$x<$W;$x++)for($y=0;$y<$H;$y++){$b=imagecolorat($in,$x,$y)&0xFF;if($b>$maxL)$maxL=$b;}
// Golden ramps: warm gold, not brown. g1 lighter, g2 medium, g3 deeper (more visible on white)
$ramps = [
  'g1' => [[0x6e,0x51,0x1f],[0xb8,0x8f,0x3e],[0xe8,0xc9,0x7a]], // bright gold
  'g2' => [[0x5a,0x42,0x14],[0xa6,0x7d,0x2c],[0xd8,0xb6,0x5e]], // medium gold
  'g3' => [[0x47,0x33,0x0e],[0x92,0x6c,0x22],[0xc4,0x9c,0x4a]], // deep gold (visible on white)
];
function lerp($a,$b,$t){return [(int)round($a[0]+($b[0]-$a[0])*$t),(int)round($a[1]+($b[1]-$a[1])*$t),(int)round($a[2]+($b[2]-$a[2])*$t)];}
function rampC($r,$t){return $t<0.5?lerp($r[0],$r[1],$t/0.5):lerp($r[1],$r[2],($t-0.5)/0.5);}
$floor=0.10;
function build($in,$W,$H,$maxL,$ramp,$floor){
  $out=imagecreatetruecolor($W,$H);imagealphablending($out,false);imagesavealpha($out,true);
  imagefilledrectangle($out,0,0,$W,$H,imagecolorallocatealpha($out,0,0,0,127));
  $lut=[];
  for($i=0;$i<=255;$i++){$l=$i/255;if($l<=$floor){$lut[$i]=null;continue;}$t=($l-$floor)/(1-$floor);$gdA=127-(int)round(min(1,$t*1.3)*127);$c=rampC($ramp,$t);$lut[$i]=imagecolorallocatealpha($out,$c[0],$c[1],$c[2],$gdA);}
  for($x=0;$x<$W;$x++)for($y=0;$y<$H;$y++){$idx=(int)round((imagecolorat($in,$x,$y)&0xFF)/$maxL*255);$c=$lut[$idx];if($c===null)continue;imagesetpixel($out,$x,$y,$c);}
  return $out;
}
function mc($s){$c=imagecreatetruecolor($s,$s);imagealphablending($c,false);imagesavealpha($c,true);imagefilledrectangle($c,0,0,$s,$s,imagecolorallocatealpha($c,0,0,0,127));return $c;}
function sp($si,$ss,$t,$p){$c=mc($t);imagealphablending($c,false);imagecopyresampled($c,$si,0,0,0,0,$t,$t,$ss,$ss);imagepng($c,$p,9);imagedestroy($c);}
foreach($ramps as $name=>$ramp){
  $img=build($in,$W,$H,$maxL,$ramp,$floor);
  sp($img,$W,512,"$brandDir/logo-$name.png");
  // luminance readout
  $sr=0;$sg=0;$sb=0;$n=0;
  for($k=0;$k<4000;$k++){$x=rand(0,$W-1);$y=rand(0,$W-1);$c=imagecolorat($img,$x,$y);$a=($c>>24)&0x7F;$r=($c>>16)&0xFF;$g=($c>>8)&0xFF;$b=$c&0xFF;if($a<64){$sr+=$r;$sg+=$g;$sb+=$b;$n++;}}
  $L=(0.299*$sr+0.587*$sg+0.114*$sb)/$n;
  printf("%s: #%02x%02x%02x lum=%.0f (%s)\n",$name,(int)($sr/$n),(int)($sg/$n),(int)($sb/$n),$L,($L<60?'EXCELLENT':($L<110?'GOOD':'MODERATE')).' on white');
  imagedestroy($img);
}
echo "golden variants g1,g2,g3 generated\n";
