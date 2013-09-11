<?php
    class ICodeGraphics
    {   
        public static function PutWaterMarkText($srcContainer,$textMark,$dest,$isCenter,$x=0,$y=0)
        {
        }
        //$srcImages are in number-indexed array like this 0->'src'->path to an img     
                                                      //   0->'isCenter'->false
                                                      //   0->'x'->100
                                                      //   0->'y'->200
                                                      //   1->'src'->.....    x,y is the top left pos
        public static function PutImagesOnAnother($srcContainer,$srcImages,$dest,$alpha=false)
        {
            if(!is_array($srcImages)||empty($srcImages)|| $srcContainer=='' || $dest=='')
                return "Check PutImagesOnAnother Function arguments";
            // we will get the image type from extension. no hard work
            $ext=FileExtension($srcContainer);
            $background=Graphics::CreateImage($srcContainer);   //this will be used as background     
            if($background===-1)
                return "<br> Image extension not supported ($ext).";
            $containerWidth=ImageSX($background);
            $containerHeight=ImageSY($background);
            $container=ImageCreateTrueColor($containerWidth,$containerHeight);  
            if($container===false)
                return "<br> Image processing error on server.";
            $black=ImageColorAllocate($container,255,255,255);
            imagefill($container,0,0,$black);
            ImageCopy($container,$background,0,0,0,0,$containerWidth,$containerHeight);

            imagealphablending($container,$alpha);
            $error='';
            foreach($srcImages as $aSrcImg)
            {
                 if(!file_exists($aSrcImg['src']))
                 {
                     $error.="<br> image not found".$aSrcImg['src'];
                     continue;
                 }

                 $content=Graphics::CreateImage($aSrcImg['src']);
                 if($content===-1)
                 {
                     $error.="<br> Image extension not supported ($ext).".$aSrcImg['src'];
                     continue;
                 }
                 if(!$content)
                 {
                     $error.="<br> Image processing error on server.".$aSrcImg['src'];
                     continue;
                 }
                 //all is well
                 //x,y top of the img src to put on
                 $x=0; //where to put?
                 $y=0;
                 $contentWidth=ImageSX($content);
                 $contentHeight=ImageSY($content);
                 //calculating position of top-left
                 if(isset($aSrcImg['isCenter']) && $aSrcImg['isCenter']==true)
                 {
                     $x=Floor($containerWidth/2);
                     $y=Floor($containerHeight/2);
                 }
                 else //do with x, y
                 {                        
                     if(isset($aSrcImg['x']))
                         $x=$aSrcImg['x'];
                     if(isset($aSrcImg['y']))
                         $y=$aSrcImg['y'];
                 }
                 imagealphablending($content,$alpha);                                             
                 ImageCopy($container,$content,$x,$y,0,0,$contentWidth,$contentHeight);
                 //ImageCopyMerge($container,$content,$x,$y,0,0,$contentWidth,$contentHeight,100);
                 ImageDestroy($content);
            }
            if(Graphics::SaveImage($container,$dest,$ext))
                $error.="<br> Image Saved at $dest";
            else $error.="<br> Image was not saved";
            if($error=='')
                return true;
            return $error;


        }
        public static function CreateImage($src) //wrapper for ImageCreateFrom*
        {    
            // we will get the image type from extension. no hard work
            $ext=FileExtension($src);
            if($ext=='jpg')
                $container=ImageCreateFromJPEG($src);
            else if($ext=='png')
                $container=ImageCreateFromPNG($src);
            else if($ext=='gif')
                $container=ImageCreateFromGIF($src);
            else
                return -1;
            return $container;
        }
        public static function SaveImage($resourceId,$path,$ext)
        {
            DeleteFile($path);
                
            if($ext=='jpg')
                return ImageJPEG($resourceId,$path);
            else if($ext=='png')             
                ImagePNG($resourceId,$path);
            else if($ext=='gif')             
                ImageGIF($resourceId,$path);
            else
                return false;
            return true;
        }
        /*
        public static function ()
        {
        }
        */
    }

?>