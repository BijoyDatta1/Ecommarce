@extends('dashboard.layout.main')
@section('section')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Product</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="products.html" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title">Title</label>
                                            <input value="{{$product->name}}" type="text" name="title" id="title" class="form-control" placeholder="Title">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea  name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description">{{$product->description}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Media</h2>
                                <div  id="images" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">
                                        <br>Drop files here or click to upload.<br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input value="{{$product->price}}" type="text" name="price" id="price" class="form-control" placeholder="Price">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="compare_price">Compare at Price</label>
                                            <input value="{{$product->compare_price}}" type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price">
                                            <p class="text-muted mt-3">
                                                To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Inventory</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku">SKU (Stock Keeping Unit)</label>
                                            <input value="{{$product->sku}}" type="text" name="sku" id="sku" class="form-control" placeholder="sku">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barcode">Barcode</label>
                                            <input value="{{$product->barcode}}" type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input  @checked($product->track_qty == 'yes') class="custom-control-input" type="checkbox" id="track_qty" name="track_qty">
                                                <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                             <input value="{{$product->qty}}" type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value=" ">Please Select the status</option>
                                        @if($product->status == 'active')
                                            <option selected value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        @else
                                            <option value="active">Active</option>
                                            <option selected value="inactive">Inactive</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h4  mb-3">Product category</h2>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <input id="activeCategoryId" type="hidden" value="{{$product->category_id}}">
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Select Your Category</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="category">Sub category</label>
                                    <input type="hidden" value="{{$product->sub_category_id}}" id="ActiveSubCategoryId">
                                    <select name="sub_category" id="sub_category" class="form-control">
                                        <option value="">Select Sub Category</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product brand</h2>
                                <div class="mb-3">
                                    <input type="hidden" value="{{$product->brand_id}}" id="activeBrandId">
                                    <select name="brands" id="brands" class="form-control">
                                        <option value="">Select you Product Brand</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Featured product</h2>
                                <div class="mb-3">
                                    <select name="featured" id="featured" class="form-control">
                                        <option value=" ">Do you Want Featured</option>
                                        @if($product->featured == 'yes')
                                            <option selected value="yes">Yes</option>
                                            <option value="no">No</option>
                                        @else
                                            <option value="yes">Yes</option>
                                            <option selected value="no">No</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Display Product</h2>
                                <div class="mb-3">
                                    <select name="display" id="display" class="form-control">
                                        <option value=" ">Do you Want Display</option>
                                        @if($product->display == 'yes')
                                            <option selected value="yes">Yes</option>
                                            <option value="no">No</option>
                                        @else
                                            <option value="yes">Yes</option>
                                            <option selected value="no">No</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button onclick="productUpdate()" class="btn btn-primary">Update</button>
                    <a href="products.html" class="btn btn-outline-dark ml-3">Cancel</a>
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


        //summarnote js plagin
        $(document).ready(function() {
            $('.summernote').summernote();
        });


        //get all active category
        getCategory();
        let category = document.getElementById('category');
        async function getCategory(){
            showLoader();
            let req = await axios.get('/activecategory');
            hideLoader();

            if(req.status === 200 && req.data['status'] === 'success'){
                let activeCategory = document.getElementById('activeCategoryId').value;
                req.data.data.forEach(function (item, index){
                    let row =  `<option ${item['id'] == activeCategory ? 'selected' : ""} value="${item['id']}">${item['name']}</option>`
                    category.innerHTML += row;
                })
                getSubcategory(activeCategory);
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

        // get active sub category by category id
        category.addEventListener('change',function (){
            let id = this.value;
            getSubcategory(id);
        })

        async function getSubcategory(id){
            let subcategory = document.getElementById('sub_category');
            subcategory.innerHTML = '<option value="">Select Sub Category</option>';
            showLoader();
            req = await axios.post('/getactivesubcategory',{
                id : id
            });
            hideLoader();
            if(req.status === 200 && req.data['status'] === 'success'){
                let activeSubCategory = document.getElementById('ActiveSubCategoryId').value;
                console.log(activeSubCategory);
                req.data.data.forEach(function (item,index){
                    let row = `<option ${item['id'] == activeSubCategory ? 'selected' : ""} value="${item['id']}">${item['name']}</option>`
                    subcategory.innerHTML += row;
                })
            }else {
                let subcategory = document.getElementById('sub_category');
                let data = req.data.message;
                if(typeof data === 'object'){
                    for (let key in data) {
                        let row = `<option value="">${data[key]}</option>`
                        subcategory.innerHTML += row;
                    }
                }else{
                    let row = `<option value="">${data}</option>`
                    subcategory.innerHTML += row;
                }
            }
        }

        // get all active brands
        getBrand();
        async function getBrand(){
            showLoader();
            let req = await axios.get('/getactivebrand');
            hideLoader();
            let brand =  document.getElementById('brands');
            if(req.status === 200 && req.data['status'] === 'success'){
                let activeBrand = document.getElementById('activeBrandId').value;
                req.data.data.forEach(function (item,index){
                    let row = `<option ${item['id'] == activeBrand ? 'selected' : ""} value="${item['id']}">${item['name']}</option>`
                    brand.innerHTML += row;
                })
            }else {
                let brand = document.getElementById('sub_category');
                let data = req.data.message;
                if(typeof data === 'object'){
                    for (let key in data) {
                        let row = `<option value="">${data[key]}</option>`
                        brand.innerHTML += row;
                    }
                }else{
                    let row = `<option value="">${data}</option>`
                    brand.innerHTML += row;
                }
            }

        }




        //dorpzone js plagin innatializ
        Dropzone.autoDiscover = false;

        let existingImages = @json($images);
        let removedImageIds = [];

        let dropzone = new Dropzone("#images", {
            url: "/create/product", // same endpoint
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 10,
            maxFiles: 10,
            paramName: "images",
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            dictRemoveFile: "Remove", // optional: text for the button

            thumbnailWidth: 200,
            thumbnailHeight: 200,
            thumbnailMethod: "contain",


            init: function () {
                let myDropzone = this;

                // 🩵 1️⃣ Preload existing images
                existingImages.forEach(function (image) {
                    let mockFile = { name: image.image_url, size: 12345 };
                    myDropzone.emit("addedfile", mockFile);
                    myDropzone.emit("thumbnail", mockFile, `/uploads/product/${image.image_url}`);
                    myDropzone.emit("complete", mockFile);
                    mockFile.serverId = image.id;
                });

                // 🧡 2️⃣ When remove clicked
                this.on("removedfile", function (file) {
                    if (file.serverId) {
                        // This was an existing image
                        removedImageIds.push(file.serverId); // store for later deletion
                        console.log("Marked for deletion:", file.serverId);
                    }
                });
            }
        });


        async function productUpdate(){
            let id = "{{$product->id}}";
            let name = document.getElementById('title').value;
            let description = document.getElementById('description').value;
            let price = document.getElementById('price').value;
            let compare_price = document.getElementById('compare_price').value;
            let category_id = document.getElementById('category').value;
            let sub_category_id = document.getElementById('sub_category').value;
            let brand_id = document.getElementById('brands').value;
            let featured = document.getElementById('featured').value;
            let display = document.getElementById('display').value;
            let status = document.getElementById('status').value;
            let sku = document.getElementById('sku').value;
            let barcode = document.getElementById('barcode').value;
            let track_qty = document.getElementById('track_qty').checked ? 'yes' : 'no';
            let qty = document.getElementById('qty').value;

            let formData = new FormData();
            formData.append('id',id);
            formData.append('name',name);
            formData.append('description',description);
            formData.append('price',price);
            formData.append('compare_price',compare_price);
            formData.append('category_id',category_id);
            formData.append('sub_category_id',sub_category_id);
            formData.append('brand_id',brand_id);
            formData.append('featured',featured);
            formData.append('display',display);
            formData.append('status',status);
            formData.append('sku',sku);
            formData.append('barcode',barcode);
            formData.append('track_qty',track_qty);
            formData.append('qty',qty);

            formData.append('removeImages', JSON.stringify(removedImageIds));

            dropzone.files.forEach(file => {
                if(!file.serverId){
                    formData.append('images[]',file);
                }
            })

            showLoader();
            let req = await axios.post('/update/product',formData,{
                headers: { 'Content-Type': 'multipart/form-data' }
            })
            hideLoader();

            if(req.status === 200 && req.data['status'] === 'success'){
                successToast(req.data.message);
                dropzone.removeAllFiles(true);
                setTimeout(function (){
                    window.location.href = "/getproduct/listpage";
                },2000)

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
