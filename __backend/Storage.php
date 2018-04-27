<?php

/**
 * Define platform on which app is running for proper reading on dirs and files
 */
define('PLATFORM','win32');

$mimes=array(
    'folder'=>'fa fa-folder',
    'pdf'=>'fa fa-file-pdf-o',
    'mp4'=>'fa fa-file-video-o',
    'doc'=>'fa fa-file-video',
    'docx'=>'fa fa-file-video',
    'powerpoint'=>'fa fa-file-powerpoint-o',
    'zip'=>'fa fa-file-zip',
    'rar'=>'fa fa-file-zip',
    'default'=>'fa fa-file'
);

class Storage{

    public static function getDirInfo($dir){
        $rawContents=array_diff(scandir($dir,1),array('.','..'));
        $contents=Storage::formart($rawContents,$dir);
    
        return $contents;
        
    }


    public static function formart($contents,$dir){
        $processed=array();
        $itemNum=0;
        foreach($contents as $item){
            $path=$dir.'/'.$item;
            $processed[$itemNum]=array(
                'name'=>$item,
                'size'=>ceil(Storage::getSize($path)/1000000),
            );
            if(is_dir($path)){
               $processed[$itemNum]['type']='dir';
               $processed[$itemNum]['items']=count(array_diff(scandir($path,1),array('.','..')));
            }
            else{
                $processed[$itemNum]['type']='file';
                $processed[$itemNum]['mime']=Storage::getMime($path);
                $processed[$itemNum]['icon']=Storage::getIcon($processed[$itemNum]['mime']);
            }
           
            $itemNum++;
        }
        return $processed;
    }

    public static function getSize($path){
            
        $size = 0;
        if(is_file($path)){
            return filesize($path);
        }
        if(!is_dir($path)){return false;};
        $files = scandir($path);
        if(!$files){return false;}
        $files = array_diff($files, array('.','..'));

        foreach ($files as $file) {
            if(is_dir("$path/$file")){
                 $size += Storage::getSize("$path/$file");
            }else{
                $size += filesize("$path/$file");
            }
        }
        

       return $size;
    }

    public static function getMime($filepath){
        $mime=explode('/',mime_content_type($filepath))[1];
        return $mime;
    }

    public static function getIcon($mime){
        global $mimes;

        if(array_key_exists($mime,$mimes)){
            return $mimes[$mime];
        }

        return $mimes['default'];
    }

    public static function resolve($path,$dir){
        $bits=explode('/',$path);
        $resolved='';
        foreach($bits as $bit){
            if($bit!=$dir){
                $resolved.=$bit.'/';
            }
            if($bit==$dir){
                break;
            }
        }
        $resolved.=$dir;

        return $resolved;
    }

    public static function download($path){
        $bits=explode('/',$path);
        if(is_dir($path)){

            //compress contents into archive
            
            $destination='archives/'.$bits[count($bits)-1].'.zip';
            
    
            
            //check if archive does not already exists
            $file_ready=true;
            if(!file_exists($destination)){
                //continue with archiving
                $file=Storage::zip($path,$destination);
                if(!$file){
                    $file_ready=false;
                }
          
            }

            if($file_ready){
                @header('Content-Type:Application/zip');
                @header('Content-Disposition: attachment; filename='.$bits[count($bits)-1].'.zip');
                echo file_get_contents($destination);
                exit();
            }
            else{
                print_r('Sorry Could not archive the contents of this folder!');
            }
        }
        elseif(is_file($path)){
            $mime=Storage::getMime($path);
            @header('Content-Type:'.mime_content_type($path));
            @header('Content-Disposition: attachment; filename='.$bits[count($bits)-1]);
            echo file_get_contents($path);
            exit();
        }
    
        
    }

    public static function Zip($source, $destination)
    {
        if (!extension_loaded('zip') || !file_exists($source)) {
            return false;
        }

        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
            return false;
        }

      

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source),RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file)
        {
            
             $file = str_replace('\\', '/', $file);
            // Ignore "." and ".." folders
            if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
            continue;

            $file = realpath($file);

            //ignore the storage root directory and intermidiary folders - only get files and subfolders
             $rootCount=strlen($_SERVER['DOCUMENT_ROOT'].'/SmartDrive'. Storage::resolve('',$source));
             $name=substr($file,$rootCount);
             if(is_dir($file)){
                $zip->addEmptyDir($file);
             }
             else{
                $zip->addFromString($name,file_get_contents($file));
             }             
        
        }
        return $zip->close();
    }
}

?>