//$("#error").html(
// '<div  class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> warraapp </strong></div>'
// );
$(document).ready(function(){
	// declaring the items in the page 
	const sub_but = document.getElementById("submit_but");
	var error = document.getElementById("error");
	sub_but.addEventListener("click",function(){
    var pass1 = document.getElementById("password1").value;
    var pass2 = document.getElementById("password2").value;
       var user_cpr = document.getElementById("user_cpr").value;

	// declaring the submit function 
	function submit(user_cpr , password){
		 $.ajax({
			url: "/api/jsscripts.php",
			method: "post",
			data: {
				func: "first_password_submit",
				user_cpr: user_cpr,
				password: password,
			},
       success: function (data) {
	if(data == "success"){
		alert('تم حفظ كلمة السر الجديدة بنجاح ');
		window.location.replace("/");
	}else{
		$("#error").html(data);
	}
         
       },
     });
	}




    if(pass1 == "" || pass2 == ""){
      $("#error").html(
      '<div  class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> الرجاء ملء جميع الحقول </strong></div>'
      );
    }else if(pass1.length < 8){
$("#error").html(
  '<div  class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>كلمة السر يجب أن تكون على الأقل 8 خانات </strong></div>'
);
    }
    else if(pass1 != pass2){
	$("#error").html(
    '<div  class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>كلمات السر لا تتوافق ، الرجاء مراجع البيانات </strong></div>'
  );

    }else{
	console.log(user_cpr+ pass1);
	submit(user_cpr,pass1);
    }
  });
});