<span class="reviewDate"><?= $this->PHTime->niceShort($article['Feedback']['created']) ?></span>
<span class="reviewName"><?= $article['Feedback']['title'] ?></span>
<span class="reviewText ellipsis">
    <span class="text"><?= $article['Feedback']['body'] ?></span>
<?
    if (mb_strlen($article['Feedback']['body']) > 100) {
?>
    <a href="javascript: void(0)" class="readmore">Подробнее &raquo;</a>
<?
    }
?>
</span>
