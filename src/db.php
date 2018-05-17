<?php
require 'vendor/autoload.php'; // include Composer's autoloader
ini_set('mbstring.substitute_character', "none");
$client = new MongoDB\Client("mongodb://localhost:27017");


class File{
    /**
    *获取某个目录下所有文件
    *@param $path文件路径
    *@param $child 是否包含对应的目录
    */
    public  function getFiles($path,$child=false){
        $files=array();        
        if(!$child){
            if(is_dir($path)){
                $dp = dir($path); 
            }else{
                return null;
            }
            while ($file = $dp ->read()){  
                if($file !="." && $file !=".." && is_file($path.$file)){  
                   $files[] = $file;
                }  
            }           
            $dp->close();
        }else{
            $this->scanfiles($files,$path);
        }              
        return $files;
    }
    /**
    *@param $files 结果
    *@param $path 路径
    *@param $childDir 子目录名称
    */
    public function scanfiles(&$files,$path,$childDir=false){
        $dp = dir($path); 
        while ($file = $dp ->read()){  
            if($file !="." && $file !=".."){ 
                if(is_file($path.$file)){//当前为文件
                     $files[]= $file;
                }else{//当前为目录  
                     $this->scanfiles($files[$file],$path.$file.DIRECTORY_SEPARATOR,$file);
                }               
            } 
        }
        $dp->close();
    }
}


$File=new File();
$info=$File->getFiles('txt/');

foreach( $info as $b){
	$fp=fopen('txt/'.$b,"r");
	$title = substr($b,0,-4);
	$chapte = 0;
	while(!(feof($fp))){
		$chapte += 1;
		$i=0;
		while($i<102 & !(feof($fp)) )
		{
			$text[$i] = substr(fgets($fp),0,-2);
			//$text[$i] = utf8_encode($text[$i]);
			$text[$i] = mb_convert_encoding($text[$i], 'UTF-8', 'UTF-8'); 
			//$text[$i] = str_replace("\"","“",$text[$i]);
			if ( $text[$i] <> ""){
				$i += 1;
			}
		}
//START
		$json = array('t' => $title ,'c' => $chapte ,'p' => $text);
		$collection = $client->test->books;
		//$result = $collection->insertOne($json);
		//echo json_encode($json);
		//echo "Inserted with Object ID '{$result->getInsertedId()}'";
	}
        $collection = $client->test->index;
        //$result = $collection->insertOne([ 'n' => $title,'c' => $chapte ] );
	$r = fclose($fp);
	echo $r;
}


?>
