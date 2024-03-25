const submit_btn = document.getElementById("btn_sub");
const button = document.getElementById("share_but");
const user_select = document.getElementById("user_cpr");
const year_select = document.getElementById("share_year");
const month_select = document.getElementById("share_month");
var div = document.getElementById("year_div");
div.style.display = "none";

$(document).ready(function () {

	//function for username related years 
	function load_data(query) {
    $.ajax({
      url: "../api/jsscripts.php",
      method: "post",
      data: { query: query },
      success: function (data) {
        $("#year_div").html(data);
      },
    });
  }

  //even for user select to promt the year and month select 
  $("#userselect").on("change", function () {
    div.style.display = "block";
    var search = $(this).val();
    console.log(search);
    if (search != "none") {
      load_data(search);
    } else {
      div.style.display = "none";
      load_data();
    }
    var subbtn = document.getElementById("btn_sub");
    if (div.style.display == "none") {
      subbtn.style.display = "none";
    } else {
      subbtn.style.display = "block";
    }
  });
  
  //function for share payment
  function share_pay(user_cpr, year, month , amount) {
    var error = document.getElementsByClassName("error");
    error[0].style.display = "inline-block";
    $.ajax({
      url: "../api/jsscripts.php",
      method: "post",
      data: { func: "share_sub", user_cpr: user_cpr, year: year, month: month,amount:amount },
      success: function (data) {
        error[0].style.display = "none";
        $("#error").html(data);
      },
    });
  }

  // monthly shares and payments function
  function load_table(user_cpr, year, month) {
    var error = document.getElementsByClassName("error");
    error[1].style.display = "inline-block";
    $.ajax({
      url: "../api/jsscripts.php",
      method: "post",
      data: {
        func: "share_table",
        user_cpr: user_cpr,
        year: year,
        month: month,
      },
      success: function (data) {
         error[1].style.display = "none";
        $("#share_result").html(data);
      },
    });
  }

  // the button event listener for the share payment function
  submit_btn.addEventListener("click", function () {
    var sub_user_cpr = document.getElementById("userselect").value;
    var sub_year = document.getElementById("year_select").value;
    var sub_month = document.getElementById("share_pay_month").value;
    var sub_amount = document.getElementById("share_amount").value;

    if(sub_amount % 20 != 0  ){
       document.getElementById("share_amount").style.borderColor = "#ff0000";
      $("#error").html(
        '<div  class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>كمية النقود لا تقبل القسمة على 20</strong></div>'
      );
    }
    else  if (sub_amount == "") {
      document.getElementById("share_amount").style.borderColor = "#ff0000";
      $("#error").html(
        '<div  class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> الرجاء ادخال الكمية </strong></div>'
      );
    } else {
       document.getElementById("share_amount").style.borderColor = "#f0f0f0";
      share_pay(sub_user_cpr, sub_year, sub_month, sub_amount);
      var user_cpr = document.getElementById("user_cpr").value;
      var year = document.getElementById("share_year").value;
      var month = document.getElementById("share_month").value;
      
    }
    var user_cpr = document.getElementById("user_cpr").value;
    var year = document.getElementById("share_year").value;
    var month = document.getElementById("share_month").value;
    load_table(user_cpr, year, month);
   
  });

  // construct function declaration
  function get_list() {
    var user_cpr = document.getElementById("user_cpr").value;
    var year = document.getElementById("share_year").value;
    var month = document.getElementById("share_month").value;
    console.log(user_cpr + year + month);
    load_table(user_cpr, year, month);
  }
  // running the function
  get_list();

  //using the function when the user select changes
  user_select.addEventListener("change", function () {
    var user_cpr = document.getElementById("user_cpr").value;
    var year = document.getElementById("share_year").value;
    var month = document.getElementById("share_month").value;
    console.log(user_cpr + year + month);
    load_table(user_cpr, year, month);
  });

  //using the function when the year select changes
  year_select.addEventListener("change", function () {
    var user_cpr = document.getElementById("user_cpr").value;
    var year = document.getElementById("share_year").value;
    var month = document.getElementById("share_month").value;
    console.log(user_cpr + year + month);
    load_table(user_cpr, year, month);
  });

  //using the function when the month select changes
  month_select.addEventListener("change", function () {
    var user_cpr = document.getElementById("user_cpr").value;
    var year = document.getElementById("share_year").value;
    var month = document.getElementById("share_month").value;
    console.log(user_cpr + year + month);
    load_table(user_cpr, year, month);
  });
  // setInterval(function(){
  //      var user_cpr = document.getElementById("user_cpr").value;
  //     var year = document.getElementById("share_year").value;
  //     var month = document.getElementById("share_month").value;
  // console.log(user_cpr + year + month);
  //   load_table(user_cpr , year , month );
  // } , 1500);
});
