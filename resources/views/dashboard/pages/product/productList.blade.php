@extends('dashboard.layout.main')
@section('section')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Products</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{'/product/createpage'}}" class="btn btn-primary">Create Product</a>
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
                    <div class="card-body table-responsive p-0">
                        <table id="tableData" class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th width="60">No</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Compare Price</th>
                                <th>Quntaty</th>
                                <th>Featured</th>
                                <th>Display</th>
                                <th >Status</th>
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
    @include('dashboard.pages.product.productDelete');
@endsection

@section('script')
    <script>
        getList();


        async function updateStatus(id, status){
            showLoader();
            let req = await axios.post('/sub/updatestatus',{
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
            let req = await axios('/get/allproduct');
            hideLoader();
            let tablebody = $('#tableData');
            let tableList = $('#tableList');

            //DataTable(),empty() and destroy() fucntion from jqurey Data Table plagin. those function fast distroy the table and then empty the table
            tablebody.DataTable().destroy();
            tableList.empty();

            if(req.status === 200 && req.data['status'] === 'success'){
                req.data['product'].forEach(function(item,index){

                    let images = [];
                    req.data['images'].forEach(function (item1, index1){
                        if(item['id'] === item1['product_id']){
                             images.push(item1['image_url'])
                        }
                    })
                    console.log(images);

                    let imageHtml = '';
                    for(let i = 0; i < images.length && i < 3; i++){
                        imageHtml += `<img style="width: 50px; padding: 2px; border: 1px solid gray" src="/uploads/product/${images[i]}" alt="">`
                    }

                    let badgeStatus = item['status'] == "active" ? "badge badge-success" : "badge badge-danger";
                    let badgeFeature = item['featured'] == "yes" ? "badge badge-success" : "badge badge-danger";
                    let badgeDisplay = item['display'] == "yes" ? "badge badge-success" : "badge badge-danger";
                    let button = item['status'] == "active"
                        ? `<button type="button" data-id="${item['id']}" data-status ="inactive" class="btn StatusButton btn-warning">Inactive</button>`
                        : `<button type="button" data-id="${item['id']}" data-status ="active" class="btn StatusButton btn-success">Active</button>`;
                    let row = `
                        <tr>
                                <td>${index + 1}</td>
                                <td>${item['name']}</td>
                                <td class="thumbnel">${imageHtml}</td>
                                <td>${item['price']}</td>
                                <td>${item['compare_price']}</td>
                                <td>${item['qty']}</td>
                                <td><span class="${badgeFeature}">${item['featured']}</span></td>
                                <td><span class="${badgeDisplay}">${item['display']}</span></td>
                                <td><span class="${badgeStatus}">${item['status']}</span></td>
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
                    document.getElementById('deleteCategoryId').value = id;
                    let modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
                    modal.show();
                })
            })

            let UpdateButton = document.querySelectorAll('.EditButton');
            UpdateButton.forEach(function(button){
                button.addEventListener('click',function(){
                    let id  = this.getAttribute('data-id');
                    window.location.href = `/subCategory/updatepage/${id}`;
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
