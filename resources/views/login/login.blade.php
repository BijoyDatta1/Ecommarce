@extends('login.layout')
@section('main-section')
    <div class="login100-form validate-form">
					<span class="login100-form-title p-b-26">
						Welcome
					</span>
        <span class="login100-form-title p-b-48">
						<i class="zmdi zmdi-font"></i>
					</span>

        <div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
            <input id="email" class="input100" type="text" name="email">
            <span class="focus-input100" data-placeholder="Email"></span>
        </div>

        <div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
            <input id="password" class="input100" type="password" name="pass">
            <span class="focus-input100" data-placeholder="Password"></span>
        </div>

        <div class="container-login100-form-btn">
            <div class="wrap-login100-form-btn">
                <div class="login100-form-bgbtn"></div>
                <button onclick="Login()" class="login100-form-btn">
                    Login
                </button>
            </div>
        </div>

        <div class="text-center p-t-115">
						<span class="txt1">
							Don’t have an account?
						</span>

            <a class="txt2" href="/registerPage">
                Sign Up
            </a>
        </div>
    </div>
@endsection

<script>
    async function Login(){
        let email = document.getElementById('email').value;
        let password =document.getElementById('password').value;
        showLoader();
        let res = await axios.post('/login',{
            email : email,
            password : password
        });
        hideLoader();
        if(res.status === 200 && res.data['status'] === "success"){
            successToast(res.data['message']);
            setTimeout(function (){
                window.location.href = "/dashboard"
            },1000);
        }else {
            let data = res.data.message;
            if(typeof data === "object"){
                for(let key in data){
                    errorToast(data[key]);
                }
            }else{
                errorToast(data);
            }
        }
    }
</script>
