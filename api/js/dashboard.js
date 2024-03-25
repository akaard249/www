$(document).ready(function(){
function numberOfClients(){
	$.ajax({
		url:"/api/jsscripts.php",
		method:"post",
		data:{func:"numOfClients"},
		success:function(data){
			$("#numClients").html(data);
		}
	});
}
numberOfClients();

function numberOfShares() {
  $.ajax({
    url: "/api/jsscripts.php",
    method: "post",
    data: { func: "numbShares" },
    success: function (data) {
      $("#numShares").html(data);
    },
  });
}
numberOfShares();

function numberOfLoans() {
  $.ajax({
    url: "/api/jsscripts.php",
    method: "post",
    data: { func: "numbLoans" },
    success: function (data) {
      $("#numLoans").html(data);
    },
  });
}
numberOfLoans();

});