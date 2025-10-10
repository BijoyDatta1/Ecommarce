@extends('login.layout')
@section('main-section')
    <div class="login100-form validate-form">
					<span class="login100-form-title p-b-26">
						Send OTP
					</span>
{{--        <span class="login100-form-title p-b-48">--}}
{{--						<i class="zmdi zmdi-font"></i>--}}
{{--					</span>--}}

        <div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
            <input id="email" class="input100" type="text" name="email">
            <span class="focus-input100" data-placeholder="Email"></span>
        </div>

        <div class="container-login100-form-btn">
            <div class="wrap-login100-form-btn">
                <div class="login100-form-bgbtn"></div>
                <button onclick="sendOtp()" class="login100-form-btn">
                    Send Otp
                </button>
            </div>
        </div>

        <div class="text-center p-t-115">
						<span class="txt1">
							Back to
						</span>

            <a class="txt2" href="/loginpage">
                Login
            </a>
        </div>
    </div>
@endsection
<script>
    async function sendOtp(){
        let email = document.getElementById('email').value;
        showLoader();
        let res = await axios.post('/sendotp',{
            email : email
        });
        hideLoader();

        if(res.status === 200 && res.data['status'] === "success"){
            sessionStorage.setItem('email',email);
            successToast(res.data['message']);
            setTimeout(function (){
                window.location.href = "/otpPage"
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
