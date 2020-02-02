var waitmeOptions = {
    effect : 'bounce',
    text   : 'Please wait...',
    bg     : "rgba(255,255,255,0.7)",
    color  : "#000",
    textPos: 'vertical',
};

var swalConfirmationOptions = {
    background        : "#000",
    showCancelButton  : true,
    confirmButtonColor: "#48cab2",
    cancelButtonColor : '#DD6B55',
    confirmButtonText : "Yes",
    closeOnConfirm    : false,
    showCloseButton   : true,
    allowOutsideClick : false,
    allowEscapeKey    : false,
    confirmButtonClass: 'swal-custom-confirm-btn',
    cancelButtonClass : 'swal-custom-cancel-btn',
};

function show_common_popup(heading, txt) {
    $(".common-popup h3").text(heading);
    $(".common-popup .msg-body").html(txt);
    $(".common-popup").addClass("showMsg");    
}

function swal_success(txt) {
    // swal({
    //     text: txt,
    //     type: "success",
    //     buttons: true,
    //     confirmButtonColor: "#48cab2",
    //     buttons: 'OK',
    //     closeModal: false,
    //     className: "theme-bg",
    // });
    show_common_popup('Message', txt);
}

function swal_warning(txt) {
    // swal({
    //     text: txt,
    //     type: "warning",
    //     buttons: true,
    //     confirmButtonColor: "#DD6B55",
    //     buttons: 'OK',
    //     closeModal: false,
    //     className: "theme-bg",
    // });
    show_common_popup('Message', txt);
}

function common_form_checking(flag, msgbox = '') {
    $('.requiredCheck').each(function () {
        if ($.trim($(this).val()) == '') {
            var txt = $(this).attr('data-check') + ' is mandatory !!!';
            if (msgbox != '') {
                $("." + msgbox).text(txt);
            } else {
                swal_warning(txt);
            }
            flag = 'false';
            return false;
        } else {
            if ($(this).attr('data-check') == 'Email') {
                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if (reg.test($.trim($(this).val())) == false) {
                    var txt = 'Enter valid Email address !!!';
                    if (msgbox != '') {
                        $("." + msgbox).text(txt);
                    } else {
                        swal_warning(txt);
                    }
                    flag = 'false';
                    return false;
                }
            }
            if ($(this).attr('data-check') == 'Phone') {
                if ($.trim($(this).val()).length != 10) {
                    var txt = 'Enter 10 digit phone number !!!';
                    if (msgbox != '') {
                        $("." + msgbox).text(txt);
                    } else {
                        swal_warning(txt);
                    }
                    flag = 'false';
                    return false;
                }
            }
            if ($(this).attr('data-check') == 'Zip') {
                if ($.trim($(this).val()).length != 6) {
                    var txt = 'Enter 6 digit Postcode !!!';
                    if (msgbox != '') {
                        $("." + msgbox).text(txt);
                    } else {
                        swal_warning(txt);
                    }
                    flag = 'false';
                    return false;
                }
            }
        }
    });
    return flag;
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        if (charCode == 43 || charCode == 45) {
            return true;
        }
        return false;
    }
    return true;
}

function isChar(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ((charCode >= 65 && charCode <= 122) || charCode == 32 || charCode == 0) {
        return true;
    }
    return false;
}
/* ***
Restrict Special Characters in textbox 
***/
$(document).on('keyup', '.restrictSpecial', function () {
    var yourInput = $(this).val();
    var re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
    var isSplChar = re.test(yourInput);
    if (isSplChar) {
        var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
        $(this).val(no_spl_char);
    }
});

function age_submit(val) {
    if (val == 'N') {
        swal_warning('Sorry!!! You are under age!!!');
        $('#age-alert').text('Sorry!!! You are under age!!!');
    } else {
        $.ajax({
            type: "POST",
            url: "set-age",
            cache: false,
            success: function (data) {
                //window.location.href = 'landing';
                location.reload();
            }
        });
    }
}

function refine_performer(type, id) {
    $.ajax({
        type: "POST",
        url: "filter-performer",
        data: {
            'type': type,
            'id': id
        },
        cache: false,
        success: function (res) {
            var tmp = res.split('~~');
            if (tmp[0] == 'ok') {
                $('.index-p-div').html(tmp[1]);
            } else {
                $('.index-p-div').html('<h1 style="color: #ac975e; font-size: 39px;">' + tmp[1] + '</h1>');
            }
        }
    });
}

