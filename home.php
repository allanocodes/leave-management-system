<?php

session_start();
ob_start();
require_once("./classes/Database.php");
require_once("./classes/leaveHistory.class.php");
require_once("./classes/leave_history-handler.class.php");

$messagex = $_GET['messagex'] ?? null;
$errorx = $_GET['errorx'] ?? null;

$historyhandler = new Historyhandler();
$historyhandler->historyhandler();


$logout = isset($_GET['logout']) ?  $_GET['logout']: null;

if(!empty($logout)){

   unset($_SESSION["username"]);
   unset($_SESSION['role']);
   unset($_SESSION["requested"]);
   unset($_SESSION['annual_balance']);
   unset($_SESSION['department']);
   header("location: ./index.php");
}




if(!isset($_SESSION['username'])){
    header("location: ./index.php");
    exit();
}


$userName =$_SESSION["username"];
$role = $_SESSION['role'];
$requested = $_SESSION["requested"] ;
$annual_balance = $_SESSION['annual_balance'];


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">


    <style>

     :root{
        --mainBackground: #2d67f7;
        --centerBackground: white;
     }
     *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
     }
     html {
  scroll-behavior: smooth;
}

     body{
    
        width: 100vw;
        height: 300vh;
        font-family: 'Nunito', sans-serif;
        display: flex;
        flex-flow: column nowrap;
        gap: 0;
     }
     .home{
  
        position: relative;
        width: 100vw;
        height: 100vh;
        background-image: url("./images/projectimage.avif");
        background-position: center; 
        background-repeat: no-repeat; 
        background-size: cover

     }

     .sidebar{
     
        top:0;
        left: 0;
        bottom: 0;
        width: 200px;

        display: flex;
        flex-flow: column nowrap;
         justify-content: center;
         align-items: center;
      
     }
     .topbar{
         top: 0;
         right: 0;
         left: 202px;
         height: 90px;
         border-radius: 2px;
         display: flex;
         gap: 40px;
    
       
       
     }
     .centerbar{
   
      position: fixed;
      top:110px ;
      left: 210px;
      bottom: 0;
      right: 0;
      border-radius: 2px;
  
 
      
      
     }

     .topbar,.sidebar{
      background: var(--mainBackground);
      position:  fixed ;
     
     }


     .menulist{
        width: 95%;
        display: flex;
        flex-flow: column nowrap;
        gap: 30px;
        list-style: none;
        text-transform: capitalize;
     }
     .menulist   a{
        text-decoration: none;
        color: white;
        width: 100%;
        height: 100%;
        width: 95%;
        padding: 15px 7px;
        background: #0d2187;
        height: 50px;
        text-align: center;
        box-shadow: 2px 2px 2px black;
        border-radius: 2px;
        transition:  0.5s ease-in ;
    
     }


     .menulist  a:hover {

        background:#2d67f7;
        box-shadow: 5px 2px 5px 2px black;
  
     }

     .action{
      position: fixed;
      top:0;
      bottom: 0;
      left: 0;
      right: 0;
      background: rgba(0, 0, 0,0.5);
      z-index: 100;
      display: none;
      justify-content: center;
      align-items: center;
     }
     .action.active{
      display: flex;
     }

     .cont{
      position: relative;
      width: 300px;
      min-height: 200px;
      display: flex;
      justify-content: center;
      flex-flow: column nowrap;
      gap: 20px;
      background: #fff;
     
      align-items: center;
     }
    .cancel{
      position: absolute;
      top:1px;
      right: 6px;
      font-size: 2rem;
      cursor: pointer;
    }
    .actiontab{
      padding: 10px;
      text-align: center;
      display: flex;
      flex-flow: column nowrap;
      align-items: center;
      gap: 20px;
      width: 80%;
      height: 100%;
      border: #0d2187 solid 1px;
    }
    .actiontab select{
        background: white;
        padding: 5px 10px;
        width: 80%;
        border: solid black 1px;
        border-radius: 3px;
    }
    .actiontab  input{
      padding: 10px 20px;
      background: #0d2187;
      border: none;
      color: white;
      border-radius: 3px;
    }
    .topRight,.topleft{
         width: 100%;
         height: 100%;
       

    }

    .topRight{

      display: flex;
      justify-content: center;
      align-items: center;
      gap: 30px;
    }

   .topRight a{
    color:white ;
    text-decoration: none  ;
    transition: 0.5s ease-in;

   }
    .about{
      height: 90%;
    
      width: 100px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #0d2187;
      border-radius: 3px;
      box-shadow: 1px 1px 1px 1px black;

    }
    .contact{
      width: 100px;
      height: 90%;
 
      text-align: center;
      display: flex;
      align-items: center;
      background: #0d2187;
      justify-content: center;
      border-radius: 3px;
      box-shadow: 1px 1px 1px 1px black;
      
      
    }

   .logoutbtn{
      padding: 10px 20px;
      background: #0d2187;
      border-radius: 3px;
      box-shadow: 1px 1px 1px 1px black;
   }
   .topRight a:hover{
      background: #2d67f7;
      transform: scale(1.008);
      
   }
   .aboutsec{
      width: 100vw;
      height: 100vh;
      position: relative;
      display: flex ;
      flex-flow: column nowrap;
      background: whitesmoke;
      z-index: 10;
    
   }
   .aboutContant{
      display: flex;
      z-index: 90;
      background: #2d67f7;

      
   }
   .aboutContant{
      height: 100%;
   }
    .emptySec{
      height: 50%;
      background: #fff;
    }
   .aboutsecHeading{
     height: 50%;
     text-align: center;
     margin-top: 30px;

   }
   /* .aboutContant ul{
      list-style: none;
   } */
   .why ,.features,.built_with{
     width: 100%;
     display: flex;
     flex-flow: column nowrap;
      align-items: center;
      gap: 20px;
      padding: 30px;
      border-right: 1px solid white;
      border-left: 1px solid white;
      color: white;
      font-size: 1.25rem;
      font-family: 'Comic Neue', cursive;
   }
   .contacts{
      position: relative;
   width: 100%;
   height: 100vh;
   z-index: 90;
   background: #fff;
   }

   .contactContainer{
      width: 70%;
      height: 70%;
      display: flex;
      background: #2d67f7;
      color: white;
      margin: 20px auto;

   }
   .contactLeft,.contactRight{
      width: 100%;
      height: 100%;
      padding: 20px;
   }

   .contactform{
      display: flex;
      flex-flow: column nowrap;
      gap: 10px;
   }
    .contactform div{
     width: 100%;
     height: 90%;
     display: flex;
     flex-flow: column nowrap;
    }
    .contactform input{
      padding: 5px 0px;
     
    }
    .contactSec{
      padding: 10px;
      display: flex;
      flex-flow: column nowrap;
      gap: 10px;
    }
    .contactLeft{
      display: flex;
      flex-flow: column nowrap;
      gap: 30px;
      border-right: solid white 1px;
    }
    .contactHeading{
      text-align: center;
    }
    .contactBtn{
      padding: 5px;
     
     
      border-radius: 3px;
      border: none;
    }
    .home{
      position: relative;
      z-index: 1;
    }

    .cover{
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0,0.3);
      z-index: -1;
      display: flex;
      justify-content: center;
      align-items: center;
    
      font-size: 1.2rem;
      font-weight: bold;
      
      
    }
   .writings{
      width: 700px;
      color: white;
    
   }
   .writings
   h2{
      color: white ;
   }
   .message{
            color: white;
        }
     

    </style>
