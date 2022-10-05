window.onload = async () => {
    const response = await Promise.all([utils.axiosGet('homepage', localStorage.getItem('token')), 
                                    utils.axiosGet('userinfo', localStorage.getItem('token')),
                                    utils.axiosGet('messages', localStorage.getItem('token'))]);

    localStorage.setItem('users', JSON.stringify(response[0].data.message));
    localStorage.setItem('user_info', JSON.stringify(response[1].data.message));
    localStorage.setItem('messaged_users', JSON.stringify(response[2].data.message));

    const card_container = document.querySelector('.card-container');
    const messages_container = document.querySelector('.messages')
    utils.fillCards(JSON.parse(localStorage.getItem('users')), card_container);
    utils.fillMessages(JSON.parse(localStorage.getItem('messaged_users')), messages_container);
}