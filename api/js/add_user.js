
$(document).ready(function () {
	const add_user_button = document.getElementById("add_user_submit_button");
  function add_user(
    user_cpr,
    user_name,
    user_company,
    user_init_payment,
    user_phone,
    user_rel,
    user_rel_phone,
    user_reg_year,
    user_init_share
  ) {
var error = document.getElementsByClassName("error");
error[0].style.display = "inline-block";
    $.ajax({
      url: "/api/jsscripts.php",
      method: "post",
      data: {
        func: "add_user",
        user_cpr: user_cpr,
        user_name: user_name,
        user_company: user_company,
        user_init_payment: user_init_payment,
        user_rel: user_rel,
        user_rel_phone: user_rel_phone,
        user_phone: user_phone,
        user_reg_year: user_reg_year,
	user_init_share:user_init_share
      },
      success: function (data) {

        
        if (data == "success") {
          error[0].style.display = "none";
          alert("تم اضافة العميل بنجاح");
          window.location.replace("/management/users.php");
        } else if (data == "error") {
          error[0].style.display = "none";
          $("#error").html(
            '<div class="alert alert-danger alert-dismissible"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong> حدث خطأ الرجاء مراجعة البيانات </strong>  </div>'
          );
        } else if (data == "user_cpr_dup") {
          error[0].style.display = "none";
          $("#error").html(
            '<div class="alert alert-danger alert-dismissible"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong> العميل مسجل بالفعل . الرجاء مراجعة البيانات </strong>  </div>'
          );
        } else {
          error[0].style.display = "none";
          $("#error").html(data);
        }
      },
    });
  }
  add_user_button.addEventListener("click", function () {
    var user_cpr = document.getElementById("user_cpr").value;
    var user_name = document.getElementById("user_name").value;
    var user_company = document.getElementById("user_company").value;
    var user_init_payment = document.getElementById("user_init_payment").value;
    var user_phone = document.getElementById("user_phone").value;
    var user_rel = document.getElementById("user_rel").value;
    var user_rel_phone = document.getElementById("user_rel_phone").value;
    var user_reg_year = document.getElementById("user_reg_year").value;
    var user_init_share = document.getElementById("user_init_share").value;


    if (user_cpr.length < 9) {
      document.getElementById("user_cpr").style.borderColor = "#ff0000";
      $("#error").html(
        '<div class="alert alert-warning alert-dismissible"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>الرقم الشخصي للعميل اقل من 9 خانات </strong>  </div>'
      );
    } else if (user_name == "") {
      document.getElementById("user_cpr").style.borderColor = "#f0f0f0";
      document.getElementById("user_name").style.borderColor = "#ff0000";
      $("#error").html(
        '<div class="alert alert-warning alert-dismissible"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong> اسم العميل لا يمكن أن يكون خاليا </strong>  </div>'
      );
    } else if (user_init_payment == "") {
      document.getElementById("user_cpr").style.borderColor = "#f0f0f0";
      document.getElementById("user_name").style.borderColor = "#f0f0f0";
      document.getElementById("user_init_payment").style.borderColor =
        "#ff0000";
      $("#error").html(
        '<div class="alert alert-warning alert-dismissible"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong> الدفعة الأولية لا يمكن أن تكون خالية </strong>  </div>'
      );
    } else if (user_phone.length < 8) {
      document.getElementById("user_cpr").style.borderColor = "#f0f0f0";
      document.getElementById("user_name").style.borderColor = "#f0f0f0";
      document.getElementById("user_init_payment").style.borderColor ="#f0f0f0";
      document.getElementById("user_phone").style.borderColor = "#ff0000";
      $("#error").html('<div class="alert alert-warning alert-dismissible"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>رقم الهاتف لا يمكن أن يكون أقل من 8 خانات </strong>  </div>'
      );
    } else if(user_rel.length < 1) {
      document.getElementById("user_cpr").style.borderColor = "#f0f0f0";
      document.getElementById("user_name").style.borderColor = "#f0f0f0";
      document.getElementById("user_init_payment").style.borderColor = "#f0f0f0";
      document.getElementById("user_phone").style.borderColor = "#f0f0f0";
      document.getElementById("user_rel").style.borderColor = "#ff0000";
      $("#error").html(
        '<div class="alert alert-warning alert-dismissible"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>اسم اقرب شخص لا يمكن أن يكون خاليا </strong>  </div>'
      );
    } else if(user_rel_phone.length < 9){
	document.getElementById("user_cpr").style.borderColor = "#f0f0f0";
  document.getElementById("user_name").style.borderColor = "#f0f0f0";
  document.getElementById("user_init_payment").style.borderColor = "#f0f0f0";
  document.getElementById("user_phone").style.borderColor = "#f0f0f0";
  document.getElementById("user_rel").style.borderColor = "#f0f0f0";
   document.getElementById("user_rel_phone").style.borderColor = "#ff0000";
$("#error").html('<div class="alert alert-warning alert-dismissible"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>رقم هاتف القريب لا يمكن أن يكون خاليا </strong>  </div>');
    }else {
      document.getElementById("user_cpr").style.borderColor = "#f0f0f0";
      document.getElementById("user_name").style.borderColor = "#f0f0f0";
      document.getElementById("user_init_payment").style.borderColor =
        "#f0f0f0";
      document.getElementById("user_rel").style.borderColor = "#f0f0f0";
      document.getElementById("user_rel_phone").style.borderColor = "#f0f0f0";
      document.getElementById("user_phone").style.borderColor = "#f0f0f0";
      $("#error").html("");

      add_user(
        user_cpr,
        user_name,
        user_company,
        user_init_payment,
        user_phone,
        user_rel,
        user_rel_phone,
        user_reg_year,
        user_init_share
      );
    }
  });
});

$(document).on({
  ajaxStart: function () {
    
  },
  ajaxStop: function () {
     
  },
});
