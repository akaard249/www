function adminBtnFun(evt) {
  if (evt.currentTarget.id == "accept") {
    var monthlyPayment = document.getElementById("monthlyPayment").value;
    var adminComment = document.getElementById("adminComment").value;
    if (monthlyPayment == "") {
      $("#error").html(
        '<div  class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>الدفعة الشهرية لا يمكن أن تكون فارغة </strong></div>'
      );
    } else if (adminComment.trim() == "") {
      $("#error").html(
        '<div  class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>تعليق المدير لا يمكن أن يكون فارغا </strong></div>'
      );
    } else {
      var loan_id = document.getElementById("loan_id").value;
      function acceptFun(loan_id, adminComment, monthlyPayment) {
        $.ajax({
          url: "/api/jsscripts.php",
          method: "post",
          data: {
            func: "adminLoanAccept",
            loan_id: loan_id,
            adminComment: adminComment,
            monthlyPayment: monthlyPayment,
          },
          success: function (data) {
            $("#error").html(data);
          },
        });
      }
      acceptFun(loan_id, adminComment, monthlyPayment);
    }
  } else if (evt.currentTarget.id == "reject") {
    var adminComment = document.getElementById("adminComment").value;
    if (adminComment.trim() == "") {
      $("#error").html(
        '<div  class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>تعليق المدير لا يمكن أن يكون فارغا </strong></div>'
      );
    } else {
      var loan_id = document.getElementById("loan_id").value;
      function rejectFun(loan_id, adminComment) {
        $.ajax({
          url: "/api/jsscripts.php",
          method: "post",
          data: {
            func: "adminLoanReject",
            loanId: loan_id,
            adminComment: adminComment,
          },
          success: function (data) {
		if(data =="success"){
			alert('تم رفض القرض بنجاح');
			window.location.replace("/management/requests");
		}else{
		 $("#error").html(data);	
		}
           
          },
        });
      }
      rejectFun(loan_id, adminComment);
    }
  }
}
function financeFun(evt) {
  if (evt.currentTarget.id == "accept") {
	
	var financeComment = document.getElementById("financeComment").value;
	if (financeComment.trim() == ""){
		$("#error").html(
		        '<div  class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>تعليق الأمين المالي لا يمكن أن يكون فارغا </strong></div>'		
		);
	}else{
		var loanId = document.getElementById("loan_id").value;
		$.ajax({
			url:"/api/jsscripts/php",
			method:"post",
			data:{func:"financeLoanAccept",loanId:loanId , financeComment:financeComment},
			success:function(data){
				if (data == "success"){
					alert('تمت الموافقة على القرض بنجاح');
					window.location.replace("/management/requests");
				}else{
					$("#error").html(data);
				}
				
			}
		});
	}
  } else if (evt.currentTarget.id == "reject") {

	var loanId = document.getElementById("loan_id").value;
	var financeComment = document.getElementById("financeComment").value;
	if(financeComment.trim() == "" ){
$("#error").html(
  '<div  class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>تعليق أمين الصندوق لا يمكن أن يكون فارغا </strong></div>'
);
	}else{
		$.ajax({
		url:"/api/jsscripts.php",
		method:"post",
		data:{func:"financeLoanReject" , loanId:loanId , financeComment:financeComment},
		success : function(data) {
			if (data == "success"){
				alert('تم رفض القرض بنجاح !');
				window.location.replace("/management/requests")
			}else{
			$("#error").html(data);	
			}
			
		}
	});
	}
	
    
  }
}
function back() {
  window.location.assign("/management/requests");
}
$(document).ready(function () {});
