<?
/**
	Implements a basic functions for working with images
**/
class Image 
{
	protected $rImage; // image resource to work with
	
	/**
		Class constructor. Creates image resource and sets image size.
		@param (int) $iSizeX - set image size X. Default value is 1.
		@param (int) $iSizeY - set image size Y. Default value is 1.
	**/
	public function __construct($iSizeX = 1, $iSizeY = 1) 
	{
		$this->rImage = imagecreatetruecolor($iSizeX, $iSizeY);
	}

	/**
		Loads image into inner buffer to work with. If image cannot be loaded, 'false' is returned.
		@param (string) $_inFile - image file name with path
	**/
	public function load($_inFile) 
	{
		if ((list($src_w, $src_h, $src_type, $src_attr) = @getimagesize($_inFile)) === false)
		{
			return false;
		}
		
		imagedestroy($this->rImage);
		
		switch ($src_type) 
		{
			case "1":  // GIF
				$this->rImage = imagecreatefromgif($_inFile);
				break;
				
			case "2":  // JPG
				$this->rImage = imagecreatefromjpeg($_inFile);
				break;
				
			case "3":  // PNG
				$this->rImage = imagecreatefrompng($_inFile);
				break;
				
			case "15": // WBMP
				$this->rImage = imagecreatefromwbmp($_inFile);
				break;
				
			case "16": // XBM
				$this->rImage = imagecreatefromxbm($_inFile);
				break;
				
			case "4":  // SWF
			case "5":  // PSD
			case "6":  // BMP
			case "7":  // TIFF(intel byte order)
			case "8":  // TIFF(motorola byte order)
			case "9":  // JPC
			case "10": // JP2
			case "11": // JPX
			case "12": // JB2
			case "13": // SWC
			case "14": // IFF
				return false;
				break;
    	}
		
		return true;
	}
	
	/**
		Returns image resource
		@return (resource) - image resource
	**/
	public function getImage() 
	{
		return $this->rImage;
	}
	
	/**
		Sets image resource.
		@param (resource) $rImage - image resource
	**/
	public function setImage($rImage) 
	{
		imagedestroy($this->rImage);
		$this->rImage = $rImage;
	}
	
	/**
		Returns size X of image
		@return (int) - size X of image
	**/
	public function getSizeX()
	{
		return imagesx($this->getImage());
	}
	
	/**
		Sets size X of image. Image will be resized to $iNewSizeX by width
		@param (int) $iNewSizeX - new size X
	**/
	public function setSizeX($iNewSizeX) 
	{
		$this->resize($iNewSizeX, imagesy($this->getImage()));
	}
	
	/**
		Returns size Y of image
		@return (int) - size Y of image
	**/
	public function getSizeY() 
	{
		return imagesy($this->getImage());
	}
	
	/**
		Sets size Y of image. Image will be resized to $iNewSizeX by height
		@param (int) $iNewSizeY - new size Y
	**/
	public function setSizeY($iNewSizeY) 
	{
		$this->resize(imagesx($this->getImage()), $iNewSizeY);
	}
	
	/**
		Performs an image resizing constrain proportions. If new sizes do not correspond to image actial sizes, 
		image is filled with given background color. 
		Result image can be smaller then specified area according to proportions.
		@param (int) $iNewSizeX - new size X
		@param (int) $iNewSizeY - new size Y
		@param (string) $sHexBkgColor - hexadecimal string of RGB-color representation for background color
	**/
	public function resize($iNewSizeX = 0, $iNewSizeY = 0, $sHexBkgColor = "FFFFFF") 
	{
		$rImage = $this->getImage();
		$iSourceX = $this->getSizeX();
		$iSourceY = $this->getSizeY();
        
		$iW = $iNewSizeX;
		$iH = $iNewSizeY;
        
		//$iNewSizeX = min($iNewSizeX, $iSourceX); - reduce only
		//$iNewSizeY = min($iNewSizeY, $iSourceY);
        
		$fAspectX = $iNewSizeX / $iSourceX;
		$fAspectY = $iNewSizeY / $iSourceY;
		
		if (!$iH) 
		{
			$fAspect = $fAspectX;
			$iSourceY = imagesy($rImage);
			$iNewSizeY = $iSourceY * $fAspect;
		} 
		else {
			$fAspect = min($fAspectX, $fAspectY);
			$iNewSizeX = $iSourceX * $fAspect;
		}
		$iDestX = $iSourceX * $fAspect;
		$iDestY = $iSourceY * $fAspect;
		
		$rImage = imagecreatetruecolor($iNewSizeX, $iNewSizeY);
		$aColor = $this->getAColor($sHexBkgColor);
		imagefill($rImage, 1, 1, imagecolorallocate($rImage, $aColor[0], $aColor[1], $aColor[2]));
		imagecopyresampled($rImage, $this->getImage(), ($iNewSizeX - $iDestX) / 2, ($iNewSizeY - $iDestY) / 2, 0, 0, $iDestX, $iDestY, $iSourceX, $iSourceY);
		// imagecopyresized($rImage, $this->getImage(), ($iNewSizeX - $iDestX) / 2, ($iNewSizeY - $iDestY) / 2, 0, 0, $iDestX, $iDestY, $iSourceX, $iSourceY);
		$this->setImage($rImage);
	}
	
