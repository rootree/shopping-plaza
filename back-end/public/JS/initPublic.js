$(document).ready(function() {
 
   function showLoginForm(){
       $('#loginForm').toggle();
   }

 
});

    function constrationPercent(){

       $('span.aboniment').hide();
       $('span.percent').show();

    }

    function constrationAboniment(){

       $('span.percent').hide();
       $('span.aboniment').show();

    }

    function checkRegForm(){

       $('#serverError').hide();
       $('#error_title').hide();
       $('#error_domain').hide();
       $('#error_username').hide();
       $('#error_mai').hide();
       $('#error_password').hide();
       $('#error_confirmation_empty').hide();
       $('#error_confirmation').hide();

        var errors = false;

        if($('#signup_title').val() == ''){
            errors = true;
            $('#error_title').show();
        }
        if($('#signup_domain').val() == '' && $('#signup_own_domain').val() == ''){
            errors = true;
            $('#error_domain').show();
        }
        if($('#signup_username').val() == ''){
            errors = true;
            $('#error_username').show();
        }
        if($('#signup_mail').val() == ''){
            errors = true;
            $('#error_mai').show();
        }
        if($('#signup_password').val() == ''){
            errors = true;
            $('#error_password').show();
        }
        if($('#signup_password_confirmation').val() == ''){
            errors = true;
            $('#error_confirmation_empty').show();
        }
        if($('#signup_password_confirmation').val() != $('#signup_password').val()){
            errors = true;
            $('#error_confirmation').show();
        }

        if(errors){
            location.href = location.href + '#formStart';
        }
 
        return !errors;

    }