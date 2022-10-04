const email = document.getElementById('email');
const password = document.getElementById('password');
const submit = document.getElementById('login');
const error_field = document.querySelector('.error');

submit.addEventListener('click', login);

async function login(event){
    event.preventDefault();
    const data = new FormData();
    data.append('email', email.value);
    data.append('password', password.value);

    const response = await utils.axiosPost('login', data);
    if(!response){
        utils.showError('Wrong credentials', error_field);
        return;
    }
    utils.hideError(error_field);
    localStorage.setItem('token', response.data.access_token);
    console.log(response);
}