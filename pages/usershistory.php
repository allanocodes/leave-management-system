
<?php



$department = $_SESSION['department'];
$username = $_SESSION['username'];

require_once("./classes/leaveHistory.class.php");
require_once("./classes/leaveHistory-display.class.php");

$history = new  HistoryDisplay($username);
$leaveRequests = $history->showRequests();



$limit = 5;
$total = count($leaveRequests);
$totalpages = ceil($total/$limit);

$page = isset($_GET['pagination_page'])  && is_numeric($_GET['pagination_page']) ? (int) $_GET['pagination_page'] : 1;
$page = max(1,min($totalpages,$page));
$start = ($page -1)  * 5;
$paginatedtable = array_slice($leaveRequests,$start,$limit)

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
        min-height: 150px;
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
        padding: 10px 14px;
    
       
      }

      .requestTable tr:nth-child(even){
        background:#fff ;
      
      }
    #requesthead{
        background:  #2d67f7;
        
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
      
 
      


    </style>
    
</head>
<body >

<div class="wrapper">

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
     

 </tr>

</thead>


<tbody>
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
      
     </tr>
    

  <?php }?>
</tbody>


</table>

<div class="pagination">
  <?php if($page > 1){?>

     <a href="home.php?page=leave_history&pagination_page=<?= $page-1?>">PREV</a>
    <?php } ?>
    <span> page <?=$page?> of  <?=$totalpages?></span>
    <?php if($page < $totalpages){ ?>
        <a href="home.php?page=leave_history&pagination_page=<?= $page + 1 ?>">NEXT</a>  
    <?php }?>

</div>


</div>


</table>



</body>
</html>
