const utils = {};

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
    parent_div.innerHTML += `<div>
                                <input id="` + field_name + `" type="` + input_type + `" placeholder="this will not show">
                                <label for="` + field_name + `">` + field_name_shown + `</label>
                            </div>`;
}