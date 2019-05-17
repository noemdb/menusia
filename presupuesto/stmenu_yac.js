/*
   Deluxe Menu Data File
   Created by Deluxe Tuner v3.2
   http://deluxe-menu.com
*/

// -- Deluxe Tuner Style Names
var tstylesNames=["Top Item",];
var tXPStylesNames=[];
// -- End of Deluxe Tuner Style Names

//--- Common
var tlevelDX=20;
var texpanded=0;
var texpandItemClick=0;
var tcloseExpanded=0;
var tcloseExpandedXP=0;
var ttoggleMode=1;
var tnoWrap=1;
var titemTarget="_self";
var titemCursor="pointer";
var statusString="link";
var tblankImage="../imagenes/blank.gif";
var tpathPrefix_img="";
var tpathPrefix_link="";

//--- Dimensions
var tmenuWidth="250px";
var tmenuHeight="auto";

//--- Positioning
var tabsolute=1;
var tleft="15px";
var ttop="60px";

//--- Font
var tfontStyle="normal 10pt Arial";
var tfontColor=["#3F3D3D","#7E7C7C"]; tfontColor=["#000066","#0033FF"];
var tfontDecoration=["none","underline"];
var tfontColorDisabled="#ACACAC";
var tpressedFontColor="#AA0000";

//--- Appearance
var tmenuBackColor="#E0E0E0";  tmenuBackColor="#FFFFFF";
var tmenuBackImage="back1.gif";
var tmenuBorderColor="#FFFFFF";
var tmenuBorderWidth=2;
var tmenuBorderStyle="solid";

//--- Item Appearance
var titemAlign="left";
var titemHeight=26;
var titemBackColor=["",""];
var titemBackImage=["../imagenes/blank.gif","../imagenes/blank.gif"];

//--- Icons & Buttons
var ticonWidth=21;
var ticonHeight=15;
var ticonAlign="left";
var texpandBtn=["../imagenes/expandbtn2.gif","../imagenes/expandbtn2.gif","../imagenes/collapsebtn2.gif"];
var texpandBtnW=15;
var texpandBtnH=15;
var texpandBtnAlign="left";

//--- Lines
var tpoints=1;
var tpointsImage="../imagenes/hpoint.gif";
var tpointsVImage="../imagenes/vpoint.gif";
var tpointsCImage="../imagenes/cpoint.gif";
var tpointsBImage="../imagenes/bpoint.gif";

//--- Floatable Menu
var tfloatable=1;
var tfloatIterations=10;
var tfloatableX=1;
var tfloatableY=1;

//--- Movable Menu
var tmoveable=0;
var tmoveHeight=12;
var tmoveColor="#AA0000";
var tmoveImage="";

//--- XP-Style
var tXPStyle=0;
var tXPIterations=10;
var tXPBorderWidth=1;
var tXPBorderColor="#FFFFFF";
var tXPAlign="left";
var tXPTitleBackColor="#AFB1C3";
var tXPTitleBackImg="../imagenes/xptitle_s.gif";
var tXPTitleLeft="../imagenes/xptitleleft_s.gif";
var tXPTitleLeftWidth=4;
var tXPIconWidth=31;
var tXPIconHeight=32;
var tXPMenuSpace=10;
var tXPExpandBtn=["../imagenes/xpexpand1_s.gif","../imagenes/xpexpand1_s.gif","../imagenes/xpcollapse1_s.gif","../imagenes/xpcollapse1_s.gif"];
var tXPBtnWidth=25;
var tXPBtnHeight=23;
var tXPFilter=1;

//--- Advanced
var tdynamic=0;
var tajax=0;

//--- State Saving
var tsaveState=0;
var tsavePrefix="menu1";

var tstyles = [
    ["tfontDecoration=none,none"],
];
var tXPStyles = [];



