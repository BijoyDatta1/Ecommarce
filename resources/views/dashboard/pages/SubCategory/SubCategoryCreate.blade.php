@extends('dashboard.layout.main')
@section('section')
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
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3" >
                                    <div class="form-group">
                                        <label name="status"> Status </label>
                                        <select name="stauts" id="status" class="form-control">
                                            <option selected>Select The Status</option>
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
                                        <select name="display" id="display" class="form-control">
                                            <option selected>Select The Status</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="Category">Category</label>
                                    <select class="form-control" id="Category" name="Category">
                                        <option selected>Select Category</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary" onclick="SubCreateCategory()">Create</button>
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
                req.data.data.forEach(function(item, index){
                    let row = `<option value="${item['id']}">${item['name']}</option>`
                    Category.innerHTML += row;
                })
            }
        }
        async function SubCreateCategory(){
            let name = document.getElementById('name').value;
            let status = document.getElementById('status').value;
            let display = document.getElementById('display').value;
            let category_id = document.getElementById('Category').value;
            showLoader();
            let req = await axios.post('/sub/createcategory',{
                'name' : name,
                'category_id' : category_id,
                'status' : status,
                'display' : display
            })
            hideLoader();
            if(req.status === 200 && req.data['status'] === 'success'){
                successToast(req.data['message']);
                setTimeout(function (){
                    window.location.href = "/sub/categorypage";
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
