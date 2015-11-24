var ru2en = {
  ru_str : "АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя",
  en_str : ['A','B','V','G','D','E','JO','ZH','Z','I','J','K','L','M','N','O','P','R','S','T',
    'U','F','H','C','CH','SH','SHCH',String.fromCharCode(39),'Y',String.fromCharCode(39),'JE','JU',
    'JA','a','b','v','g','d','e','jo','zh','z','i','j','k','l','m','n','o','p','r','s','t','u','f',
    'h','c','ch','sh','shch',String.fromCharCode(39),'y',String.fromCharCode(39),'e','ju','ja'],
  translit : function(org_str) {
    var tmp_str = [];
    for(var i = 0, l = org_str.length; i < l; i++) {
      var s = org_str.charAt(i), n = this.ru_str.indexOf(s);
      if(n >= 0) { tmp_str[tmp_str.length] = this.en_str[n]; }
      else { tmp_str[tmp_str.length] = s; }
    }
    return tmp_str.join("");
  },
  tr_url : function(org_str) {
    var tmp_str = [];
    org_str = org_str.toLowerCase();
    for(var i = 0, l = org_str.length; i < l; i++) {
      var s = org_str.charAt(i), n = this.ru_str.indexOf(s);
      if (n == -1 && !s.match(/[a-zA-Z0-9]/)) { tmp_str[tmp_str.length] = '-'; }
      else { tmp_str[tmp_str.length] = s; }
    }
    org_str = tmp_str.join('');
    while (org_str.indexOf('--') > 0) {
       org_str = org_str.replace(/--/, '-');
    }
    
    org_str = this.translit(org_str);
    org_str = org_str.replace(/\'/g, '');
    org_str = org_str.replace(/-$/g, '');

    return this.translit(org_str);
  }
}
// alert(ru2en.tr('Начало учёбы в школе означает полную перестройку режима отдыха и работы ребёнка.'));
