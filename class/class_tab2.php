<script language="javascript" type="text/javascript">
var top = 10;                 //posicion de las pestañas con respecto al borde superior
var left = 4;                //posicion de las pestañas con respecto al borde izquierdo
                              //OJO, si cambia, hay que cambiar tambien el atributo top de tab-body del CSS
var tab_off = "#e9f3fc";      //color pestaña no seleccionada  "#e0e0e0"
var tab_on = "#6699FF";        //color pestaña seleccionada  "silver"  #0066ff
var NS4 = (document.layers) ? 1 : 0;
var IE = (document.all) ? 1 : 0;
var DOM = 0;
if (parseInt(navigator.appVersion) >=5) {DOM=1};
var lastHeader;
var currShow;
function changeCont(tgt,header) {
    target=('T' +tgt);
    if (DOM) { currShow.style.visibility="hidden";
        if(lastHeader) {lastHeader.style.background = tab_off; lastHeader.style.fontWeight="normal";}
        var flipOn = document.getElementById(target);
        flipOn.style.visibility="visible";
        var thisTab = document.getElementById(header);
        thisTab.style.background = tab_on;
        thisTab.style.fontWeight = "bold";
        currShow=document.getElementById(target);
        lastHeader = document.getElementById(header);
        return false;}
    else if (IE) {
        currShow.style.visibility = 'hidden';
        if(lastHeader) {lastHeader.style.background = tab_off; lastHeader.style.fontWeight="normal"; }
        document.all[target].style.visibility = 'visible';
        document.all[header].style.background = tab_on;
        document.all[header].style.fontWeight = 'bold';
        currShow=document.all[target];
        lastHeader=document.all[header];
        return false; }
    else if (NS4) {
        currShow.visibility = 'hide';
        document.layers[target].visibility = 'show';
        currShow=document.layers[target];
        return false; }
    else { window.location=('#A' +target);  return true; }
}
function DrawTabs() {
var output = '';
    for ( var x = 1; x <= num_rows; x++ ) {
        if( x > 1 ) {top = top + 20;  left = left - 15; width = width + 15;  }
        output += '<div id="tabstop" style="position:absolute; ';
        output += 'left:' + left + 'px;';
        output += 'top:' + top + 'px; ';
        output += 'width:' + width + 'px; z-index:1;">\n';
        output += '<table border="0" cellpadding="0" cellspacing="1">\n';
        output += '<tr valign="top">\n';
        for ( var z = 1; z < rows[x].length; z++ ) {
              var tid = "tab" + x + z;
              var did = x + z;
              output += '<td id="' + tid +'" class="tab-button"><a href="#" onClick="changeCont(\'' + x + z + '\', \'' + tid + '\'); return false;" onFocus="if(this.blur)this.blur()">' + rows[x][z] + '</a></td>\n';}
        output += '</tr>\n';
        output += '</table>\n';
        output += '</div>\n\n';}
    self.document.write(output);}
function IniciaTabs() {
    if (DOM) { currShow=document.getElementById('T11');}
    else if (IE) { currShow=document.all['T11'];}
    else if (NS4) { currShow=document.layers["T11"];};
    changeCont("11", "tab11");}
window.onload = IniciaTabs;
if (document.captureEvents) {document.captureEvents(Event.LOAD)}
</script>
<style TYPE="text/css">
.tab-button         {
    width: 150px;
    height: 20px;
    font-weight: Arial;
    background: #e9f3fc;
    border-top: 1px solid buttonhighlight;
    border-left: 1px solid buttonhighlight;
    border-bottom: 1px solid buttonhighlight;
    border-right: 1px solid buttonshadow;
    cursor: hand;
    padding-top: 2px;
    padding: 3;
    border-bottom-color: white;
    border: 1px solid #778;
    font-size: 8pt; color: #004080; font-family: Verdana, Arial, sans-serif}
.tab-body        {
    background: white;
    font-weight: Arial;
    border-top: 1px solid buttonhighlight;
    border-left: 1px solid buttonhighlight;
    border-bottom: 1px solid buttonshadow;
    border-right: 1px solid buttonshadow;
    border-style: ridge;
    border: 1px solid #778;
    padding: 3;
    position: absolute;
    left: 2px;
    top: 30px;
    width: 905px;
    z-index:1;
    visibility: hidden;
    font-size: 8pt; color: #004080; font-family: Verdana, Arial, sans-serif
}
</style>