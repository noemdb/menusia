<?php
$out_file="";$lineap=""; $salto="\n"; $nro_pages=0; $max_lines=65; $max_col=80; $nro_lines=0; $nlines_top=2; $nlines_bot=2;
function next_page(){global $max_lines; global $salto; global $nro_lines; global $nlines_top; global $nlines_bot;   $temp1=" ";
  $n=$max_lines-$nlines_top-$nlines_bot; $n=$max_lines;   if($nro_lines>$n){$m=0;} else { $m=$n-$nro_lines; }
  for ($i=0;$i<=$m;$i++){echo $temp1.$salto; }	
  $nro_lines=0; encabezado(); 
}
function print_last_page(){global $max_lines; global $salto; global $nro_lines; global $nlines_top; global $nlines_bot;   $temp1=" ";
  $n=$max_lines-$nlines_top-$nlines_bot; $n=$max_lines;   if($nro_lines>$n){$m=0;} else { $m=$n-$nro_lines; }
  for ($i=0;$i<$m;$i++){echo $temp1.$salto; }	
  $nro_lines=0; 
}
function print_line($lineap){global $max_lines; global $salto; global $nro_lines; global $nlines_top; global $nlines_bot;    $n=$max_lines-$nlines_top-$nlines_bot;
  if ($nro_lines>=$n){  next_page();   }
  $nro_lines=$nro_lines+1;  echo $lineap.$salto;
} 
function centrar_linea($texto,$col){  $valor=$texto;  $l=strlen($texto);
  if($l<$col){ $valor="";	$e=$col-$l; $n=$e/2; $n=round($n,0);
    for ($i=0; $i<$n; $i++){$valor=$valor." ";}     $valor=$valor.$texto; $n=$e-$n;    for ($i=0; $i<$n; $i++){$valor=$valor." ";}	
  }	
return $valor;}
function blanks($col){ $valor="";
	for ($i=0; $i<$n; $i++){$valor=$valor." ";}
return $valor;}	
function  print_multi_line($texto,$long_line){
  $part1=$texto; $part2=' '; $l=strlen($part1); if($l>$long_line)  {$part1=substr($texto,0,$long_line); }     $lp=strlen($part1);  $c2=$lp; $care="N"; 
  if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part1,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part1=substr($texto,0,$c2); }  
  if(substr($texto,$c2,1)==' '){$c2=$c2+1;}
  $part2=substr($texto,$c2,$long_line);  $lp2=strlen($part2);  $c3=$lp+$lp2; $l3=$lp+$lp2;
  if($l>=$l3){ for($h=$lp2-1; $h>0; $h--){  $care=substr($part2,$h,1); if($care==" ") {$c3=$h; $h=0; } }  $part2=substr($texto,$c2,$c3); }   
  $c3=strlen($part1)+strlen($part2)+1;  $part3=''; $l3=$c3;
  if($l>=$l3){ if(substr($texto,$c3,1)==' '){$c3=$c3+1;}  
  $part3=substr($texto,$c3,$long_line);  $lp3=strlen($part3);  $c4=$lp+$lp2+$lp3; $l4=$lp+$lp2+$lp3; 
  if($l>=$l4){ for($h=$lp3-1; $h>0; $h--){  $care=substr($part3,$h,1); if($care==" ") {$c4=$h; $h=0; } }  $part3=substr($texto,$c3,$c4); }    }
  $l4=strlen($part1)+strlen($part2)+strlen($part3)+2; $c4=$l4;
  $part4=''; if($l>=$l4){ if(substr($texto,$c4,1)==' '){$c4=$c4+1;} $part4=substr($texto,$c4,$long_line);}  
  $lineap=$part1;  print_line($lineap);  if($part2<>""){ $lineap=$part2;  print_line($lineap);} if($part3<>""){ $lineap=$part3;  print_line($lineap);} if($part4<>""){ $lineap=$part4;  print_line($lineap);}
}
function build_print($texto,$n){  $l=strlen($texto); if($l<$n){$m=$n-$l;}else{$m=$n;}
 for ($i=0; $i<=$m; $i++){$texto=$texto." ";}  $p=$n; $valor=substr($texto,0,$p);
return $valor;}
function build_print_r($texto,$n){  $l=strlen($texto); if($l<$n){$m=$n-$l;}else{$m=0;}
 for ($i=0; $i<=$m; $i++){$texto=" ".$texto;}  $p=$n; $valor=substr($texto,1,$p);
return $valor;}
?>