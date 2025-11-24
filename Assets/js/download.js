$('#downloadForm').on('click', function (e) {
    e.preventDefault();
    const url = '/Assets/images/test-request-form.pdf';
    const a = document.createElement('a');
    a.href = url;
    a.download = 'test-request-form.pdf';
    document.body.appendChild(a);
    a.click();
    a.remove();
});
