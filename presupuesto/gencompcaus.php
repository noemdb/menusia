<?php  $gen_comprob=$_GET["gencomp"]; $codigo_mov=$_GET["codigo_mov"];
 if($gen_comprob=='SI'){?>
  <iframe src="Det_inc_comp_caus.php?codigo_mov=<?echo $codigo_mov?>"  width="850" height="250" scrolling="auto" frameborder="1">
  </iframe>
  <table width="870" border="0">   <tr>     <td width="864" height="5">&nbsp;</td>   </tr>
  </table>
  <? }else{?>&nbsp;<? }?>