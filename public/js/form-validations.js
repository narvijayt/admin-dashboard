jQuery(document).ready(function($) {

    // Validate Self Assessment Survey Choices before publish
    $("button[name='save-draft-self-choices']").on("click", function(){
        $(this).closest("form").trigger("submit");
    });
    $("button[name='publish-self-choices']").on("click", function(){
        $(this).closest("form").validate({
            submitHandler: function (form) {
                console.log('test', form);
                // form.submit();
                var isValid = true;
                $(document).find("input[name^='selfQuestionChoices']").each(function(i,e){
                    if($(this).val() == ""){
                        if($(e).hasClass("is-invalid")){
                            // nothing to do
                        }else{
                            $(e).addClass('is-invalid').closest('.col-md-9').append("<span id='"+$(e).attr("name")+"-error' class='error invalid-feedback'>This field is required.</span>");
                        }
                        isValid = false;
                    }else{
                        $(e).removeClass('is-invalid').closest('.col-md-9').find(".invalid-feedback").remove();
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
        $(this).closest("form").trigger("submit");
    });
    // validate Needs Assessment Survey Choices before Publish
    $("button[name='publish-needs-choices']").on("click", function(){
        $(this).closest("form").validate({
            errorElement: 'span',
            errorClass: 'error',
            onkeyup: false, 
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.col-md-9').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function (form) {
                console.log('test', form);
                // form.submit();
                var isValid = true;
                $(document).find("input[name^='needsChoiceTitle']").each(function(i,e){
                    if($(this).val() == ""){
                        if($(e).hasClass("is-invalid")){
                            // nothing to do
                        }else{
                            $(e).addClass('is-invalid').closest('.col-md-9').append("<span id='"+$(e).attr("name")+"-error' class='error invalid-feedback'>This field is required.</span>");
                        }
                        isValid = false;
                    }else{
                        $(e).removeClass('is-invalid').closest('.col-md-9').find(".invalid-feedback").remove();
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
});