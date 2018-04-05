<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Customers</h2>
  <table class="table">
    <thead>
      <tr>
        <th>Fullname</th>
        <th>password</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
        <?php
            include('dbconnection.php');
            
        $query = "SELECT * FROM users";
        
        $run = mysqli_query($connection, $query);
        
        while($result = mysqli_fetch_assoc($run)){
            
        ?> <!--close php here to input data from while loop lower down-->
            
      <tr>
        <td><?php echo $result['full_name'] ?></td>
        <td><?php echo $result['password'] ?></td>
        <td><?php echo $result['email'] ?></td>
      </tr>
        <?php } ?> <!-- end of php while loop -->
    
    </tbody>
  </table>
</div>

</body>
</html>