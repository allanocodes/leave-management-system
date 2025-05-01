

<?php
require_once("./classes/leaveHistory.class.php");
require_once("./classes/leaveHistory-display.class.php");
$username = $_SESSION['username'];
$statusDisp = new  HistoryDisplay($username);
$status = $statusDisp->displaystatus();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>

    *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
    .statusWrapper{
        width: 500px;
        display: flex;
        flex-flow: column nowrap;
        gap: 5px;
        margin: 20px auto;
       
    }

     .statusContainer{
        width: 500px;
        height: 250px;
        border-radius: 3px;
        display: flex;
       
    
     }

     .left,.right{
      width: 100%;
      display: flex;
      flex-flow: column nowrap;
      gap: 3px;
      height: 100%

     }

     .left div,.right div{
        width: 100%;
        height: 100%;
        padding: 10px;
        background: whitesmoke;
        box-shadow: 1px 1px 1px 1px;


     }
     .heading{
        border-radius: 3px;
        background: #2d67f7;
        color: white;
        padding: 10px;
     }
     .noRecords{
        background: whitesmoke;
        padding: 10px;
     }

    </style>
</head>
<body>
    

<div class="statusWrapper">

<div class="heading">
<h3>Leave Status</h3>
</div>

<?php if (count($status) > 0): ?>

<?php foreach ($status as $s): ?>
    <div class="statusContainer">
        <div class="left">
            <div class="username">
                <h4>Username</h4>
                <p><?= htmlspecialchars($s['username']) ?></p>
            </div>
            <div class="department">
                <h4>Status</h4>
                <p><?= htmlspecialchars($s['status']) ?></p>
            </div>
            <div class="leave_type">
                <h4>Leave Type</h4>
                <p><?= htmlspecialchars($s['leave_type']) ?></p>
            </div>
        </div>
        <div class="right">
            <div class="start">
                <h4>Start Date</h4>
                <p><?= htmlspecialchars($s['start_date']) ?></p>
            </div>
            <div class="enddate">
                <h4>End Date</h4>
                <p><?= htmlspecialchars($s['end_date']) ?></p>
            </div>
            <div class="leave_days">
                <h4>Leave Days</h4>
                <p><?= htmlspecialchars($s['leave_days']) ?></p>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php else: ?>
    <div class="noRecords">No records found</div>
    <?php endif; ?>
</tbody>


</div>

</div>

  

</body>
</html>