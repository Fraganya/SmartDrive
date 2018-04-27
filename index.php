<?php
/**
 * @file index - router file for handling all requests 
 * @recieves the following request params - 
 * ==> res : index,view or download
 * ==> path:storage path name of resource
 */

require_once '__backend/Storage.php';
$host="http://localhost:8082/smartdrive/"; // IP and port where app is hosted

$res=(isset($_GET['res'])) ? $_GET['res'] : 'index';
$path=(isset($_GET['path'])) ? $_GET['path'] : null;


/**
 * check if the user is accessing the root of the app
 */
if($res=='index'){
    $dir='Storage';
    $dirSize=ceil(Storage::getSize($dir)/1000000);
    $dirDisp=ucfirst('root');
    $contents=Storage::getDirInfo('storage');
    return require_once 'views/index.php';
}

/* validate request */
if(!$path || !$res){
    $msg="Unknown Request Path or Resource was not defined!";
    return require_once 'views/status.php';
}

if(file_exists($path)){
    if($res=='view'){
        $dirSize=ceil(Storage::getSize($path)/1000000);
        $contents=Storage::getDirInfo($path);
        $dirs=explode('/',$path);
        $dirDisp=ucfirst($dirs[count($dirs)-1]);
        return require_once 'views/view.php';
    }
    elseif($res='download'){
        return Storage::download($path);
    }
    else{
        $msg="Unknown Request Path or Resource was not defined!";
        return require_once 'view/status.php';
    }
    
}
else{
    require_once 'views/404.php';
}

?>