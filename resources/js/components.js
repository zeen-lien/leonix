document.addEventListener('alpine:initializing', () => {

    Alpine.data('dashboardStats', () => ({
        stats: {
            totalFiles: 0,
            storageUsed: '0 B',
            trashFiles: 0,
            latestFile: '-'
        },
        fetchStats() {
            axios.get('/dashboard/statistics')
                .then(response => {
                    this.stats = response.data;
                })
                .catch(error => {
                    console.error('Error fetching statistics:', error);
                    window.dispatchEvent(new CustomEvent('show-notification', {
                        detail: { type: 'error', message: 'Gagal memuat statistik.' }
                    }));
                });
        }
    }));

    Alpine.data('folderCreateModal', () => ({
        show: false,
        name: '',
        parentId: null,
        errors: {},
        open(detail) {
            this.show = true;
            this.name = '';
            this.errors = {};
            this.parentId = detail ? (detail.parentId !== undefined ? detail.parentId : null) : null;
            this.$nextTick(() => {
                if (this.$refs.folderNameInput) {
                    this.$refs.folderNameInput.focus();
                }
            });
        },
        close() {
            this.show = false;
        },
        submit() {
            axios.post('/folders', {
                name: this.name,
                parent_id: this.parentId
            })
            .then(response => {
                this.close();
                window.dispatchEvent(new CustomEvent('show-notification', {
                    detail: { type: 'success', message: response.data.message || 'Folder berhasil dibuat!' }
                }));
                setTimeout(() => window.location.reload(), 1000);
            })
            .catch(error => {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                     window.dispatchEvent(new CustomEvent('show-notification', {
                        detail: { type: 'error', message: 'Terjadi kesalahan saat membuat folder.' }
                    }));
                }
            });
        }
    }));

    Alpine.data('uploadModal', () => ({
        show: false, 
        folderId: null,
        files: [], 
        dragging: false, 
        progress: 0, 
        error: '', 
        success: '', 
        isUploading: false,
        
        open(detail) {
            this.show = true;
            this.folderId = detail ? (detail.folderId !== undefined ? detail.folderId : null) : null;
            this.files = [];
            this.error = '';
            this.success = '';
            this.progress = 0;
            this.isUploading = false;
        },

        close() {
            if (this.isUploading) return;
            this.show = false;
        },

        handleFileDrop(event) {
            this.dragging = false;
            if (event.dataTransfer.files.length > 0) {
                 this.files = [...this.files, ...Array.from(event.dataTransfer.files)];
            }
        },

        handleFileSelect(event) {
            if (event.target.files.length > 0) {
                 this.files = [...this.files, ...Array.from(event.target.files)];
            }
        },

        removeFile(index) {
            this.files.splice(index, 1);
        },

        submitForm() {
            this.progress = 0;
            this.error = '';
            this.success = '';
            this.isUploading = true;

            if (this.files.length === 0) {
                this.error = 'Silakan pilih setidaknya satu file.';
                this.isUploading = false;
                return;
            }

            let formData = new FormData();
            for (let i = 0; i < this.files.length; i++) {
                formData.append('file[]', this.files[i]);
            }
            
            if (this.folderId !== null) {
                formData.append('folder_id', this.folderId);
            }

            axios.post('/files', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress: (progressEvent) => {
                    this.progress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                }
            }).then(response => {
                this.success = response.data.message;
                this.files = [];
                this.progress = 0;
                this.isUploading = false;
                window.dispatchEvent(new CustomEvent('show-notification', {
                    detail: { type: 'success', message: this.success }
                }));
                setTimeout(() => window.location.reload(), 1500);
            }).catch(error => {
                this.progress = 0;
                this.isUploading = false;
                if (error.response && error.response.data.errors) {
                    this.error = Object.values(error.response.data.errors).flat().join(' ');
                } else if (error.response && error.response.data.message) {
                    this.error = error.response.data.message;
                } else {
                    this.error = 'Terjadi kesalahan tidak diketahui.';
                }
                window.dispatchEvent(new CustomEvent('show-notification', {
                    detail: { type: 'error', message: this.error }
                }));
            });
        }
    }));
}); 