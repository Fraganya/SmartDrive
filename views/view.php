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
          <a href="index.php?res=log" style="color:white">
           <span class="fa fa-list-alt"></span>
           Log
          </a>
        </li>
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
    <p>
      <b>You are here :
        <b>
    </p>
    <ul class="breadcrumb">
      <li>
        <a href="<?php echo $host;?>">SmartDrive</a>
      </li>
      <?php $linkCount=0; ?>
      <?php foreach($dirs as $dir):?>
      <?php if(strtolower($dir)!='storage'):?>
      <?php if($linkCount==count($dirs)-1 || (count($dirs)==1)):?>
      <li>
        <?php echo $dir;?>
      </li>
      <?php else: ?>
      <li>
        <a href="<?php echo $host;?>index.php?res=view&path=<?php echo Storage::resolve($path,$dir);?>">
          <?php echo $dir;?>
        </a>
      </li>
      <?php endif;?>
      <?php endif;?>
      <?php $linkCount++; ?>
      <?php endforeach;?>
    </ul>
    <br>
    <?php if(count($contents)==0) : ?>

    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title">(Empty Dir)</h3>
      </div>
      <div class="panel-body">
        Directory has no content!
      </div>
    </div>


    <?php else: ?>

    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title">
          Dir =>
          <?php echo $dirDisp; ?>
          <span class="pull-right">(
            <?php echo $dirSize;?> MB)</span>
        </h3>
      </div>

      <ul class="list-group">
        <?php foreach($contents as $item):?>
        <li class="list-group-item">
          <?php if($item['type']=='dir'): ?>
          <span class="fa fa-folder-o"></span>&nbsp;
          <?php else :?>
          <span class="<?php echo $item['icon'];?>"></span>&nbsp;
          <?php endif; ?>
          <?php echo $item['name'] ?>

          <div class="pull-right">
            <span>
              (
              <?php echo $item['size'] ?> MB)
            </span>
            &nbsp;
            <?php if($item['type']=='dir'): ?>
            <a href="<?php echo $host;?>index.php?res=view&path=<?php echo $path.'/'.$item['name'];?>" class="btn-link" title="Open">
              <i class="fa fa-external-link"></i>&nbsp;Open
            </a>
            &nbsp;&nbsp;
            <?php endif; ?>
            <a href="<?php echo $host;?>index.php?res=download&path=<?php echo $path.'/'.$item['name'];?>" class="btn-link" title="Download"
              target="__blank">
              <i class="fa fa-cloud-download"></i>&nbsp;Download
            </a>

          </div>
        </li>
        <!-- ./storage item -->
        <?php endforeach;?>
      </ul>
      <!--- ./item list  -->
    </div>
    <?php endif; ?>



    <hr>
    <p style="display:inline-block">Computing Information Technology-3&copy;2018 </p>
    <p style="display:inline-block" class="pull-right">~ A labour of love</p>

  </div>
  <script src="assets/js/jquery-2.1.3.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>