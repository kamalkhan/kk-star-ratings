<?php

namespace Bhittani\StarRating;

function toNormalizedRatings($ratings, $from = 5, $to = 5)
{
    return $ratings / ($from / $to);
}

function calculateScore($total, $count, $from = 5, $to = 5)
{
    $count = (float) $count;
    $total = (float) $total;

    return $count ? round(($total / $count) * ($from / $to), 1, PHP_ROUND_HALF_DOWN) : 0;
}

// We will neglect $from but here for consistency!
function calculatePercentage($total, $count, $from = 5, $to = 5)
{
    $count = (float) $count;
    $total = (float) $total;

    return $count ? round($total / $count / $to * 100, 2, PHP_ROUND_HALF_DOWN) : 0;
}

// Admin

function getAdminTabs()
{
    return [
        'general' => __('General', KKSR_SLUG),
        'grs' => __('GRS', KKSR_SLUG),
        'skin' => __('Skin', KKSR_SLUG),
        'dev' => __('Developers', KKSR_SLUG),
        'support' => __('Support', KKSR_SLUG),
    ];
}

function getDefaultAdminTab()
{
    return 'general';
}

function getActiveAdminTab()
{
    $defaultTab = getDefaultAdminTab();

    if (! isset($_GET['tab'])) {
        return $defaultTab;
    }

    $tab = $_GET['tab'];

    if (empty($tab)) {
        return $defaultTab;
    }

    $tabs = getAdminTabs();

    if (isset($tabs[$tab])) {
        return $tab;
    }
}

function isActiveAdminTab($tab)
{
    return $tab == getActiveAdminTab();
}
