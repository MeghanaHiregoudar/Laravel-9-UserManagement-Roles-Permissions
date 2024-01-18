// only number with dot 
$(".only_number_dec").keypress(function(e){
    //alert(e.which);  
    charCode=e.which;  
    if ((charCode >= 48 && charCode <= 57) || charCode == 46)
    return true;
  
    return false;
});	

// only number with dot & slash
$(".only_number_dec_slash").keypress(function(e){
    //alert(e.which);  
    charCode=e.which;  
    if ((charCode >= 48 && charCode <= 57) || charCode == 46 || charCode == 47)
    return true;
  
    return false;
});


// only number 
$(".only_number").keypress(function(e){
    //alert(e.which);
    charCode=e.which;
    if ((charCode >= 48 && charCode <= 57))
    return true;

    return false;
});

// Allow only alphabets and space
$(".alphabets").keypress(function(e) {
    if ((e.which >= 65 && e.which < 91) || (e.which >= 97 && e.which < 123) || e.which == 32 || e.which == 47 || e.which == 92 || e.which == 40 || e.which == 41) {
        return true;
    } else {
        return false;
    }
});


// Allow only alphabets and numbers only
$(".alphabets_numbers").keypress(function(e) {
    if ((e.which >= 65 && e.which < 91) || (e.which >= 97 && e.which < 123) || (e.which > 47 && e.which < 58)) {
        return true;
    } else {
        return false;
    }
});

// Allow only alphabets ,numbers and underscore only
$(".alphabets_numbers_underscore").keypress(function(e) {
    if ((e.which >= 65 && e.which < 91) || (e.which >= 97 && e.which < 123) || (e.which > 47 && e.which < 58) || e.which == 95 || e.which == 45) {
        return true;
    } else {
        return false;
    }
});

// Allow only alphabets, numbers and space and special characters only ,./\-
$(".alphabets_address").keypress(function(e) {
    if ((e.which >= 65 && e.which < 91) || (e.which >= 97 && e.which < 123) || e.which == 32 || e.which == 44 || e.which == 45 || e.which == 46 || e.which == 47 || e.which == 92 || (e.which > 47 && e.which < 58)) {
        return true;
    } else {
        return false;
    }
});

// restrict these 2 special characters  from input
$(".restrict_characters").keypress(function(e){
    //alert(e.which);
    charCode=e.which;
    if (charCode == 60 || charCode == 62) {
        return false;
    }
    return true;
});

// for password display in text
$('.togglePasswordEye').click(function(){
    var passInput = $(this).data('key');
    if($(this).hasClass('fa-eye')){
        $(this).addClass("fa-eye-slash");
        $("#"+passInput).attr('type','text');
        $(this).removeClass("fa-eye");
    }else{
        $(this).addClass("fa-eye");
        $(this).removeClass("fa-eye-slash");
        $("#"+passInput).attr('type','password');
    }
});