function subscribe(performer_id, user_id) {
    var options = swalConfirmationOptions;
    options.title = "Confirmation";
    options.text = "Are you sure?";
    options.type = "warning";

    swal(options).then(function () {
        $.ajax({
            type: "POST",
            url: base_url + "subs-cribe",
            data: {
                'performer_id': performer_id,
                'user_id': user_id
            },
            cache: false,
            success: function (data) {
                var tmp = data.split('~~');
                swal_success(tmp[1]);
                if (tmp[0] == 'ok') {
                    $(".subs_btn").text(tmp[2]);
                    if (tmp[2] == 'Subscribe') {
                        $('.item-subscribe').show();
                    } else {
                        $('.item-subscribe').hide();
                    }
                }
            }
        });
    });
}
/***************VOTE*******************/
$(".vt").click(function () {
    $("#vote_nm").text('VOTE FOR ' + $('#perf_name' + $(this).attr('id')).val());
    $("#vote_pts").text($('#perf_vote' + $(this).attr('id')).val() + ' pts');
    $("#vote_rnk").text('RANK: ' + $('#perf_rank' + $(this).attr('id')).val());
    $('.voteBtn').attr('onClick', 'vote(\'' + $(this).attr('id') + '\','+$('#perf_vote' + $(this).attr('id')).val()+');');
    $('.vote-bg').show();
    $(".vote-bg").css("height", $(document).height());
    $(".vote-container").css("transform", "scale(1)");
    $('body').css("overflow", "hidden");
});

$(".voteClose").click(function () {
    $(".vote-container").css("transform", "scale(0.3)");
    $('.vote-bg').hide(300);
    $('body').css("overflow", "auto");
});

function vote(performer_id,val) {
    var options = swalConfirmationOptions;
    options.title = "Confirmation";
    options.text = "Are you sure?";
    options.type = "warning";

    swal(options).then(function () {
        $.ajax({
            type: "POST",
            url: base_url + "vote",
            data: {
                'performer_id': performer_id,
                'point': val
            },
            cache: false,
            success: function (data) {
                $(".voteClose").click();
                var res = data.split('~~');
                if (res[0] == 'ok') {
                    swal_success(res[1]);
                } else {
                    swal_warning(res[1]);
                }
            }
        });
    });
}
/***************VOTE*******************/

/***************GIFT*******************/
$(".gift-modal").click(function () {
    
    $('.giftBtn').attr('onClick', 'vote(\'' + $(this).attr('id') + '\');');
    $('.gift-bg').show();
    $(".gift-bg").css("height", $(document).height());
    $(".gift-container").css("transform", "scale(1)");
    $('body').css("overflow", "hidden");
});

$(".giftClose").click(function () {
    $(".gift-container").css("transform", "scale(0.3)");
    $('.gift-bg').hide(300);
    $('body').css("overflow", "auto");
});
/***************GIFT*******************/


/***************CHAT*******************/
var checkMsg = '';
var url = '';
var parts = '';
var last_part = '';
var undefinedvar;
$(".msg").click(function () {
    $.ajax({
        type: "POST",
        url: base_url + "chat-lists",
        cache: false,
        success: function (data) {
            $('.msg-list').html('');
            $('.msg-list').html(data);
            $('.msg-bg').addClass("showMsg");
            $('body').css("overflow", "hidden");
            checkMsg = '';
        }
    });
});

function openMsg(user_id) {
    $.ajax({
        type: "POST",
        url: base_url + "full-chat-details",
        data: {
            'user_id': user_id
        },
        cache: false,
        success: function (data) {
            $('.msg-body-nav').hide();
            $('.msg-list').html('');
            $('.msg-list').html(data);
            checkMsg = 'check';
            var wtf = $('#chatSec' + user_id);
            var height = $('#chatSec' + user_id)[0].scrollHeight;
            wtf.scrollTop($('#chatSec' + user_id)[0].scrollHeight);
            // scroll to last
            scrollToLast();            
        }
    });
}

function backMsg(user_id) {
    $('.msg-list').html('');
    $('.msg-body-nav').show();
    $(".msg").click();
}

function deleteChat(user_id) {
    var options       = swalConfirmationOptions;
        options.title = "Confirmation";
        options.text  = "Are you sure want to delete this chat?";
        options.type  = "warning";

    swal(options).then(function () {
        $.ajax({
            type: "POST",
            url: base_url + "delete-chat",
            data: {
                'user_id': user_id
            },
            cache: false,
            success: function (data) {
                $('#msglst' + user_id).remove();
                $('.chat-ul').html('');
            }
        });
    });
}
$("#msg-close").click(function () {
    checkMsg = '';
    $('.msg-bg').removeClass("showMsg");
    $('body').css("overflow", "auto");
});

