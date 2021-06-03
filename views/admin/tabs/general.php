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
        $postTypes[] = [
            'value' => $postType->name,
            'label' => $postType->labels->name,
        ];
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
                <label for="<?= $enable[0] ?>"><?= _x('Status', 'Label', 'kk-star-ratings') ?></label>
            </th>
            <td>
                <label>
                    <input type="checkbox" name="<?= $enable[0] ?>" id="<?= $enable[0] ?>" value="1"<?= $enable[1] ? ' checked="checked"' : ''  ?>>
                    <?= _x('Active', 'Label', 'kk-star-ratings') ?>
                </label>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= __('Globally activate/deactivate the star ratings.', 'kk-star-ratings') ?>
                </p>
            </td>
        </tr>

        <!-- Strategies -->
        <tr>
            <th scope="row" valign="top">
                <?= _x('Strategies', 'Label', 'kk-star-ratings') ?>
            </th>
            <td>
                <?php foreach ($availableStrategies as $value => $label) : ?>
                    <p>
                        <label>
                            <input type="checkbox" name="<?= $strategies[0] ?>[]" value="<?= $value ?>"<?= (in_array($value, $strategies[1])) ? ' checked="checked"' : ''  ?>>
                            <?= $label ?>
                        </label>
                    </p>
                <?php endforeach; ?>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= __('Select the voting strategies.', 'kk-star-ratings') ?>
                </p>
            </td>
        </tr>

        <!-- Manual Control -->
        <!-- <tr>
            <th scope="row" valign="top">
                <?= _x('Manual Control', 'Label', 'kk-star-ratings') ?>
            </th>
            <td>
                <?php foreach ($postTypes as $type => $label) : ?>
                    <p>
                        <label>
                            <input type="checkbox" name="<?= $manualControl[0] ?>[]" value="<?= $type ?>"<?= (in_array($type, $manualControl[1])) ? ' checked="checked"' : ''  ?>>
                            <?= $label ?>
                        </label>
                    </p>
                <?php endforeach ?>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= sprintf(__('Select the post types that should not auto embed the markup and will be manually controlled by the theme. E.g. Using %s in your theme/template file(s).', 'kk-star-ratings'), '<code>echo kk_star_ratings();</code>') ?>
                </p>
            </td>
        </tr> -->

        <!-- Exclude Locations -->
        <tr>
            <th scope="row" valign="top">
                <?= _x('Exclude Locations', 'Label', 'kk-star-ratings') ?>
            </th>
            <td>
                <?php foreach ($availableLocations as $type => $label) : ?>
                    <p>
                        <label>
                            <input type="checkbox" name="<?= $excludeLocations[0] ?>[]" value="<?= $type ?>"<?= (in_array($type, $excludeLocations[1])) ? ' checked="checked"' : ''  ?>>
                            <?= $label ?>
                        </label>
                    </p>
                <?php endforeach ?>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= sprintf(__('The selected locations will not auto-embed the star ratings. You may still manually show the star ratings. E.g. Using %s in your theme/template file(s).', 'kk-star-ratings'), '<code>echo kk_star_ratings();</code>') ?>
                </p>
            </td>
        </tr>

        <!-- Exclude Categories -->
        <tr>
            <th scope="row" valign="top">
                <?= _x('Exclude Categories', 'Label', 'kk-star-ratings') ?>
            </th>
            <td>
                <?php foreach ($postCategories as $value => $label) : ?>
                    <p>
                        <label>
                            <input type="checkbox" name="<?= $excludeCategories[0] ?>[]" value="<?= $value ?>"<?= (in_array($value, $excludeCategories[1])) ? ' checked="checked"' : ''  ?>>
                            <?= $label ?>
                        </label>
                    </p>
                <?php endforeach ?>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= sprintf(__('The posts belonging to the selected categories wil not auto-embed the star ratings. You may still manually show the star ratings. E.g. Using %s in your theme/template file(s).', 'kk-star-ratings'), '<code>echo kk_star_ratings();</code>') ?>
                </p>
            </td>
        </tr>
    </tbody>
</table>
