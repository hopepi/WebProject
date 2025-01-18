document.querySelectorAll('.card-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();

        let form = this.closest('form');
        let movieId = form.querySelector('input[name="movie_id"]').value;
        let action = this.value; // 'add' veya 'remove'

        // Butonun disable edilmesi, aynı anda birden fazla işlem yapılmasını engeller
        this.disabled = true;

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
                alert('İşlem başarısız oldu: ' + (data.message || 'Bilinmeyen hata'));
            }

            // Butonun tekrar aktif hale getirilmesi
            this.disabled = false;
        })
        .catch(error => {
            console.error('Hata:', error);
            alert('Bir hata oluştu.');
            this.disabled = false;
        });
    });
});
