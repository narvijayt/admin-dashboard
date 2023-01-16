jQuery(document).ready(function($) {

    // Validate Self Assessment Survey Choices before publish
    $("button[name='save-draft-self-choices']").on("click", function(){
        $(this).closest("form").validate().destroy();
        $(document).find("input[name^='selfQuestionChoices']").each(function(i,e){
            $(e).removeClass('is-invalid').parent('div').find(".invalid-feedback").remove();
        });
        $(this).closest("form").submit();
    });
    $("button[name='publish-self-choices']").on("click", function(){
        $(this).closest("form").validate({
            submitHandler: function (form) {
                // form.submit();
                var isValid = true;
                $(document).find("input[name^='selfQuestionChoices']").each(function(i,e){
                    if($(this).val() == ""){
                        if($(e).hasClass("is-invalid")){
                            // nothing to do
                        }else{
                            $(e).addClass('is-invalid').parent('div').append("<span id='"+$(e).attr("name")+"-error' class='error invalid-feedback'>This field is required.</span>");
                        }
                        isValid = false;
                    }else{
                        $(e).removeClass('is-invalid').parent('div').find(".invalid-feedback").remove();
                    }
                });
    
                if(isValid == true){
                    // console.log("This is true, now submitting form!");
                    form.submit();
                }else{
                    // console.log("Opps! Still false.");
                }
            }
        });
    })


    $("button[name='save-draft-needs-choices']").on("click", function(){
        $(this).closest("form").validate().destroy();
        $(document).find("input[name^='needsChoiceTitle']").each(function(i,e){
            $(e).removeClass('is-invalid').parent('div').find(".invalid-feedback").remove();
        });
        $(this).closest("form").submit();
    });
    // validate Needs Assessment Survey Choices before Publish
    $("button[name='publish-needs-choices']").on("click", function(){
        $(this).closest("form").validate({
            errorElement: 'span',
            errorClass: 'error',
            onkeyup: false, 
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.parent('div').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function (form) {
                // form.submit();
                var isValid = true;
                $(document).find("input[name^='needsChoiceTitle']").each(function(i,e){
                    if($(this).val() == ""){
                        if($(e).hasClass("is-invalid")){
                            // nothing to do
                        }else{
                            $(e).addClass('is-invalid').parent('div').append("<span id='"+$(e).attr("name")+"-error' class='error invalid-feedback'>This field is required.</span>");
                        }
                        isValid = false;
                    }else{
                        $(e).removeClass('is-invalid').parent('div').find(".invalid-feedback").remove();
                    }
                });

                if(isValid == true){
                    // console.log("This is true, now submitting form!");
                    form.submit();
                }else{
                    // console.log("Opps! Still false.");
                }
            }
        });
    });


    // Validate User Create Form
    /*
    $(".create-user-form").validate({
        errorElement: 'span',
        errorClass: 'error',
        onkeyup: false,
        rules: {
            accountType: {
                required: true,
            },
            firstName: {
                required: true,
                minlength: 2
            },
            lastName: {
                required: true,
                minlength: 2
            },
            password: {
                required: true,
                minlength: 5
            },
            password_confirmation: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            accountType: {
                required: "Please select account type",
            },
            firstName: {
                required: "Please enter First Name",
                minlength: "Your first name must consist of at least 2 characters"
            },
            lastName: {
                required: "Please enter last name",
                minlength: "Your last name must consist of at least 2 characters"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            password_confirmation: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            email: "Please enter a valid email address",
        }, 
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.parent('div').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
    */
});
