/* Size */
.kk-star-ratings .kksr-stars .kksr-star svg {
    width: <?php echo $size; ?>px;
    height: <?php echo $size; ?>px;
}

/* Colors */

.kk-star-ratings .kksr-stars .kksr-star svg,
.kk-star-ratings:not(.kksr-disable) .kksr-stars .kksr-star:hover ~ .kksr-star svg {
    fill: <?php echo $colors['default']['fill']; ?>;
    stroke: <?php echo $colors['default']['stroke']; ?>;
}

.kk-star-ratings .kksr-stars .kksr-active-stars .kksr-star svg {
    fill: <?php echo $colors['active']['fill']; ?>;
    stroke: <?php echo $colors['active']['stroke']; ?>;
}

.kk-star-ratings:not(.kksr-disable) .kksr-stars:hover .kksr-star svg {
    fill: <?php echo $colors['hover']['fill']; ?>;
    stroke: <?php echo $colors['hover']['stroke']; ?>;
}

.kk-star-ratings .kksr-legend {
    background-color: <?php echo $colors['active']['stroke']; ?>;
}

.kk-star-ratings .kksr-legend .kksr-legend-meta {
    color: <?php echo $colors['active']['stroke']; ?>;
}
