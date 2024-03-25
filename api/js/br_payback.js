$(document).ready(function () {
  var error = document.getElementsByClassName("error");

  // the submit button for the br payback form
  const br_sub_button = document.getElementById("btn_sub");
  // year select div controller / variable
  var div = document.getElementById("year_select");
  div.style.display = "none";

  // varibales for the selects in report section
  const user_select = document.getElementById("user_cpr");
  const month_select = document.getElementById("br_month");
  const year_select = document.getElementById("br_year");

  //  function for loading the year select using the username select
  function load_data(query) {
    error[0].style.display = "inline-block";
    $.ajax({
      url: "../api/jsscripts.php",
      method: "post",
      data: { func: "borrowings_data", user_cpr: query },
      success: function (data) {
        error[0].style.display = "none";
        $("#year_select").html(data);
      },
    });
  }

  // event listener for the user select
  $("#br_user_cpr").on("change", function () {
    div.style.display = "block";
    var search = $(this).val();
    
    if (search != "none") {
      load_data(search);
    } else {
      div.style.display = "none";
      load_data(search);
    }
    var subbtn = document.getElementById("btn_sub");
    if (div.style.display == "none") {
      subbtn.style.display = "none";
    } else {
      subbtn.style.display = "block";
    }
  });

  // function for submitting
  function br_sub_fun(user_cpr, amount) {
    error[0].style.display = "inline-block";
    $.ajax({
      url: "../api/jsscripts.php",
      method: "post",
      data: { func: "br_sub_fun", user_cpr: user_cpr , amount:amount },
      success: function (data) {
        error[0].style.display = "none";
	if(data=="success"){
     Swal.fire({
       title: "نجاح !",
       html: " تم تسجيل الدفعة بنجاح " ,
       icon: "success",
     });
		var user_cpr = document.getElementById("user_cpr").value;
		var year = document.getElementById("br_year").value;
		var month = document.getElementById("br_month").value;
		load_table(user_cpr, year, month);
	}else if(data == "Greater"){
		
      Swal.fire({
       title: "فشل  !",
       html: " المسجل من الدفعة أكبر من المتبقي للسلفة " ,
       icon: "error",
     });
	}
  else{
    $("#error").html(data);
  }
        
      },
    });
  }

  // event listener for the submit button
  br_sub_button.addEventListener("click", function () {
    
    var paying = document.getElementById("br_payback_amount").value;
    var paid = document.getElementById("br_paid").value;
    var whole = document.getElementById("br_amount").value;
    var user_cpr = document.getElementById("br_user_cpr").value;
    var user_name = document.getElementById("br_user_cpr").options[
         document.getElementById("br_user_cpr").selectedIndex
       ].text;
    if(paying > whole - paid ){
      Swal.fire({
        title: "فشل !",
        html: "القيمة المدخلة أكبر من المتبقي من قيمة السلفة ",
        icon: "error",
      });
    }
    else{
Swal.fire({
      title: "هل المعلومات المدخلة صحيحة ؟",
      html:
        "اسم المستخدم " +
        user_name +
        " <br> الرقم الشخصي للعميل : " +
        user_cpr +
        " <br>  المبلغ : " +
        paying,
      icon: "question",
      confirmButtonText: "تأكيد",
      showCancelButton: true,
      cancelButtonText: "مراجعة",
      reverseButtons: false,
    }).then((result) => {
      if (result.isConfirmed) {
      br_sub_fun(user_cpr, paying);
      } else{
       
      }
    });}



   
   

    
    
  });

  // function for retreiving the data for the report
  function load_table(user_cpr, year, month) {
    $.ajax({
      url: "../api/jsscripts.php",
      method: "post",
      data: {
        func: "br_table",
        user_cpr: user_cpr,
        year: year,
        month: month,
      },
      success: function (data) {
        error[1].style.display = "none";
        $("#result_table").html(data);
      },
    });
  }

  // starting function for initial on loan report
  function starter() {
    var user_cpr = document.getElementById("user_cpr").value;
    var year = document.getElementById("br_year").value;
    var month = document.getElementById("br_month").value;
   
    load_table(user_cpr, year, month);
  }
  starter();

  // auto update values every 30 seconds
  setInterval(function () {
    var user_cpr = document.getElementById("user_cpr").value;
    var year = document.getElementById("br_year").value;
    var month = document.getElementById("br_month").value;
   
    load_table(user_cpr, year, month);
  }, 30000);

  // functions for triggering the retreiving function using the user , year and month select

  user_select.addEventListener("change", function () {
    error[1].style.display = "inline-block";
    var user_cpr = document.getElementById("user_cpr").value;
    var year = document.getElementById("br_year").value;
    var month = document.getElementById("br_month").value;
    
    load_table(user_cpr, year, month);
  });
  month_select.addEventListener("change", function () {
    error[1].style.display = "inline-block";
    var user_cpr = document.getElementById("user_cpr").value;
    var year = document.getElementById("br_year").value;
    var month = document.getElementById("br_month").value;

    load_table(user_cpr, year, month);
  });
  year_select.addEventListener("change", function () {
    error[1].style.display = "inline-block";
    var user_cpr = document.getElementById("user_cpr").value;
    var year = document.getElementById("br_year").value;
    var month = document.getElementById("br_month").value;
    
    load_table(user_cpr, year, month);
  });
});
