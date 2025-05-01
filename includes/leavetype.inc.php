
<?php

if($_SERVER["REQUEST_METHOD"] === "POST"){
 
$leave_id = (isset($_POST['leave_id'])) ? trim($_POST['leave_id']) : null;
$leave_name = (isset($_POST['leave_name'])) ? trim($_POST['leave_name']) : null;
$leave_days = (isset($_POST['leave_days'])) ? trim($_POST['leave_days']) : null;


include("../classes/Database.php");
include("../classes/leavetype.class.php");
include("../classes/leavetype-controller.class.php");

$leavetypeContr = new LeavetypeContr($leave_id,$leave_name,$leave_days);
$leavetypeContr->submitLeavetype();


}



?>