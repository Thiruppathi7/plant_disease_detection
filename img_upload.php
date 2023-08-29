<?php
include './db.php';
$name = "sample/".$_POST['image_name'].".jpg";
$pth = $_POST['image_path'];

$b = file_put_contents($name, base64_decode($pth));

if($b) {
    $fp = fopen($name, "r");
    $c = fread($fp, filesize($name));
    fclose($fp);
    $s = "no~No Match Found";
    
    $result = mysqli_query($link, "select id,fname,cname,cropname,dname,descr,solution from uploads");
    while($row = mysqli_fetch_row($result)) {
        $fp = fopen($row[1], "r");
        $d = fread($fp, filesize($row[1]));
        fclose($fp);
        
        if(strlen($c)==strlen($d)) {
            if(steg_compare($c, $d, 1)==0) {
                $s = "ok~$row[2]~$row[3]~$row[4]~$row[5]~$row[6]"; 
                break;
            }
        }
    }
    mysqli_free_result($result);
    //if(strcasecmp(substr($s, 0,2), "ok")==0) {}
    echo $s;
} else {
    echo "no~File Not Uploaded...!";    
}


function is_even($num)
{
	// returns true if $num is even, false if not
	return ($num%2==0);
}

function asc2bin($char)
{
	// returns 8bit binary value from ASCII char
	// eg; asc2bin("a") returns 01100001
	return str_pad(decbin(ord($char)), 8, "0", STR_PAD_LEFT);
}

function bin2asc($bin)
{
	// returns ASCII char from 8bit binary value
	// eg; bin2asc("01100001") returns a
	// argument MUST be sent as string
	return chr(bindec($bin));
}

function rgb2bin($rgb)
{
	// returns binary from rgb value (according to evenness)
	// this way, we can store one ascii char in 2.6 pixels
	// not a great ratio, but it works (albeit slowly)

	$binstream = "";
	$red = ($rgb >> 16) & 0xFF;
	$green = ($rgb >> 8) & 0xFF;
	$blue = $rgb & 0xFF;

	if(is_even($red))
	{
		$binstream .= "1";
	} else {
		$binstream .= "0";
	}
	if(is_even($green))
	{
		$binstream .= "1";
	} else {
		$binstream .= "0";
	}
	if(is_even($blue))
	{
		$binstream .= "1";
	} else {
		$binstream .= "0";
	}

	return $binstream;
}

