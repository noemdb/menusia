<?include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){ $temp_usuario='';} else {$temp_usuario=$_GET["GUsuario"];}  $prev_modulo="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");

$sql="Select campo601, campo701, campo702, campo703, campo704, campo705, campo607, campo608, campo609, campo610, campo611, campo612, campo613, campo614, campo615, campo616, campo617, campo618, campo619, campo620, campo621, campo622, campo623, campo624, campo625, campo626, campo706, campo707, campo708, campo709, campo710, campo711, campo712, campo713, campo714, campo715, campo716, campo717, campo718, campo719, campo720, campo721, campo722, campo723, campo724, campo725  FROM SIA007,SIA006 where (SIA006.campo602=SIA007.campo701) And (SIA006.campo603=SIA007.campo702) And (SIA006.campo601 ='$temp_usuario') Order By campo701,campo702";
if($temp_usuario==''){ $sql="Select campo601, campo701, campo702, campo703, campo704, campo705, campo607, campo608, campo609, campo610, campo611, campo612, campo613, campo614, campo615, campo616, campo617, campo618, campo619, campo620, campo621, campo622, campo623, campo624, campo625, campo626, campo706, campo707, campo708, campo709, campo710, campo711, campo712, campo713, campo714, campo715, campo716, campo717, campo718, campo719, campo720, campo721, campo722, campo723, campo724, campo725  FROM SIA007,SIA006 where (SIA006.campo602=SIA007.campo701) And (SIA006.campo603=SIA007.campo702)  Order By campo601,campo701,campo702";}
$res=pg_query($sql); $prev_usuario="";
while($reg=pg_fetch_array($res)){ $campo701=$reg["campo701"];  $campo601=$reg["campo601"];

  if($prev_usuario<>$campo601) { $prev_usuario=$campo601;
     $sql1="Select * from SIA001 WHERE campo101='$prev_usuario'";  $res1=pg_query($sql1);
     if ($registro1=pg_fetch_array($res1,0)){ $nombre=$registro1["campo104"]; }
	 echo " ","<br>";
	 echo " ","<br>";
     echo "USUARIO : ".$prev_usuario."   NOMBRE: ".$nombre,"<br>";
  }	 
  if($prev_modulo<>$campo701) { $prev_modulo=$campo701;
    echo " ","<br>";
	if($campo701=="01"){  echo "ORDENAMIENTO DE PAGOS","<br>"; }
	if($campo701=="02"){  echo "CONTROL BANCARIO","<br>"; }
	if($campo701=="03"){  echo "CONTABILIDAD","<br>"; }
	if($campo701=="04"){  echo "NOMINA Y PERSONAL","<br>"; }
	if($campo701=="05"){  echo "CONTABILIDAD PRESUPUESTARIA","<br>"; }
	if($campo701=="06"){  echo "CONTABILIDAD","<br>"; }
	if($campo701=="07"){  echo "CONTROL DE INGRESOS","<br>"; }
	if($campo701=="09"){  echo "COMPRAS,SERVICIOS Y ALMACEN","<br>"; }
	if($campo701=="13"){  echo "CONTROL DE BIENES NACIONALES","<br>"; }
  }
  $macceso="";
  if(($reg["campo607"]=="S")and($reg["campo706"]<>"")){ $macceso=$macceso.$reg["campo706"].", ";}
  if(($reg["campo608"]=="S")and($reg["campo707"]<>"")){ $macceso=$macceso.$reg["campo707"].", ";}
  if(($reg["campo609"]=="S")and($reg["campo708"]<>"")){ $macceso=$macceso.$reg["campo708"].", ";}
  if(($reg["campo610"]=="S")and($reg["campo709"]<>"")){ $macceso=$macceso.$reg["campo709"].", ";}
  if(($reg["campo611"]=="S")and($reg["campo710"]<>"")){ $macceso=$macceso.$reg["campo710"].", ";}
  if(($reg["campo612"]=="S")and($reg["campo711"]<>"")){ $macceso=$macceso.$reg["campo711"].", ";}
  if(($reg["campo613"]=="S")and($reg["campo712"]<>"")){ $macceso=$macceso.$reg["campo712"].", ";}
  if(($reg["campo614"]=="S")and($reg["campo713"]<>"")){ $macceso=$macceso.$reg["campo713"].", ";}
  if(($reg["campo615"]=="S")and($reg["campo714"]<>"")){ $macceso=$macceso.$reg["campo714"].", ";}
  if(($reg["campo616"]=="S")and($reg["campo715"]<>"")){ $macceso=$macceso.$reg["campo715"].", ";}
  if(($reg["campo617"]=="S")and($reg["campo716"]<>"")){ $macceso=$macceso.$reg["campo716"].", ";}
  if(($reg["campo618"]=="S")and($reg["campo717"]<>"")){ $macceso=$macceso.$reg["campo717"].", ";}
  echo $reg["campo703"]."; OPCIONES: ".$macceso,"<br>";
}
pg_close();
?>