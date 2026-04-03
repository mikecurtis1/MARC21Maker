<?php 

require_once('../src/MARC21Maker.php');
require_once('../src/EscapeString.php');

/*
$mrc = new MARC21Maker('n','g','m');
$mrc->addControlField('001','123456789');
$mrc->addDataField('100','0',' ','$aAkira Kurosawa (黒澤 明)');
$mrc->addDataField('240','1','0','$aSeven Samurai');
$mrc->addDataField('245',' ',' ','$a七人の侍');
$mrc->addDataField('264',' ','1','$c1954');
#$mrc->emitMRC();
$data = $mrc->getMRC();
$mrc->emitMRC('utf-8',$data,'Seven_Samurai');
*/

$set = '';

$mrc = new MARC21Maker('n','a','m');
$mrc->addControlField('001','0001');
$mrc->addDataField('100','0',' ','$aJohn Doe');
$mrc->addDataField('245',' ',' ','$aTitle #1');
$mrc->addDataField('264',' ','1','$c2024');
$set .= $mrc->getMRC();

$mrc = new MARC21Maker('n','a','m');
$mrc->addControlField('001','0002');
$mrc->addDataField('100','0',' ','$aJohn Doe');
$mrc->addDataField('245',' ',' ','$aTitle #2');
$mrc->addDataField('264',' ','1','$c2024');
$set .= $mrc->getMRC();

$mrc = new MARC21Maker('n','a','m');
$mrc->addControlField('001','0003');
$mrc->addDataField('100','0',' ','$aJohn Doe');
$mrc->addDataField('245',' ',' ','$aTitle #3');
$mrc->addDataField('264',' ','1','$c2024');
$set .= $mrc->getMRC();

$mrc->emitMRC('utf-8',$set,'set_of_marc_records');

?>
