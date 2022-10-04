const email = document.getElementById('email');
const full_name = document.getElementById('full_name');
const location_field = document.getElementById('location');
const date_of_birth = document.getElementById('date-of-birth');
const gender = document.getElementById('gender');
const interested_in = document.getElementById('interest');
const submit = document.getElementById('submit');
const error_field = document.querySelector('.error');
const inputs_div = document.getElementById('inputs-div');
const data_entered = new FormData();
let password;
let confirm_password;
let username;

restrictMaxDate(date_of_birth);
submit.addEventListener('click', verifyInput);
location_field.addEventListener('click', getLocation);

function verifyInput(event){
    event.preventDefault();

    if(utils.checkValidEmail(email.value) == -1){
        utils.showError('Invalid email format', error_field);
        return;
    }

    if (utils.fieldIsEmpty(email) || utils.fieldIsEmpty(full_name) || utils.fieldIsEmpty(location_field) || utils.fieldIsEmpty(date_of_birth)){
        utils.showError('please fill all fields', error_field);
        return;
    }

    if(!checkValidLocation(location_field.value)){
        utils.showError('location format is not valid', error_field);
        return;
    }

    utils.hideError(error_field);
    saveEnteredData();
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
    register();
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

function saveEnteredData(){
    data_entered.append('email', email.value);
    data_entered.append('full_name', full_name.value);
    data_entered.append('gender', gender.value);
    data_entered.append('interested_in', interested_in.value);
    data_entered.append('date_of_birth', date_of_birth.value);
    data_entered.append('location', location_field.value);

    return data_entered;
}

function restrictMaxDate(date_of_birth){
    let today = new Date();
    let dd = today.getDate();
    let mm = today.getMonth() + 1; //January is 0
    let yyyy = today.getFullYear();

    if (dd < 10) {
    dd = '0' + dd;
    }
    if (mm < 10) {
    mm = '0' + mm;
    } 
    yyyy -= 18;
        
    today = yyyy + '-' + mm + '-' + dd;
    date_of_birth.max = today;
}

async function register(){
    data_entered.append('username', username.value);
    data_entered.append('password', password.value);

    const response = await utils.axiosPost('user', data_entered);
}