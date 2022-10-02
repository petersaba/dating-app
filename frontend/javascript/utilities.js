const utils = {};

utils.checkStrongPassword = (password) => {
    let pattern = /\d.*\d/;
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

utils.checkPattern = (value, pattern) => {
    return value.search(pattern);
}

utils.passwordErrorMessage = (type) => {
    return 'password should contain at least 2 ' + type;
}

console.log(utils.checkStrongPassword('123ASaa!@'))