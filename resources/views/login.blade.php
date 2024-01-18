@extends('layouts.app')
@section('title',__('titles.sign-in'))
@section('content')
<div class="innerpage_section p-4"></div>
    <section class="login_box">
        <div class="container-fluid w-90">
            <div class="card main-card border-0 border-radius-10 overflow-hidden transp_bg_white">
                <div class="row ">                
                    <div class="col-lg-10 col-md-6 col-sm-12 mx-auto">
                        <div class="login_content_box">
                            <div class="row justify-content-center">
                                <div class="col-lg-9 col-md-12 col-sm-12 mt-5">
                                    <h2 class="text-center f-600">{{ __('lables.sign-in') }}</h2>
                                    <form method="POST" id ="login_form" action="{{ route('login.post') }}">
                                        @csrf
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @elseif (session('error'))
                                            <div class="alert alert-danger" role="alert">
                                                {{ session('error') }}
                                            </div>
                                        @endif
                                        <div class="form-group ">
                                            <label for="exampleInputEmail1">Username <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Enter Standard format Email Address for login account"></i></label>
                                            <input type="text" id="username" class="form-control @error('username') is-invalid @enderror alphabets_numbers_underscore" placeholder="Enter username" value="{{ old('username') }}" autocomplete="off" autofocus name="username">
                                            <span class="alert text-danger pl-0 pb-0 fs-14 email_err mb-0 error_msg" role="alert">
                                                <strong></strong>
                                            </span>
                                            @error('username')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror 
                                        </div>
                                        <div class="form-group mb-0">
                                            <label for="exampleInputPassword1">{{ __('lables.password') }}  <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Enter password that must be of 8-15 characters long ,Must contain a number ,Must contain a capital, small , special character"></i> </label>
                                            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{__('placeholders.enter-password')}}" name="password" min="8" max="15"  autocomplete="off">
                                            <button type="button" class="btn p-0 border-0 shadow-none" style="position: relative;left: 93%;top: -37px;"><i class="fa fa-eye togglePasswordEye float-right" data-key="password"></i></button>
                                            <span class="alert text-danger pl-0 pb-0 fs-14 password_err  mb-0 error_msg" role="alert">
                                                <strong></strong>
                                            </span>
                                            @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                            @enderror 
                                        </div>
                                        
                                        <div class="row mt-0">
                                            <div class="col-md-12 col-sm-12 text-right">
                                                <a href="{{route('forgot.password.form')}}" class="pt-1 d-inline-block text-dark fw-600 text-decoration-none">{{__('lables.forgot-password')}}?</a>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="row">
                                                <div class="col-lg-10 col-md-7 col-sm-12 captcha">
                                                    <span>{!! captcha_img('flat') !!}</span>
                                                </div>
                                                <div class="col-lg-2 col-md-5 col-sm-12">
                                                    <a href="javascript:void(0)" class="btn btn-info rounded-circle img-box-sm d-flex align-items-center justify-content-center mt-2" onclick="reload_captcha()"><i class="fas fa-sync-alt"></i></a>
                                                   </div>
                                                <div class="col-md-12 col-sm-12  mt-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{__('lables.please-enter-characters-from-image-above')}}</label>
                                                        <input type="text" class="form-control" name="captcha" id="captcha"  placeholder="{{__('placeholders.enter-captcha')}}" required autocomplete="off">  
                                                        <span class="alert text-danger pl-0 pb-0 fs-14 captcha_err  mb-0 error_msg" role="alert">
                                                            <strong></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" id ="login_btn" class="btn bg_green_dark d-block text-white w-100 round_btn p-2 fs-18">{{ __('lables.sign-in') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
            
         </div>   
    </section>
@endsection

@section('script')
<!-- Custome javascript/jQuery functions -->
<script type="text/javascript">
   
   
    $("#login_form").submit(function(e){
        e.preventDefault();
        var login_email = $("#username").val();
        var login_password = $("#password").val();
        var captcha = $("#captcha").val();
        var token = $('meta[name="csrf-token"]').attr('content');	
        var error = 0;

        if(login_email == "")
        {
            $(".email_err").text("Please enter username");
            error++;
        } else {
            $(".email_err").empty();
        }

        if(login_password == "")
        {
            $(".password_err").text("Please enter password");
            error++;
        } else {
            $(".password_err").empty();
        }

        if(captcha == "")
        {
            $(".captcha_err").text("Please enter captcha");
            error++;
        } else {
            $(".captcha_err").empty();
        }

        if(error>0)
        {
            return false;
        } else { 
            
            var data = {
                username: login_email,
                password: login_password,
                captcha: captcha,
                _token:token
            };

            $("#login_btn").attr("disabled",true);
            $.ajax({
                url:$("#login_form").attr("action"),
                type:"POST",
                dataType:"JSON",
                data:data,
                success:function(response){
                    // console.log(response);
                    $("#login_btn").attr("disabled",false);
                    if(response.status == 1){
                        window.location.href =response.redirect
                    } else if(response.status == 2) {
                        toastr.error(response.msg);
                        $("#password").val('');
                        $("#captcha").val('');
                        reload_captcha();
                    } else if(response.status == 'password') {
                        toastr.warning(response.msg);
                        window.location.href =response.redirect                        
                    } else if(response.status == 0){
                        $.each(response.errors, function(prefix, val){
                            $('span.'+prefix+'_err').text(val[0]);
                        });
                        $("#password").val('');
                        $("#captcha").val('');
                        reload_captcha();
                    }
                },
            });
        }
        
    });

   function reload_captcha() {
        $.ajax({
            type: 'GET',
            url: 'reload-captcha',
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    }

</script>
@endsection