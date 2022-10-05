const utils = {};

utils.baseUrl = 'http://127.0.0.1:8000/api/';
utils.imagesUrl = './assets/images/';

utils.checkStrongPassword = (password) => {
    if(password.length < 16)
        return 'password should have at least 16 characters';

    let pattern = / /;
    if(utils.checkPattern(password, pattern) != -1)
        return 'password should not contain spaces';

    pattern = /\d.*\d/;
    if(utils.checkPattern(password, pattern) == -1) 
        return utils.passwordErrorMessage('integers');
    
    pattern = /[A-Z].*[A-Z]/;
    if(utils.checkPattern(password, pattern) == -1)
        return utils.passwordErrorMessage('capital letters');

    pattern = /[a-z].*[a-z]/;
    if(utils.checkPattern(password, pattern) == -1)
        return utils.passwordErrorMessage('lower case letters');

    // checkign for 2 symbols
    pattern = /[\W_].*[\W_]/;
    if(utils.checkPattern(password, pattern) == -1)
        return utils.passwordErrorMessage('symblos');
}

utils.checkValidEmail = (email) => {
    const pattern = /^.{3,}@[^\W_]{3,}\.[^\W_]{2,}$/;
    return utils.checkPattern(email, pattern);
}

utils.checkPattern = (value, pattern) => {
    return value.search(pattern);
}

utils.passwordErrorMessage = (type) => {
    return 'password should contain at least 2 ' + type;
}

utils.fieldIsEmpty = (field) => {
    return field.value ? false : true;
}

utils.showError = (message, element) => {
    element.innerText = message;
    element.style.visibility = 'visible';
    
}

utils.hideError = (element) => {
    element.style.visibility = 'hidden';
}

utils.addInputDiv = (field_name_shown, field_name, input_type, parent_div) => {
    parent_div.innerHTML += `<div id="` + field_name + `-div">
                                <input id="` + field_name + `" type="` + input_type + `" placeholder="this will not show">
                                <label for="` + field_name + `">` + field_name_shown + `</label>
                            </div>`;
}

utils.samePasswords = (password1, password2) => {
    if(password1 == password2)
        return true;
    return false;
}

utils.axiosPost = async (api, data, token=null) => {
    try{
        return await axios.post(utils.baseUrl + api, data,
                                {
                                    headers: {
                                        'Authorization': "Bearer" + token
                                    }
                                });
    }catch(error){
        console.log('Error from API');
        console.log(error);
    }
}

utils.axiosGet = async (api, token=null) => {
    try{
        return await axios.get(utils.baseUrl + api,
            {
                headers: {
                    'Authorization': "Bearer " + token
                }
            });
    }catch(error){
        console.log('Error from Api');
        console.log(error);
    }
}

utils.getEighteenDate = () => {
    let today = new Date();
    let dd = today.getDate();
    let mm = today.getMonth() + 1; //January is 0
    const yyyy = today.getFullYear();

    if (dd < 10) {
    dd = '0' + dd;
    }
    if (mm < 10) {
    mm = '0' + mm;
    }
    
    yyyy -= 18;

    today = yyyy + '-' + mm + '-' + dd;
    return today;
}

utils.createUserCard = (user, container) => {
    const currentDate = new Date();
    const userBirthDate = new Date(user.date_of_birth);
    const ageInMs = currentDate - userBirthDate;
    const ageInYears = Math.floor(ageInMs/(1000*3600*24*30*12));

    const image = user.profile_url ? utils.baseUrl + '../public/images/' + user.profile_url : utils.imagesUrl + 'no-photo.png';

    const card = document.createElement('div');
    card.innerHTML = `<ul>
                        <li>${user.full_name}</li>
                        <li>Age: ${ageInYears}</li>
                    </ul> 
                    <img src="${image}" alt="">
                    <ul>
                        <li>Gender: ${user.gender}</li>
                        <li>Interested in: ${user.interested_in}</li>
                        <li>XXXKm away</li>
                    </ul>`;

    container.appendChild(card);
}

utils.fillCards = (users, container) => {
    container.innerHTML = '';
    for(const user of users){
        utils.createUserCard(user, container);
    }
}

utils.createMessageUser = (user, container) => {
    const icon = user.profile_url ? utils.baseUrl + '../public/images/' + user.profile_url : utils.imagesUrl + 'no-photo.png';
    const user = document.createElement('div');

    user.innerHTML = `<div>
                            <img src="${icon}" alt="">
                            <span>${user.full_name}</span>
                      </div>`;

    container.appendChild(user);
}

utils.fillMessages = (users, container) => {
    container.innerHTML = `<h3>Messages</h3>
                            <!-- just to take the space of the messages header -->
                            <div></div>`;

    for(const user of users){
        utils.createMessageUser(user, container);
    }
}