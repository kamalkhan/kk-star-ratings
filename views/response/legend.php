<div class="kksr-legend">
    <?php if ($count) : ?>
        <strong class="kksr-score"><?= esc_html($score) ?></strong>
        <span class="kksr-muted">/</span>
        <strong><?= esc_html($best) ?></strong>
        <span class="kksr-muted">(</span>
        <strong class="kksr-count"><?= esc_html($count) ?></strong>
        <span class="kksr-muted">
            <?= _n('vote', 'votes', esc_html($count), 'kk-star-ratings') ?>
        </span>
        <span class="kksr-muted">)</span>
    <?php else : ?>
        <span class="kksr-muted"><?= esc_html($greet) ?></span>
    <?php endif; ?>
</div>
