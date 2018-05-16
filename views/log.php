<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/font-awesome.min.css">

</head>

<body>
  <nav class="navbar navbar-inverse" style="border-radius:0px">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="<?php echo $host;?>" style="color:white">
          <i class="fa fa-hdd-o"></i>
          <b>SmartDrive</b>
        </a>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="#">
            <span class="fa fa-users" style="color:white">
              <b>CIT 3</b> PROTOTYPE</span>
          </a>
        </li>
      </ul>
    </div>
  </nav>

    <div class="container">
        
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Resource <i class="fa fa-circle-o-notch" aria-hidden="true"></i></th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($logs as $log): ?>
                    <tr>
                        <td>
                            <?php 
                                $bits=explode('/',$log->name);
                                echo $bits[count($bits)-1];
                             ?>
                        </td>
                        <td>
                            <?php echo $log->downloads; ?>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        
    </div>



  </div>
  <script src="assets/js/jquery-2.1.3.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>