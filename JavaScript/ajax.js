document.querySelectorAll('.card-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Sayfanın yenilenmesini engelle

        let form = this.closest('form');
        let movieId = form.querySelector('input[name="movie_id"]').value;
        let action = this.value; // 'add' veya 'remove'

        fetch('PHP/updateWatchList.php', {
            method: 'POST',
            body: new URLSearchParams({
                'movie_id': movieId,
                'action': action
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Başarılı olduğunda buton metnini ve değerini güncelle
                if (action === 'add') {
                    this.value = 'remove';
                    this.textContent = 'Listeden Çıkar';
                } else {
                    this.value = 'add';
                    this.textContent = 'İzleme Listesine Ekle';
                }
            } else {
                alert('İşlem başarısız oldu: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Hata:', error);
            alert('Bir hata oluştu.');
        });
    });
});