function commonSendChat(msg, rec_id, rec_typ, sndr_id, sndr_typ) {
    $.ajax({
        type: "POST",
        url: base_url + "send-chat",
        data: {
            'chat_msg': msg,
            'receiver_id': rec_id,
            'receiver_type': rec_typ,
            'sender_id': sndr_id,
            'sender_type': sndr_typ
        },
        beforeSend: function () {
            $("#p_send_chat").prop('disabled', true);
            $("#pop_snd_msg").prop('disabled', true);
        },
        cache: false,
        success: function (data) {
            var res = data.split('~~');
            $("#last_chat_id").val(res[0]);
            $("#pop_last_chat").val(res[0]);
            $('#mCSB_1_container').append('<li style="text-align: right;">' + msg + '</li>');
            $('.chatLstUl').append(res[1]);
            $("#p_chat_msg").val('');
            $("#pop_chat_msg").val('');
            $("#p_send_chat").prop('disabled', false);
            $("#pop_snd_msg").prop('disabled', false);
            $(".chat-ul").mCustomScrollbar("scrollTo", "bottom", {
                scrollInertia: 0
            });
            var wtf = $('#chatSec' + rec_id);
            var height = $('#chatSec' + rec_id)[0].scrollHeight;
            wtf.scrollTop($('#chatSec' + rec_id)[0].scrollHeight);

            // scroll to last
            scrollToLast();          
        }
    });
}

function scrollToLast() {
    let elem = $(".chatLstUl li").last();
    if(elem.length) {
        window.setTimeout(function(){
            elem[0].scrollIntoView({ 
                behavior: 'smooth',
                block   : 'nearest',
                inline  : 'start'
            });
        }, 500);
    }      
}

$("#p_send_chat").click(function () {
    if ($("#p_chat_msg").val() != '') {
        var msg = $("#p_chat_msg").val();
        var rec_id = $("#p_receiver_id").val();
        var rec_typ = $("#p_receiver_type").val();
        var sndr_id = $("#p_sender_id").val();
        var sndr_typ = $("#p_sender_type").val();
        commonSendChat(msg, rec_id, rec_typ, sndr_id, sndr_typ);
    } else {
        $("#p_chat_msg").focus();
        swal_warning("Please enter some message");
    }
});

function send_pop_chat() {
    if ($("#pop_chat_msg").val() != '') {
        var msg = $("#pop_chat_msg").val();
        var rec_id = $("#pop_receiver_id").val();
        var rec_typ = $("#pop_receiver_type").val();
        var sndr_id = $("#pop_sender_id").val();
        var sndr_typ = $("#pop_sender_type").val();
        commonSendChat(msg, rec_id, rec_typ, sndr_id, sndr_typ);
    } else {
        $("#pop_chat_msg").focus();
        swal_warning("Please enter some message");
    }
    //var formdata = $('#chatrply-form').serialize();
    //var formEl = document.forms.chatrply_form;
    //var formData = new FormData(formEl);
    //console.log(formData);
    /*
    input = document.getElementById('fileinput');
    file = input.files[0];
    fr = new FileReader();
    fr.onload = receivedText;
    //fr.readAsText(file);
    fr.readAsDataURL(file);*/
    //alert($('#pop_chat_msg').val());
}
$(document).ready(function () {
    setInterval(function () {
		//$("#pop_snd_msg,#p_send_chat").click(function(){
        url = $(location).attr('href');
        parts = url.split("/");
        last_part = parts[parts.length - 4];
        if (last_part == 'performer') {
            checkMsg = 'check';
        }
        if (checkMsg == 'check') {
            if ($('#p_receiver_id').val() === undefinedvar) {
                var rec_id = $('#pop_receiver_id').val();
                var last_chat_id = $('#pop_last_chat').val();
            } else {
                var rec_id = $('#p_receiver_id').val();
                var last_chat_id = $('#last_chat_id').val();
            }
            $.ajax({
                type: "POST",
                url: base_url + "check-new-msg",
                data: {
                    'last_chat_id': last_chat_id,
                    'rec_id': rec_id
                },
                cache: false,
                success: function (data) {
                    var res = data.split('~~');
                    if (res[0] != '') {
                        $('#mCSB_1_container').append(res[1]);
                        $('.chatLstUl').append(res[2]);
                        $(".chat-ul").mCustomScrollbar("scrollTo", "bottom", {
                            scrollInertia: 0
                        });                        
                        var wtf = $('#chatSec' + rec_id);
                        var height = $('#chatSec' + rec_id)[0].scrollHeight;
                        wtf.scrollTop($('#chatSec' + rec_id)[0].scrollHeight);
                        $("#last_chat_id").val(res[0]);
                        $('#pop_last_chat').val(res[0]);
                        
                        // scroll to last
                        scrollToLast();
                    }
                }
            });
        }
		//});
    }, 5000);

    $(document).on('keypress', '#chatrply_form', function(e){
        switch(e.which) {
            case 13:
                e.preventDefault();
                send_pop_chat();
                return false;
        }
    });
});

