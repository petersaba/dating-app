const email = document.getElementById('email');
const full_name = document.getElementById('full_name');
const location_field = document.getElementById('location');
const submit =document.getElementById('submit');
const error_field = document.querySelector('.error');
const inputs_div = document.getElementById('inputs-div');
let password;
let confirm_password;
let username;

submit.addEventListener('click', verifyInput);
location_field.addEventListener('click', getLocation);

function verifyInput(event){
    event.preventDefault();

    if(utils.checkValidEmail(email.value) == -1){
        utils.showError('Invalid email format', error_field);
        return;
    }

    if (utils.fieldIsEmpty(email) || utils.fieldIsEmpty(full_name) || utils.fieldIsEmpty(location_field)){
        utils.showError('please fill all fields', error_field);
        return;
    }

    if(!checkValidLocation(location_field.value)){
        utils.showError('location format is not valid', error_field);
        return;
    }

    utils.hideError(error_field);
    showNextPage();
}

function showNextPage(){
    inputs_div.innerHTML = '';
    utils.addInputDiv('Username', 'username', 'text', inputs_div);
    utils.addInputDiv('Password', 'password', 'password', inputs_div);
    utils.addInputDiv('Confirm Password', 'confirm_password', 'password', inputs_div);
    submit.innerText = 'Sign Up';
    
    username = document.getElementById('username');
    password = document.getElementById('password');
    confirm_password = document.getElementById('confirm_password');

    submit.removeEventListener('click', verifyInput);
    submit.addEventListener('click', verifySamePasswords);
}

function verifySamePasswords(event){
    event.preventDefault();

    if(utils.fieldIsEmpty(username) || utils.fieldIsEmpty(password) || utils.fieldIsEmpty(confirm_password)){
        utils.showError('please fill all fields', error_field);
        return;
    }

    if (!utils.samePasswords(password.value, confirm_password.value)){
        utils.showError('both passwords should be the same', error_field);    
        return;
    }
    utils.hideError(error_field);
}

function getLocation(){{
    if(!location_field.value){
        navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
    }
}}

function successFunction(position){
    location_field.value = position.coords.latitude + ', ' + position.coords.longitude;
}

function errorFunction(){
    error_field.innerText = 'Could not retrieve your location';
}

function checkValidLocation(location){
    const lat_and_long = location.split(', ');
    // latitude should be between -90 and 90 and longitude should be between -180 and 180
    if((Math.abs(lat_and_long[0])) >= 90 || (Math.abs(lat_and_long[1]) >= 180) || lat_and_long.length != 2)
        return false;
    return true;

}