<?
class Translit {
	
	static function convert($st, $lUrlMode = false) {
		// ������� �������� "��������������" ������.
		$st = mb_convert_encoding($st, 'cp1251', 'utf8');
		$st = strtr($st, "�����������������������", "abvgdeeziyklmnoprstufhye");
		$st = strtr($st, "�����Ũ�����������������", "ABVGDEEZIYKLMNOPRSTUFHYE");
		
		// ����� - "���������������".
		$st = strtr($st, array(
			"�"=>"zh", "�"=>"c", "�"=>"ch", "�"=>"sh", "�"=>"shch", "�"=>"", "�"=>"", "�"=>"ju", "�"=>"ja",
			"�"=>"ZH", "�"=>"C", "�"=>"CH", "�"=>"SH", "�"=>"SHCH", "�"=>"", "�"=>"", "�"=>"JU", "�"=>"JA",
			"�"=>"i", "�"=>"Yi", "�"=>"ie", "�"=>"Ye"
		));
		
		if ($lUrlMode) {
			$st = strtolower(strtr($st, array(
				"'" => "", '"' => '', ' ' => '-', '.' => '-', ',' => '-', '/' => '-'
			)));
			$st = str_replace(array('----', '---', '--'), '-', $st);
		}
		
		return $st;
	}
}