function openSearch(ph) {
    if ($('.srchBar').width() == 0) {
        $('.srchBar').css({
            "width": "200px"
        });
        $('#msgSearch').addClass('usrnm');
        $('#msgSearch').focus();
        $('.srchBar input').css({
            "padding": "0 30px !important"
        });
        $('#msgSearch').attr("placeholder", ph);
    } else {
        $('.srchBar').css({
            "width": "0px"
        });
        $('#msgSearch').val('');
        $('#msgSearch').removeClass('usrnm');
        $('#msgSearch').attr("placeholder", '');
        $('.suggList').addClass('hide_content');
    }
}
$("#msgSearch").on('keyup', function () {
    if ($(this).val().length > 2) {
        $.ajax({
            type: "POST",
            url: base_url + "search-user",
            data: {
                'user_sugg': $(this).val(),
            },
            beforeSend: function () {
                $('.suggList').html('');
                $('.suggList').removeClass('hide_content');
            },
            cache: false,
            success: function (data) {

                if (data != '') {
                    $('.suggList').html(data);
                } else {
                    $('.suggList').html('<li>No Such Performer Found !!!</li>');
                }
            }
        });
    } else if ($(this).val().length == 0) {
        $('.suggList').html('');
        $('.suggList').addClass('hide_content');
        //$(".msg").click();
    }
});
/***************CHAT*******************/
$("#registration-form").submit(function (e) {
    e.preventDefault();
    $(".signup-message").text('');
    var tmp = 'true';
    var flag = common_form_checking(tmp, 'signup-message');
    if (flag != 'false') {
        if ($('#reg_cnf_pwd').val() == $('#reg_pwd').val()) {
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "do-registration",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $("#reg_btn").prop("disabled", true);
                },
                success: function (data) {
                    $("#reg_btn").prop("disabled", false);
                    if (data == 'ok') {
                        $('.reg_first').addClass('hide_content');
                        $('#reg_success_email').text($('#reg_email').val());
                        $('.reg_success').removeClass('hide_content');
                        $("#registration-form :input").each(function () {
                            $(this).val('');
                        });
                        /*setTimeout(function () {
    window.location = base_url + 'login';
}, 3000);*/
                    } else if (data == 'notok') {
                        $(".signup-message").text('Something Went Wrong!!! Please Try Again !!!');
                    } else {
                        $(".signup-message").text(data);
                    }
                }
            });
        } else {
            $(".signup-message").text('Password & Confirm Password didn\'t match !!!');
        }
    }
});
$("#login-form").submit(function (e) {
    e.preventDefault();
    $(".login-message").text('');
    var tmp = 'true';
    var flag = common_form_checking(tmp, 'login-message');
    if (flag != 'false') {
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "do-login",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#login_btn").prop("disabled", true);
            },
            success: function (data) {
                $("#login_btn").prop("disabled", false);
                if (data == 'ok') {
                    window.location.href = base_url;
                } else if (data == 'notok') {
                    $(".login-message").text('Something Went Wrong!!! Please Try Again.');
                    //swal_warning('Something Went Wrong!!! Please Try Again.');
                } else {
                    //swal_warning(data);
                    $(".login-message").text(data);
                }
            }
        });
    }
});
$("#editprofile-form").submit(function (e) {
    e.preventDefault();
    $(".editpro-message").text('');
    var tmp = 'true';
    var flag = common_form_checking(tmp);
    if (flag != 'false') {
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "profile-update",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#editpro_submit_btn").prop("disabled", true);
            },
            success: function (data) {
                $("#editpro_submit_btn").prop("disabled", false);
                var res = data.split('~~');
                if (res[0] == 'ok') {
                    $('.welcome_unm').text('Welcome ' + $('#name_edit').val());
                    swal_success(res[1]);
                } else {
                    swal_warning(res[1]);
                }
            }
        });
    }
});
$("#personaldetails-form").submit(function (e) {
    e.preventDefault();
    $(".personal-details-message").text('');
    var tmp = 'true';
    var flag = common_form_checking(tmp, 'personal-details-message');
    if (flag != 'false') {
        if ($('#editpro_pwd').val() != '') {
            if ($('#editpro_cnfpwd').val() == '') {
                $(".personal-details-message").text('Confirm Password is Required !!!');
                $('#editpro_cnfpwd').focus();
                return false;
            } else {
                if ($('#editpro_cnfpwd').val() != $('#editpro_pwd').val()) {
                    $(".personal-details-message").text('Password & Confirm Password doesn\'t match !!!');
                    $('#editpro_cnfpwd').focus();
                    return false;
                }
            }
        }
        if ($('#editpro_cnfpwd').val() != '') {
            if ($('#editpro_pwd').val() == '') {
                $(".personal-details-message").text('Password is Required !!!');
                $('#editpro_pwd').focus();
                return false;
            } else {
                if ($('#editpro_cnfpwd').val() != $('#editpro_pwd').val()) {
                    $(".personal-details-message").text('Password & Confirm Password doesn\'t match !!!');
                    $('#editpro_cnfpwd').focus();
                    return false;
                }
            }
        }
        if ($('#editpro_card').val() != '' || $('#editpro_cardm').val() != '' || $('#editpro_cardy').val() != '' || $('#editpro_card_cvv').val() != '') {
            if ($('#editpro_card').val() == '') {
                $(".personal-details-message").text('Card No. is Required !!!');
                $('#editpro_card').focus();
                return false;
            }
            if ($('#editpro_cardm').val() == '') {
                $(".personal-details-message").text('Expiry Month is Required !!!');
                $('#editpro_cardm').focus();
                return false;
            }
            if ($('#editpro_cardy').val() == '') {
                $(".personal-details-message").text('Expiry Year is Required !!!');
                $('#editpro_cardy').focus();
                return false;
            }
            if ($('#editpro_card_cvv').val() == '') {
                $(".personal-details-message").text('CVV is Required !!!');
                $('#editpro_card_cvv').focus();
                return false;
            }
        }
        if ($('#editpro_address').val() != '') {
            if ($('#editpro_pin').val() == '') {
                $(".personal-details-message").text('Postcode is Required !!!');
                $('#editpro_pin').focus();
                return false;
            }
        }
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "personal-details",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#edit_personal_details_btn").prop("disabled", true);
            },
            success: function (data) {
                $("#edit_personal_details_btn").prop("disabled", false);
                $(".personal-details-message").text(data);
                $('#editpro_cnfpwd').val('');
                $('#editpro_pwd').val('');
            }
        });
    }
});
$("#ac_settings-form").submit(function (e) {
    e.preventDefault();
    var tmp = 'true';
    var flag = common_form_checking(tmp, 'account-settings-message');
    var formData = new FormData(this);
    if (flag != 'false') {
        $.ajax({
            type: "POST",
            url: "account-settings",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#edit_acc_act_btn").prop("disabled", true);
                $(".account-settings-message").text('');
            },
            success: function (data) {
                $("#edit_acc_act_btn").prop("disabled", false);
                $(".account-settings-message").text(data);
            }
        });
    }
});
$(".ac_credit").change(function () {
    if ($(this).val() == 'Y') {
        $('.set_crdt').removeClass('hide_content');
        $('#ac_maxcrdt').addClass('requiredCheck');
    } else {
        $('.set_crdt').addClass('hide_content');
        $('#ac_maxcrdt').removeClass('requiredCheck');
    }
});
$("#cancel_btn").click(function () {
    window.location.href = base_url;
});
$("#reg_login_btn").click(function () {
    window.location.href = base_url + 'login';
});
$("#login_reg_btn").click(function () {
    window.location.href = base_url + 'signup';
});
$(".editpro_image_brows").click(function () {
    $("#editpro_image").click();
});
$(".verify_pic_ref").click(function () {
    $("#verify_pic").click();
});
$(".verify_pic_id_ref").click(function () {
    $("#verify_pic_id").click();
});
$("#editpro_image").change(function () {
    var reader = new FileReader();
    reader.onload = function (e) {
        $('#display_img').attr('src', e.target.result);
    }
    reader.readAsDataURL(this.files[0]);
});
$('#veriry_agreement').click(function () {
    if ($("#veriry_agreement").is(':checked')) {
        $("#verify_submit_btn").prop('disabled', false);
    } else {
        $("#verify_submit_btn").prop('disabled', true);
    }
});
// $(".editpro_gal_image_brows").click(function () {
   
