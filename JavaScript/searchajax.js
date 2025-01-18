document.querySelectorAll('.watch-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();  // Butona tıklanmasıyla sayfanın yenilenmesini engelle

        const movie_id = this.getAttribute('data-movie-id');  // Movie ID'yi butondan al
        const action = this.textContent.includes('Ekle') ? 'add' : 'remove';  // Buton metnine göre işlem

        const formData = new URLSearchParams();
        formData.append('movie_id', movie_id);
        formData.append('action', action);

        fetch('PHP/updateWatchList.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: formData.toString()  // Form verisini URL encoded olarak gönder
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // İşlem başarılı olduğunda buton metnini güncelle
                if (action === 'add') {
                    this.textContent = 'Listeden Çıkar';  // 'Ekle' ise, 'Çıkar' olarak değiştir
                } else {
                    this.textContent = 'İzleme Listesine Ekle';  // 'Remove' ise, 'Ekle' olarak değiştir
                }
            } else {
                alert(data.message);  // Başarısız olursa hata mesajını göster
            }
        })
        .catch(error => console.error('Hata:', error));
    });
});
