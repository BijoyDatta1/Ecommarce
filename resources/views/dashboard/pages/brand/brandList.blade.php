@extends('dashboard.layout.main')
@section('section')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Brand</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{'/brandcreatepage'}}" class="btn btn-primary">New Brand</a>
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
                    <div class="card-header">
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 250px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table id="tableData" class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th width="60">No</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Display</th>
                                <th width="100">Status</th>
                                <th width="100">Action</th>
                            </tr>
                            </thead>
                            <tbody id="tableList">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    {{--delete modal include for conframation--}}
    @include('dashboard.pages.brand.delete');
@endsection

@section('script')
    <script>
        getList();

        async function updateStatus(id, status){
            showLoader();
            let req = await axios.post('/updatebrandstatus',{
                id : id,
                status : status
            });
            hideLoader();

            if(req.status === 200 && req.data['status'] === 'success'){
                successToast(req.data['message']);
                getList();
            }
        }

        async function getList(){
            showLoader();
            let req = await axios('/getbrand');
            hideLoader();
            let tablebody = $('#tableData');
            let tableList = $('#tableList');

            //DataTable(),empty() and destroy() fucntion from jqurey Data Table plagin. those function fast distroy the table and then empty the table
            tablebody.DataTable().destroy();
            tableList.empty();

            if(req.status === 200 && req.data['status'] === 'success'){
                req.data.data.forEach(function(item,index){
                    let statusBadge = item['status'] == "active" ? "badge badge-success" : "badge badge-danger";
                    let displayBadge = item['display'] == "yes" ? "badge badge-success" : "badge badge-danger";
                    let button = item['status'] == "active"
                        ? `<button type="button" data-id="${item['id']}" data-status ="inactive" class="btn StatusButton btn-warning">Inactive</button>`
                        : `<button type="button" data-id="${item['id']}" data-status ="active" class="btn StatusButton btn-success">Active</button>`;
                    let row = `
                        <tr>
                                <td>${index + 1}</td>
                                <td><img style="width: 50px" src="uploads/brand/${item['image']}" alt=""></td>
                                <td>${item['name']}</td>
                                <td>${item['slug']}</td>
                                <td><span class="${displayBadge}">${item['display']}</span></td>
                                <td><span class="${statusBadge}">${item['status']}</span></td>
                                <td>
                                    <button type="button" data-id="${item['id']}" class="btn EditButton btn-success">Edit</button>
                                    <button type="button" data-id="${item['id']}" class="btn DeleteButton btn-danger">Delete</button>
                                    ${button}
                                </td>
                            </tr>
                    `
                    tableList.append(row);
                })

            }else{

            }

            let StatusButton = document.querySelectorAll('.StatusButton');
            StatusButton.forEach(function(button){
                button.addEventListener('click',function (){
                    let id = this.getAttribute('data-id');
                    let status = this.getAttribute('data-status');
                    updateStatus(id,status);
                })
            })

            let DeleteButtons = document.querySelectorAll('.DeleteButton');
            DeleteButtons.forEach(function(button){
                button.addEventListener('click',function(){
                    let id = this.getAttribute('data-id');
                    document.getElementById('deleteBrandId').value = id;
                    let modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
                    modal.show();
                })
            })

            let UpdateButton = document.querySelectorAll('.EditButton');
            UpdateButton.forEach(function(button){
                button.addEventListener('click',function(){
                    let id  = this.getAttribute('data-id');
                    window.location.href = `/brand/updatepage/${id}`;
                })
            })



            //jqurey data table plagin
            new DataTable('#tableData', {
                order:[[0,'desc']],
                lengthMenu:[5,10,15,20,30]
            });
        }
    </script>
@endsection