function steg_compare($maskfile, $hidefile,$cnttype)
{
	//echo "<br>Maskfile value is:".$maskfile;
	//echo "<br>Hidden file value is:".$hidefile;
	//echo "<br>Content type is:".$cnttype;
	// hides $hidefile in $maskfile
	// initialise some vars
	
	global $temp_file_path,$temp_file_name;
	global $f,$f1;
	
		
	
	
	$binstream = "";
	$recordstream = "";
	$make_odd = Array();

	// ensure a readable mask file has been sent
	//$extension = strtolower(substr($maskfile['name'],-3));
	
	$extension = strtolower(substr($temp_file_name,-3));
	
	if($extension=="jpeg")
	{
		$createFunc = "ImageCreateFromJPEG";
                
                // create images
	//$pic = @ImageCreateFromJPEG($maskfile['tmp_name']);
	$pic = @ImageCreateFromJPEG($temp_file_path);
	
	//$attributes = @getImageSize($maskfile['tmp_name']);
	$attributes = @getImageSize($temp_file_path);
	
	//$outpic = @ImageCreateFromJPEG($maskfile['tmp_name']);
	$outpic = @ImageCreateFromJPEG($temp_file_path);
	
	//$fname=$_FILES['maskfile']['name'];
	$fname=$temp_file_name;
	
	
	if(!$pic || !$outpic || !$attributes)
	{
		// image creation failed
		return "cannot create images - maybe GDlib not installed?";
	}

	// read file to be hidden
	if($cnttype=="text")
	{
		$data=file_get_contents($hidefile);
		$stpos=strrpos($hidefile,'/');
		$fname=substr($hidefile,$stpos+1);
		//echo $fname;
	}
	else
	{
		//$data = file_get_contents($hidefile['tmp_name']);
		//$fname=$hidefile['name'];
	}
	//echo "Filename is:".$fname;
	// generate unique boundary that does not occur in $data
	// 1 in 16581375 chance of a file containing all possible 3 ASCII char sequences
	// 1 in every ~1.65 billion files will not be steganographisable by this script
	// though my maths might be wrong.
	// if you really want to get silly, add another 3 random chars. (1 in 274941996890625)
	// ^^^^^^^^^^^^ would require appropriate modification to decoder.
	do
	{
		$boundary = chr(rand(0,255)).chr(rand(0,255)).chr(rand(0,255));
	} while(strpos($data,$boundary)!==false && strpos($fname,$boundary)!==false);

	// add boundary to data
	$data = $boundary.$fname.$boundary.$data.$boundary;
	// you could add all sorts of other info here (eg IP of encoder, date/time encoded, etc, etc)
	// decoder reads first boundary, then carries on reading until boundary encountered again
	// saves that as filename, and carries on again until final boundary reached

	// check that $data will fit in maskfile
	if(strlen($data)*8 > ($attributes[0]*$attributes[1])*3)
	{
		// remove images
		ImageDestroy($outpic);
		ImageDestroy($pic);
		return "Cannot fit ".$fname." in ".$maskfile['name'].".<br />".$fname." requires mask to contain at least ".(intval((strlen($data)*8)/3)+1)." pixels.<br />Maximum filesize that ".$maskfile['name']." can hide is ".intval((($attributes[0]*$attributes[1])*3)/8)." bytes";
	}

	// convert $data into array of true/false
	// pixels in mask are made odd if true, even if false
	for($i=0; $i<strlen($data) ; $i++)
	{
		// get 8bit binary representation of each char
		$char = $data{$i};
		$binary = asc2bin($char);

		// save binary to string
		$binstream .= $binary;

		// create array of true/false for each bit. confusingly, 0=true, 1=false
		for($j=0 ; $j<strlen($binary) ; $j++)
		{
			$binpart = $binary{$j};
			if($binpart=="0")
			{
				$make_odd[] = true;
			} else {
				$make_odd[] = false;
			}
		}
	}

	// now loop through each pixel and modify colour values according to $make_odd array
	$y=0;
	for($i=0,$x=0; $i<sizeof($make_odd) ; $i+=3,$x++)
	{
		// read RGB of pixel
		$rgb = ImageColorAt($pic, $x,$y);
		$cols = Array();
		$cols[] = ($rgb >> 16) & 0xFF;
		$cols[] = ($rgb >> 8) & 0xFF;
		$cols[] = $rgb & 0xFF;

		for($j=0 ; $j<sizeof($cols) ; $j++)
		{
			if($make_odd[$i+$j]===true && is_even($cols[$j]))
			{
				// is even, should be odd
				$cols[$j]++;
			} else if($make_odd[$i+$j]===false && !is_even($cols[$j])){
				// is odd, should be even
				$cols[$j]--;
			} // else colour is fine as is
		}

		// modify pixel
		$temp_col = ImageColorAllocate($outpic,$cols[0],$cols[1],$cols[2]);
		ImageSetPixel($outpic,$x,$y,$temp_col);

		// if at end of X, move down and start at x=0
		if($x==($attributes[0]-1))
		{
			$y++;
			// $x++ on next loop converts x to 0
			$x=-1;
		}
	}

	// output modified image as PNG (or other *LOSSLESS* format)
	//header("Content-type: image/png");
	//header("Content-Disposition: attachment; filename=encoded.png");
	
	$extpos=strpos($fname,'.');
	$f=substr($fname,0,$extpos);
	$f1="c:/wamp/www/PHPAndr_CropDisease/".$f.".jpg";
	/*
	}
	else if($extension=="png")
	{
		$createFunc = "ImageCreateFromPNG";
	} else if($extension=="gif")
	{
		$createFunc = "ImageCreateFromGIF";
	*/
	} else {
            if(strcmp($maskfile, $hidefile)==0) {
                return 0;
                               
            } else {
                return 1;
            }
		//return "Only .jpg mask files are supported";
	}

	
	

	// remove images
	//ImageDestroy($outpic);
	//ImageDestroy($pic);
	//exit();	
}



function steg_recover($maskfile)
{
	// recovers file hidden in a PNG image

	$binstream = "";
	$filename = "";

	// get image and width/height
	$attributes = @getImageSize($maskfile['tmp_name']);
	$pic = @ImageCreateFromPNG($maskfile['tmp_name']);

	if(!$pic || !$attributes)
	{
		return "could not read image";
	}

	// get boundary
	$bin_boundary = "";
	for($x=0 ; $x<8 ; $x++)
	{
		$bin_boundary .= rgb2bin(ImageColorAt($pic, $x,0));
	}

	// convert boundary to ascii
	for($i=0 ; $i<strlen($bin_boundary) ; $i+=8)
	{
		$binchunk = substr($bin_boundary,$i,8);
		$boundary .= bin2asc($binchunk);
	}


	// now convert RGB of each pixel into binary, stopping when we see $boundary again

	// do not process first boundary
	$start_x = 8;

	for($y=0 ; $y<$attributes[1] ; $y++)
	{
		for($x=$start_x ; $x<$attributes[0] ; $x++)
		{
			// generate binary
			$binstream .= rgb2bin(ImageColorAt($pic, $x,$y));

			// convert to ascii
			if(strlen($binstream)>=8)
			{
				$binchar = substr($binstream,0,8);
				$ascii .= bin2asc($binchar);
				$binstream = substr($binstream,8);
			}

			// test for boundary
			if(strpos($ascii,$boundary)!==false)
			{
				// remove boundary
				$ascii = substr($ascii,0,strlen($ascii)-3);

				if(empty($filename))
				{
					$filename = $ascii;
					$ascii = "";
				} else {
					// final boundary; exit both 'for' loops
					break 2;
				}
			}
		}
		// on second line of pixels or greater; we can start at x=0 now
		$start_x = 0;
	}

	// remove image from memory
	ImageDestroy($pic);

	// and output result (retaining original filename)
	header("Content-type: text/plain");
	header("Content-Disposition: attachment; filename=".$filename);
	if(isset($_POST['submit']))
	echo $ascii;
	exit();
}
?>