<?php  $gen_comprob=$_GET["gencomp"]; $codigo_mov=$_GET["codigo_mov"];
 if($gen_comprob=='SI'){?>
  <iframe src="../presupuesto/Det_inc_comp_caus.php?codigo_mov=<?echo $codigo_mov?>"  width="850" height="220" scrolling="auto" frameborder="1">
  </iframe>
  <? }else{?>&nbsp;<? }?>