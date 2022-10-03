const email = document.getElementById('email');
const submit =document.getElementById('submit');

submit.addEventListener('click', verifyEmail);

function verifyEmail(event){
    event.preventDefault();
    if(utils.checkValidEmail(email.value) == -1){
        console.log('Invalid email format');
    }else{
        console.log('email format is valid');
    }
}