function back() {
  window.location.replace("/management/br_requests");
}
function financeBtnFun(evt) {
  if (evt.currentTarget.id == "accept") {
    var financeComment = document.getElementById("financeComment").value;
    var brId = document.getElementById("borrowing_id").value;
    if (financeComment.trim() == "") {
      $("#error").html(
        '<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>تعليق أمين الصندوق لا يمكن أن يكون خاليا</strong></div>'
      );
    } else {
      $.ajax({
        url: "/api/jsscripts.php",
        method: "post",
        data: {
          func: "brFinanceAccept",
          brId: brId,
          brFinanceComment: financeComment,
        },
        success: function (data) {
          if (data == "success") {
            alert("تمت الموافقة على السلفة بنجاح");
            window.location.replace("/management/br_requests");
          } else {
            $("#error").html(data);
          }
        },
      });
    }
  } else if (evt.currentTarget.id == "reject") {
    var financeComment = document.getElementById("financeComment").value;
    var brId = document.getElementById("borrowing_id").value;
    if (financeComment.trim() == "") {
      $("#error").html(
        '<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>تعليق أمين الصندوق لا يمكن أن يكون خاليا</strong></div>'
      );
    } else {
      $.ajax({
        url: "/api/jsscripts.php",
        method: "post",
        data: {
          func: "brFinanceReject",
          brId: brId,
          brFinanceComment: financeComment,
        },
        success: function (data) {
          if (data == "success") {
            alert("تم رفض السلفة بنجاح");
            window.location.replace("/management/br_requests");
          } else {
            $("#error").html(data);
          }
        },
      });
    }
  }
}
function adminBtnFun(evt) {
  if (evt.currentTarget.id == "accept") {
    var adminComment = document.getElementById("adminComment").value;
    var brId = document.getElementById("borrowing_id").value;
    if (adminComment.trim() == "") {
      $("#error").html(
        '<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>تعليق الإدارة لا يمكن أن يكون خاليا</strong></div>'
      );
    } else {
      $.ajax({
        url: "/api/jsscripts.php",
        method: "post",
        data: {
          func: "brAdminAccept",
          brId: brId,
          brAdminComment: adminComment,
        },
        success: function (data) {
          if (data == "success") {
            alert("تمت الموافقة على السلفة بنجاح");
            window.location.replace("/management/br_requests");
          } else {
            $("#error").html(data);
          }
        },
      });
    }
  }
  else if (evt.currentTarget.id == "reject") {
	var adminComment = document.getElementById("adminComment").value;
  var brId = document.getElementById("borrowing_id").value;
  if (adminComment.trim() == "") {
    $("#error").html(
      '<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>تعليق الإدارة لا يمكن أن يكون خاليا</strong></div>'
    );
  } else {
    $.ajax({
      url: "/api/jsscripts.php",
      method: "post",
      data: {
        func: "brAdminReject",
        brId: brId,
        brAdminComment: adminComment,
      },
      success: function (data) {
        if (data == "success") {
          alert("تم رفض السلفة بنجاح");
          window.location.replace("/management/br_requests");
        } else {
          $("#error").html(data);
        }
      },
    });
  }

  }
}
