<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function confirmDownload(fileName, fileUrl, materiId) {
    const url = "{{ route('materi.download.count') }}"; // Blade route

    Swal.fire({
        title: 'Download File?',
        text: 'Apakah kamu ingin mendownload file ' + fileName + '?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Download',
        cancelButtonText: 'Batal',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(url, { materi_id: materiId }, function(response) {
                if(response.status) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message || 'Download berhasil tercatat.',
                        icon: 'success',
                        timer: 1200,
                        showConfirmButton: false
                    });

                    setTimeout(() => {
                        const link = document.createElement('a');
                        link.href = fileUrl;
                        link.download = fileName;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    }, 800);
                } else {
                    Swal.fire('Gagal', response.message || 'Gagal mencatat log download.', 'error');
                }
            }).fail(function(xhr) {
                let msg = xhr.responseJSON?.message || 'Terjadi kesalahan saat mencatat download.';
                Swal.fire('Error', msg, 'error');
            });
        }
    });
}
</script>
