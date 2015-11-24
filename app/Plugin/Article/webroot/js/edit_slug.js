function article_onChangeTitle() {
	if (!slug_EditMode) {
		$('#ArticleSlug').val(translit($('#ArticleTitle').val()));
	}
}

function article_onChangeSlug() {
	slug_EditMode = ($('#ArticleSlug').val() && true);
}

function translit(str) {
	return ru2en.tr_url(str);
}
