<?php
//fetch.php
include('conn.php');
if(isset($_COOKIE["language"]) && $_COOKIE["language"]=="arabic"){
	
	include('ar.php');
}
elseif((isset($_COOKIE["language"]) && $_COOKIE["language"]=="English")){
	include('en.php');
}


$output = '';
if(isset($_POST["query"]))
{
 $search = mysqli_real_escape_string($con, $_POST["query"]);
 $query = "
  SELECT * FROM products 
  WHERE p_company LIKE '%".$search."%'
  OR p_name LIKE '%".$search."%' 
  OR p_type LIKE '%".$search."%' 
 
 ";
}
else
{
 $query = "
  SELECT * FROM products ORDER BY p_name
 ";
}
$result = mysqli_query($con, $query);
if(mysqli_num_rows($result) > 0)
{
echo  "

   <table class='table table bordered' width='100%'>
    <tr>
     <th>".$lang["product-name"]."</th>
     <th>".$lang["product-brand"]."</th>
     <th>".$lang["type"]."</th>
    
    </tr>
 ";
 while($row = mysqli_fetch_array($result))
 {
echo "
   <tr>
    <td><a   color = 'black' href='product-detail.php?P_id=$row[P_id]'> $row[P_name] </a></td>
	
    <td>$row[P_company]</td>
	
    <td>$row[P_type]</td>
   
   </tr>
  ";
 }

}
else
{
 echo 'Data Not Found';
}

?>