var tmenuItems = [

     ["Archivo","", "", "", "", "Menu Archivos", "", "0", "", "", ],
        ["|Codigos / Asignacion","Act_codigos.php", "", "", "", "", "", "", "", "", ],
		["|Fuentes de Financiamiento","Act_fuentes.php", "", "", "", "", "", "", "", "", ],
		["|Tipos de Aplicaciones","Act_tipo_aplica.php", "", "", "", "", "", "", "", "", ],
		["|Clasificador Presupuestario","Act_clasificador.php", "", "", "", "", "", "", "", "", ],
		["|Documentos","", "", "", "", "", "", "0", "", "", ],
            ["||Compromisos","Act_doc_compromiso.php", "", "", "", "", "", "", "", "", ],
			["||Causados","Act_doc_causado.php", "", "", "", "", "", "", "", "", ],
			["||Pagados","Act_doc_pago.php", "", "", "", "", "", "", "", "", ],
			["||Ajustes","Act_doc_ajuste.php", "", "", "", "", "", "", "", "", ],
        ["|Tipos de Compromisos","Act_tipo_compromiso.php", "", "", "", "", "", "", "", "", ],
		["|Tipos Diferidos ","Act_tipo_diferido.php", "", "", "", "", "", "", "", "", ],
		["|Regiones","Act_regiones.php", "", "", "", "", "", "", "", "", ],
		["|Entidades","Act_entidades.php", "", "", "", "", "", "", "", "", ],
		["|Municipios","Act_municipios.php", "", "", "", "", "", "", "", "", ],
		["|Cuidades","Act_ciudades.php", "", "", "", "", "", "", "", "", ],
		["|Parroquias","Act_parroquias.php", "", "", "", "", "", "", "", "", ],
		["|Beneficiarios","Act_beneficiarios.php", "", "", "", "", "", "", "", "", ],
		["|Pre-Definicion Articulos","Act_Def_Art.php", "", "", "", "", "", "", "", "", ], 
		["|Pre-Definicion Servicios","Act_Def_Serv.php", "", "", "", "", "", "", "", "", ],
    ["Procesos","", "", "", "", "Menu Procesos", "", "0", "", "", ],        
        ["|Diferido Presupuestario","Act_diferidos.php", "", "", "", "", "", "", "", "", ], 
		["|Comprometer","Act_compromisos.php", "", "", "", "", "", "", "", "", ],
		["|Causar","Act_causados.php", "", "", "", "", "", "", "", "", ],
		["|Pagar","Act_pagos.php", "", "", "", "", "", "", "", "", ],
		["|Ajuste","Act_ajustes.php", "", "", "", "", "", "", "", "", ],
		["|Modificaciones","Act_modificaciones.php", "", "", "", "", "", "", "", "", ],
    ["Reportes","", "", "", "", "Menu Reportes", "", "0", "", "", ],
        ["|+Catalogos","", "", "", "", "", "", "0", "", "", ],
            ["||Partidas","/sia/presupuesto/rpt/Rpt_Catalogo_Codigos.php", "", "", "", "", "", "", "", "", ],
            ["||Documento Compromisos","/sia/presupuesto/rpt/Rpt_documentos_comp.php", "", "", "", "", "", "", "", "", ],
            ["||Documento Causados","/sia/presupuesto/rpt/Rpt_documentos_causado.php", "", "", "", "", "", "", "", "", ],
            ["||Documento Pagos","/sia/presupuesto/rpt/Rpt_documentos_pag.php", "", "", "", "", "", "", "", "", ],
            ["||Documento Ajuste","/sia/presupuesto/rpt/Rpt_documentos_ajuste.php", "", "", "", "", "", "", "", "", ],
            ["||Tipos de Compromisos","/sia/presupuesto/rpt/Rpt_tipo_compromiso.php", "", "", "", "", "", "", "", "", ],
            ["||Tipos de Diferidos","/sia/presupuesto/rpt/Rpt_tipo_diferido.php", "", "", "", "", "", "", "", "", ],
            ["||Fuentes de Financiamiento","/sia/presupuesto/rpt/Rpt_fuente_finan.php", "", "", "", "", "", "", "", "", ],
            ["||Beneficiarios","/sia/presupuesto/rpt/Rpt_Catalogo_Beneficiarios.php", "", "", "", "", "", "", "", "", ],
        ["|Reportes de Asignacion","", "", "", "", "", "", "0", "", "", ],
            ["||Presupuestaria ","/sia/presupuesto/rpt/Rpt_Asignacion_Presupuestaria.php", "", "", "", "", "", "", "", "", ],
            ["||Presupuestaria por Partida ","/sia/presupuesto/rpt/Rpt_Asignacion_Presup_Partida.php", "", "", "", "", "", "", "", "", ],
            ["||Actualizada ","/sia/presupuesto/rpt/Rpt_Asignacion_Presup_Actualizada.php", "", "", "", "", "", "", "", "", ],
            ["||Actualizada por Partida ","/sia/presupuesto/rpt/Rpt_Asignacion_Presup_Actualizada_Partida.php", "", "", "", "", "", "", "", "", ],
		["|Reportes de Disponibilidad","", "", "", "", "", "", "0", "", "", ],
		    ["||Consulta Disponibilidad ","javascript:window.open('Consulta_dispon.php?Gcodigo=');", "", "", "", "", "", "", "", "", ],
		    ["||Actualizada ","/sia/presupuesto/rpt/Rpt_Disponibilidad_Actualizada.php", "", "", "", "", "", "", "", "", ],
            ["||Actualizada por Partida ","/sia/presupuesto/rpt/Rpt_Diponibilidad_Actualizada_Partida.php", "", "", "", "", "", "", "", "", ],
	        ["||Periodo ","/sia/presupuesto/rpt/Rpt_Disponibilidad_Periodo.php", "", "", "", "", "", "", "", "", ],       
            ["||Diaria ","/sia/presupuesto/rpt/Rpt_Disponibilidad_Diaria.php", "", "", "", "", "", "", "", "", ],
        ["|Reportes de Ejecucion","", "", "", "", "", "", "0", "", "", ],  
            ["||Presupuestaria","/sia/presupuesto/rpt/Rpt_ejecu_presup.php", "", "", "", "", "", "", "", "", ],
			["||Presupuestaria Partida","/sia/presupuesto/rpt/Rpt_ejecu_presup_part.php", "", "", "", "", "", "", "", "", ],
            ["||Resumen General","/sia/presupuesto/rpt/Rpt_resumen_general.php", "", "", "", "", "", "", "", "", ],
        ["|Reportes de Compromisos","", "", "", "", "", "", "0", "", "", ],
            ["||Compromisos General","/sia/presupuesto/rpt/Rpt_compromisos_general.php", "", "", "", "", "", "", "", "", ],
            ["||Compromisos por Causar/Pagar","/sia/presupuesto/rpt/Rpt_compromisos_causar_pagar.php", "", "", "", "", "", "", "", "", ],
			["||Compromisos por Beneficiario","/sia/presupuesto/rpt/Rpt_compromisos_beneficiario.php", "", "", "", "", "", "", "", "", ],
			["||Movimiento de Compromisos","/sia/presupuesto/rpt/Rpt_movimientos_compromisos.php", "", "", "", "", "", "", "", "", ],
        ["|Reportes de Causados","", "", "", "", "", "", "0", "", "", ],
            ["||Causados General","/sia/presupuesto/rpt/Rpt_causados_general.php", "", "", "", "", "", "", "", "", ],
            ["||Causados por Pagar","/sia/presupuesto/rpt/Rpt_causados_pagar.php", "", "", "", "", "", "", "", "", ],
        ["|Pago","/sia/presupuesto/rpt/Rpt_pagos.php", "", "", "", "", "", "", "", "", ],
        ["|Ajustes","/sia/presupuesto/rpt/Rpt_ajustes.php", "", "", "", "", "", "", "", "", ],
        ["|Modificaciones","/sia/presupuesto/rpt/Rpt_modificaciones.php", "", "", "", "", "", "", "", "", ],
        ["|Diferido","/sia/presupuesto/rpt/Rpt_diferido.php", "", "", "", "", "", "", "", "", ],
		["|Relacion Diaria de Documentos Procesados","/sia/presupuesto/rpt/Rpt_relac_diaria_doc_presup_procesados.php", "", "", "", "", "", "", "", "", ],
        ["|Consolidado de Ejecucion","/sia/presupuesto/rpt/Rpt_consolidacion_ejecucion.php", "", "", "", "", "", "", "", "", ],
        ["|Creditos Adicional","", "", "", "", "", "", "0", "", "", ], 
            ["||Ejecucion de Creditos Adicional","/sia/presupuesto/rpt/Rpt_ejecucion_credito_adicional.php", "", "", "", "", "", "", "", "", ],
            ["||Consolidado de Ejecucion del Credito Adicional","/sia/presupuesto/rpt/Rpt_consolidacion_ejecucion_credito_adicional.php", "", "", "", "", "", "", "", "", ],
            ["||Rendincion del Credito Adicional","/sia/presupuesto/rpt/Rpt_rendincion_credito_adicional.php", "", "", "", "", "", "", "", "", ],
        ["|Reportes Especiales","", "", "", "", "", "", "0", "", "", ],                  
            ["||Resumen General","/sia/presupuesto/rpt/Rpt_esp_resumen_general.php", "", "", "", "", "", "", "", "", ],
			["||Distribucion del Gasto","/sia/presupuesto/rpt/Rpt_esp_distribucion_gasto.php", "", "", "", "", "", "", "", "", ],
			["||Ejecucion Presupuestaria","/sia/presupuesto/rpt/Rpt_esp_ejecu_presup.php", "", "", "", "", "", "", "", "", ],
            ["||Resumen Consolidado de la Ejecucion del Presupuesto","/sia/presupuesto/rpt/Rpt_esp_res_cons_ejecu_presup.php", "", "", "", "", "", "", "", "", ],
			//["||Informe Mensual de la Ejecucion Financiera del Presupuesto","/sia/presupuesto/rpt/Rpt_esp_informe_ejecucion_presup_mensual.php", "", "", "", "", "", "", "", "", ],
            ["||Ejecucion Presupuestaria por Fuente de Financiamiento","/sia/presupuesto/rpt/Rpt_esp_ejecu_presup_fuente.php", "", "", "", "", "", "", "", "", ],			
        ["|Reportes ONAPRE","", "", "", "", "", "", "0", "", "", ],                  
            ["||Situacion del Ente","/sia/presupuesto/rpt/Rpt_esp_sit_ente.php", "", "", "", "", "", "", "", "", ],
			["||Ejecucion Fisica de las Metas del Proyecto","/sia/presupuesto/rpt/Rpt_esp_ejec_fis_metas_proy.php", "", "", "", "", "", "", "", "", ],
			["||Cons.Ejec.Financ.Proyecto y Acciones Centralizadas por Partidas","/sia/presupuesto/rpt/Rpt_esp_cons_ejecucion_financiera_proy_acc.php", "", "", "", "", "", "", "", "", ],
			["||Ejecucion Trimestral de Gastos y Aplicaciones Financiera","/sia/presupuesto/rpt/Rpt_esp_ejec_trim_gasto_aplic.php", "", "", "", "", "", "", "", "", ],
			["||Ejecucion Financiera Trimestral del Presup de Gastos","/sia/presupuesto/rpt/Rpt_esp_ejec_fin_trim_presup_gasto.php", "", "", "", "", "", "", "", "", ],
			["||Ejecucion Presupuestaria por cuenta y tipo de recurso","/sia/presupuesto/rpt/Rpt_esp_ejec_presup_por_cuenta_tipo.php", "", "", "", "", "", "", "", "", ],
			["||Ejecucion Financiera Mensual del Presup de Gastos","/sia/presupuesto/rpt/Rpt_esp_ejec_fin_mens_presup_gasto.php", "", "", "", "", "", "", "", "", ],
		["Utilidades","", "", "", "", "Menu Utilidades", "", "0", "", "", ],
          ["|Actualizar Asignacion","javascript:VentanaCentrada('Act_asigna_ini.php','Actualizar Asignacion Inicial','','600','260','true');", "", "", "", "", "", "", "", "", ],
		  ["|Actualizar Maestro","javascript:VentanaCentrada('Act_maestro.php','Actualizar Maestro','','600','260','true');", "", "", "", "", "", "", "", "", ],
		  ["|Actualizar Movimiento","javascript:VentanaCentrada('Act_movimientos.php','Actualizar Movimiento','','600','260','true');", "", "", "", "", "", "", "", "", ],
          ["|Auditoria","Auditoria_presup.php", "", "", "", "", "", "", "", "", ],
 		  ["|Cambio de Clave","Cambio_clave.php", "", "", "", "", "", "", "", "", ],  
          ["|Periodo Trabajo Presupuesto","Cierre_presup.php", "", "", "", "", "", "", "", "", ],		  
   ["Salir","salir.php", "", "", "", "", "", "", "", "", ],
];dtree_init();