</head>
<body>

    <section class="home">
      <section class="cover">

      <div class="writings">

      <h2>Easily manage your time off. Submit leave requests </h2> <h2> check leave balances, and view request statuses—all in one place.</h2>

      </div>

      </section>

    <section class="action">
      <div class="cont">
      <span class="cancel">&times;</span>
   
    <form action="./includes/action.inc.php" method="post" class="actiontab">
    <h2>Action Tab</h2>
      <select name="status" id="status">
      <option value="approved">Approve</option>
          <option value="declined">Deny</option>
      </select>
      <input type="hidden" class="usernamevalue" name="username">

      <input type="submit" name="submit" value="save">
    </form>
      </div>
    
    </section>

        <section class="sidebar">

        <?php if($role == "user"): ?>

            <ul class="menulist">
                 <a href="?page=home">home</a>
                  <a href="?page=request-leave">request leave</a>
                 <a href="?page=leave_status">leave status</a>
                 <a href="?page=leave_history">leave history</a>
                 

            </ul>
         <?php  endif;?>  
         
         
         <?php if($role == "manager"): ?>
            <ul class="menulist">
                 <a href="?page=home">home</a>
                <a href="?page=leave_request">leave request</a>
                 <a href="?page=on_leave">on leave</a>
                <a href="?page=department_employees"> Dep employees</a>

            </ul>
            <?php endif ;?>


            <?php if($role == "hr"): ?>
            <ul class="menulist">
                 <a href="?page=home">home</a>
                <a href="?page=employees">employees</a>
                 <a href="?page=On_leave">on leave</a>
                <a href="?page=requests">Requests</a>
                <a href="?page=departments">Department</a>
                <a href="?page=leave_type">Leave type</a>

            </ul>
            <?php endif ;?>

       
        </section>


        <section class="topbar">

        <div class="topleft">


        </div>


        <div class="topRight">
          <a href="#about_us" class="about">About</a>
          <a href="#contact" class="contact">Contact</a>
          <a href="?logout=yes" class="logoutbtn">Log out</a>
        </div>
          

        </section>

        <section class="centerbar">

        <?php
         if(isset($_GET['page'])){
            $page = $_GET['page'];

            if($page == "request-leave"){
               include("./requestform.php");
            }

         }

         if(isset($_GET['page'])){
            $page = $_GET['page'];

            if($page == "leave_request"){
               include("./pages/requestTable.php");
            }

         }

         if(isset($_GET['page'])){
            $page = $_GET['page'];

            if($page == "department_employees"){
               include("./pages/departmentEmp.php");
            }

         }

         if(isset($_GET['page'])){
            $page = $_GET['page'];

            if($page == "on_leave"){
               include("./pages/onleave.php");
            }

         }
         if(isset($_GET['page'])){
            $page = $_GET['page'];

            if($page == "employees"){
               include("./pages/Employees.php");
            }

         }


         if(isset($_GET['page'])){
            $page = $_GET['page'];

            if($page == "On_leave"){
               include("./pages/Hr-onleave.php");
            }

         }


         if(isset($_GET['page'])){
            $page = $_GET['page'];

            if($page == "requests"){
               include("./pages/Hr-request.php");
            }

         }

         if(isset($_GET['page'])){
            $page = $_GET['page'];

            if($page == "departments"){
               include("./pages/department.php");
            }

         }

         if(isset($_GET['page'])){
            $page = $_GET['page'];

            if($page == "leave_type"){
               include("./pages/leave_type.php");
            }

         }

         if(isset($_GET['page'])){
            $page = $_GET['page'];

            if($page == "leave_history"){
               include("./pages/usershistory.php");
            }

         }


         if(isset($_GET['page'])){
            $page = $_GET['page'];

            if($page == "leave_status"){
               include("./pages/status.php");
            }

         }


        
        ?>
            
        </section>

    </section>


     <section class="aboutsec" id="about_us">


     <div class="aboutsecHeading">

     <h1>ABOUT</h1>
     </div>


     <div class="aboutContant">
     <div class="why">

     <h4>Why This System?</h4>
     <p class="whyDescription">
      Managing leave manually can be time-consuming and error-prone.
      This system helps automate the process, saving time 
      and ensuring transparency for both employees and management.
      </p>

     </div>

     <div class="features">
      <h2>Features</h2>
      <ul>
       <li>  Submit and manage leave requests online</li>
       <li>Real-time leave tracking and status updates</li>
       <li> Department-wise filtering and reporting</li>
       <li> Approval and rejection workflows for admins</li>
       <li> Dashboard overview for administrators</li>
      </ul>

     </div>

     <div class="built_with">
     <h2>Built With</h2>
      <ul>
       <li> PHP</li>
       <li>HTML/CSS</li>
       <li>JavaScript</li>
       <li>MySQL</li>
      
      </ul>
     </div>


     </div> 

    
    
     <div class="emptySec">

     </div>

     </section>



     <section class="contacts" id="contact">


     <div class="contactHeading">
      <h1>Contact Us</h1>
     </div>

     <div class="contactContainer">


     <div class="contactLeft">
      <div class="contactSec">
     <p>ADDRESS</p> 
     <p>

     500 Terry Francine Street
    San Francisco, CA 94158

     </p>
      </div>

      <div class="contactSec">
     <p>Opening Hours</p> 
     <p>
     Mon - Fri :

     10am - 7pm

       Sat - Sun :

      11am - 4pm

     </p>
      </div>

      <div class="contactSec">
     <p>CONTACT US</p> 
     <p>

     123-456-7890

      info@mysite.com

     </p>
      </div>
     


     </div>

