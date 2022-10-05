window.onload = async () => {
    console.log(localStorage.getItem('token'));
    const response = await Promise.all([utils.axiosGet('homepage/1', localStorage.getItem('token')), 
                                    utils.axiosGet('userinfo', localStorage.getItem('token'))]);

    console.log(response[0].data.message);
    console.log(response[1].data.message);
}