	/**
	 * Resize image as a thumb (result image fills whole given area)
	 *
	 * @param int $iNewSizeX
	 * @param int $iNewSizeY
	 */
	public function thumb($iNewSizeX, $iNewSizeY) 
	{
		$iSourceX = $this->getSizeX();
		$iSourceY = $this->getSizeY();
        
		$fAspectX = $iNewSizeX / $iSourceX;
		$fAspectY = $iNewSizeY / $iSourceY;
		
		$fAspect = max($fAspectX, $fAspectY);
		
		$iDestX = $iSourceX * $fAspect;
		$iDestY = $iSourceY * $fAspect;
		
		$rImage = imagecreatetruecolor($iNewSizeX, $iNewSizeY);
		imagecopyresampled($rImage, $this->getImage(), ($iNewSizeX - $iDestX) / 2, ($iNewSizeY - $iDestY) / 2, 0, 0, $iDestX, $iDestY, $iSourceX, $iSourceY);
		$this->setImage($rImage);
	}
	
	public function crop($x, $y, $sizeX, $sizeY) {
		$rImage = imagecreatetruecolor($sizeX, $sizeY);
		imagecopy($rImage, $this->getImage(), 0, 0, $x, $y, $sizeX, $sizeY);
		$this->setImage($rImage);
	}
	
	/** 
		Divides hexadecimal string of RGB-color representation into a RGB-color array accordingly. 
		If $i parameter is passed, returns only appropriate color component (R,G or B)
		@param (string) $sHexColor - hexadecimal string of RGB-color representation. 
		@param (int) $i - index of RGB-color array. Can take values from 0 to 2 or false.
		@return (int/array) - color component (R,G or B) if $i is passed or RGB-array if $i is ommited
	**/
	public function getAColor($sHexColor, $i = false)
	{
		$_return = array(hexdec(substr($sHexColor, 0, 2)), hexdec(substr($sHexColor, 2, 2)), hexdec(substr($sHexColor, 4, 2)));
		if ($i !== false) 
			$_return = $_return[$i];
		return $_return;
	}
	
	/** 
		Allocates and returns integer color representation for hexadecimal string of RGB-color representation
		@param (string) $sHexColor - hexadecimal string of RGB-color representation
		@return (int) - integer color representation
	**/
	public function getColor($sHexColor) 
	{
		$aColor = $this->getAColor($sHexColor);
		return imagecolorallocate($this->rImage, $aColor[0], $aColor[1], $aColor[2]);
	}
	
	/**
		Outputs image as GIF. If $sOutFile is passed, image is saved as GIF file else performs raw output of GIF image to browser
		@param (string) $sOutFile - file name for GIF image. If ommited, performs raw output to browser
		@param (resource) $rImage - image resource to create GIF from. By default it is inner image.
	**/
	public function outputGif($sOutFile = false, $rImage = false) 
	{
		if (!$rImage) {
			$rImage = $this->getImage();
		}
		if ($sOutFile === false) 
		{
			header("Content-type: image/gif");
			imagegif($rImage);
		} 
		else 
			imagegif($rImage, $sOutFile);
		
	}
	
	public function outputJpg($sOutFile = false, $rImage = false) 
	{
		if (!$rImage) {
			$rImage = $this->getImage();
		}
		if ($sOutFile === false) 
		{
			header("Content-type: image/jpeg");
			imagejpeg($rImage);
		} 
		else 
			imagejpeg($rImage, $sOutFile, 90);
	}
	
