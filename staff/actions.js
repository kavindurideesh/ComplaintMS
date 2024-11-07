function submitDeleteForm(studentId) {
    Swal.fire({
        title: 'Confirm Delete',
        text: 'Are you sure you want to delete this student?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'post';
            form.action = 'manage.php'; 
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'delete';
            input.value = studentId;
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
