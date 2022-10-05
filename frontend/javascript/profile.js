window.onload = async () => {
    const response = await Promise.all([utils.axiosGet('userinfo', localStorage.getItem('token')),
                                    utils.axiosGet('messages', localStorage.getItem('token'))]);

    localStorage.setItem('user_info', JSON.stringify(response[0].data.message));
    localStorage.setItem('messaged_users', JSON.stringify(response[1].data.message));

    const profile_container = document.querySelector('.profile-container');
    const messages_container = document.querySelector('.messages')
    const favorites_link = document.getElementById('favorites');
    const profile_link = document.getElementById('profile');
    const homepage_link = document.getElementById('homepage');
    
    
    favorites_link.addEventListener('click', () => {
        window.location.href = 'favorites.html';
    });
    profile_link.addEventListener('click', () => {
        window.location.href = 'profile.html';
    });
    homepage_link.addEventListener('click', () => {
        window.location.href = 'homepage.html';
    });

    utils.createProfile(JSON.parse(localStorage.getItem('user_info')), profile_container);
    utils.fillMessages(JSON.parse(localStorage.getItem('messaged_users')), messages_container);
}