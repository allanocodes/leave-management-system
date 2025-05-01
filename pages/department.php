<?php

require_once("./classes/Database.php");
include("./classes/department.class.php");
include("./classes/departmentDisplay.class.php");

$displayContr = new DisplayDep();
$leaveRequests = $displayContr->displayDep();
 
$limit = 5;
$total = count($leaveRequests);
$totalpages = ceil($total/$limit);

$page = isset($_GET['pagination_page'])  && is_numeric($_GET['pagination_page']) ? (int) $_GET['pagination_page'] : 1;
$page = max(1,min($totalpages,$page));
$start = ($page -1)  * 5;
$paginatedtable = array_slice($leaveRequests,$start,$limit)


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
        justify-content: space-between;
        align-items: center;
        background: whitesmoke;
        background: #0d2187;
        padding-left: 2px;
      }
      .depTable{
        width: 100%;
        border-collapse: collapse;
        background: whitesmoke;
        border-radius: 3px;
       
      }

      .depTable ,th,td{
        padding: 5px;
        border: none;
        border-radius: 3px;
        padding: 10px 14px;
    
       
      }

      #depTableHead{
        background: #2d67f7;
        color: white;
      }


      .depTable tr:nth-child(even){
        background:#fff ;
      
      
      }

      .depTable tr:nth-child(odd){
        background:whitesmoke ;
        border-radius: 5px;
      
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

    .leftside{
        width: 30%;
        background: whitesmoke;
        height: 50%;
        border-radius: 7px;
    }
    .rightside{
       
        width: 60%;
    }


    .depform{
        display: flex;
        flex-flow: column nowrap;
        align-items: center;
        padding: 10px;
        height: 100%;
        gap: 30px;
        background: #fff;
       
    }
    .depform input{
        padding: 5px 10px;
    }
    .heading{
        text-align: center;
    }
    .update{
        width: 40%;
        padding: 10px 20px;
        background: #0d2187;
        color: white;
        border-radius: 3px;
        border: none;
    }

    tbody tr {
    transition: transform 0.3s ease-in-out;
    cursor: pointer;
}

tbody tr:hover {
    transform: scale(1.008);
    border-radius: 5px;
    box-shadow: 1px 1px 1px;
}
    </style>
    <title>Document</title>
</head>
<body>


<div class="wrapper">
  <div class="leftside">
     <form action="./includes/department.inc.php"  class="depform" method="post">
        <div class="heading">
            <h2>Department form</h2>
        </div>
         <input type="text" name="department_id" class="DepId" placeholder="Department id">
         <input type="text" name="department_name" class="dep_name" placeholder="department name">
         <input type="text"  name="manager" class="manager" placeholder="manager">

         <input type="submit" class="update" value="submit" name="submit">
         
     </form>
  </div>

  <div class="rightside">

  <table border="1" class="depTable" >

  <thead>
    <tr id="depTableHead">
        <th>Department Id</th>
        <th>Department Name</th>
        <th>manager</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach($paginatedtable as $department) { ?>
      <tr class="row"  data-depId = "<?= $department['id']?>"
      data-depName = "<?= $department['department_name']?>"
      data-depManager = "<?=$department['department_manager']?>"
      >
        <td><?= htmlspecialchars($department['id']) ?></td>
        <td><?= htmlspecialchars($department['department_name']) ?></td>
        <td><?= htmlspecialchars($department['department_manager']) ?></td>
      </tr>
    <?php } ?>
  </tbody>

  </table>
  
<div class="pagination">
  <?php if($page > 1){?>

     <a href="home.php?page=departments&pagination_page=<?= $page-1?>">PREV</a>
    <?php } ?>
    <span> page <?=$page?> of  <?=$totalpages?></span>
    <?php if($page < $totalpages){ ?>
        <a href="home.php?page=departments&pagination_page=<?= $page + 1 ?>">NEXT</a>  
    <?php }?>

</div>

  </div>


</div> 

<script>

    const rows = document.querySelectorAll(".row");
    rows.forEach(el=>{
        el.addEventListener("click",(event)=>{
         const input1 = document.querySelector(".DepId");
         const input2 = document.querySelector(".dep_name");
         const input3 = document.querySelector(".manager");

          const depId =   el.dataset.depid;
          const depName = el.dataset.depname;
          const manager = el.dataset.depmanager;


          input1.value = depId;
          input2.value = depName;
          input3.value=  manager;


        })
    })

</script>
</body>
</html>