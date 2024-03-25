function loan_details(evt){
  document.getElementById("loansTableContainer").className = "col-lg-6 col-md-12";

	var id = evt.currentTarget.id;
	function detail_data(id){
		$.ajax({
			url:"/api/jsscripts.php",
			method:"post",
			data:{func:"user_loan_details",loan_id:id},
			success: function(data){
				$("#res").html(data);
			}
		});
	}

	detail_data(id);
	


}
$(document).ready(function () {
  const par_loan_but = document.getElementById("par_loan_but");
  function par_loan_request(user_cpr, loan_amount) {
    $.ajax({
      url: "/api/jsscripts",
      method: "post",
      data: {
        func: "par_loan_request",
        user_cpr: user_cpr,
        loan_amount: loan_amount,
      },
      success: function (data) {
        $("#error").html(data);
      },
    });
  }

  par_loan_but.addEventListener("click", function () {
    var user_cpr = document.getElementById("user_cpr").value;
    var loan_amount = document.getElementById("load_request_amount").value;
    if (loan_amount == "") {
      document.getElementById("load_request_amount").style.borderColor =
        "#ff0000";
      $("#error").html(
        '<div style=\'margin: 5px;\' class="alert alert-danger alert-dismissible" style=0<strong> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> الحقل فارغ</strong></div>'
      );
    } else if (isNaN(loan_amount)) {
      document.getElementById("load_request_amount").style.borderColor =
        "#ff0000";
      $("#error").html(
        '<div style=\'margin: 5px;\' class="alert alert-danger alert-dismissible" style=0<strong> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>ليس رقم </strong></div>'
      );
    } else {
      par_loan_request(user_cpr, loan_amount);
    }
  });

  function par_loan_list(user_cpr) {
    var user_cpr = document.getElementById("user_cpr").value;
    $.ajax({
      url: "/api/jsscripts.php",
      method: "post",
      data: { func: "par_loan_list", user_cpr: user_cpr },
      success: function (data) {
        $("#par_loan_list").html(data);
      },
    });
  }
par_loan_list();
  setInterval(par_loan_list, 60000);

});
