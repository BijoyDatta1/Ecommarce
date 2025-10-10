@extends('login.layout')
@section('main-section')
    <div class="login100-form validate-form">
					<span class="login100-form-title p-b-26">
						Resgistation
					</span>
{{--        <span class="login100-form-title p-b-48">--}}
{{--						<i class="zmdi zmdi-font"></i>--}}
{{--					</span>--}}


        <div class="wrap-input100 validate-input" data-validate = "Valid firstName is: a@b.c">
            <input id="firstName" class="input100" type="text" name="firstName">
            <span class="focus-input100" data-placeholder="First Name"></span>
        </div>

        <div class="wrap-input100 validate-input" data-validate = "Valid lastName is: a@b.c">
        <input id="lastName" class="input100" type="text" name="lastName">
        <span class="focus-input100" data-placeholder="Last Name"></span>
        </div>

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

        <div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
            <input id="confirm_password" class="input100" type="password" name="pass">
            <span class="focus-input100" data-placeholder="Confirm Password"></span>
        </div>

        <div class="container-login100-form-btn">
            <div class="wrap-login100-form-btn">
                <div class="login100-form-bgbtn"></div>
                <button onclick="registation()" class="login100-form-btn">
                    Registation
                </button>
            </div>
        </div>

        <div class="text-center p-t-115">
						<span class="txt1">
							<a class="txt2" href="/loginpage">
                                Back to Login.
                            </a>
						</span>

            <a class="txt2" href="/recoveryPage">
                Forget Password
            </a>
        </div>
    </div>
@endsection
<script>
    async function registation(){
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;
        let first_name = document.getElementById('firstName').value;
        let last_name = document.getElementById('lastName').value;
        let confirm_password = document.getElementById('confirm_password').value;

        if(password !== confirm_password){
            errorToast("Password and Confirm Password Not Match");
        }else{
            showLoader();
            let res = await axios.post('/registation',{
                first_name: first_name,
                last_name: last_name,
                email: email,
                password: password
            })
            hideLoader();

            if(res.status === 200 && res.data['status'] === "success"){
                successToast(res.data['message']);
                setTimeout(function (){
                    window.location.href = "/loginpage"
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

    }

</script>
