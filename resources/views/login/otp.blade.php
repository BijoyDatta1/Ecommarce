@extends('login.layout')
@section('main-section')
    <div class="login100-form validate-form">
					<span class="login100-form-title p-b-26">
						Verify OTP
					</span>
{{--        <span class="login100-form-title p-b-48">--}}
{{--						<i class="zmdi zmdi-font"></i>--}}
{{--					</span>--}}

        <div class="wrap-input100 validate-input" data-validate = "Valid Otp is: a@b.c">
            <input id="otp" class="input100" type="text" name="Otp">
            <span class="focus-input100" data-placeholder="Otp"></span>
        </div>

        <div class="container-login100-form-btn">
            <div class="wrap-login100-form-btn">
                <div class="login100-form-bgbtn"></div>
                <button onclick="verify()" class="login100-form-btn">
                    Verify
                </button>
            </div>
        </div>

{{--        <div class="text-center p-t-115">--}}
{{--						<span class="txt1">--}}
{{--							Don’t have an account?--}}
{{--						</span>--}}

{{--            <a class="txt2" href="/registerPage">--}}
{{--                Sign Up--}}
{{--            </a>--}}
{{--        </div>--}}
    </div>
@endsection
<script>
    async function verify(){
        let otp = document.getElementById('otp').value;
        let email = sessionStorage.getItem('email');
        showLoader();
        let res = await axios.post('/verifyotp',{
            otp : otp,
            email : email
        });
        hideLoader();
        if(res.status === 200 && res.data['status'] === "success"){
            sessionStorage.removeItem('email');
            successToast(res.data['message']);
            setTimeout(function (){
                window.location.href = "/resetPasswordPage"
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
