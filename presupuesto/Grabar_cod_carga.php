<?include ("../class/conect.php"); include ("../class/funciones.php");
$MControl = array (0,0,0,0,0,0,0,0,0,0);
function BUSCAR_ACTUAL($Clave, $Formato){  global $MControl;
  $j=0;   for ($i=0; $i<10; $i++) {$MControl[$i]=0;}
  for ($i=0; $i<strlen($Formato); $i++) {if (substr($Formato,+$i, 1) == "-") {$j++;} else{$MControl[$j]++;} }
  $Ultimo=$j;$k=$MControl[0];
  for ($i=1; $i<10; $i++) {if ($MControl[$i] == 0) {$MControl[$i]=0;} else { $j=$MControl[$i]+$k; $MControl[$i]=$j+1; $k=$MControl[$i];}}
  for ($i=1; $i<10; $i++) {if ($MControl[$i] < 0) {$MControl[$i]=0;}}   $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($Clave) == $MControl[$i]){$actual=$i; $i=10;} }
  if ($actual==-1){?><script language="JavaScript">muestra('ERROR Longitud del Código Invalido <? echo $Clave ?>');</script><? }
  return $actual;
}
?>
<?php
$formato_presup="XX-XX-XX-XX-XXX-XX-XX-XX"; $formato_categoria="XX-XX-XX"; $formato_partida="XXX-XX-XX-XX";
$codigo=$_GET["codigo"]; $SIA_Definicion=substr($codigo,0,1);
$cod_fuente=substr($codigo,1,2);$cod_categoria=substr($codigo,3,20); $url="Act_codigos.php?Gcodigo=U";
echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql);
  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];}
  $cod_presup=$formato_presup; $a=BUSCAR_ACTUAL($cod_presup,$formato_presup);
  $cod_presup=$formato_categoria;  $b=BUSCAR_ACTUAL($cod_presup,$formato_presup);
  $l=strlen($formato_presup);  $c=strlen($formato_categoria);$p=strlen($formato_partida);  $error=0;
  if ($error==0){ $sql="SELECT * FROM PRE032 where cod_categoria='$cod_categoria' and cod_fuente='$cod_fuente' order by cod_presup";  $res=pg_query($sql);
     while($registro=pg_fetch_array($res)){ $monto=$registro["asignado"];
       $cod_presup=$registro["cod_presup"];  $denominacion=$registro["denominacion"];
       $cod_contable=$registro["cod_contable"]; $func_inv=$registro["func_inv"];  $aplicacion=$registro["aplicacion"]; $status_dist="1";
       if(strlen($cod_presup)==strlen($formato_presup)){
       $sSQL="Select * from pre001 WHERE cod_presup='$cod_presup' and cod_fuente='$cod_fuente'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
       if ($filas>0){$error=1;}
        else{$error=0;   $asignado=$monto;
          If($asignado==0){$f=0;}else{$f=($asignado/12);$f=FNRTD($f);}
          $disponible=0;$diferido=0;$disp_diferida=0;
          $asignado01=$f;$asignado02=$f;$asignado03=$f;$asignado04=$f;$asignado05=$f;$asignado06=$f;
          $asignado07=$f;$asignado08=$f;$asignado09=$f;$asignado10=$f;$asignado11=$f;$asignado12=$f;
          $monto=$asignado01+$asignado02+$asignado03+$asignado04+$asignado05+$asignado06+$asignado07+$asignado08+$asignado09+$asignado10+$asignado11+$asignado12;
          if($monto!=$asignado){  $f=round($f,2); $t=$asignado-$monto;  $t=round($t,2);  $f=$f+$t;$asignado12=$f;  }
          $monto=formato_numero($monto);$asignado01=formato_numero($asignado01);$asignado02=formato_numero($asignado02);$asignado03=formato_numero($asignado03);$asignado04=formato_numero($asignado04);$asignado05=formato_numero($asignado05);$asignado06=formato_numero($asignado06);
          $asignado07=formato_numero($asignado07);$asignado08=formato_numero($asignado08);$asignado09=formato_numero($asignado09);$asignado10=formato_numero($asignado10);$asignado11=formato_numero($asignado11);$asignado12=formato_numero($asignado12);

		  $disponible=$asignado;$diferido=0;$disp_diferida=0; $fecha=asigna_fecha_hoy();
          if($fecha==""){$sfecha="2007-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
          $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE001(1,'$cod_presup','$cod_fuente','$denominacion','$cod_contable','$status_dist',$asignado,$disponible,$diferido,$disp_diferida,'$func_inv','O','$aplicacion','','$sfecha',$asignado01,$asignado02,$asignado03,$asignado04,$asignado05,$asignado06,$asignado07,$asignado08,$asignado09,$asignado10,$asignado11,$asignado12)");
          $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
          else{
            for ($i=$a-1; $i>$b; $i--) { $l=$MControl[$i]; $temp_cuenta=substr($cod_presup,0,$l);
              $sSQL="Select * from pre001 WHERE cod_presup='$temp_cuenta'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
              if ($filas==0){$temp_partida=substr($cod_presup,$c+1,$l-$c-1);
                 $sSQL="Select * from PRE098 WHERE cod_partida='$temp_partida'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
                 if ($filas==0){$f=0;}else{$registro=pg_fetch_array($resultado);   $den_partida=$registro["den_partida"];  $func_inv=$registro["func_inv"];$aplicacion=$registro["aplicacion"];}
                 $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE001(1,'$temp_cuenta','00','$den_partida','','1',0,0,0,0,'$func_inv','O','$aplicacion','','$sfecha',0,0,0,0,0,0,0,0,0,0,0,0)");
                 $error=pg_errormessage($conn);
              }
            }
          }
       }}
     }
  }
}
pg_close();?>
<script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>