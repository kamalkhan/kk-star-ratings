<?php
    $gap = $get('gap');
    $greet = $get('greet');
    $legend = $get('legend');
    $position = $get('position');
    $size = $get('size');
    $stars = $get('stars');

    $positions = [
        'top-left' => _x('Top Left', 'Label', 'kk-star-ratings'),
        'top-center' => _x('Top Center', 'Label', 'kk-star-ratings'),
        'top-right' => _x('Top Right', 'Label', 'kk-star-ratings'),
        'bottom-left' => _x('Bottom Left', 'Label', 'kk-star-ratings'),
        'bottom-center' => _x('Bottom Center', 'Label', 'kk-star-ratings'),
        'bottom-right' => _x('Bottom Right', 'Label', 'kk-star-ratings'),
    ];
?>

<table class="form-table" role="presentation">
    <tbody>
        <!-- Greet -->
        <tr>
            <th scope="row" valign="top">
                <label for="<?= esc_attr($greet[0]) ?>">
                    <?= esc_html_x('Greeting', 'Label', 'kk-star-ratings') ?>
                </label>
            </th>
            <td>
                <p>
                    <input type="text" name="<?= esc_attr($greet[0]) ?>" id="<?= esc_attr($greet[0]) ?>" value="<?= esc_attr($greet[1]) ?>" placeholder="Rate this {type}" class="regular-text" style="font-family: monospace;">
                </p>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= esc_html__('Text that will be displayed when no votes have been casted.', 'kk-star-ratings') ?>
                    <br><br>
                    <?= esc_html__('The following variables are available:', 'kk-star-ratings') ?>
                    <br>
                    <?= sprintf(esc_html__('%s Post Type', 'kk-star-ratings'), '<code>{type}</code>') ?>
                </p>
            </td>
        </tr>

        <!-- Legend -->
        <tr>
            <th scope="row" valign="top">
                <label for="<?= esc_attr($legend[0]) ?>">
                    <?= esc_html_x('Legend', 'Label', 'kk-star-ratings') ?>
                </label>
            </th>
            <td>
                <p>
                    <input type="text" name="<?= esc_attr($legend[0]) ?>" id="<?= esc_attr($legend[0]) ?>" value="<?= esc_attr($legend[1]) ?>" placeholder="{score}/{best} - ({count} {votes})" class="regular-text" style="font-family: monospace;">
                </p>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= esc_html__('Text that will be displayed when votes have been casted.', 'kk-star-ratings') ?>
                    <br><br>
                    <?= esc_html__('The following variables are available:', 'kk-star-ratings') ?>
                    <br>
                    <?= sprintf(esc_html__('%s Average ratings', 'kk-star-ratings'), '<code>{score}</code>') ?>
                    <br>
                    <?= sprintf(esc_html__('%s Number of votes casted', 'kk-star-ratings'), '<code>{count}</code>') ?>
                    <br>
                    <?= sprintf(esc_html__('%s Total amount of stars', 'kk-star-ratings'), '<code>{best} </code>') ?>
                    <br>
                    <?= sprintf(esc_html__('%s Votes', 'kk-star-ratings'), '<code>{votes}</code>') ?>
                </p>
            </td>
        </tr>

        <!-- Stars -->
        <tr>
            <th scope="row" valign="top">
                <label for="<?= esc_attr($stars[0]) ?>">
                    <?= esc_html_x('Stars', 'Label', 'kk-star-ratings') ?>
                </label>
            </th>
            <td>
                <p>
                    <input type="number" name="<?= esc_attr($stars[0]) ?>" id="<?= esc_attr($stars[0]) ?>" value="<?= esc_attr($stars[1]) ?>" class="regular-text" style="max-width: 4rem; padding-right: 0;">
                </p>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= esc_html__('Total number of stars.', 'kk-star-ratings') ?>
                </p>
            </td>
        </tr>

        <!-- Gap -->
        <tr>
            <th scope="row" valign="top">
                <label for="<?= $gap[0] ?>">
                    <?= esc_html_x('Gap', 'Label', 'kk-star-ratings'); ?>
                </label>
            </th>
            <td>
                <p>
                    <input type="number" name="<?= esc_attr($gap[0]) ?>" id="<?= esc_attr($gap[0]) ?>" value="<?= esc_attr($gap[1]) ?>" class="regular-text" style="max-width: 4rem; padding-right: 0;">
                </p>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= esc_html__('Gap between the stars.', 'kk-star-ratings') ?>
                </p>
            </td>
        </tr>

        <!-- Size -->
        <tr>
            <th scope="row" valign="top">
                <label for="<?= $size[0] ?>">
                    <?= esc_html_x('Size', 'Label', 'kk-star-ratings'); ?>
                </label>
            </th>
            <td>
                <p>
                    <input type="number" name="<?= esc_attr($size[0]) ?>" id="<?= esc_attr($size[0]) ?>" value="<?= esc_attr($size[1]) ?>" class="regular-text" style="max-width: 4rem; padding-right: 0;">
                </p>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= esc_html__('Size of a single star.', 'kk-star-ratings') ?>
                </p>
            </td>
        </tr>

        <!-- Position -->
        <tr>
            <th scope="row" valign="top">
                <?= esc_html_x('Default Position', 'Label', 'kk-star-ratings'); ?>
            </th>
            <td>
                <?php foreach ($positions as $value => $label) : ?>
                    <p>
                        <label>
                            <input type="radio" name="<?= esc_attr($position[0]) ?>" value="<?= esc_attr($value) ?>"<?= ($value ==  $position[1]) ? ' checked="checked"' : ''  ?>>
                            <?= esc_html($label) ?>
                        </label>
                    </p>
                <?php endforeach ?>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= esc_html__('Choose the default position for the auto-embedded star ratings.', 'kk-star-ratings'); ?>
                </p>
            </td>
        </tr>
    </tbody>
</table>