// });
$(document).on('click', '.add-more-gal-img', function() {
    var old_cnt = $('#gallery_cnt').val();
    var new_cnt = parseInt($('#gallery_cnt').val()) + parseInt(1);
    $('#gallery_cnt').val(new_cnt);
    $('.galdiv').append('<div class="row add-new-browse"><div class="form-group galdiv' + new_cnt + ' gallery-brouser-area">\
                                    <div class="proo">\
                                        <img src="' + base_url + 'assets/images/noimage.png" alt="" style="height:40px; width:45px;" id="display_gal_img' + new_cnt + '">\
                                    </div>\
                                    <input type="file" class="form-control username formsm display_gal_img' + new_cnt + ' brouse-input" onchange="disp_img(\'' + new_cnt + '\', this)" data-count="' + new_cnt + '" name="gallery[]" id="gallery_image' + new_cnt + '" />\
                                    <div class="brows editpro_gal_image_brows" data-count="' + new_cnt + '">BROWSER</div>\
                                    <select name="type[]" id="type" class="form-control username formsm display_gal_img1">\
                                            <option value="1">Free Content</option>\
                                            <option value="2">Premium Content</option>\
                                        </select>\
                                </div></div>');
}).on('click', '.editpro_gal_image_brows', function(){
    //console.log("#gallery_image" + $(this).attr('data-count'));
    $("#gallery_image" + $(this).attr('data-count')).click();
});
// $('.add-more-gal-img').click(function () {
    
