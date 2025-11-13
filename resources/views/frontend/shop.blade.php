@extends('frontend.layout.app')

@section('section')

    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                        <li class="breadcrumb-item active">Shop</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-6 pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 sidebar">
                        <div class="sub-title">
                            <h2>Categories</h3>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div id="categoryBox" class="accordion accordion-flush" id="accordionExample">


                                </div>
                            </div>
                        </div>

                        <div class="sub-title mt-5">
                            <h2>Brand</h3>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Canon
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Sony
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Oppo
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Vivo
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="sub-title mt-5">
                            <h2>Price</h3>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        $0-$100
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        $100-$200
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        $200-$500
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        $500+
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div  class="col-md-9">
                        <div class="row pb-3">
                            <div class="col-12 pb-1">
                                <div class="d-flex align-items-center justify-content-end mb-4">
                                    <div class="ml-2">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">Sorting</button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#">Latest</a>
                                                <a class="dropdown-item" href="#">Price High</a>
                                                <a class="dropdown-item" href="#">Price Low</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div id="productBox" class="row">

                            </div>



                            <div class="col-md-12 pt-5">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection

@section('script')
    <script>
      getproduct();

      async function getproduct(){
          showLoader();
          let req = await axios.get('/get/shopproduct');
          hideLoader();

          if(req.status === 200 && req.data['status'] === 'success'){
              let productBox = document.getElementById('productBox');
            req.data.data.forEach(function(item, index){
                let row = `
                    <div class="col-md-4">
                                <div class="card product-card">
                                    <div class="product-image position-relative">
                                        <a href="" class="product-img"><img class="card-img-top"  style="height: 350px" src="{{asset('uploads/product')}}/${item['images'][0]['image_url']}" alt=""></a>
                                        <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                                        <div class="product-action">
                                            <a class="btn btn-dark" href="#">
                                                <i class="fa fa-shopping-cart"></i> Add To Cart
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body text-center mt-3">
                                        <a class="h6 link" href="product.php">${item['name']}</a>
                                        <div class="price mt-2">
                                            <span class="h5"><strong>${item['price']}</strong></span>
                                            <span class="h6 text-underline"><del>${item['compare_price']}</del></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                `
               productBox.innerHTML += row;
            });

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

      getCategory();

      async function getCategory(){
          let req = await axios.get('/get/shopcategory');

          if(req.status === 200 && req.data['status'] === 'success'){
              let categoryBox = document.getElementById('categoryBox');
              console.log(req.data.data);
              req.data.data.forEach(function(item, index){
                  let submenuId = `submenuBox${index}`
                  let row = `
                        <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="false" aria-controls="collapse${index}">
                                                ${item['name']}
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                            <div class="accordion-body">
                                                <div id="${submenuId}" class="navbar-nav">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                `
                  categoryBox.innerHTML += row;

                  let submenuBox = document.getElementById(submenuId);

                  item['sub_categoris'].forEach(function(item1,index1){
                      let row1 = `
                            <a href="" class="nav-item nav-link">${item1['name']}</a>
                      `
                      submenuBox.innerHTML += row1;
                  })

              });

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
