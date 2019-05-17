<?php
        require_once("PHPReportMaker.php");
        require_once("PHPReportsUtil.php");

        /******************************************************************************
        *                                                                                                                                                                                                                *
        *        Use this file to check how the output plugins works.                                                                *
        *        Please see PHPReportConvert.php also.                                                                                                        *
        *        It need to be placed on a directory reached by the web server.                                        *
        *                                                                                                                                                                                                                *
        ******************************************************************************/
        $sSQL = "select tipo_compromiso,nombre_tipo_comp,nombre_abrev_comp from pre002";
        $sXML = tempnam(getPHPReportsTmpPath(),"phprpt").".xml";
        $sBase= basename($sXML);

        $oRpt = new PHPReportMaker();
        $oRpt->setUser("eduardo");
        $oRpt->setPassword("123");
       $oRpt->setConnection("localhost");
       $oRpt->setDatabaseInterface("postgresql");
       $oRpt->setSQL($sSQL);
       $oRpt->setDatabase("SIA");
        $oRpt->setXML("pre002.xml");
        $oRpt->setXMLOutputFile($sXML);
        $oOut = $oRpt->createOutputPlugin("default");
        $oOut->setClean(false);
        $oOut->setOutput("");
        $oRpt->setOutputPlugin($oOut);
        $oRpt->run();
?>
<html>
        <head>
                <title>PHPReports exchanging formats</title>
                <link rel="stylesheet" type="text/css" href="css/phpreports.css">
        </head>
        <body>
                <p class="REGULAR" style="margin:15px;">
                <?php
                        print "converting <b>$sBase</b> to<br><br>";
                        print "<a href='PHPReportConvert.php?output=default&file=$sBase'         target='MAIN'>default html</a><br>";
                        print "<a href='PHPReportConvert.php?output=page&file=$sBase'                 target='MAIN'>page to page</a><br>";
                        print "<a href='PHPReportConvert.php?output=txt&file=$sBase'                 target='MAIN'>text file</a><br>";
                        print "<a href='PHPReportConvert.php?output=bookmarks&file=$sBase' target='MAIN'>bookmarks file</a><br>";
                ?>
                </p>
        </body>
</html>
