window.onload = async () => {
    console.log(localStorage.getItem('token'));
    const response = await Promise.all([utils.axiosGet('homepage', localStorage.getItem('token')), 
                                    utils.axiosGet('userinfo', localStorage.getItem('token'))]);

    // console.log(response[0].data.message);
    localStorage.setItem('users', JSON.stringify(response[0].data.message));
    // console.log(response[1].data.message);
    localStorage.setItem('user_info', JSON.stringify(response[1].data.message));

    let card_container = document.querySelector('.card-container');
    utils.fillCards(JSON.parse(localStorage.getItem('users')), card_container);
}