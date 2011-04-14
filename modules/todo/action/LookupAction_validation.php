<?php
global $VALIDATION;
$VALIDATION["addOk"]["lookup.type"][]["validate"] = "!isEmpty";
$VALIDATION["addOk"]["lookup.code"][]["validate"] = "!isEmpty";
$VALIDATION["addOk"]["lookup.name"][]["validate"] = "!isEmpty";
$VALIDATION["addOk"]["lookup.priority"][]["validate"] = "isNumeric";
$VALIDATION["editOk"]["lookup.type"][]["validate"] = "!isEmpty";
$VALIDATION["editOk"]["lookup.code"][]["validate"] = "!isEmpty";
$VALIDATION["editOk"]["lookup.name"][]["validate"] = "!isEmpty";
$VALIDATION["editOk"]["lookup.priority"][]["validate"] = "isNumeric";
?>