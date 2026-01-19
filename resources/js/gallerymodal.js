export function galleryModal(currentUser) {
    return {
        currentUser: currentUser,
        modalOpen: false,
        activePhotos: [],
        currentPhotoIndex: 0,
        newComment: '',

        openModal(photos, title = '') {
            this.activePhotos = photos;
            this.currentPhotoIndex = 0;
            this.galleryTitle = title;
            this.modalOpen = true;
        },

        closeModal() {
            this.modalOpen = false;
        },

        nextPhoto() {
            this.currentPhotoIndex = (this.currentPhotoIndex + 1) % this.activePhotos.length;
        },

        prevPhoto() {
            this.currentPhotoIndex = (this.currentPhotoIndex - 1 + this.activePhotos.length) % this.activePhotos.length;
        },

        async submitComment() {
            if (!this.newComment) return;

            try {
                const response = await fetch('/comments', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        photo_id: this.activePhotos[this.currentPhotoIndex].id,
                        content: this.newComment,
                        name: this.currentUser?.name || null
                    })
                });

                if (response.ok) {
                    const newComment = await response.json();
                    this.activePhotos[this.currentPhotoIndex].comments.push(newComment);
                    this.newComment = '';
                } else {
                    console.error('Gagal mengirim komentar');
                }
            } catch (err) {
                console.error('Error submit comment:', err);
            }
        }
    }
}
