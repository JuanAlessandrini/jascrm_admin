<?php 
namespace App\Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ImagesService extends AbstractController{

    public function createThumbnail($url_base, $saveas_path){
        $image = imagecreatefromjpeg($url_base);
        $filename = $saveas_path;

        $thumb_width = 200;
        $thumb_height = 150;

        $width = imagesx($image);
        $height = imagesy($image);

        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;

        if ( $original_aspect >= $thumb_aspect )
        {
        // If image is wider than thumbnail (in aspect ratio sense)
        $new_height = $thumb_height;
        $new_width = $width / ($height / $thumb_height);
        }
        else
        {
        // If the thumbnail is wider than the image
        $new_width = $thumb_width;
        $new_height = $height / ($width / $thumb_width);
        }

        $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

        // Resize and crop
        imagecopyresampled($thumb,
                        $image,
                        0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                        0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                        0, 0,
                        $new_width, $new_height,
                        $width, $height);
        imagejpeg($thumb, $filename, 80);
    }

    public function cropFromCoord($orientation, $src_path, $dest_path, $dest_width, $coord_x, $coord_y, $coord_w, $coord_h){
        echo "obteniendo $src_path";
        $data =file_get_contents($src_path);
        echo "2";
        $imgsrc = imagecreatefromstring($data);
        $tamano = getimagesizefromstring($data);
        $width_imagen = $tamano[0];
        $height_imagen = $tamano[1];
        
        
        
            $top = ($coord_x - ($coord_h / 5)) ;
            $left = $coord_y - ($coord_w / 5)  ;
            $width = $coord_w + (($coord_w / 5) * 2);
            $height = $coord_h + (($coord_h / 5) * 2) ;
            $ratio = ($coord_w / $coord_h);
       
            
        $ratio = ($tamano[0] / $tamano[1]);
        $dest_height = $height * $dest_width / $width;

        $dest = imagecreatetruecolor($dest_width, $dest_height);
        echo "3";
        imagecopyresized(
            $dest, 
            $imgsrc,
            0, 
            0, 
            $top,
            $left,
            $dest_width,
            $dest_height, 
            $width, 
            $height
        );
        
        echo "4";
        // $aspect = ($coord_w / $coord_h);
        // $dest_height = ($coord_h  * $aspect);
        
        
        
        // // Output and free from memory
        
        imagepng($dest, $dest_path); 
        echo "5";
        imagedestroy($dest);
        echo "6";
        imagedestroy($imgsrc);
        echo "7";
        // return $tamano;
    }
}