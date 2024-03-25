<?php
if (isset($_COOKIE["username"])){



}
else{

header("location:login.php");
die();
}





?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - Responsive Bootstrap Card Table</title>
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css'><link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<body class="large-screen">
  <div class="wrap">
    <div class="btn-toolbar buttons">
      <div class="btn-group">
        <button id="desktop" class="btn btn-primary">
        <i class="fa fa-desktop" aria-hidden="true"></i>
        Desktop Table
      </button>
      </div>
      <div class="btn-group">
        <button id="mobile" class="btn btn-default">
        <i class="fa fa-mobile-phone" aria-hidden="true"></i>
        Mobile Card List
      </button>
      </div>
    </div>
    <div class="table-wrapper">
      <table class="table-responsive card-list-table">
        <thead>
          <tr>
            <th>Column #1</th>
            <th>Column #2</th>
            <th>Column #3</th>
            <th>Column #4</th>
            <th>Column #5</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td data-title="Column #1">Value #1</td>
            <td data-title="Column #2">Value #2</td>
            <td data-title="Column #3">Value #3</td>
            <td data-title="Column #4">Value #4</td>
            <td data-title="Column #5">Value #5</td>
          </tr>
          <tr>
            <td data-title="Column #1">Value #1</td>
            <td data-title="Column #2">Value #2</td>
            <td data-title="Column #3">Value #3</td>
            <td data-title="Column #4">Value #4</td>
            <td data-title="Column #5">Value #5</td>
          </tr>
          <tr>
            <td data-title="Column #1">Value #1</td>
            <td data-title="Column #2">Value #2</td>
            <td data-title="Column #3">Value #3</td>
            <td data-title="Column #4">Value #4</td>
            <td data-title="Column #5">Value #5</td>
          </tr>
          <tr>
            <td data-title="Column #1">Value #1</td>
            <td data-title="Column #2">Value #2</td>
            <td data-title="Column #3">Value #3</td>
            <td data-title="Column #4">Value #4</td>
            <td data-title="Column #5">Value #5</td>
          </tr>
          <tr>
            <td data-title="Column #1">Value #1</td>
            <td data-title="Column #2">Value #2</td>
            <td data-title="Column #3">Value #3</td>
            <td data-title="Column #4">Value #4</td>
            <td data-title="Column #5">Value #5</td>
          </tr>
          <tr>
            <td data-title="Column #1">Value #1</td>
            <td data-title="Column #2">Value #2</td>
            <td data-title="Column #3">Value #3</td>
            <td data-title="Column #4">Value #4</td>
            <td data-title="Column #5">Value #5</td>
          </tr>
          <tr>
            <td data-title="Column #1">Value #1</td>
            <td data-title="Column #2">Value #2</td>
            <td data-title="Column #3">Value #3</td>
            <td data-title="Column #4">Value #4</td>
            <td data-title="Column #5">Value #5</td>
          </tr>
          <tr>
            <td data-title="Column #1">Value #1</td>
            <td data-title="Column #2">Value #2</td>
            <td data-title="Column #3">Value #3</td>
            <td data-title="Column #4">Value #4</td>
            <td data-title="Column #5">Value #5</td>
          </tr>
          <tr>
            <td data-title="Column #1">Value #1</td>
            <td data-title="Column #2">Value #2</td>
            <td data-title="Column #3">Value #3</td>
            <td data-title="Column #4">Value #4</td>
            <td data-title="Column #5">Value #5</td>
          </tr>
          <tr>
            <td data-title="Column #1">Value #1</td>
            <td data-title="Column #2">Value #2</td>
            <td data-title="Column #3">Value #3</td>
            <td data-title="Column #4">Value #4</td>
            <td data-title="Column #5">Value #5</td>
          </tr>
          <tr>
            <td data-title="Column #1">Value #1</td>
            <td data-title="Column #2">Value #2</td>
            <td data-title="Column #3">Value #3</td>
            <td data-title="Column #4">Value #4</td>
            <td data-title="Column #5">Value #5</td>
          </tr>
          <tr>
            <td data-title="Column #1">Value #1</td>
            <td data-title="Column #2">Value #2</td>
            <td data-title="Column #3">Value #3</td>
            <td data-title="Column #4">Value #4</td>
            <td data-title="Column #5">Value #5</td>
          </tr>
          <tr>
            <td data-title="Column #1">Value #1</td>
            <td data-title="Column #2">Value #2</td>
            <td data-title="Column #3">Value #3</td>
            <td data-title="Column #4">Value #4</td>
            <td data-title="Column #5">Value #5</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</body>
<!-- partial -->
  <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
<script src='https://cdn.jsdelivr.net/jquery.floatthead/1.4.2/jquery.floatThead.min.js'></script><script  src="./script.js"></script>

</body>
</html>
