<?php
header("Content-Type: text/csv");
echo $str;
header("Content-Disposition: attachment;filename=" . $so . "-" . $si . ".csv");
