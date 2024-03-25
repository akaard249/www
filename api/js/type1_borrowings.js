function fetch_details(evt) {
 var table_res_div = document.getElementById("report_resize");
 table_res_div.className = "col-lg-6 col-md-12";

var id = evt.currentTarget.id;
function show_details(id){
	$.ajax({
		url:"/api/jsscripts.php",
		method:"post",
		data:{func:"user_br_details",br_id:id},
		success:function(data){
			$("#res").html(data);
		}
	});
}
show_details(id);
}

$(document).ready(function () {
  var table_res_div = document.getElementById("report_resize");
  table_res_div.className = "col-lg-12 col-md-12";
  const button = document.getElementById("br_but");
  function br_sub(user_cpr, amount) {
    $.ajax({
      url: "/api/jsscripts.php",
      method: "post",
      data: { func: "par_br_sub", user_cpr: user_cpr, amount: amount },
      success: function (data) {
        $("#error").html(data);
      },
    });
  }

  button.addEventListener("click", function () {
    var user_cpr = document.getElementById("user_cpr").value;
    var amount = document.getElementById("br_amount").value;

    if (amount == "") {
      $("#error").html(
        '<div style=\'margin-left: auto; margin-right:auto;\' class="alert alert-danger alert-dismissible" style=\'border:5px;\'> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong> الحقل فارغ </strong></div>'
      );
      document.getElementById("br_amount").style.borderColor = "#ff0000";
    } else {
      console.log(user_cpr, amount);
      br_sub(user_cpr, amount);
    }

    // share_pay(sub_user_cpr , sub_year , sub_month );
  });

  // data table section
  function user_br_list() {
    var user_cpr = document.getElementById("user_cpr").value;
    $.ajax({
      url: "/api/jsscripts.php",
      method: "post",
      data: { func: "par_br_list", user_cpr: user_cpr },
      success: function (data) {
        $("#par_br_result").html(data);
      },
    });
  }
  user_br_list();
  setInterval(user_br_list, 20000);

  // borrowing details function
});
