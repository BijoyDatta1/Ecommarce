<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteConfirmLabel">Confirm Delete</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this item?
                <input type="hidden" id="deleteCategoryId">
            </div>
            <div class="modal-footer">
                <button type="button" id="delete-close-btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="deleteCategoy()" id="confirmDeleteBtn" class="btn btn-danger">Confirm</button>
            </div>
        </div>
    </div>
</div>
<script>
    async function deleteCategoy(){
        let id = document.getElementById('deleteCategoryId').value;
        showLoader();
        let req = await axios.post('/sub/deletecategory',{
            id : id
        })
        hideLoader();

        if(req.status === 200 && req.data['status'] === "success"){
            successToast(req.data['message']);
            document.getElementById('delete-close-btn').click();
            await getList();
        }else{
            let data = req.data.message;
            if(typeof data === 'object'){
                for (let key in data) {
                    errorToast(data[key]);
                }
            }else{
                errorToast(data);
            }
        }
    }
</script>
