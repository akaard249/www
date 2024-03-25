
 var div  = document.getElementById('searchq');
 var div2  = document.getElementById('all');
 	div.style.display = 'none';
$(document).ready(function(){
	load_data();
	function load_data(query)
	{
		$.ajax({
			url:"search.php",
			method:"post",
			data:{query:query},
			success:function(data)
			{
				$('#searchq').html(data);
			}
		});
	}
	
	$('#search_key').keyup(function(){
		div2.style.display = 'none';
			div.style.display = 'block';
		var search = $(this).val();
		if(search != '')
		{
			load_data(search);
		}
		else
		{
			div.style.display = 'none';
			div2.style.display = 'block';			
		}
	});
	
	
	function sortByNewest() {
		document.div.innerHTML = "";
	div2.style.display = 'none';

	var sort = "newest";
	
	function load_data(query,sort)
	{
			$.ajax({
			url:"search.php",
			method:"post",
			data:{query:query,sort:sort},
			success:function(data)
			{
				$('#searchq').html(data);
			}
		});
	}
	
	var key = document.getElementById.value('search_k');
	
	load_data(key,"newest");
	
	
	
	
}
	
	
	
	
	
});














function sortByBest() {
 
}
function sortByMostPop() {
 
}