// });

function disp_img(tmp, ths) {
    var tmp = $(ths).attr('data-count');
    var reader = new FileReader();
    reader.onload = function (e) {
        $('#display_gal_img' + tmp).attr('src', e.target.result);
    }
    reader.readAsDataURL(ths.files[0]);
}
$("#verification-form").submit(function (e) {
    e.preventDefault();
    $(".verification-message").text('');
    var tmp = 'true';
    var flag = common_form_checking(tmp);
    if (flag != 'false') {
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "verification",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $(".verification-message").text('Sending ...');
                $("#verify_submit_btn").prop("disabled", true);
            },
            success: function (data) {
                $(".verification-message").text('');
                $("#verify_submit_btn").prop("disabled", false);
                var res = data.split('~~');
                if (res[0] == 'ok') {
                    $('#verify_name').val('');
                    $('#verify_day').val('');
                    $('#verify_month').val('');
                    $('#verify_year').val('');
                    $('#verify_pic').val('');
                    $('#verify_pic_id').val('');
                    swal_success(res[1]);
                } else {
                    swal_warning(res[1]);
                }
            }
        });
    }
});

function search_suggestion(val) {
    if (val == '') {
        val = 'tmp';
    }
    $.ajax({
        type: "POST",
        url: base_url + "subs-suggestion",
        data: {
            'subs_search': val
        },
        cache: false,
        success: function (res) {
            $('.subs-ul').html('');
            $('.subs-ul').html(res);
        }
    });
}
/**************VIDEO CHAT****************/
var constHasCamera = '';

