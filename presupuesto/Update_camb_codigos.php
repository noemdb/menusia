<?include ("../class/conect.php");  include ("../class/funciones.php"); $MControl=array(0,0,0,0,0,0,0,0,0,0);
function BUSCAR_ACTUAL($Clave,$Formato){  global $MControl;    $j=0;
  for ($i=0; $i<strlen($Formato); $i++) {if (substr($Formato,+$i,1)=="-") {$j++;} else{$MControl[$j]++;} }  $Ultimo=$j;$k=$MControl[0];
  for ($i=1; $i<10; $i++) {if ($MControl[$i]==0) {$MControl[$i]=0;} else { $j=$MControl[$i]+$k; $MControl[$i]=$j+1; $k=$MControl[$i];}}
  for ($i=1; $i<10; $i++) {if ($MControl[$i] < 0) {$MControl[$i]=0;}}  $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($Clave)==$MControl[$i]){$actual=$i; $i=10;} }
  if ($actual==-1){?><script language="JavaScript">muestra('ERROR Longitud del CODIGO Invalido');</script><? }
  return $actual;
}
function Nivel_Cta_Valido($Clave,$Formato){  $mval=0; $e=0;
  for ($i=0; $i<strlen($Clave); $i++) {    if ((substr($Clave,$i,1)=="-")  || (substr($Clave,$i,1)==".")){if (substr($Clave,$i,1)==substr($Formato,$i,1)){$e=0;} else {$mval=1;}} }
  if ($mval==1){?><script language="JavaScript">muestra('ERROR niveles del CODIGO Invalido');</script><? }
  return $mval;
}
//function FNRTD($fmonto){  $mval=floor($fmonto*100)/100;  return $mval; }
?>
<?php
$cod_presup=$_POST["txtcod_presup"];$cod_fuente=$_POST["txtcod_fuentea"]; $denominacion=$_POST["txtdenominacion"];$cod_presupn=$_POST["txtcod_presupn"];$cod_fuenten=$_POST["txtcod_fuente"];
echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; 
$formato_presup="XX-XX-XX-XXX-XX-XX-XX"; $formato_cat="XX-XX-XX"; $equipo=getenv("COMPUTERNAME");$url="Mod_codigos.php?Gcodigo=".$cod_fuente.$cod_presup;
$url="Act_codigos.php?Gcodigo=".$cod_fuenten.$cod_presupn; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
else{ $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];}
  $sSQL="Select * from pre001 WHERE cod_presup='$cod_presup' and cod_fuente='$cod_fuente'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO NO EXISTE');  </script> <? }
   else{ $registro=pg_fetch_array($resultado); $sal_ant=$registro["disponible"]; $des_ant=$registro["denominacion"]; $asig_ant=$registro["asignado"];  $cod_cont_ant=$registro["cod_contable"]; $sfecha=$registro["fecha_creado"];}
  if(strlen($cod_presup)==strlen($formato_presup)){    
    $a=BUSCAR_ACTUAL($cod_presup,$formato_presup); $l=0;  if ($a>=0){$error=0;}else{$error=1;}
    if ($error==0){ $b=Nivel_Cta_Valido($cod_presup,$formato_presup); if ($b>0){$error=1;} }
    if ($error==0){ if ($a>0){$l=$MControl[$a-1];}
      if ($l>0){ $temp_cuenta=substr($cod_presupn,0,$l);
       $sSQL="Select * from pre001 WHERE cod_presup='$temp_cuenta'";$resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);       if ($filas==0){ $error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO NIVEL ANTERIOR NO EXISTE');</script> <? }
      }
    }
  }else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD CODIGO PRESUPUESTARIO INVALIDA');</script><?}
  if($error==0){ $sSQL="Select * from PRE095 WHERE cod_fuente_financ='$cod_fuenten'";  $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE FUENTE NO EXISTE');</script><? }}
  if($error==0){ 
    $sSQL="Select * from pre001 WHERE cod_presup='$cod_presupn' and cod_fuente='$cod_fuenten'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
    If ($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO NUEVO YA EXISTE');  </script> <? }
  }
  if($error==0){ $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2007-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
     $sqlg="SELECT CAMBIA_cod_presup('$cod_presup','$cod_fuente','$cod_presupn','$cod_fuenten')";     $resultado=pg_exec($conn,$sqlg); //echo $sqlg;	 
     $error=pg_errormessage($conn);$error=substr($error, 0, 91); if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
      else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? $error=0;
        $desc_doc="CAMBIAR CODIGO PRESUPUETARIO:".$cod_presup.", FUENTE:".$cod_fuente.", DENOMINACION:".$des_ant.", CODIGO NUEVO:".$cod_presupn.", FUENTE NUEVO:".$cod_fuenten;
        $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");  $error=pg_errormessage($conn); $error=substr($error, 0, 91);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <?}}

	  
  }	  
  
}pg_close();
/* */
if ($error==0){?><script language="JavaScript">LlamarURL('<?echo $url;?>'); </script> <? } else { ?> <script language="JavaScript">history.back();</script>  <? } 
?>
   
   