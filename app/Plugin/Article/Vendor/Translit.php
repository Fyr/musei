<?
class Translit {
	
	static function convert($st, $lUrlMode = false) {
		// Ñíà÷àëà çàìåíÿåì "îäíîñèìâîëüíûå" ôîíåìû.
		$st = mb_convert_encoding($st, 'cp1251', 'utf8');
		$st = strtr($st, "àáâãäå¸çèéêëìíîïğñòóôõûı", "abvgdeeziyklmnoprstufhye");
		$st = strtr($st, "ÀÁÂÃÄÅ¨ÇÈÉÊËÌÍÎÏĞÑÒÓÔÕÛİ", "ABVGDEEZIYKLMNOPRSTUFHYE");
		
		// Çàòåì - "ìíîãîñèìâîëüíûå".
		$st = strtr($st, array(
			"æ"=>"zh", "ö"=>"c", "÷"=>"ch", "ø"=>"sh", "ù"=>"shch", "ü"=>"", "ú"=>"", "ş"=>"ju", "ÿ"=>"ja",
			"Æ"=>"ZH", "Ö"=>"C", "×"=>"CH", "Ø"=>"SH", "Ù"=>"SHCH", "Ü"=>"", "ú"=>"", "Ş"=>"JU", "ß"=>"JA",
			"¿"=>"i", "¯"=>"Yi", "º"=>"ie", "ª"=>"Ye"
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
