const cursorGlow = document.createElement('div');
cursorGlow.classList.add('cursor-glow');
document.body.appendChild(cursorGlow);

document.addEventListener('mousemove', (event) => {
    // Fare konumunu al
    const mouseX = event.clientX;
    const mouseY = event.clientY;

    // Glow'un konumunu fare konumuna ayarla
    cursorGlow.style.left = `${mouseX}px`;
    cursorGlow.style.top = `${mouseY}px`;
});

// Fareyi hareket ettirdiğinde glow efektini aktive et
document.addEventListener('mousemove', () => {
    cursorGlow.classList.add('hovered');
});

// Fareyi durdurduğunda glow efektini kaldır
document.addEventListener('mouseleave', () => {
    cursorGlow.classList.remove('hovered');
});
