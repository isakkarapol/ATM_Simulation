var showErrorMsg = function (form, type, msg) {
    var alert = $('<div class="m-alert m-alert--outline alert alert-' + type + ' alert-dismissible" role="alert">\
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
                        <span></span>\
                        </div>');

    form.find('.alert').remove();
    alert.prependTo(form);
    alert.animateClass('fadeIn animated');
    alert.find('span').html(msg);
}

function message_response(type, message) {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "7000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    var title = "";
    if (type == "success") {
        title = "Success";
    } else if (type == "warning") {
        title = "Warning";
    } else if (type == "error") {
        title = "Failed";
    }

    toastr[type](message, title);
}

function validate_field(id_form) {
    var count_valid = 0;
    $(id_form + " input").each(function () {
        if ($(this).attr("type") == "text") {
            if ($(this).val() == "") {
                console.log($(this).attr("name"));
                $(this).closest("div").find(".form-control-feedback").remove();
                $(this).css("border", "1px solid red");
                $(this).after('<div class="form-control-feedback" style="color:red">Please fill ' + $(this).attr("name") + '</div>');
                count_valid++;
            }
        } else if ($(this).attr("type") == "email") {
            if ($(this).val() == "") {
                $(this).closest("div").find(".form-control-feedback").remove();
                $(this).css("border", "1px solid red");
                $(this).after('<div class="form-control-feedback" style="color:red">Please fill E-mail</div>');
                count_valid++;
            } else {
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                if (!emailReg.test($(this).val())) {
                    $(this).closest("div").find(".form-control-feedback").remove();
                    $(this).css("border", "1px solid red");
                    $(this).after('<div class="form-control-feedback" style="color:red">Please enter a valid E-mail address</div>');
                    count_valid++;
                } else {
                    return true;
                }
            }
        } else if ($(this).attr("type") == "password") {
            if ($("#str_type").length) {
                if ($("#str_type").val() == "add") {
                    if ($(this).val() == "") {
                        $(this).css("border", "1px solid red");
                        $(this).closest("div").next().remove();
                        $(this).closest("div").after('<div class="form-control-feedback" style="color:red">Please fill Password</div>');
                        count_valid++;
                    }
                }
            } else {
                if ($(this).val() == "") {
                    $(this).css("border", "1px solid red");
                    $(this).closest("div").next().remove();
                    $(this).closest("div").after('<div class="form-control-feedback" style="color:red">Please fill password</div>');
                    count_valid++;
                }
            }
        }

        $(id_form).each(function () {
            if ($(this).find("select").val() == "") {
                $(this).find("select").css("border", "1px solid red");
                $(this).find("select").next().remove();
                $(this).find("select").after('<div class="form-control-feedback" style="color:red">Please select ' + $(this).find("select").attr("name") + '</div>');
                count_valid++;
            }
        })
    });

    if (count_valid == 0) {
        return true;
    } else {
        return false;
    }
}

function keypess_valid(id_form) {
    $(id_form + " :input").each(function () {
        $(this).keyup(function () {
            if ($(this).prop('type') == 'password') {
                if ($(this).prop("style")["border"] != '') {
                    $(this).css("border", "");
                    $(this).closest("div").next().remove();
                }
            }

            if ($(this).prop("style")["border"] != '') {
                $(this).css("border", "");
                $(this).closest("div").find(".form-control-feedback").remove();
            }
        })
    })

    $(id_form + " select").each(function () {
        $(this).change(function () {
            $(this).css("border", "");
            $(this).closest("div").find(".form-control-feedback").remove();
        })
    })
}
