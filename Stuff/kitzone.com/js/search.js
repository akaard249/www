
 var div  = document.getElementById('result');
 	div.style.display = 'none';
$(document).ready(function(){
	load_data();
	function load_data(query)
	{
		$.ajax({
			url:"fetch.php",
			method:"post",
			data:{query:query},
			success:function(data)
			{
				$('#result').html(data);
			}
		});
	}
	
	$('#search_text').keyup(function(){
			div.style.display = 'block';
		var search = $(this).val();
		if(search != '')
		{
			load_data(search);
		}
		else
		{
			div.style.display = 'none';
			load_data();			
		}
	});
});
