<?xml version="1.0" encoding="ISO-8859-1" standalone="no"?>
<!DOCTYPE REPORT SYSTEM "PHPReport.dtd"> 
<REPORT xmlns:xi="http://www.w3.org/2001/XInclude">
	<TITLE>REPORTE RELACION RETENCIONES/ORDENES</TITLE>
	<BACKGROUND_COLOR>#FFFFFF</BACKGROUND_COLOR>
	<CSS>sia.css</CSS>
   <DOCUMENT>   
       <FOOTER BORDER="0" CELLSPACING="0" CELLPADDING="6" WIDTH="500">
	     <ROW>
		 	<COL ALIGN="RIGHT" CELLCLASS="DOCUMENT_LAYER" TEXTCLASS="BOLD" NUMBERFORMATEX="2" COLSPAN="4" TYPE="EXPRESSION"></COL>
		 	<COL ALIGN="RIGHT" CELLCLASS="DOCUMENT_LAYER" TEXTCLASS="BOLD" NUMBERFORMATEX="2" COLSPAN="1" TYPE="EXPRESSION">"============="</COL>
		 </ROW>
		 <ROW>
		    <COL ALIGN="LEFT"  CELLCLASS="DOCUMENT_LAYER" TEXTCLASS="BOLD" COLSPAN="1" TYPE="EXPRESSION">"CANTIDAD"</COL>
            <COL ALIGN="LEFT"  CELLCLASS="DOCUMENT_LAYER" TEXTCLASS="BOLD" COLSPAN="1" TYPE="EXPRESSION">$this->getParameter("cant_orden")</COL>
		 	<COL ALIGN="RIGHT" CELLCLASS="DOCUMENT_LAYER" TEXTCLASS="BOLD" NUMBERFORMATEX="2" COLSPAN="2" TYPE="EXPRESSION">"TOTAL GENERAL:   "</COL>
		 	<COL ALIGN="RIGHT" CELLCLASS="DOCUMENT_LAYER" TEXTCLASS="BOLD" NUMBERFORMATEX="2" COLSPAN="1" TYPE="EXPRESSION">$this->getSum("monto_retencion")</COL>
		 </ROW>
      </FOOTER>   
   </DOCUMENT>
	<PAGE BORDER="0" SIZE="23" CELLSPACING="0" CELLPADDING="6" WIDTH="940"> 
	<HEADER>
	 <ROW>
		<COL COLSPAN="6" CELLCLASS="PAGE_LAYER" TEXTCLASS="BOLD">
			<XHTML>
				<TABLE BORDER="0" CELLPADDING="2" CELLSPACING="0" WIDTH="100%">
					<TR>
					    <TD width="930" rowspan="4">
						  <IMG SRC="../../imagenes/Encabezado_rpt_pagos.png" WIDTH="930" HEIGHT="49" BORDER="0"/>						  
						</TD>
				    </TR>		
					</TABLE>				
			</XHTML>
		</COL>
	</ROW>		   
	<ROW>
		<COL COLSPAN="6" CELLCLASS="PAGE_LAYER" TEXTCLASS="BOLD">
			<XHTML>
				<TABLE BORDER="1" CELLPADDING="2" CELLSPACING="0" WIDTH="100%"  HEIGHT="35">
					<TR>
					   	<TD width="930" rowspan="4" ALIGN="CENTER"  TEXTCLASS="BOLD">ORDENES RETENCIONES/CODIGOS PRESUPUESTARIOS</TD>
				    </TR>		
				</TABLE>				
			</XHTML>
		  </COL>	
	</ROW>	
	<ROW>
	   <COL ALIGN="LEFT"  TYPE="EXPRESSION" TEXTCLASS="BOLD"  COLSPAN="6">$this->getParameter("criterio1")</COL>
	</ROW>
	<ROW>
		<COL TYPE="EXPRESSION" ALIGN="LEFT" TEXTCLASS="BOLD" COLSPAN="6">"_____________________________________________________________________________________________________________"</COL> 
     </ROW>
	<ROW>
          <COL CELLCLASS="GROUP_LAYER" ALIGN="LEFT" TEXTCLASS="BOLD" TYPE="REGULAR">Orden</COL>
		  <COL CELLCLASS="GROUP_LAYER" ALIGN="LEFT" TEXTCLASS="BOLD" TYPE="REGULAR">Fecha</COL>
		  <COL CELLCLASS="GROUP_LAYER" ALIGN="LEFT" TEXTCLASS="BOLD" TYPE="REGULAR">Concepto</COL>
		  <COL CELLCLASS="GROUP_LAYER" ALIGN="LEFT" TEXTCLASS="BOLD" TYPE="REGULAR">Codigo Presupuestario</COL>
		  <COL CELLCLASS="GROUP_LAYER" ALIGN="RIGHT" TEXTCLASS="BOLD" TYPE="REGULAR">Monto</COL>
		  
		  <COL CELLCLASS="GROUP_LAYER" ALIGN="LEFT" TEXTCLASS="BOLD" TYPE="REGULAR">Estatus</COL>
		  
    </ROW>
	<ROW>
		<COL TYPE="EXPRESSION" ALIGN="LEFT" TEXTCLASS="BOLD" COLSPAN="6">"_____________________________________________________________________________________________________________"</COL> 
     </ROW>
   </HEADER>
   <FOOTER> 
   	     
   </FOOTER>
   </PAGE>
	<GROUPS>
		<GROUP REPRINT_HEADER_ON_PAGEBREAK="TRUE" NAME="fecha" EXPRESSION="fecha">   
           <HEADER> 
           </HEADER>
           <FOOTER>
            </FOOTER> 
			<GROUP REPRINT_HEADER_ON_PAGEBREAK="TRUE" NAME="Detalles" EXPRESSION="deta">
			 <HEADER> </HEADER>
			 <FOOTER> </FOOTER>
             <FIELDS>
   			  <ROW>
				<COL TEXTCLASS="REGULAR" ALIGN="LEFT"  TYPE="FIELD">aux_orden</COL>
				<COL TEXTCLASS="REGULAR" ALIGN="LEFT"  TYPE="FIELD">fechae</COL>
                <COL TEXTCLASS="REGULAR" ALIGN="LEFT"  TYPE="FIELD">concepto</COL>
				<COL TEXTCLASS="REGULAR" ALIGN="LEFT"  TYPE="FIELD">cod_presup_ret</COL>
                <COL TEXTCLASS="REGULAR" ALIGN="RIGHT" NUMBERFORMATEX="2" TYPE="FIELD">monto_retencion</COL>
				<COL TEXTCLASS="REGULAR" ALIGN="LEFT" TYPE="RAW_EXPRESSION">muestra_st_orden($this->getValue("status_r"),$this->getValue("anulado"),$this->getValue("fecha_anulado"),$this->getValue("fecha_cheque_r"))</COL>			        
			 </ROW>
			</FIELDS>   
			</GROUP>	
		</GROUP>
	</GROUPS>
</REPORT>
