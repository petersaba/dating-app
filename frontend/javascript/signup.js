const email = document.getElementById('email');
const full_name = document.getElementById('full_name');
const location_field = document.getElementById('location');
const submit =document.getElementById('submit');
const error_field = document.querySelector('.error');



submit.addEventListener('click', verifyInput);

function verifyInput(event){
    event.preventDefault();

    if(utils.checkValidEmail(email.value) == -1){
        utils.showError('Invalid email format', error_field);
        return;
    }else{
    }

    if (utils.fieldIsEmpty(email) || utils.fieldIsEmpty(full_name) || utils.fieldIsEmpty(location_field)){
        utils.showError('please fill all fields', error_field);
        return;
    }else{
    }

    utils.hideError(error_field);
}