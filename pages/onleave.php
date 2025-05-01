

<?php

$department = $_SESSION['department'];
require_once("./classes/Database.php");
include("./classes/employess.class.php");
include("./classes/employees-controller.class.php");

$employees_contr = new EmployeesContr();

$leaveRequests2 = $employees_contr->showOnLeave();
$leaveRequests = [];
foreach($leaveRequests2 as $results){
  if(strtolower($department) == strtolower($results['department'])){
  $leaveRequests[] = $results;
  }
  
}


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
        min-height: 250px;
        margin: 0px auto;
        box-shadow: 2px 2px 2px 2px;
        display: flex;
        flex-flow: column nowrap;
        align-items: center;
        background: whitesmoke;
      }

      .EmpTable{
        width: 100%;
        border-collapse: collapse;
        background: whitesmoke;
        border-radius: 3px;
       
       
       
      }
      .EmpTable ,th,td{
        padding: 5px;
        border: none;
        border-radius: 3px;
        padding: 10px 20px;
    
       
      }

      .EmpTable tr:nth-child(even){
        background:#fff ;
      
      }
    #requesthead{
        background:  #0d2187;
        
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

<table border="1" class="EmpTable">

<thead>
 <tr id="requesthead">
        <th>Username</th>
        <th>First name</th>
        <th>Sir name</th>
      
        <th>Department</th>
      
        <th>Gender</th>

 </tr>

</thead>


<tbody>
 


<?php if (count($paginatedtable) > 0): ?>

  <?php foreach($paginatedtable as $request){?>

     

     <tr>
         <td><?=htmlspecialchars($request['username'])?></td>
         <td><?=htmlspecialchars($request['first_name'])?></td>
         <td><?=htmlspecialchars($request['sir_name'])?></td>
         <td><?=htmlspecialchars($request['department'])?></td>
      
         <td><?=htmlspecialchars($request['gender'])?></td>
         
     </tr>
    

  <?php }?>

  <?php else: ?>
    <tr class="noRecords"><td colspan="5">No records found.</td></tr>
    <?php endif; ?>
</tbody>


</table>

<?php if (count($paginatedtable) > 0): ?>

<div class="pagination">
  <?php if($page > 1){?>

     <a href="home.php?page=on_leave&pagination_page=<?= $page-1?>">PREV</a>
    <?php } ?>
    <span> page <?=$page?> of  <?=$totalpages?></span>
    <?php if($page < $totalpages){ ?>
        <a href="home.php?page=on_leave&pagination_page=<?= $page + 1 ?>">NEXT</a>  
    <?php }?>

</div>
<?php endif; ?>


</div>


</table>



</body>
</html>

