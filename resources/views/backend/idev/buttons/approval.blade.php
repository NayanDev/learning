<div class="modal fade" tabindex="-1" role="dialog" id="modalApproval">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi</h5>
            </div>
            <div class="modal-body">
                <p>Approve / Reject data ?</p>
                <form id='formApproval' class="m-t-20" action="" method="post">
                    {{ csrf_field() }}
                    <div class="my-2">
                        <label for="">Status</label>
                        <select name="" id="apprej" class="form-control">
                            <option value="">Pilih Opsi</option>
                            <option value="Approve">Approve</option>
                            <option value="Reject">Reject</option>
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="">Notes</label>
                        <textarea name="" id="" cols="30" rows="4" class="form-control"></textarea>
                    </div>
                    <hr>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="actionApproval()">Ya</button>
                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal">Tidak</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function actionApproval() {
        var aprej = $("#apprej").val()
        alertSwal("success", "Sukses "+aprej+" Data");
        $("#modalApproval").modal("hide");
    }

    function setApproval(params) {
        console.log(params);
    }
</script>