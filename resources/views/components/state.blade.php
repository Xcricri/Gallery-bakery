<div x-data="{
        modalOpen: false,
        activePhotos: [],
        currentPhotoIndex: 0,
        galleryTitle: '',
        currentUser: {{ Auth::check() ? 'true' : 'false' }},

        openModal(photos, title) {
            if (!photos || photos.length === 0) {
                alert('Tidak ada foto dalam galeri ini.');
                return;
            }
            this.activePhotos = photos;
            this.galleryTitle = title;
            this.currentPhotoIndex = 0;
            this.modalOpen = true;
            document.body.style.overflow = 'hidden';
        },
        closeModal() {
            this.modalOpen = false;
            setTimeout(() => { this.activePhotos = []; }, 300);
            document.body.style.overflow = 'auto';
        },
        nextPhoto() {
            this.currentPhotoIndex = (this.currentPhotoIndex + 1) % this.activePhotos.length;
        },
        prevPhoto() {
            this.currentPhotoIndex = (this.currentPhotoIndex - 1 + this.activePhotos.length) % this.activePhotos.length;
        }
    }">
    {{ $slot }}
</div>
