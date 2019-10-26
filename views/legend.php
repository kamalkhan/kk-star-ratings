<div class="kksr-legend">
    <?php if ($count) : ?>
        <strong class="kksr-score"><?= $score ?></strong>
        <span class="kksr-muted">/</span>
        <strong><?= $best ?></strong>
        <span class="kksr-muted">(</span>
        <strong class="kksr-count"><?= $count ?></strong>
        <span class="kksr-muted">
            <?= _n('vote', 'votes', $count, 'kk-star-ratings') ?>
        </span>
        <span class="kksr-muted">)</span>
    <?php else : ?>
        <span class="kksr-muted"><?= $greet ?></span>
    <?php endif; ?>
</div>
