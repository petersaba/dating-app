const email = document.getElementById('email');
const full_name = document.getElementById('full_name');
const location_field = document.getElementById('location');
const submit =document.getElementById('submit');


submit.addEventListener('click', verifyInput);

function verifyInput(event){
    event.preventDefault();

    if (utils.fieldIsEmpty(email) || utils.fieldIsEmpty(full_name) || utils.fieldIsEmpty(location_field))
        console.log('please fill all fields');

    if(utils.checkValidEmail(email.value) == -1){
        console.log('Invalid email format');
    }else{
        console.log('email format is valid');
    }
}