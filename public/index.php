<?php 

/*

http://www.loc.gov/marc/bibliographic/bdintro.html
http://www.loc.gov/marc/specifications/specrecstruc.html
http://www.loc.gov/marc/bibliographic/bdleader.html

https://www.loc.gov/marc/makrbrkr.html

docker build -t marc21maker .
docker run -p 8084:80 -d -v $(pwd):/var/www/html marc21maker

*/

require_once('../src/MARC21Maker.php');
require_once('../src/EscapeString.php');

$mrc = new MARC21Maker('n','j','a');
$mrc->addControlField('001','123456789');
$mrc->addDataField('100',' ',' ','$aauthor');
$mrc->addDataField('245',' ',' ','$aTitle With Escaped \$ Dollar Sign');
$mrc->emitMRC();

/* 

OUTPUT 

00120nja  2200061   4500001001000000100001100010245003700021123456789  aauthor  aTitle With Escaped $ Dollar Sign

OUTPUT in MarcEdit

=LDR  00120nja  2200061   4500
=001  123456789
=100  \\$aauthor
=245  \\$aTitle With Escaped {dollar} Dollar Sign

*/

?>