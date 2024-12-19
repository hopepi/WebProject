const card = document.querySelector('.card');
const video = document.querySelector('.back video');

card.addEventListener('mouseover', () => {
     video.play();
});

card.addEventListener('mouseleave', () => {
    video.pause();
    video.currentTime = 0;
});