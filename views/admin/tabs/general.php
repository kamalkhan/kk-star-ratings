<?php
    $enable = $get('enable');
    $excludeCategories = $get('exclude_categories');
    $excludeLocations = $get('exclude_locations');
    $manualControl = $get('manual_control');
    $strategies = $get('strategies');

    $postTypes = ['post' => 'Posts', 'page' => 'Pages'];
    foreach (get_post_types([
        'publicly_queryable' => true,
        '_builtin' => false,
    ], 'objects') as $postType) {
        $postTypes[$postType->name] = $postType->labels->name;
    }

    $postCategories = array_reduce(get_terms([
        'taxonomy' => 'category',
        'hide_empty' => false,
        'parent' => 0,
    ]), function ($categories, $category) {
        $categories[$category->term_id] = $category->name;

        return $categories;
    }, []);

    $availableLocations = [
        'home' => _x('Home', 'Label', 'kk-star-ratings'),
        'archives' => _x('Archives', 'Label', 'kk-star-ratings')
    ] + $postTypes;

    $availableStrategies = [
        'archives' => _x('Allow voting in archives', 'Label', 'kk-star-ratings'),
        'guests' => _x('Allow guests to vote', 'Label', 'kk-star-ratings'),
        'unique' => _x('Unique votes (based on IP Address)', 'Label', 'kk-star-ratings'),
    ];
?>

<table class="form-table" role="presentation">
    <tbody>

        <!-- Status -->
        <tr>
            <th scope="row" valign="top">
                <label for="<?= esc_attr($enable[0]) ?>"><?= esc_html_x('Status', 'Label', 'kk-star-ratings') ?></label>
            </th>
            <td>
                <label>
                    <input type="checkbox" name="<?= esc_attr($enable[0]) ?>" id="<?= esc_attr($enable[0]) ?>" value="1"<?= $enable[1] ? ' checked="checked"' : ''  ?>>
                    <?= esc_html_x('Active', 'Label', 'kk-star-ratings') ?>
                </label>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= esc_html__('Globally activate/deactivate the star ratings.', 'kk-star-ratings') ?>
                </p>
            </td>
        </tr>

        <!-- Strategies -->
        <tr>
            <th scope="row" valign="top">
                <?= esc_html_x('Strategies', 'Label', 'kk-star-ratings') ?>
            </th>
            <td>
                <?php foreach ($availableStrategies as $value => $label) : ?>
                    <p>
                        <label>
                            <input type="checkbox" name="<?= esc_attr($strategies[0]) ?>[]" value="<?= esc_attr($value) ?>"<?= (in_array($value, $strategies[1])) ? ' checked="checked"' : ''  ?>>
                            <?= esc_html($label) ?>
                        </label>
                    </p>
                <?php endforeach; ?>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= esc_html__('Select the voting strategies.', 'kk-star-ratings') ?>
                </p>
            </td>
        </tr>

        <!-- Manual Control -->
        <!-- <tr>
            <th scope="row" valign="top">
                <?= esc_html_x('Manual Control', 'Label', 'kk-star-ratings') ?>
            </th>
            <td>
                <?php foreach ($postTypes as $type => $label) : ?>
                    <p>
                        <label>
                            <input type="checkbox" name="<?= esc_attr($manualControl[0]) ?>[]" value="<?= esc_attr($type) ?>"<?= (in_array($type, $manualControl[1])) ? ' checked="checked"' : ''  ?>>
                            <?= esc_html($label) ?>
                        </label>
                    </p>
                <?php endforeach ?>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= sprintf(esc_html__('Select the post types that should not auto embed the markup and will be manually controlled by the theme. E.g. Using %s in your theme/template file(s).', 'kk-star-ratings'), '<code>echo kk_star_ratings();</code>') ?>
                </p>
            </td>
        </tr> -->

        <!-- Exclude Locations -->
        <tr>
            <th scope="row" valign="top">
                <?= esc_html_x('Exclude Locations', 'Label', 'kk-star-ratings') ?>
            </th>
            <td>
                <?php foreach ($availableLocations as $type => $label) : ?>
                    <p>
                        <label>
                            <input type="checkbox" name="<?= esc_attr($excludeLocations[0]) ?>[]" value="<?= esc_attr($type) ?>"<?= (in_array($type, $excludeLocations[1])) ? ' checked="checked"' : ''  ?>>
                            <?= esc_html($label) ?>
                        </label>
                    </p>
                <?php endforeach ?>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= sprintf(esc_html__('The selected locations will not auto-embed the star ratings. You may still manually show the star ratings. E.g. Using %s in your theme/template file(s).', 'kk-star-ratings'), '<code>echo kk_star_ratings();</code>') ?>
                </p>
            </td>
        </tr>

        <!-- Exclude Categories -->
        <tr>
            <th scope="row" valign="top">
                <?= esc_html_x('Exclude Categories', 'Label', 'kk-star-ratings') ?>
            </th>
            <td>
                <?php foreach ($postCategories as $value => $label) : ?>
                    <p>
                        <label>
                            <input type="checkbox" name="<?= esc_attr($excludeCategories[0]) ?>[]" value="<?= esc_attr($value) ?>"<?= (in_array($value, $excludeCategories[1])) ? ' checked="checked"' : ''  ?>>
                            <?= esc_html($label) ?>
                        </label>
                    </p>
                <?php endforeach ?>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= sprintf(esc_html__('The posts belonging to the selected categories will not auto-embed the star ratings. You may still manually show the star ratings. E.g. Using %s in your theme/template file(s).', 'kk-star-ratings'), '<code>echo kk_star_ratings();</code>') ?>
                </p>
            </td>
        </tr>
    </tbody>
</table>
