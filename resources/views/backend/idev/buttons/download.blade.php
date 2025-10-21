<script>
    // function confirmDownload(fileName, fileUrl, materiId) {
    //     Swal.fire({
    //         title: 'Download File?',
    //         text: 'Apakah kamu ingin mendownload file ' + fileName + '?',
    //         icon: 'question',
    //         showCancelButton: true,
    //         confirmButtonText: 'Download',
    //         cancelButtonText: 'Batal',
    //         reverseButtons: true,
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             // Step 1: Kirim log download ke server
    //             fetch('/api/materi-log', {
    //                 method: 'POST',
    //                 headers: {
    //                     'Content-Type': 'application/json',
    //                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',

    //                 },
    //                 body: JSON.stringify({
    //                     materi_id: materiId,
    //                     action: 'download',
    //                 })
    //             })
    //             .then(response => {
    //                 if (!response.ok) {
    //                     throw new Error('Gagal menyimpan log.');
    //                 }
    //                 return response.json();
    //             })
    //             .then(data => {
    //                 // Step 2: Lanjutkan download file
    //                 const link = document.createElement('a');
    //                 link.href = fileUrl;
    //                 link.download = fileName;
    //                 document.body.appendChild(link);
    //                 link.click();
    //                 document.body.removeChild(link);
    //             })
    //             .catch(error => {
    //                 console.error('Error:', error);
    //                 Swal.fire('Error', 'Gagal mencatat log download.', 'error');
    //             });
    //         }
    //     });
    // }



    function confirmDownload(fileName, fileUrl) {
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
                // Langsung download file
                const link = document.createElement('a');
                link.href = fileUrl;
                link.download = fileName;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        });
    }
</script>
