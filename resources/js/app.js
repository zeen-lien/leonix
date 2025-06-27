import './bootstrap';
import Chart from 'chart.js/auto';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import axios from 'axios';

window.Alpine = Alpine;
window.axios = axios;
window.Chart = Chart;

// --- SweetAlert2 Themed Instances ---
const cyberpunkTheme = {
    background: 'rgba(20, 20, 35, 0.95)',
    color: '#ffffff',
    confirmButtonColor: '#00FFC6',
    cancelButtonColor: '#FF5AF7',
    confirmButtonText: 'Konfirmasi',
    cancelButtonText: 'Batal',
};

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    },
    background: cyberpunkTheme.background,
    color: cyberpunkTheme.color,
});

window.Swal = Swal.mixin({
    ...cyberpunkTheme,
    customClass: {
        popup: 'glass-card',
        title: 'cyberpunk-gradient',
        confirmButton: 'btn-gradient',
        cancelButton: 'btn-gradient',
    }
});


// --- Global Event Listeners ---
window.addEventListener('show-notification', event => {
    Toast.fire({
        icon: event.detail.type || 'success',
        title: event.detail.message || 'Selesai!'
    });
});

window.addEventListener('show-confirm-dialog', async event => {
    const { title, message, action, fileId, method = 'DELETE', confirmButtonText = 'Ya, lakukan!' } = event.detail;

    const result = await window.Swal.fire({
        title: title,
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: confirmButtonText,
    });

    if (result.isConfirmed) {
        try {
            let response;
            const headers = {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            };

            if (method.toUpperCase() === 'DELETE') {
                response = await axios.delete(action, { headers });
            } else {
                response = await axios.post(action, {}, { headers });
            }
            
            window.dispatchEvent(new CustomEvent('show-notification', {
                detail: {
                    type: 'success',
                    message: response.data.message || 'Aksi berhasil diselesaikan.'
                }
            }));

            // Optional: Dispatch another event to update the UI
            if (fileId) {
                window.dispatchEvent(new CustomEvent('file-deleted', { detail: { fileId: fileId }}));
            } else {
                // General purpose event for reloads
                window.dispatchEvent(new CustomEvent('action-completed'));
            }

        } catch (error) {
            window.dispatchEvent(new CustomEvent('show-notification', {
                detail: {
                    type: 'error',
                    message: error.response.data.message || 'Terjadi sebuah kesalahan.'
                }
            }));
        }
    }
});

window.addEventListener('action-completed', event => {
    window.location.reload();
});

    // Component for the Create Folder Modal
    Alpine.data('folderCreateModal', () => ({
        show: false,
        name: '',
        parentId: null,
        errors: {},
        open(detail) {
            this.show = true;
            this.parentId = detail && detail.hasOwnProperty('parentId') ? detail.parentId : null;
            this.name = '';
            this.errors = {};
            this.$nextTick(() => this.$refs.folderNameInput.focus());
        },
        close() {
            this.show = false;
        },
        async submit(formElement) {
            this.errors = {};
            const actionUrl = formElement.dataset.action;
            try {
                const response = await axios.post(actionUrl, {
                    name: this.name,
                    parent_id: this.parentId,
                });
                window.dispatchEvent(new CustomEvent('show-notification', {
                    detail: { type: 'success', message: response.data.message }
                }));
            
            // Dispatch event with the new folder data
            window.dispatchEvent(new CustomEvent('folder-created', { detail: { folder: response.data.folder }}));

                this.close();
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    window.dispatchEvent(new CustomEvent('show-notification', {
                        detail: { type: 'error', message: 'Terjadi kesalahan.' }
                    }));
                }
            }
        }
    }));

Alpine.start();
