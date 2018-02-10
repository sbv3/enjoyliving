<?php

function CroppedThumbnail($imgSrc,$thumbnail_width,$thumbnail_height) { //$imgSrc is a FILE - Returns an image resource.
	//getting the image dimensions 
    list($width_orig, $height_orig) = getimagesize($imgSrc);  
    $myImage = imagecreatefromjpeg($imgSrc);
    $ratio_orig = $width_orig/$height_orig;
   
    if ($thumbnail_width/$thumbnail_height > $ratio_orig) {
       $new_height = $thumbnail_width/$ratio_orig;
       $new_width = $thumbnail_width;
    } else {
       $new_width = $thumbnail_height*$ratio_orig;
       $new_height = $thumbnail_height;
    }
   
    $x_mid = $new_width/2;  //horizontal middle
    $y_mid = $new_height/2; //vertical middle
   
    $process = imagecreatetruecolor(round($new_width), round($new_height));
   
    imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
    $thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
    imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($thumbnail_width/2)), ($y_mid-($thumbnail_height/2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);

    imagedestroy($process);
    imagedestroy($myImage);
    return $thumb;
}

?>



<?
require_once($_SERVER['DOCUMENT_ROOT']."Connections/usrdb_enjftfxb2_12_1.php");
$article_id_query = mysql_query("select googleurl, img from cms where Artikeltyp='Std-Artikel' and img!=''") or die ("article_id_query: ".mysql_error());
?>
<table>
	<?php 
	while ($article_id_result=mysql_fetch_assoc($article_id_query))
	{
		$Filename = $article_id_result["img"];
		$info = getimagesize ($_SERVER['DOCUMENT_ROOT'].$Filename );
		?>
		<tr>
			<td><?php echo $article_id_result["googleurl"];?></td>		
			<td><?php echo $Filename;?></td>
			<td><?php echo 'Bildbreite: ' . $info[0];?></td>
			<td><?php echo 'Bildhöhe: ' . $info[1];?></td>				
               <td><img src="<?php echo $Filename; ?>" /></td>
		</tr>
	<?php }?>
</table>



