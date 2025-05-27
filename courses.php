fetch('/student-portal/ajax/enroll.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ course_id: btn.dataset.id })
})
.then(response => {
    if (!response.ok) {
        throw new Error(HTTP error! status: ${response.status});
    }
    return response.json();
})
.then(data => {
    if (data.success) {
        // تغيير الزر حسب الحالة
        if (data.action === 'enrolled') {
            btn.classList.replace('btn-success', 'btn-danger');
            btn.innerHTML = '<i class="bi bi-x-circle"></i> Cancel Enrollment';
        } else {
            btn.classList.replace('btn-danger', 'btn-success');
            btn.innerHTML = '<i class="bi bi-plus-circle"></i> Enroll';
        }

        // إنشاء Toast في أسفل منتصف الصفحة
        const toastWrapper = document.createElement('div');
        toastWrapper.className = 'toast-container position-fixed bottom-0 start-50 translate-middle-x p-3';
        toastWrapper.style.zIndex = '1055';

        const toast = document.createElement('div');
        toast.className = 'toast align-items-center text-white bg-success border-0 show';
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');

        toast.innerHTML = 
            <div class="d-flex">
                <div class="toast-body">
                    ${data.message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        ;

        toastWrapper.appendChild(toast);
        document.body.appendChild(toastWrapper);

        // إزالة التنبيه بعد 3 ثوانٍ
        setTimeout(() => toastWrapper.remove(), 3000);
    } else {
        alert(data.message || 'Operation failed.');
    }
})
.catch(error => {
    console.error('Operation error:', error);
    alert('Failed to process request. Please try again.');
});