	public function outputPng($sOutFile = false, $rImage = false) 
	{
		if (!$rImage) {
			$rImage = $this->getImage();
		}
		if ($sOutFile === false) 
		{
			header("Content-type: image/png");
			imagepng($rImage);
		} 
		else 
			imagepng($rImage, $sOutFile);
	}
	
	/**
		Draws a line of given thickness.
		@param (int) $iX1 - X1 coordinate of line
		@param (int) $iY1 - Y1 coordinate of line
		@param (int) $iX2 - X2 coordinate of line
		@param (int) $iY2 - Y2 coordinate of line
		@param (string) $sHexColor - hexadecimal string of RGB-color representation
		@param (int) $iThick - thickness of line in pixels
	**/
	public function linethick($iX1, $iY1, $iX2, $iY2, $sHexColor, $iThick = 1) 
	{
		$rImage = $this->getImage();
		$iColor = $this->getColor($sHexColor);
		
	    /* this way it works well only for orthogonal lines
	    imagesetthickness($rImage, $iThick);
	    return imageline($rImage, $iX1, $iY1, $iX2, $iY2, $iColor);
	    */
	    if ($iThick == 1) 
	        return imageline($rImage, $iX1, $iY1, $iX2, $iY2, $iColor);
		
	    $t = $iThick / 2 - 0.5;
	    if ($iX1 == $iX2 || $iY1 == $iY2) 
	        return imagefilledrectangle($rImage, round(min($iX1, $iX2) - $t), round(min($iY1, $iY2) - $t), round(max($iX1, $iX2) + $t), round(max($iY1, $iY2) + $t), $iColor);
		
	    $k = ($iY2 - $iY1) / ($iX2 - $iX1); //y = kx + q
	    $a = $t / sqrt(1 + pow($k, 2));
	    $aPoints = array(
	        round($iX1 - (1+$k)*$a), round($iY1 + (1 - $k) * $a),
	        round($iX1 - (1-$k)*$a), round($iY1 - (1 + $k) * $a),
	        round($iX2 + (1+$k)*$a), round($iY2 - (1 - $k) * $a),
	        round($iX2 + (1-$k)*$a), round($iY2 + (1 + $k) * $a),
	    );    
	    imagefilledpolygon($rImage, $aPoints, 4, $iColor);
	    imagepolygon($rImage, $aPoints, 4, $iColor);
	}
	
	/**
		Draws a rectangle. $xHexColor is a color parameter to fill a rectangle. If a string is passed, 
		this parameter is considered as hexadecimal string of RGB-color representation. If an array is passed, 
		then this parameter must contain two elements setting a begin color of gradient and end color of gradient.
		By now only vertical gradient is implemented.
		@param (int) $iX1 - X1 coordinate of rectangle
		@param (int) $iY1 - Y1 coordinate of rectangle
		@param (int) $iX2 - X2 coordinate of rectangle
		@param (int) $iY2 - Y2 coordinate of rectangle
		@param (string/array) $xHexColor - hexadecimal string of RGB-color or an array with gradient colors to fill a rectangle. 
	**/
	public function filledRectangle($iX1, $iY1, $iX2, $iY2, $xHexColor) 
	{
		if (is_array($xHexColor)) 
		{
			// gradient passed
			$aGradient = $xHexColor;
			$aColor1 = $this->getAColor($aGradient[0]);
			$aColor2 = $this->getAColor($aGradient[1]);
			
			// gradient type - vertical
			$aOffsetColor = array($aColor2[0] - $aColor1[0], $aColor2[1] - $aColor1[1], $aColor2[2] - $aColor1[2]);
			for ($iY = $iY1; $iY <= $iY2; $iY++) 
			{
				$offset = ($iY - $iY1) / ($iY2 - $iY1);
				$iColor = imagecolorallocate($this->getImage(), 
					round($aColor1[0] + $aOffsetColor[0] * $offset), 
					round($aColor1[1] + $aOffsetColor[1] * $offset),
					round($aColor1[2] + $aOffsetColor[2] * $offset)
				);
				imageline($this->getImage(), $iX1, $iY, $iX2, $iY, $iColor);
			}
		} 
		else 
			imagefilledrectangle($this->getImage(), $iX1, $iY1, $iX2, $iY2, $this->getColor($xHexColor));
	}
}
