@extends('dashboard.layout.main')
@section('section')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Brand</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{'/brandpage'}}" class="btn btn-primary">Back</a>
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
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3" >
                                    <div class="form-group">
                                        <label name="slug"> Status </label>
                                        <select name="slug" id="status" class="form-control">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3" >
                                    <div class="form-group">
                                        <label name="display"> Display </label>
                                        <select name="display" id="display" class="form-control" placeholder="Select Brand Name">
                                            <option value="yes">YES</option>
                                            <option value="no">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                               <img id="tamnelImg" style="width: 150px" src="{{asset('dashboardAsset/img/default-150x150.png')}}">
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <input id="brandImg" oninput="tamnelImg.src=window.URL.createObjectURL(this.files[0])" type="file" name="image" class="form-control" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary" onclick="brandCreate()">Create</button>
                    <a href="{{'/brandpage'}}" class="btn btn-outline-dark ml-3">Cancel</a>
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
        async function brandCreate(){
            let name = document.getElementById('name').value;
            let status = document.getElementById('status').value;
            let display = document.getElementById('display').value;
            let image = document.getElementById('brandImg').files[0];
            let formData = new FormData();
            formData.append("name", name);
            formData.append('status', status);
            formData.append('image', image);
            formData.append('display', display)
            showLoader();
            let req = await axios.post('/createbrand', formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })
            hideLoader();
            if(req.status === 200 && req.data['status'] === 'success'){
                setTimeout(function(){
                    successToast(req.data['message']);
                },1000);
                window.location.href = "/brandpage";
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
