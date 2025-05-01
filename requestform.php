<?php



require_once("./classes/Database.php");
require_once("./classes/leavetype.class.php");
require_once("./classes/leavetype-display.php");
require_once("./classes/requestform.class.php");
require_once("./classes/requestform-controller.class.php");

$message = $_GET['message'] ?? null;
$error = $_GET['error'] ?? null;

$error = isset($_SESSION['error101']) ?  $_SESSION['error101']: null;
$error2 = null;

unset($_SESSION['error101']);

$leave_type = new LeavetypeDisplay();
$leave_types = $leave_type->showLeaveType();

if(isset($_POST['submit'])){
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $leave_type = $_POST['leave_type'];
    $phone = $_POST['phone'];
    $description = $_POST['description'];
    $created_at = date("Y-m-d");

    $userName = $_SESSION['username'];
    $annual_balance = $_SESSION['annual_balance'];
    $department = $_SESSION['department'];

    $requestcontr = new RequestformContr(
        $start_date, $end_date, $leave_type, $phone, $description,
        $userName, $created_at, $annual_balance, $department,$leave_types
    );

    $requestcontr->submitrequest();
}


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        :root{
         --mainbackground: whitesmoke;
         --buttonbackground: #2d67f7;
        }

      
        .centerpart{
            width: 100%;
            height: 100%;
        }
        .wrapper{
        width: 400px;
        min-height: 300px;
        margin: 0px auto;
        background: white;
        padding: 10px;
        border-radius: 5px;
        }
        .requestform{
            width: 95% ;
            display: flex;
            flex-flow: column nowrap;
            justify-content: center;
            align-items: center;
          
            gap: 10px;
        }
        .dates input{
            width: 100%;
        }

         .requestform div{
            width: 100%;

         }
        .dates{
            width: 100%;
            display: flex;
            gap:2px;
        }
        .start ,.end,.leavetypes,.tel,.backup,.description{
            display: flex;
            flex-flow: column;
            gap: 3px;

        }
        input ,select{
        border-radius: 2px;
        border: 0.5px solid grey;
        background: white;
        padding: 5px 2px;

        }
        #message{
            max-width: 380px;
            height: 60px;
        }
      
        .submit{
          background:rgb(36, 96, 247);
          width: 30%;
          padding: 10px 15px;  
          margin: 0px auto;
          border: none;
          color: white;
        }
        .error{
            color:red;
        }

        h2{
            color: #2d67f7;
        }

        
       .message{
        color: green;
       }

       .error{
        color: red;
       }


    </style>
</head>
<body class="centerpart">

    <div class="wrapper">

    <form action="home.php?page=request-leave" class="requestform" method="post">
    
       <h2>Leave request form</h2>

       <?php   if(!empty($message)){?>
        <span class="message"> <?= $message?></span>


     <?php } ?>   

     <?php   if(!empty($error)){?>
        <span class = "error"><?=$error?></span>

     <?php } ?>  
        

    <div class="dates">

    <div class="start">
    <span>Start Date</span>
    <input type="text" name="start_date" id="start_date" required>
    </div>

    <div class="end">
    <span>End date</span>
    <input type="text" name="end_date" id="end_date" required>
   
    </div>
   
    </div>

    <?php if(!empty($error)){?>
        <span class="error"><?php echo $error?></span> 
      <?php }?> 


    <div class="leavetypes">
        <span>Leave type</span>
        <select name="leave_type" id="leave_type">
          <?php foreach($leave_types as $leave) {?>
             <option value="<?=$leave["leave_name"]?>"><?=$leave["leave_name"]?></option>

            <?php }?>
        </select>
    </div>

    <div class="tel">
        <span>Phone number</span>
        <input type="tel" pattern="^(\+254|0)?7\d{8}$" name="phone" id="phone" placeholder="+254712345678" required>
    </div>

    <div class="backup">
    <span>BackUp </span>
    <input type="text" placeholder="Input the your replacements username">
    </div>

     <div class="description">
        <span>Reason</span>
        <textarea name="description" id="message" placeholder="write a small description about the reason for leave"></textarea>

     </div>
   


     <input type="submit" name="submit" value="submit" class="submit">


    </form>

    </div>


    <script>

     flatpickr("#start_date", { dateFormat: "Y-m-d" , disable: [
    
      function(date) {
        return (date.getDay() === 0 || date.getDay() === 6); 
      }
    ]});
    flatpickr("#end_date", { dateFormat: "Y-m-d", disable: [
      
      function(date) {
        return (date.getDay() === 0 || date.getDay() === 6); 
      }
    ], });

    </script>
    
</body>
</html>