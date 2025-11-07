@extends('dashboard.layout.main')
@section('section')
<h1>{{$data->name}}</h1>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{'/categorypage'}}" class="btn btn-primary">Back</a>
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
                    <div class="row">
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
                            <div class="mb-3" >
                                <div class="form-group">
                                    <label name="slug"> Display </label>
                                    <select name="slug" id="display" class="form-control">
                                        @if($data->display === 'yes')
                                            <option value="yes" selected>Yes</option>
                                            <option value="no">No</option>
                                        @else
                                            <option value="yes">Yes</option>
                                            <option value="no" selected>No</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <img id="tamnelImg" style="width: 150px" src="{{asset('uploads/category/').'/'.$data->image}}">
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <input id="categoryImg" oninput="tamnelImg.src=window.URL.createObjectURL(this.files[0])" type="file" name="image" class="form-control" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button class="btn btn-primary" onclick="updateCategory()">Create</button>
                <a href="{{'/categorypage'}}" class="btn btn-outline-dark ml-3">Cancel</a>
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
        async function updateCategory(){

            let id = document.getElementById('categoryId').value;
            let name = document.getElementById('name').value;
            let status = document.getElementById('status').value;
            let display = document.getElementById('display').value;
            let image = document.getElementById('categoryImg').files[0];
            let formData = new FormData();
            formData.append("id", id);
            formData.append("name", name);
            formData.append('status', status);
            formData.append('display', display);
            formData.append('image', image);
            showLoader();
            let req = await axios.post('/updatecategory', formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })
            hideLoader();
            if(req.status === 200 && req.data['status'] === 'success'){
                successToast(req.data['message']);
                setTimeout(function(){
                    window.location.href = "/categorypage";
                },1000);

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
