$(document).ready(function(){
    $('ul.nav.nav-tabs > li > a').click(function(){
    	var tab = $(this).parent().get(0).id.replace(/tab\-/, '');
    	$('ul.nav.nav-tabs > li').removeClass('active');
    	$('ul.nav.nav-tabs > #tab-' + tab).addClass('active');
    	$('.tab-content-all .tab-content').hide();
    	$('.tab-content-all #tab-content-' + tab).show();
    });
    var url = window.location.href;
    if (url.indexOf('#tab-') > 0) {
        var a = url.split('#');
        var tabID = a[1];
        $('#' + tabID + ' a').click();
    }
});
