<?
class MediaPath {
	
	private $basePath = PATH_FILES_UPLOAD;
	
	function setBasePath($path) {
		$this->basePath = $path;
	}

    function getSizeInfo($size) {
    	$_ret = array();
    	if ($size && strpos($size, 'x') !== false) {
    		
    		$_ret = array('w' => null, 'h' => null);

    		$size = str_replace('thumb', '', $size);
    		$aSize = explode('x', $size);
    		if (isset($aSize[0]) && $aSize[0]) {
    			$_ret['w'] = $aSize[0];
    		}
    		if (isset($aSize[1]) && $aSize[1]) {
    			$_ret['h'] = $aSize[1];
    		}
    	}
    	return $_ret;
    }

    function getFileInfo($filename) {
		$aFName = explode('.', $filename);
		$_ret = array('fname' => $aFName[0], 'orig_fname' => $aFName[0], 'orig_ext' => $aFName[1]);
		if (isset($aFName[2]) && $aFName[2]) {
			$_ret['ext'] = $aFName[2];
		} else {
			$_ret['ext'] = $aFName[1];
		}
		return $_ret;
    }

    /**
     * Return real media-file path with name
     *
     * @param str $type - object type
     * @param int $id - media ID
     * @param str $size - size of image: noresize, "<width>x", "<width>x<height>"
     * @param str $filename - file name with extension. Used to speed up image output
     * @return str
     */
    function getFileName($type, $id, $size, $filename) {
    	$aFName = $this->getFileInfo($filename);
    	$prefix = '';
    	if (strpos($size, 'thumb') !== false) {
    		$prefix = 'thumb';
    	}
    	$aSize = $this->getSizeInfo($size);
    	$_ret = $this->getPath($type, $id);
    	if ($aSize) {
    		$_ret.= $prefix.$aSize['w'].'x'.$aSize['h'].'.'.$aFName['ext'];
    	} else {
    		$_ret.= $filename; // clean image file for no resizing
    	}
    	return $_ret;
    }

    /**
     * Return real path for media-file
     *
     * @param str $type - object type
     * @param int $id - media ID
     * @return str
     */
    function getPath($type, $id) {
		return $this->getPagePath($type, $id).$id.'/';
    }

    function getPagePath($type, $id) {
    	$page = floor($id/100);
		$path = $this->getTypePath($type).$page.'/';
		return $path;
    }
    
    function getTypePath($type) {
        return $this->basePath.strtolower($type).'/';
    }

    /**
     * Return URL for image
     *
     * @param str $type - object type
     * @param int $id - media ID
     * @param str $size - size of image: noresize, "<width>x", "<width>x<height>"
     * @param str
     */
    function getImageUrl($type, $id, $size, $filename) {
    	if (!$size) {
    		$size = 'noresize';
    	}
		return Configure::read('baseURL.media').'/media/router/index/'.strtolower($type).'/'.$id.'/'.$size.'/'.$filename;
    }

    /**
     * Return raw URL for file. Can be used for download binary file
     *
     * @param str $type - object type
     * @param int $id - media ID
     * @param str $filename - file name with extension. Used to speed up image output
     * @return str
     */
    function getRawUrl($type, $id, $filename) {
    	$page = floor($id/100);
    	return Configure::read('baseURL.media').'/files/'.strtolower($type).'/'.$page.'/'.$id.'/'.rawurlencode($filename);
    }

    function getResizeMethod($size) {
    	return (strpos($size, 'thumb') !== false) ? 'thumb' : 'resize';
    }
    
	/**
	* Format to human file size
	* @param $bytes
	* @param int $decimals
	* @return string format to human file size
	*/
	public function filesizeFormat($bytes, $decimals = 2) {
		$sz = array(' bytes', ' Kb', ' Mb', ' Gb', ' Tb', ' Pb');
		$factor = floor((strlen($bytes) - 1) / 3);
		return str_replace('.', ',', sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor]);
	}
		
}