function startVideoChat(performer_id, performer_nm) {
    DetectRTC.load(function () {
        if (DetectRTC.hasWebcam == false) {
            swal_warning("Sorry !!! You do not have a webcam. Please install one for your Video Call. Thank you.");
        } else {
            var hsh = Math.floor(Math.random() * 0xFFFFFF).toString(16)
            $.ajax({
                type: "POST",
                url: base_url + "start-video-chat",
                data: {
                    'performer_id': performer_id,
                    'performer_nm': performer_nm,
                    'url_hash': hsh
                },
                cache: false,
                success: function (res) {
                    if (res == 'ok') {
                        window.location = base_url + 'video-chat#' + hsh;
                    } else if (res == 'notok') {
                        swal_warning("Sorry !!! " + performer_nm + " Currently Offline !!!");
                    } else if (res == 'busy') {
                        swal_warning("Sorry !!! " + performer_nm + " is busy with another person !!!");
                    }
                }
            });
        }
    });
}
$(document).ready(function () {
    if (UserId != '' && UserType != '' && UserType == '2') {
        setInterval(function () {
            $.ajax({
                type: "POST",
                url: base_url + "check-new-video-chat-request",
                data: {
                    'performer_id': UserId
                },
                cache: false,
                success: function (data) {
                    var res = data.split('~~');
                    if (res[0] != 'no-request') {
                        var options = swalConfirmationOptions;
                        options.title = "Confirmation";
                        options.text = "New Video Call Request from " + res[1] + "!!!";
                        options.type = "success";
                        options.confirmButtonText = "Accept";

                        swal(options).then(function () {
                            $.ajax({
                                type: "POST",
                                url: base_url + "accept-video-chat",
                                data: {
                                    'performer_id': UserId,
                                    'url_hash': res[0],
                                    'user_id': res[2]
                                },
                                cache: false,
                                success: function (data) {
                                    $('#url_hash').val(res[0]);
                                    window.location = base_url + 'video-chat#' + res[0];
                                }
                            });
                            //window.open(base_url + 'video-chat#' + res, '_blank');
                        }, function (dismiss) {
                            if (dismiss == 'cancel') {
                                $.ajax({
                                    type: "POST",
                                    url: base_url + "cancel-video-chat",
                                    data: {
                                        'performer_id': UserId,
                                        'url_hash': res[0],
                                        'user_id': res[2]
                                    },
                                    cache: false,
                                    success: function (data) {}
                                });
                            }
                        });
                    }
                }
            });
        }, 5000);

        if (document.getElementById('vcStarted') != null) {
            setInterval(function () {
                $.ajax({
                    type: "POST",
                    url: base_url + "check-video-chat-status-performer",
                    data: {
                        'performer_id': $('#vcPerformerId').val(),
                        'user_id': $('#vcUserId').val(),
                        'url_hash': $('#url_hash').val()
                    },
                    cache: false,
                    success: function (res) {
                        if (res == 'ok') {
                            clearInterval(interval);
                            var options                   = swalConfirmationOptions;
                                options.title             = "Notification";
                                options.text              = "Video Call Ended !!!";
                                options.type              = "success";
                                options.confirmButtonText = "OK";

                            swal(options).then(function () {
                                window.location = base_url;
                            });
                        }
                    }
                });
            }, 5000);
        }
        setInterval(function () {
            DetectRTC.load(function () {
                if (DetectRTC.hasWebcam == false) {
                    var hasCamera = 'N';
                } else {
                    var hasCamera = 'Y';
                }
                if (constHasCamera != hasCamera) {
                    $.ajax({
                        type: "POST",
                        url: base_url + "check-webcam-performer",
                        data: {
                            'performer_id': UserId,
                            'hasCamera': hasCamera,
                        },
                        cache: false,
                        success: function (res) {
                            constHasCamera = hasCamera;
                        }
                    });
                }
            });
        }, 10000);
    }
    if (UserId != '' && UserType != '' && UserType == '1') {
        if (document.getElementById('vcStarted') != null) {
            setInterval(function () {
                $.ajax({
                    type: "POST",
                    url: base_url + "check-video-chat-status",
                    data: {
                        'chat_id': $('#videoChatId').val()
                    },
                    cache: false,
                    success: function (data) {
                        var res = data.split('~~');
                        if (res[0] == 'notok') {
                            var options         = swalConfirmationOptions;
                                options.title   = "Video Call Request Cancelled !!!";
                                options.type    = "Video Call Request Cancelled !!!";
                                options.buttons = "OK";

                            swal(options).then(function () {
                                window.location = base_url + 'performer/' + res[1] + '/' + res[2];
                            });
                        }
                    }
                });
            }, 5000);
        }
    }
    if (document.getElementById('vcStarted') != null) {
        $('.vcChatList').animate({
            scrollTop: $('.vcChatList').get(0).scrollHeight
        }, 1500);
        setInterval(function () {
            $.ajax({
                type: "POST",
                url: base_url + "vc-check-new-text",
                data: {
                    'last_id': $("#vcLastChatId").val(),
                    'receiver_id': $("#vcPerformerId").val(),
                    'sender_id': $("#vcUserId").val()
                },
                cache: false,
                success: function (data) {
                    var res = data.split('~~');
                    if (res[0] != '') {
                        $('.vcChatList').append(res[1]);
                        $('#vcLastChatId').val(res[0]);
                        $('.vcChatList').animate({
                            scrollTop: $('.vcChatList').get(0).scrollHeight
                        }, 100);
                    }
                }
            });
        }, 5000);
    }
});

$("#vcSendMsg").click(function () {
    if ($("#vcMsgBody").val() != '') {
        if ($("#vcSenderType").val() == 'user') {
            var s_id = $("#vcUserId").val();
            var r_id = $("#vcPerformerId").val();
        } else {
            var s_id = $("#vcPerformerId").val();
            var r_id = $("#vcUserId").val();
        }
        $.ajax({
            type: "POST",
            url: base_url + "vc-send-chat",
            data: {
                'chat_msg': $("#vcMsgBody").val(),
                'receiver_id': r_id,
                'receiver_type': $("#vcReceiverType").val(),
                'sender_id': s_id,
                'sender_type': $("#vcSenderType").val()
            },
            beforeSend: function () {
                $("#vcSendMsg").prop('disabled', true);
            },
            cache: false,
            success: function (data) {
                var res = data.split('~~');
                $("#vcSendMsg").prop('disabled', false);
                $('.vcChatList').append('<li class="align-right"><span>' + $("#vcMsgBody").val() + '</span><span>' + res[1] + '</span></li>');
                $('#vcLastChatId').val(res[0]);
                $("#vcMsgBody").val('');
                $('.vcChatList').animate({
                    scrollTop: $('.vcChatList').get(0).scrollHeight
                }, 100);
            }
        });
    } else {
        swal_warning("Put Some Message to Send!!!");
    }
});
var interval = '';

