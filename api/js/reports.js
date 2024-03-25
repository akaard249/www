 
function toggle(evt, div) {

  const divs = document.getElementsByClassName("report-type");
  for (i = 0; i < divs.length; i++) {
    divs[i].style.display = "none";
  }

  const buttons = document.getElementsByClassName("toggle-button");
  for (i = 0; i < buttons.length; i++) {
    buttons[i].style.backgroundColor = "#0db694";
    buttons[i].style.borderTopRightRadius = "0px";
    buttons[i].style.borderTopLeftRadius = "0px";
  }

  var divName = document.getElementById(div);
  divName.style.display = "block";
  var button = document.getElementById(evt.currentTarget.id);
  button.style.backgroundColor = "#70b1b8";
  button.style.borderRadius = "0px";
  button.style.borderTopRightRadius = "5px";
  button.style.borderTopLeftRadius = "5px";
}

$(document).ready(function() {
  // starters
  const divs = document.getElementsByClassName("report-type");
  for (i = 1; i < divs.length; i++) {
    divs[i].style.display = "none";
  }
  const buttons = document.getElementsByClassName("toggle-button");
  buttons[0].style.backgroundColor = "#70b1b8";
  buttons[0].style.borderRadius = "0px";
  buttons[0].style.borderTopRightRadius = "5px";
  buttons[0].style.borderTopLeftRadius = "5px";

  // Loans Sections
  // loans report
  function loansResult(userCpr, dateFrom, dateTo, state) {
    $.ajax({
      url: "/api/jsscripts.php",
      method: "post",
      data: {
        func: "report_loan_result",
        user_cpr: userCpr,
        date_from: dateFrom,
        date_to: dateTo,
        state: state,
      },
      success: function (data) {
        $("#loanResult").html(data);
      },
    });
  }
  // declaring filters
  var loan_user_cpr = document.getElementById("loan_user_cpr");
  var loan_from_date = document.getElementById("loan_from_date");
  var loan_to_date = document.getElementById("loan_to_date");
  var loan_stat = document.getElementById("loan_stat");

  loan_user_cpr.addEventListener("change", function () {
    var userCpr = document.getElementById("loan_user_cpr").value;
    var dateFrom = document.getElementById("loan_from_date").value;
    var dateTo = document.getElementById("loan_to_date").value;
    var stat = document.getElementById("loan_stat").value;
    loansResult(userCpr, dateFrom, dateTo, stat);
  });
  loan_from_date.addEventListener("change", function () {
    var userCpr = document.getElementById("loan_user_cpr").value;
    var dateFrom = document.getElementById("loan_from_date").value;
    var dateTo = document.getElementById("loan_to_date").value;
    var stat = document.getElementById("loan_stat").value;
    loansResult(userCpr, dateFrom, dateTo, stat);
  });
  loan_to_date.addEventListener("change", function () {
    var userCpr = document.getElementById("loan_user_cpr").value;
    var dateFrom = document.getElementById("loan_from_date").value;
    var dateTo = document.getElementById("loan_to_date").value;
    var stat = document.getElementById("loan_stat").value;
    loansResult(userCpr, dateFrom, dateTo, stat);
  });
  loan_stat.addEventListener("change", function () {
    var userCpr = document.getElementById("loan_user_cpr").value;
    var dateFrom = document.getElementById("loan_from_date").value;
    var dateTo = document.getElementById("loan_to_date").value;
    var stat = document.getElementById("loan_stat").value;
    loansResult(userCpr, dateFrom, dateTo, stat);
  });

  // borrowings section
  // borrowings report
  function borrowingResult(userCpr, dateFrom, dateTo, state) {
    $.ajax({
      url: "/api/jsscripts.php",
      method: "post",
      data: {
        func: "report_borrowing_result",
        user_cpr: userCpr,
        date_from: dateFrom,
        date_to: dateTo,
        state: state,
      },
      success: function (data) {
        $("#borrowingResult").html(data);
      },
    });
  }
  // declaring filters for borrowings
  var borrowing_user_cpr = document.getElementById("borrowing_user_cpr");
  var borrowing_from_date = document.getElementById("borrowing_from_date");
  var borrowing_to_date = document.getElementById("borrowing_to_date");
  var borrowing_stat = document.getElementById("borrowing_stat");

  // triggers
  borrowing_user_cpr.addEventListener("change", function () {
    var bruserCpr = document.getElementById("borrowing_user_cpr").value;
    var brdateFrom = document.getElementById("borrowing_from_date").value;
    var brdateTo = document.getElementById("borrowing_to_date").value;
    var brstat = document.getElementById("borrowing_stat").value;
    // console.log(bruserCpr + brdateFrom + brdateTo + brstat);
    borrowingResult(bruserCpr, brdateFrom, brdateTo, brstat);
  });

  borrowing_from_date.addEventListener("change", function () {
    var bruserCpr = document.getElementById("borrowing_user_cpr").value;
    var brdateFrom = document.getElementById("borrowing_from_date").value;
    var brdateTo = document.getElementById("borrowing_to_date").value;
    var brstat = document.getElementById("borrowing_stat").value;
    // console.log(bruserCpr + brdateFrom + brdateTo + brstat);
    borrowingResult(bruserCpr, brdateFrom, brdateTo, brstat);
  });

  borrowing_to_date.addEventListener("change", function () {
    var bruserCpr = document.getElementById("borrowing_user_cpr").value;
    var brdateFrom = document.getElementById("borrowing_from_date").value;
    var brdateTo = document.getElementById("borrowing_to_date").value;
    var brstat = document.getElementById("borrowing_stat").value;
    // console.log(bruserCpr + brdateFrom + brdateTo + brstat);
    borrowingResult(bruserCpr, brdateFrom, brdateTo, brstat);
  });

  borrowing_stat.addEventListener("change", function () {
    var bruserCpr = document.getElementById("borrowing_user_cpr").value;
    var brdateFrom = document.getElementById("borrowing_from_date").value;
    var brdateTo = document.getElementById("borrowing_to_date").value;
    var brstat = document.getElementById("borrowing_stat").value;
    // console.log(bruserCpr + brdateFrom + brdateTo + brstat);
    borrowingResult(bruserCpr, brdateFrom, brdateTo, brstat);
  });

  // monthly shares report

  // monthly report
  function monthlyReport(userCpr, dateFrom, dateTo) {
    $.ajax({
      url: "/api/jsscripts.php",
      method: "post",
      data: {
        func: "monthly_report",
        user_cpr: userCpr,
        date_from: dateFrom,
        date_to: dateTo,
      },
      success: function (data) {
        $("#monthlySharesResult").html(data);
        $("#singleUserName").html(userCpr);
      },
    });
  }

  // declaring variables
  var clientUserCpr = document.getElementById("singleClient_user_cpr");
  var clientDateFrom = document.getElementById("singleClient_from_date");
  var clientDateTo = document.getElementById("singleClient_to_date");
  

  clientUserCpr.addEventListener("change", function () {
    monthlyReport(
      clientUserCpr.value,
      clientDateFrom.value,
      clientDateTo.value,
    );
  });
  clientDateFrom.addEventListener("change", function () {
    monthlyReport(
      clientUserCpr.value,
      clientDateFrom.value,
      clientDateTo.value
    );
  });
   clientDateTo.addEventListener("change", function () {
     monthlyReport(
       clientUserCpr.value,
       clientDateFrom.value,
       clientDateTo.value
     );
   });
   function sharesStarter(){
monthlyReport(clientUserCpr.value, clientDateFrom.value, clientDateTo.value);
   }
   sharesStarter();

  // whole report

  function wholeReport(from , to){
    // init payments
    $.ajax({
      url: "/api/reports.php",
      method: "post",
      data: { func: "init", from: from },
      success: function (data) {
        $("#init").html(data);
      },
    });
    // loans
    $.ajax({
      url: "/api/reports.php",
      method: "post",
      data: { func: "loans", from: from, to: to },
      success: function (data) {
        $("#loans_given").html(data);
      },
    });
    // borrowings
    $.ajax({
      url: "/api/reports.php",
      method: "post",
      data: { func: "borrowings", from: from, to: to },
      success: function (data) {
        $("#borrowings_given").html(data);
      },
    });
    // borrowings payback
    $.ajax({
      url: "/api/reports.php",
      method: "post",
      data: { func: "borrowings_payback", from: from, to: to },
      success: function (data) {
        $("#borrowings_payback").html(data);
      },
    });
    // loans payback
    $.ajax({
      url: "/api/reports.php",
      method: "post",
      data: { func: "loan_payback", from: from, to: to },
      success: function (data) {
        $("#loans_payback").html(data);
      },
    });
    // shares
    $.ajax({
      url: "/api/reports.php",
      method: "post",
      data: { func: "shares", from: from, to: to },
      success: function (data) {
        $("#shares_table").html(data);
      },
    });
  }
  var whole_from = document.getElementById("whole_from_date");
  var whole_to = document.getElementById("whole_to_date");
  wholeReport(whole_from.value, whole_to.value);
  whole_from.addEventListener("change",function(){
       wholeReport(whole_from.value, whole_to.value); 
     
  });
  whole_to.addEventListener("change", function () {
    wholeReport(whole_from.value, whole_to.value);
  });

  /* wholeReport(from , to ); */
 function treasury (){
  $.ajax({
    url :"/api/jsscripts.php",
    method : "post",
    data:{func:"treasury"},
    success : function(data){
$("#treasury_value").html(data);
    }

  });
}
treasury();
function arrears() {
  $.ajax({
    url: "/api/jsscripts.php",
    method: "post",
    data: { func: "arrears" },
    success: function (data) {
      $("#arrears_value").html(data);
    },
  });
}
arrears(); 


   
  setTimeout(function () {
    function pieChart() {
      var new_init = document.getElementById("init").innerText;
      var new_shares = document.getElementById("shares_table").innerText;
      var new_loans_given = document.getElementById("loans_given").innerText;
      var new_loans_payback = document.getElementById("loans_payback").innerText;
      var new_borrowings_given = document.getElementById("borrowings_given").innerText;
      var new_borrowing_payback = document.getElementById("borrowings_payback").innerText;
      
      var whole = new_init + new_shares + new_loans_payback + new_borrowing_payback ;

      var treasury = whole - new_loans_given - new_borrowings_given;
      

      var myChart = document.getElementById("piechart").getContext("2d");

      var chart = new Chart(myChart, {
        type: "doughnut",
        data: {
          labels: [
            "دفعات الأولية",
            "متأخرات القروض ",
            " متأخرات السلفات ",
            "المسدد من السلفات",
            "سدادات القروض",
            "الدفعات  الشهرية",
          ],
          datasets: [
            {
              label: "",
              data: [
                new_init,
                new_loans_given,
                new_borrowings_given,
                new_borrowing_payback,
                new_loans_payback,
                new_shares,
              ],
            },
          ],
        },
        options: {
          plugins: {
            legend: {
              display: true,
              position: "right",
              rtl: true,
              labels: {
                font: {
                  size: 15,
                  weight: 700,
                  color: "#fff",
                },
              },
            },
          },
        },
      });
    }
    pieChart();

  }, 3000);
   
});


