<div class="keyboard">
    <span>й</span>
    <span>ц</span>
    <span>у</span>
    <span>к</span>
    <span>e</span>
    <span>н</span>
    <span>г</span>
    <span>ш</span>
    <span>щ</span>
    <span>з</span>
    <span>х</span>

    <span>ф</span>
    <span>ы</span>
    <span>в</span>
    <span>а</span>
    <span>п</span>
    <span>р</span>
    <span>о</span>
    <span>л</span>
    <span>д</span>
    <span>ж</span>
    <span>э</span>

    <span>я</span>
    <span>ч</span>
    <span>с</span>
    <span>м</span>
    <span>и</span>
    <span>т</span>
    <span>ь</span>
    <span>б</span>
    <span>ю</span>
    <br />
    <span class="delete"></span>
    <span class="capsLock"></span>
    <span class="space"> </span>
    <button type="button" class="styler">Ввод</button>
</div>
<script type="text/javascript">
function toggleLetterCase() {
    var lUpper = $('.keyboard').hasClass('uppercase');
    $('.keyboard span').each(function(){
        $(this).html(lUpper ? $(this).html().toUpperCase() : $(this).html().toLowerCase());
    });
}

function insertAtCaret(e, text) {
    if (document.selection) {
        e.focus();
        var sel = document.selection.createRange();
        sel.text = text;
        e.focus();
    } else if (e.selectionStart || e.selectionStart === 0) {
        var startPos = e.selectionStart;
        var endPos = e.selectionEnd;
        var scrollTop = e.scrollTop;
        e.value = e.value.substring(0, startPos) + text + e.value.substring(endPos, e.value.length);
        e.focus();
        e.selectionStart = startPos + text.length;
        e.selectionEnd = startPos + text.length;
        e.scrollTop = scrollTop;
    } else {
        e.value += text;
        e.focus();
    }
}

function backspaceAtCaret(e) {
    if (document.selection) {
        e.focus();
        sel = document.selection.createRange();
        if(sel.text.length > 0) {
            sel.text = '';
        } else {
            sel.moveStart("character",-1);
            sel.text = '';
        }
        sel.select();
    } else if (e.selectionStart || e.selectionStart == "0") {
        var startPos = e.selectionStart;
        var endPos = e.selectionEnd;

        e.value = e.value.substring(0, startPos-1) + e.value.substring(endPos, e.value.length);
        e.selectionStart = startPos-1;
        e.selectionEnd = startPos-1;
        e.focus();
    } else {
        e.value = e.value.substr(0,(e.value.length-1));
        e.focus();
    }
}

var lastFocused = null;
function getFocusedElement() {
    return lastFocused;
}

$(function(){
    $('.writeReview input[type=text]:first').focus();
    lastFocused = $('.writeReview input[type=text]:first').get(0);

    $('.writeReview input, .writeReview textarea').blur(function(){
        lastFocused = this;
    });

    $('.keyboard button').click(function(){
        var e = getFocusedElement();
        console.log(e, e.tagName);
        if (e.tagName.toLowerCase() == 'textarea') {
            insertAtCaret(e, '\n');
        } else if (e.tagName.toLowerCase() == 'input') {
            $('.writeReview textarea').focus();
        }
    });

    $('.keyboard .capsLock').click(function(){
        $('.keyboard').toggleClass('uppercase');
        toggleLetterCase();
    });
    $('.keyboard .delete').click(function(){
        backspaceAtCaret(getFocusedElement());
    });

    $('.keyboard span').click(function(){
        insertAtCaret(getFocusedElement(), $(this).html());
    });

});
</script>