function start(count) {
    var startMin = 60 * parseInt(count),
        display = document.querySelector('#vcDuration');
    startTimer(startMin, display);
}

function startTimer(duration, display) {
    var timer = duration,
        minutes, seconds;
    interval = setInterval(function () {
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        display.textContent = minutes + ":" + seconds;
        if (++timer < 0) {
            timer = duration;
        }
    }, 1000);
}
/************** Custom ScrollBar----10-09-19 ****************/

//$('body').overlayScrollbars({className : "os-theme-round-dark"}); 
$('.customScroll').overlayScrollbars({
	className : "os-theme-round-dark",
	resize : "false",
	sizeAutoCapable : true,
	paddingAbsolute : true
}); 




//BUY CREDITS
$('.buy-credit-slider').owlCarousel({
    loop:false,
    margin:10,
    nav:true,
	dots: false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:4
        }
    }
});



$('.slider-awards').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
	items:1,
	dots: false,
	autoplay: true,
	autoplayHoverPause:true,
});


$(".gift-send").click(function(){
    let btn = $(this);
    let options = swalConfirmationOptions;
    options.title = "Confirmation";
    options.text = "Are you sure to sent this gift?";

    swal(options).then(function () {
        $.ajax({
            url: base_url + 'send-gift',
            type: "post",
            data: {
                gift_id: btn.data('id'),
                receiver_id: btn.data('uid')
            },
            dataType: "json",
            beforeSend: function () {
                $("body").waitMe(waitmeOptions);
            },
            complete: function () {
                $("body").waitMe("hide");
            },
            success: function(resp) {
                if (resp.success) {
                    $(".credit-total").text(resp.data.credit);
                    swal_success(resp.data.message);
                } else {
                    swal_warning(resp.data.message);
                }
            },
            error: function(err) {
                console.log(err);
            }
        });
    });
});

function onVideoChange(event) {
    var files = event.files;

    if (files && files.length > 0) {
        var targetFile = files[0];

        try {
            var objectURL = window.URL.createObjectURL(targetFile);
            videoElem.src = objectURL;
            videoElem.style.display = "block";
        } catch (e) {
            try {
                // Fallback if createObjectURL is not supported
                var fileReader = new FileReader();

                fileReader.onload = function (evt) {
                    videoElem.src = evt.target.result;
                };

                fileReader.readAsDataURL(targetFile);
            } catch (e) {
                console.log("File Upload not supported: ".concat(e));
            }
        }
    }
}

$("#btn-video-select").click(function(){
    $("#video_file").click();
});

$("#add-video-btn").click(function(){
    $(".video-upload-bg").addClass("showMsg");
});

$(".video-upload-bg #msg-close").click(function(){
    $(".video-upload-bg").removeClass("showMsg");
});

$(".common-popup #msg-close").click(function(){
    $(".common-popup").removeClass("showMsg");
});

$("#video_submit_btn").click(function(){
    let formData = new FormData();

    formData.append("video_type", $("#video_type").val());
    formData.append("video_file", video_file.files[0]);

    if(! video_file.files.length) {
        swal_warning("Please select video file");
        return false;
    }

    $.ajax({
        url: base_url + "upload-video",
        type: "post",
        data: formData,
        dataType: "json",
        contentType: false,
        processData: false,
        beforeSend: function() {
            $("body").waitMe(waitmeOptions);
        },
        complete: function() {
            $("body").waitMe("hide");
            $("#video-upload-form")[0].reset();
            $("#videoElem").hide();
            $(".video-upload-bg").removeClass("showMsg");
        },
        success: function(resp) {
            if (resp.success) {
                swal_success(resp.message);
                $(".video-container").append(`
                <div class="video-box">
                    <video height="160" preload="false">
                        <source src="${resp.video_url}">
                    </video>  
                    <a class="video-play-btn">
                        <i class="fa fa-play"></i>
                        <i class="fa fa-pause"></i>
                    </a>
                </div>`);
            } else {
                swal_warning(resp.message);
            }
        },
        error: function(err) {
            console.log(err);
        }
    });

});

$(".video-container").on("click", ".video-play-btn", function(event){
    let btn = $(this);
    let videoBox = btn.closest(".video-box");
    let videoItem = videoBox.find("video").get(0);

    if (videoItem.paused) {
        videoItem.play();
        videoBox.addClass("is-playing");        
    } else {
        videoItem.pause();
        videoBox.removeClass("is-playing");
    }
});


$(".user-content-list li").click(function(){
    console.log($(this).index());
    let clicked_index = $(this).index();

    $(".user-content-block").addClass("d-none");
    $($(".user-content-block")[clicked_index]).removeClass("d-none");
});


$(document).ready(function(){
    $.switcher('[name="default_video_id"]');
});