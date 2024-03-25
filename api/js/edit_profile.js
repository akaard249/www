

$(document).ready(function () {
  // declaring buttons
  const edit_but = document.getElementById("edit_user");
  const confirm_but = document.getElementById("password_check");
  const back_but = document.getElementById("back_user");
  const pass_edit = document.getElementById("edit_pass_but");

  var edit_div = document.getElementById("edit_form");
  var confirm_div = document.getElementById("confirm_form");

  function passowrd_check(password, user_company, user_phone, user_rel,user_rel_phone , user_cpr) {
    $.ajax({
      url: "/api/jsscripts.php",
      method: "post",
      data: {
        func: "password_confirm",
        password: password,
        user_cpr: user_cpr,
        user_company: user_company,
        user_phone: user_phone,
        user_rel: user_rel,
	user_rel_phone:user_rel_phone
      },
      success: function (data) {
        if (data == "success") {
          alert("تم تعديل البينات الشخصية");
          window.location.replace("/");
        } else if (data == "password wrong") {
          
	   $("#error2").html(
            '<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> كلمة السر غير صحيحة</strong></div>'
          );
        } else {
         $("#error2").html(data);
        }
      },
    });
  }
  confirm_div.style.display = "none";
  edit_but.addEventListener("click", function () {
    var user_phone = document.getElementById("user_phone").value;
    var user_rel = document.getElementById("user_rel").value;
    var user_rel_phone = document.getElementById("user_rel_phone").value;

    if (user_phone.length < 9) {
      $("#error").html(
        '<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>رقم الهاتف غير صحيح</strong></div>'
      );
    } else if ( user_rel.trim() == "") {
      $("#error").html(
        '<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> اسم أقرب شخص لا يمكن أن يكون خاليا   </strong></div>'
      );
    } else if (user_rel_phone.length < 9) {
	 $("#error").html(
     '<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> رقم الهاتف لأقرب شخص غير صحيح   </strong></div>'
   );
    } else {
      $("#error").html("");
      edit_div.style.display = "none";
      confirm_div.style.display = "block";
    }
  });

  confirm_but.addEventListener("click", function () {
    var user_company = document.getElementById("user_company").value;
    var user_phone = document.getElementById("user_phone").value;
    var user_rel = document.getElementById("user_rel").value;
    var user_rel_phone = document.getElementById("user_rel_phone").value;
    var user_cpr = document.getElementById("user_cpr").value;

    var password = document.getElementById("password").value;
    if (password == "") {
      $("#error2").html(
        '<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> كلمة السر لا يمكن أن تكون فارغة! </strong></div>'
      );
    } else {
	
      passowrd_check(
        password,
        user_company,
        user_phone,
        user_rel,
        user_rel_phone,
        user_cpr
      );
    }
  });

  //edit password 
  pass_edit.addEventListener("click",function(){
    var old_password = document.getElementById("old_password").value;
    var new_password = document.getElementById("new_password").value;
    var new_password_confirm = document.getElementById(
      "new_password_confirmed"
    ).value;

    if (new_password.length < 8) {
       $("#pass_edit_error").html(
         '<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>كلمة السر الجديدة لا يمكن أن تكون أقل من 8 خانات </strong></div>'
       );
    } else if (new_password != new_password_confirm) {
      $("#pass_edit_error").html(
        '<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>كلمات السر الجديدة لا تطابق</strong></div>'
      );
    } else {
      var user_cpr = document.getElementById("user_cpr").value;
      function edit_password(user_cpr , old_password , new_password){
        $.ajax({
          url:"/api/jsscripts.php",
          method:"post",
          data:{func:"edit_password",user_cpr:user_cpr,old_password:old_password,new_password:new_password},
          success : function(data){
            if(data == "success"){
              alert('تم تعديل كلمة السر');
              window.location.replace("/");
            }else if (data == "wrong password") {
              $("#pass_edit_error").html(
                '<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>كلمة السر القديمة غير صحيحة</strong></div>'
              );
            } else {
              $("#pass_edit_error").html(data);
            }
          
          }
        });
      }
       edit_password(user_cpr , old_password , new_password);
    }
   

  });
});
