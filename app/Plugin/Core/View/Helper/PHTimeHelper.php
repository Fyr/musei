<?
App::uses('AppHelper', 'View/Helper');
App::uses('TimeHelper', 'View/Helper');
// class PHTimeHelper extends AppHelper {
class PHTimeHelper extends TimeHelper {
	function niceShort($dateString = null, $userOffset = null) {
		/*
		$ret = parent::niceShort($dateString, $userOffset);
		
		$aReplaceENG = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jul', 'Jun', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
		$aReplace = array(__('Jan', true), __('Feb', true), __('Mar', true), __('Apr', true), __('May', true), __('Jul', true), __('Jun', true), __('Aug', true), __('Sep', true), __('Oct', true), __('Nov', true), __('Dec', true));
		return str_replace(array('st', 'nd', 'th'), '', str_replace($aReplaceENG, $aReplace, $ret));
		*/
		
		// по умолчанию - выводим полный формат, но без времени
		$date = strtotime($dateString);
		$day = date('j', $date);
		$month = ' '.__(date('M', $date), true);
		$year = ' '.date('Y', $date).'г.'; // (date('Y') == date('Y', $date)) 2014-09-29 20:54:38
		$time = '';
		if (date('d') == date('d', $date)) {
			$day = __('Today', true);
			$month = '';
			$year = '';
			$time = ', '.date('H:i', $date);
		} elseif ((date('d') - 1) == date('d', $date)) {
			$day = __('Yesterday', true);
			$month = '';
			$year = '';
			$time = ', '.date('H:i', $date);
		}
		return $day.$month.$year.$time;
	}
}