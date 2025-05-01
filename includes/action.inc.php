
<?php


if(isset($_POST['submit'])){

$username = $_POST['username'];
$action = $_POST['status'];

include("../classes/Database.php");
include("../classes/action.class.php");
include("../classes/action-controller.class.php");

$actionContr = new ActionContr($username,$action);
$actionContr->submitChange();
}