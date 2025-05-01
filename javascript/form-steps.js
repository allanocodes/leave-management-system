
function handleStep(step){

    const forms=   document.querySelectorAll(".form-step");
    forms.forEach((el)=>{
       el.classList.remove('active');
    })

    document.getElementById("step" + step).classList.add('active')

   }
     
   document.getElementById("step1").addEventListener('submit',(event)=>{
       event.preventDefault();
   })



