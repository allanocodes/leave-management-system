
<?php

$department = $_SESSION['department'];
require_once("./classes/Database.php");
include("./classes/reqtable.class.php");
include("./classes/reqttable-controller.php");

$requstTable_contr = new ReqTableContr();

$leaveRequests2 = $requstTable_contr->getRequests();
$leaveRequests = [];
foreach($leaveRequests2 as $results){
  if(strtolower($department) == strtolower($results['department'])){
  $leaveRequests[] = $results;
  }
  
}


$statuses = ['approved', 'pending', 'declined'];

$filterStatus = $_GET['status'] ?? 'all';

// Filter data by status if set
$filtered = $filterStatus === 'all' ? $leaveRequests :
    array_filter($leaveRequests, fn($r) => $r['status'] === $filterStatus);



    $limit = 5;
    $total = count($filtered);
    $totalpages = ceil($total/$limit);
    
    $page = isset($_GET['pagination_page'])  && is_numeric($_GET['pagination_page']) ? (int) $_GET['pagination_page'] : 1;
    $page = max(1,min($totalpages,$page));
    $start = ($page -1)  * 5;
    $paginatedtable = array_slice($filtered,$start,$limit)

?>

<!DOCTYPE html>
<html>
<head>
    <title>Leave Requests</title>

    <style>
        body{
            width: 100%;
            height: 100%;
        }

      .wrapper{
        width: 80%;
        min-height: 250px;
        margin: 0px auto;
        box-shadow: 2px 2px 2px 2px;
        display: flex;
        flex-flow: column nowrap;
        align-items: center;
        background: whitesmoke;
      }

      .requestTable{
        width: 100%;
        border-collapse: collapse;
        background: whitesmoke;
        border-radius: 3px;
       
       
       
      }
      .requestTable ,th,td{
        padding: 5px;
        border: none;
        border-radius: 3px;
        padding: 10px 5px;
    
       
      }

      .requestTable tr:nth-child(even){
        background:#fff ;
      
      }
    #requesthead{
        background: #2d67f7;
        
        color: white;
        
    }
    #requesthead th{
      padding: 10px 20px;
    }

    .pagination{
      border-top: #0d2187  0.5px solid;
        width: 100%;
        background: whitesmoke;
        padding:10px;
        display: flex;
       align-items: center;
        gap: 30px;
    }
    .pagination a{
       border-radius: 3px;
        text-decoration: none;
        background: #0d2187;
        padding: 10px 20px;
        color: white;
    }
      
   .changebtn{
    background: #0d2187;
    padding: 6px 12px;
    color: #fff;
    cursor: pointer;
    border-radius: 3px;
    transform: 0.5s ease ;
    box-shadow: 2px 2px 2px;
   }
   .changebtn:hover{
     background:#2d67f7 ;
     
     
   }
   .heading{
    background: #2d67f7;
    color: white;
    width: 100%;
    height: 40px;
    text-align: center;
    padding-top: 10px;
   }
      


    </style>
    
</head>
<body >

<div class="wrapper">

<div class="heading">
  <h4>Request Table</h4>
</div>


<form method="GET" style="margin: 15px 0;">
    <input type="hidden" name="page" value="leave_request">
    <label for="status">Filter by Status:</label>
    <select name="status" id="status" onchange="this.form.submit()">
        <option value="all">All</option>
        <?php foreach ($statuses as $status): ?>
            <option value="<?= htmlspecialchars($status) ?>" <?= $filterStatus === $status ? 'selected' : '' ?>>
                <?= ucfirst(htmlspecialchars($status)) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<table border="1" class="requestTable">

<thead>
 <tr id="requesthead">
        <th>Username</th>
        <th>Leave Type</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>total days</th>
        <th>Description</th>
        <th>Status</th>
        <th>Action</th>

 </tr>

</thead>


<tbody>

<?php if (count($paginatedtable) > 0): ?>
  <?php
  foreach($paginatedtable as $request){?>

     <tr>
         <td><?=htmlspecialchars($request['username'])?></td>
         <td><?=htmlspecialchars($request['leave_type'])?></td>
         <td><?=htmlspecialchars($request['start_date'])?></td>
         <td><?=htmlspecialchars($request['end_date'])?></td>
         <td><?=htmlspecialchars($request['leave_days'])?></td>
         <td><?=htmlspecialchars($request['description'])?></td>
         <td><?=htmlspecialchars($request['status'])?></td>
         <td><span  data-username="<?=$request['username']?>" class="changebtn">Change</span></td>
     </tr>
    
  <?php }?>

  

  <?php else: ?>
    <tr class="noRecords"><td colspan="8">No records found.</td></tr>
    <?php endif; ?>
</tbody>


</table>


<?php if (count($paginatedtable) > 0): ?>

<div class="pagination">
  <?php if($page > 1){?>

    <a href="home.php?page=leave_request&status=<?= $filterStatus ?>&pagination_page=<?= $page - 1 ?>">PREV</a>
    <?php } ?>
    <span> page <?=$page?> of  <?=$totalpages?></span>
    <?php if($page < $totalpages){ ?>
      <a href="home.php?page=leave_request&status=<?= $filterStatus ?>&pagination_page=<?= $page + 1 ?>">NEXT</a>  
    <?php }?>

</div>

<?php endif; ?>


</div>


</table>



</body>
</html>
