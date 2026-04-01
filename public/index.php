<?php 

require_once('../src/MARC21Maker.php');
require_once('../src/EscapeString.php');

$mrc = new MARC21Maker('n','g','m');
$mrc->addControlField('001','123456789');
$mrc->addDataField('100','0',' ','$aAkira Kurosawa (黒澤 明)');
$mrc->addDataField('240','1','0','$aSeven Samurai');
$mrc->addDataField('245',' ',' ','$a七人の侍');
$mrc->addDataField('264',' ','1','$c1954');
$mrc->emitMRC();

?>