<div class="contactRight">
<form action="./includes/contanthandle.inc.php" class="contactform" method="post">



<div class="contactheading">
   <h4>Fill Contacts</h4>
</div>
<?php   if(!empty($messagex)){?>
        <span class="message"> <?= $messagex?></span>


     <?php } ?>   

     <?php   if(!empty($errorx)){?>
        <span class = "message"><?=$errorx?></span>

     <?php } ?>  
       
      <div class="cfname">
         <span>First Name</span>
         <input type="text" name="fname">

      </div>
      <div class="clname">
      <span>Last Name</span>
      <input type="text" name="lname">

     </div>
     <div class="cemail">
     <span>Gmail</span>
     <input type="email" name="email">
     </div>
     <div class="cmessage">
     <span>message</span>
      <textarea name="message" ></textarea>
     </div>

     <div>

        <input type="submit" name="submit" value="send" class="contactBtn">
     </div>


      </form>

     </div>

     </div>

     </section>






    <script>

     const form = document.querySelectorAll(".changebtn");


     form.forEach(el=>{
      el.addEventListener("click",(event)=>{
      const action = document.querySelector('.action');
      const form2 = document.querySelector('.actiontab');
      const input = document.querySelector('.usernamevalue');
      input.value = el.dataset.username;
     
      action.classList.add("active");

      })

     })

     const cancel = document.querySelector(".cancel");

     cancel.addEventListener("click",event=>{
      const action = document.querySelector('.action');
      action.classList.remove("active");
     })

     document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault(); 
    const targetId = this.getAttribute('href').substring(1); 
    const targetElement = document.getElementById(targetId);
    
    if (targetElement) {
      const offset = 90; 
      const elementPosition = targetElement.getBoundingClientRect().top + window.scrollY;
      const offsetPosition = elementPosition - offset;

      window.scrollTo({
        top: offsetPosition,
        behavior: 'smooth' 
      });
    }
  });
});


document.querySelector('a[href="#contact"]').addEventListener('click', function (e) {
  e.preventDefault(); 
  const targetElement = document.getElementById('contact');
  
  if (targetElement) {
    const offset = 90; 
    const elementPosition = targetElement.getBoundingClientRect().top + window.scrollY;
    const offsetPosition = elementPosition - offset;

    window.scrollTo({
      top: offsetPosition,
      behavior: 'smooth'
    });
  }
});
  

      
    </script>
    
</body>
</html>


<?php ob_end_flush(); ?>
