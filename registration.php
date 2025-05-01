
<?php
require_once("./classes/Database.php");
require_once("./classes/department.class.php");
require_once("./classes/departmentDisplay.class.php");
require_once("./classes/leavetype.class.php");
require_once("./classes/leavetype-display.php");


$departmentdisp = new DisplayDep();
$departments = $departmentdisp->displayDep();


$message = $_GET['message'] ?? null;
$error = $_GET['error'] ?? null;



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

    <style>

  
*{
    padding: 0;
    margin: 0;
    box-sizing: 0;
}

  :root{
    --main-background-color : whitesmoke;
    --primary-background-color: #fff;
    --button-color:blue;
    --font-color:white
  }

  body{
    background: rgb(36, 96, 247);
    font-family: 'Nunito', sans-serif;
  }
 .container{
    width: 500px;
    min-height: 400px;
    margin: 50px auto;
    display: flex;
    align-items: center;
    justify-content: center;
 }
 
    .form-step{
        display: none;
        width: 100%;
        height: 100%;
    }
 .registration-form{
    background: var(--primary-background-color);
    display: flex;
    flex-flow: column nowrap;
    /* align-items: center; */
    padding:20px;
    border-radius: 3px;
    gap: 10px;
 }
 .names{
    width: 90%;
    display: flex;
    justify-content: space-between;
    gap: 5px;
 }
 .names  .firstnamesection, .names .middlenamesection,.names .sirnamesection{
    width: calc(100%/3 );
 }

 .names input{
    width: 98%;
 }

 .firstnamesection,.middlenamesection,.sirnamesection,
 .usernamesection,.passwordsection,.confirmpasswordsection,.gendersec
 {
    width: 90%;
    display: flex;
    flex-flow: column nowrap;
    justify-content: center;
 }
 
.submitsection{
margin-top: 20px;
display: flex;
justify-content: center;
align-items: center;
gap: 10px;
}
.submitsection button{
padding: 10px 20px;
border-radius: 4px;
border: none;
background:rgb(36, 96, 247) ;
color: var(--font-color);
width: 40%;
cursor: pointer;
transition: 0.5s ease-in;
}
.submitsection button:hover{
    background:  rgb(36, 96, 247);
    
   
}

input{
border-radius: 2px;
border: 0.5px solid grey;
padding: 3px 0;
}
/* .heading{
display: flex;
justify-content: center;
align-items: center;
margin-bottom: 20px;
background: var(--main-background-color);
padding: 10px;
border-radius: 5px;
} */
.gendersec select{
   background: white;
   padding: 5px 0px;
   border-radius: 2px;
   border: solid grey 0.5px;
}



/* section two */

.secondform{
width: 300px;
display: flex;
flex-flow: column nowrap;
gap: 20px;
background: var(--primary-background-color);
padding: 20px;
border-radius: 5px;
}
.secondform input{
padding: 5px 1px;
}
.submitformsection button ,.submitformsection input{
padding: 8px 15px;
background:rgb(36, 96, 247);
border-radius: 2px;
border: none;
color: var(--font-color);
cursor: pointer;
box-shadow: 1px 1px 1px 1px;
transition: 0.6s ease-in;
}
.submitformsection{
    display: flex;
    justify-content: center;
    gap: 30px;
}
.submitformsection button:hover{
    background: rgb(36, 96, 247); 
}
.submitformsection input:hover{
    background: rgb(36, 96, 247); 
    box-shadow: 1px 1px 1px;
}




.form-step.active,form{
display: flex;
 justify-content: center;
 align-items: center;
}   


select{
    padding: 6px 0px;
    background: white;
    border: solid grey 1px;
    border-radius: 3px;
    
}
.loginsec a{
    text-decoration: none;
    color: blue;
}

.error{
    color: red;
   
}
.message{
    color: green;
}


    </style>
</head>
<body>

    <div class="container">

           
    <form action="includes/registration.inc.php" method="POST" class="registration-form">
        <section class="form-step active" id="step1">
            <div class="registration-form">

                  
                    <h2>STEP 1: PERSONAL INFO</h2>
                    <?php   if(!empty($message)){?>
        <span class="message"><?= $message?> </span>


     <?php } ?>   

     <?php   if(!empty($error)){?>
        <span class = "error"><?=$error?></span>

     <?php } ?>  
                  
                <div class="names">
                 <div class="firstnamesection">
                    <span>First Name</span>
                    <input type="text" name="fname" class="fname">
                 </div>
        
                 <div class="middlenamesection">
                    <span>Middle Name</span>
                    <input type="text" name="mname" class="mname">
                 </div>
        
        
                 <div class="sirnamesection">
                    <span>Sir Name</span>
                    <input type="text" name="sname" class="sname">
                 </div>
        
                </div>


                <div class="gendersec">
                    <span>Gender</span>
                    <select name="gender" id="gender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
        
        
                 <div class="usernamesection">
                    <span>Username</span>
                    <input type="text" name="username" class="username">
                 </div>
        
        
                 <div class="passwordsection">
                 <span>Password</span>
                 <input type="password" name="password" id="password" >
                 </div>
        
                 <div class="confirmpasswordsection">
                    <span>Confirm Password</span>
                    <input type="password" name="confirmPassword" id="confirmpassword" >
                </div>
                  <span class="message" id="passwordMessage"></span>
        
                <div class="submitsection">
            
                 <button type="button" onclick="handleStep(2)">Next</button>
                </div>
        
</div>
               
        </section>



        <section class="form-step" id="step2"> 

            <div class="secondform">

                <div class="heading">
                    <h2>STEP 2: JOB INFO</h2>
                </div>
              
            <select name="department" id="department">
                <option value="">-- Select Department --</option>
                  <?php foreach ($departments as $dept): ?>
                  <option value="<?= htmlspecialchars($dept['department_name']) ?>"><?= htmlspecialchars($dept['department_name']) ?></option>
                 <?php endforeach; ?>
              </select>
               

                <input type="text" name="email" placeholder="Enter Email">

                <div class="submitformsection">
                 <button type="button" onclick="handleStep(1)">PREV</button>
                 <input type="submit" name="submitform" value="Register">
                </div>


                <div class="loginsec">
                  <p>Already have an Account? <a href="./index.php">Login</a></p>  

                </div>
          

</div>

        </section>

    </form>
      
    </div>

    <script>

document.addEventListener("DOMContentLoaded", function () {
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirmpassword");
    const message = document.getElementById("passwordMessage");

    function checkPasswordMatch() {
        const passVal = password.value.trim();
        const confirmVal = confirmPassword.value.trim();

        if (!passVal || !confirmVal) {
            message.textContent = "";
            return;
        }

        if (passVal === confirmVal) {
            message.textContent = "Passwords match!";
            message.style.color = "green";
        } else {
            message.textContent = "Passwords do not match.";
            message.style.color = "red";
        }
    }

    password.addEventListener("input", checkPasswordMatch);
    confirmPassword.addEventListener("input", checkPasswordMatch);
});
</script>

    </script>


    <script src="javascript/form-steps.js">


    </script>
    
</body>
</html>