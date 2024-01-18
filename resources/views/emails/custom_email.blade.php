<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/fontawesome.min.css" integrity="sha512-TPigxKHbPcJHJ7ZGgdi2mjdW9XHsQsnptwE+nOUWkoviYBn0rAAt0A5y3B1WGqIHrKFItdhZRteONANT07IipA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Email Template</title>
    <title>Document</title>
    <style>
        
        .text-white{
            color:#fff;
        }
        .header_box {
            /* position: absolute; */
            z-index: 999;
            width: 100%;
            margin: 45px auto;
        }

        .header_back {
           
        }

        .listing {
            padding: 0px;
            margin: 0px;
        }

        .listing li {
            display: block;
            float: left;
        }
        
    

        .footer {
            padding: 20px 0px;
        }
        .bg_green_dark {
    background: #054450 !important;
}
.row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}
@media (min-width: 1200px){
.container, .container-lg, .container-md, .container-sm, .container-xl {
    max-width: 1140px;
}
}
@media (min-width: 992px){
.col-lg-8 {
    -ms-flex: 0 0 66.666667%;
    flex: 0 0 66.666667%;
    max-width: 66.666667%;
}
}
@media (min-width: 992px){
.col-lg-7 {
    -ms-flex: 0 0 58.333333%;
    flex: 0 0 58.333333%;
    max-width: 58.333333%;
}
}
@media (min-width: 768px){
.col-md-6 {
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
}
}
@media (min-width: 576px){
.col-sm-12 {
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
}
}
.col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
    position: relative;
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
}
.mt-4, .my-4 {
    margin-top: 1.5rem!important;
}
.mb-0, .my-0 {
    margin-bottom: 0!important;
}
.h6, h6 {
    font-size: 1rem;
}
.mb-2, .my-2 {
    margin-bottom: 0.5rem!important;
}
.clearfix {
    display: block;
    clear: both;
    
}
.position-relative{
    position:relative;
}
.ii a[href]{
    color: #fff;
}

    </style>
</head>

<body>
    <main class="container">
        <div class="row">
            <div class="col-lg-8 offset-2">
                <div class="banner position-relative p-2" style="padding:15px; background: rgb(20,128,128);background: linear-gradient(90deg, rgba(20,128,128,1) 48%, rgba(20,128,128,1) 49%);">
                    <table style="margin:auto;">
                        <tr>
                            <td style="text-align:center;">
                                <section style=" box-shadow: 0px 0px 55px 0px #0000001C;background-color: #215c68;padding: 6px 15px 6px;border-radius: 100px;">
                        <div class="header_back" style="box-shadow: 0px 0px 55px 0px #0000001C;background-color: #fff;padding: 6px 15px 4px;border-radius: 100px;">
                            <ul class="listing" style="display:flex; width:100%;">
                                <li class="list_left_border pr-2" style="width:250px">
                                    <a class="navbar-brand" href="#">
                                        <img src="{{ asset('assets/dist/img/ncfe/NCFE_logo.png')}}"  loading="lazy" width="100%" alt="" class="img_fluid hand-icon">
                                    </a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    </section>
                            </td>
                        </tr>
                    </table>
                    
                  
                </div>
                <section class="mail-content  p-3">
                    <!-- <h5>Dear Ashish Yatendramohan Jain, </h5>
                    <p class="pl-2 mb-1">This is to confirm that your APISetu application has been submitted. </p>
                    <p class="pl-2 mb-3">Will go through your application and the proposed use case, and if they meet our eligibility criterion, your APISetu account will be approved and you will then be able to sign into your account. You will be intimated via email. </p>
                    <h5 >Registration details as below:</h5>
                    <p class="pl-2 mb-1"><b>Reference ID:</b> APISETU#050996 </p>
                    <p class="pl-2 mb-1"><b> Organization:</b> EncureIT Systems Private Limited</p>
                    <p class="pl-2 mb-1"><b>Partner Type:</b> all</p>
                    <p class="pl-2"><b>Administrator name:</b> Ashish Yatendramohan Jain</p>
                    <p class="pl-2 mb-1">The approval process is likely to take 5 working days. If you do not hear from us within this time frame, please write to our customer support mentioning the organizational name, partner type and username you used during the signing up process.</p> -->
                    {!! $content !!}

                </section>
                <footer class=" bg_green_dark footer">
                    <div class="container-fluid w-90 bg_green_dark">
                        <div class="row">
                            <table style="width: 100%;padding-left: 2rem;padding-right: 2rem;">
                                <tr>
                                    <td style="width:50%;">
                                        <figure class="footer_img" style="margin:0px;background-color: #fff;padding-left: 2rem;padding-right: 2rem;padding: 6px 15px 4px;border-radius: 100px;">
                             <img src="{{ asset('assets/dist/img/ncfe/NCFE_logo.png')}}"  loading="lazy" alt="" width="100%" class="img_fluid hand-icon">
                             </figure>
                                    </td>
                                    <td style="width:50%; ">
                                        <span class="text-white " style="font-size: 2.5rem;margin-left: 5rem;">Contact</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><p class="text-white"  style="font-size:14px;margin-top: 18px;padding-left: 1rem">Content of this website is owned, published and managed by National Centre For Financial Education.</p></td>
                                    <td><p class="text-white" style="font-size:14px;margin-left: 5rem;color: #fff;margin-top: 4px;">help@ncfe.com<br>+91 12345 69870</p></td>
                                </tr>
                            </table>
                          
                        </div>
                       
                    </div>
                </footer>
            </div>
        </div>
    </main>

</body>

</html>