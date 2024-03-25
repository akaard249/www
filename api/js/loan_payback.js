

$(document).ready(function () {
  var error1 = document.getElementsByClassName("error");
  
  var error2 = document.getElementsByClassName("error");
  
const user_select = document.getElementById("user_cpr");
const month_select = document.getElementById("loans_payments_month");
const year_select = document.getElementById("loans_payments_year");
// loan payback button
const button = document.getElementById("btn_sub");
// year and month div
var yearMonthDiv = document.getElementById("year_select");
yearMonthDiv.style.display = "none";



	// function for getting users years 
	 function loanPaybackuseryear(user_cpr) {
    error1[0].style.display = "inline-block";
     $.ajax({
       url: "../api/jsscripts.php",
       method: "post",
       data: { loan_payback_year: user_cpr },
       success: function (data) {
        
        error1[0].style.display = "none";
         $("#year_select").html(data);
       },
     });
   }
   // user select event listener 
    $("#userselect").on("change", function () {
      yearMonthDiv.style.display = "block";
      var user_cpr = $(this).val();
      
      if (user_cpr != "none") {
        loanPaybackuseryear(user_cpr);
      } else {
        yearMonthDiv.style.display = "none";
        loanPaybackuseryear();
      }
      
      if (yearMonthDiv.style.display == "none") {
        button.style.display = "none";
      } else {
        button.style.display = "block";
      }
    });

	// function for loan payback payment
	function loan_payback_fun(user_cpr, loanId, year, month) {
   error1[0].style.display = "inline-block";
    $.ajax({
      url: "../api/jsscripts.php",
      method: "post",
      data: {
        func: "loan_payback_fun",
        loanId:loanId,
        user_cpr: user_cpr,
        year: year,
        month: month,
      },
      success: function (data) {
        
        error1[0].style.display = "none";
        if(data == 1){
           Swal.fire({
      title: "نجاح",
      html:"تم تسجيل الدفعة بنجاح",
      icon:"success",
           });

         
        }else if(data == 2){
           Swal.fire({
             title: "نجاح",
             html: "تم تسجيل أول دفعة للمستخدم بنجاح",
             icon: "success",
           });
        }else if(data == 3){
            Swal.fire({
              title: "فشل !",
              html: "العميل لم يبدأ بسداد القرض ، الرجاء مراجعة التاريخ و اختيار أول شهر بعد قبول القرض",
              icon: "error",
            });
          
        }else if(data == 4){
           Swal.fire({
            title: "فشل !",
            html: "العميل دفع بالفعل لهذا الشهر   ",
            icon: "error",
          });
        }
        
        else{
          Swal.fire({
            title: "فشل !",
            html: "العميل لديه شهر سابق غير مسدد ، تاريخ اخر سداد  " + data,
            icon: "error",
          });
        }
        

      },
    });
  }
  // button event listenner 
   button.addEventListener("click", function () {
     var user_cpr = document.getElementById("userselect").value;
     var loanId = document.getElementById("loanId").value;
     var year = document.getElementById("year_payback_select").value;
     var month = document.getElementById("loan_payback_month").value;
     var user_name =
       document.getElementById("userselect").options[
         document.getElementById("userselect").selectedIndex
       ].text;

    Swal.fire({
      title: "هل المعلومات المدخلة صحيحة ؟",
      html:
        "اسم المستخدم " +
        user_name +
        " <br> الرقم الشخصي للعميل : " +
        user_cpr +
        " <br> تاريخ الدفعة : " +
        month +
        " / " +
        year,
      icon: "question",
      confirmButtonText: "تأكيد",
      showCancelButton: true,
      cancelButtonText: "مراجعة",
      reverseButtons: false,
    }).then((result) => {
      if (result.isConfirmed) {
        loan_payback_fun(user_cpr, loanId , year, month);
        console.log("confirm");
      } else{
       
      }
    });


     
   });


  // loan payback payments report function
  function load_table(user_cpr, year, month) {
    
    $.ajax({
      url: "../api/jsscripts.php",
      method: "post",
      data: {
        func: "loans_result",
        user_cpr: user_cpr,
        year: year,
        month: month,
      },
      success: function (data) {
        error2[1].style.display = "none";
        $("#loans_table_result").html(data);
      },
    });
  }
  // report constructor function
  function starter() {
    error2[1].style.display = "inline-block";
    var user_cpr = document.getElementById("user_cpr").value;
    var year = document.getElementById("loans_payments_year").value;
    var month = document.getElementById("loans_payments_month").value;
    
    load_table(user_cpr, year, month);
  }
  starter();
  // report user select listener
  user_cpr.addEventListener("change", function () {
    var user_cpr = document.getElementById("user_cpr").value;
    var year = document.getElementById("loans_payments_year").value;
    var month = document.getElementById("loans_payments_month").value;
    error2[1].style.display = "inline-block";
    load_table(user_cpr, year, month);
  });
  // report year select listener
  year_select.addEventListener("change", function () {
     error2[1].style.display = "inline-block";
    var user_cpr = document.getElementById("user_cpr").value;
    var year = document.getElementById("loans_payments_year").value;
    var month = document.getElementById("loans_payments_month").value;

    load_table(user_cpr, year, month);
  });
  // report month select listener
  month_select.addEventListener("change", function () {
     error2[1].style.display = "inline-block";
    var user_cpr = document.getElementById("user_cpr").value;
    var year = document.getElementById("loans_payments_year").value;
    var month = document.getElementById("loans_payments_month").value;

    load_table(user_cpr, year, month);
  });

  
});
