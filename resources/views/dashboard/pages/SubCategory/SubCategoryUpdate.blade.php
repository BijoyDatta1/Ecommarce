@extends('dashboard.layout.main')
@section('section')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update Sub Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{'/sub/categorypage'}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <input class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{$data->name}}">
                                <input type="hidden" id="categoryId" value="{{$data->id}}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3" >
                                <div class="form-group">
                                    <label name="slug"> Status </label>
                                    <select name="slug" id="status" class="form-control">
                                        @if($data->status === 'active')
                                            <option value="active" selected>Active</option>
                                            <option value="inactive">Inactive</option>
                                        @else
                                            <option value="active">Active</option>
                                            <option value="inactive" selected>Inactive</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="Category">Category</label>
                                <select class="form-control" id="Category" name="Category">

                                </select>
                            </div>
                        </div>
                        <input type="hidden" id="selectedCategoryId" value="{{$category->id}}">

                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button class="btn btn-primary" onclick="subCategoryUpdate()">Create</button>
                <a href="{{'/sub/categorypage'}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('script')
    <script>

        getCategory();
        async function getCategory() {
            showLoader();
            let req = await axios.get('/getcategory');
            hideLoader();
            if(req.status === 200 && req.data['status'] === 'success'){
                let Category = document.getElementById('Category');
                let selectedCategoryId = document.getElementById('selectedCategoryId').value;
                req.data.data.forEach(function(item, index){
                    selectedCategoryId == item['id'] ? let selected = "selected" : "";
                    let row = `<option ${selected} value="${item['id']}">${item['name']}</option>`
                    Category.innerHTML += row;
                })
            }
        }

        async function subCategoryUpdate(){

            let id = document.getElementById('categoryId').value;
            let name = document.getElementById('name').value;
            let status = document.getElementById('status').value;
            let image = document.getElementById('categoryImg').files[0];
            let formData = new FormData();
            formData.append("id", id);
            formData.append("name", name);
            formData.append('status', status);
            formData.append('image', image);
            showLoader();
            let req = await axios.post('/updatecategory', formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })
            hideLoader();
            if(req.status === 200 && req.data['status'] === 'success'){
                setTimeout(function(){
                    successToast(req.data['message']);
                },1000);
                window.location.href = "/categorypage";
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
@endsection
