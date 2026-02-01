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
                            <div id="brandBox" class="card-body">

                            </div>
                        </div>

                        <div class="sub-title mt-5">
                            <h2>Price</h3>
                        </div>

                        <div class="card">
                            <input type="text" class="js-range-slider" name="my_range" value="" />
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

        //ion range slider plaging code for price input
        $(".js-range-slider").ionRangeSlider({
            type: "double",
            min: 0,
            max: 100000,
            from: 200,
            to: 500,
            prefix: "৳",
            skin : "round",

        });

        //get value form ion range plaging
        let price = $(".js-range-slider").data('ionRangeSlider');
        console.log(price.result.to);


      let SelectedBrands = [];
      let currentCategory = null;
      let currentSubCategory = null;

      getproduct();
      async function getproduct(category = null, subcategory = null){
          let url = '/get/shopproduct';
          if(category !== null && subcategory === null){
            url = `/get/shopproduct/${category}`;
          }
          if(subcategory !== null && category !== null){
            url = `/get/shopproduct/${category}/${subcategory}`;
          }

          if(SelectedBrands.length > 0){
              url += `?brands=${SelectedBrands.join(',')}`;
          }
          if(price.result.to > 499){
              url += '?price_min='+price.result.from;
              url += '?price_max='+price.result.to;
          }

          showLoader();
          let req = await axios.get(url);
          hideLoader();
          console.log(req.data['data']);

          if(req.status === 200 && req.data['status'] === 'success'){
              let productBox = document.getElementById('productBox');
              productBox.innerHTML = '';
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

              req.data.data.forEach(function(item, index){
                  let submenuId = `submenuBox${index}`;
                  let button = '';
                  if(item['sub_categoris'].length === 0){
                      button = `<a href="#" data-category="${item['slug']}" class="nav-item nav-link category-link">${item['name']}</a>`
                  }else{
                      button = `
                            <h2 class="accordion-header" id="heading${index}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="false" aria-controls="collapse${index}">
                                      ${item['name']}
                                   </button>
                            </h2>`
                  }

                  let row = `
                        <div class="accordion-item">
                                            ${button}
                                        <div id="collapse${index}" class="accordion-collapse collapse" aria-labelledby="heading${index}" data-bs-parent="#accordionExample" style="">
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
                            <a href="#" data-category="${item['slug']}" data-subcategory="${item1['slug']}" class="nav-item nav-link subcategory-link">${item1['name']}</a>
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

      document.addEventListener('click', function (e){
          if(e.target.classList.contains("category-link")){
              e.preventDefault();
              currentCategory = e.target.getAttribute('data-category');
              getproduct(currentCategory);
          }
      })

      document.addEventListener('click', function(e){
          if(e.target.classList.contains('subcategory-link')){
              e.preventDefault();
              currentCategory = e.target.getAttribute('data-category');
              currentSubCategory = e.target.getAttribute('data-subcategory');
              getproduct(currentCategory, currentSubCategory);
          }
      })


      getBrand();
      async function getBrand(){
          let req = await axios.get('/get/shopbrand');
          if(req.status === 200 && req.data['status'] === 'success'){
              let brandBox = document.getElementById('brandBox')
              req.data.data.forEach(function(item,index){
                  let row = `
                      <div class="form-check mb-2">
                                    <input class="form-check-input brand-filter" type="checkbox" value="${item['id']}" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        ${item['name']}
                                    </label>
                      </div>
                  `
                  brandBox.innerHTML += row;

              })

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

      //add change even on chackbox button for brand fillter function
      document.addEventListener('change', function(e){
          if(e.target.classList.contains('brand-filter')){
              let brandId = e.target.value;

              if(e.target.checked){
                  SelectedBrands.push(brandId);
              }else{
                  SelectedBrands = SelectedBrands.filter(function (id) {
                      return id !== brandId;
                  })
              }

              getproduct(currentCategory, currentSubCategory)
          }
      })


    </script>
@endsection
