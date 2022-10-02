const utils = {};

utils.checkPattern = (value, pattern) => {
    return value.search(pattern);
}

utils.checkStrongPassword = (password) => {
    let pattern = /\d.*\d/;
    if(utils.checkPattern(password, pattern) == -1) 
        return false;
    
}