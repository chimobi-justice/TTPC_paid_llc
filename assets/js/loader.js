window.onload = () => {
    setTimeout(getLoader, 400);
};

const getLoader = () => {
    document.getElementById('preloader').style.display = 'none';
    document.querySelector('.displayPageAfterLoader').style.display = 'block';
} 