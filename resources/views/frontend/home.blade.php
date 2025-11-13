@extends('frontend.layout.app')

@section('section')
<main>
    <section class="section-1">
        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <!-- <img src="images/carousel-1.jpg" class="d-block w-100" alt=""> -->

                    <picture>
                        <source media="(max-width: 799px)" srcset="images/carousel-1-m.jpg" />
                        <source media="(min-width: 800px)" srcset="images/carousel-1.jpg" />
                        <img src="images/carousel-1.jpg" alt="" />
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">Kids Fashion</h1>
                            <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">

                    <picture>
                        <source media="(max-width: 799px)" srcset="images/carousel-2-m.jpg" />
                        <source media="(min-width: 800px)" srcset="images/carousel-2.jpg" />
                        <img src="images/carousel-2.jpg" alt="" />
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">Womens Fashion</h1>
                            <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <!-- <img src="images/carousel-3.jpg" class="d-block w-100" alt=""> -->

                    <picture>
                        <source media="(max-width: 799px)" srcset="images/carousel-3-m.jpg" />
                        <source media="(min-width: 800px)" srcset="images/carousel-3.jpg" />
                        <img src="images/carousel-2.jpg" alt="" />
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">Shop Online at Flat 70% off on Branded Clothes</h1>
                            <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    <section class="section-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-check text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">Quality Product</h5>
                    </div>
                </div>
                <div class="col-lg-3 ">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">Free Shipping</h2>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-exchange-alt text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">14-Day Return</h2>
                    </div>
                </div>
                <div class="col-lg-3 ">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">24/7 Support</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-3">
        <div class="container">
            <div class="section-title">
                <h2>Categories</h2>
            </div>
            <div id="categorybox" class="row pb-3">


            </div>
        </div>
    </section>


    <section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>Featured Products</h2>
            </div>
            <div id="featuredBox" class="row pb-3">

            </div>
        </div>
    </section>

    <section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>Latest Produsts</h2>
            </div>
            <div id="latestBox" class="row pb-3">

            </div>
        </div>
    </section>
</main>

@endsection

@section('script')
    <script>
        getCategory();
        async function getCategory(){
            showLoader()
            let req = await axios.get('home/all/category');
            hideLoader()
            if(req.status === 200 && req.data['status'] === 'success'){
                let categorybox = document.getElementById('categorybox');
                req.data.categories.forEach(function (item, index){

                    let row = `
                    <div class="col-lg-3">
                    <div class="cat-card">
                        <div class="left">
                            <img style="height: 150px" src="{{ asset('uploads/category') }}/${item['image']}" alt="" class="img-fluid">
                        </div>
                        <div class="right">
                            <div class="cat-data">
                                <h2>${item['name']}</h2>
                                <p>100 Products</p>
                            </div>
                        </div>
                    </div>
                </div>`

                    categorybox.innerHTML += row;
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

        featured();

        async function featured(){
            let req = await axios.get('/featured/product')

            if(req.status === 200 && req.data['status'] === 'success'){
            console.log(req.data.products);
            let featuredBox = document.getElementById('featuredBox');
            req.data.products.forEach(function (item, index){
                let row = `
                    <div class="col-md-3">
                    <div class="card product-card">
                        <div class="product-image position-relative">
                            <a href="" class="product-img"><img class="card-img-top" style="height: 350px" src="{{asset('uploads/product')}}/${item['images'][0]['image_url']}" alt=""></a>
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
                                <span class="h5"><strong>$ ${item['price']}</strong></span>
                                <span class="h6 text-underline"><del>$ ${item['compare_price']}</del></span>
                            </div>
                        </div>
                    </div>
                </div>
                `

                 featuredBox.innerHTML += row;
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

        latestProduct();

        async function latestProduct(){
            let req = await axios.get('/latest/product')
            if(req.status === 200 && req.data['status'] === 'success'){
                console.log(req.data.products);
                let latestBox = document.getElementById('latestBox');
                req.data.products.forEach(function (item, index){
                    let row = `
                    <div class="col-md-3">
                    <div class="card product-card">
                        <div class="product-image position-relative">
                            <a href="" class="product-img"><img class="card-img-top" style="height: 350px" src="{{asset('uploads/product')}}/${item['images'][0]['image_url']}" alt=""></a>
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
                                <span class="h5"><strong>$ ${item['price']}</strong></span>
                                <span class="h6 text-underline"><del>$ ${item['compare_price']}</del></span>
                            </div>
                        </div>
                    </div>
                </div>
                `

                    latestBox.innerHTML += row;
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




    </script>
@endsection
