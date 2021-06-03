<?php
    $gap = $get('gap');
    $greet = $get('greet');
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
                <label for="<?= $greet[0] ?>">
                    <?= _x('Greeting Text', 'Label', 'kk-star-ratings'); ?>
                </label>
            </th>
            <td>
                <p>
                    <input type="text" name="<?= $greet[0] ?>" id="<?= $greet[0] ?>" value="<?= $greet[1] ?>" placeholder="Rate this {type}" class="regular-text">
                </p>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= __('Text that will be displayed when no votes have been casted.', 'kk-star-ratings') ?>
                    <br><br>
                    <?= __('The following variables are available:', 'kk-star-ratings') ?>
                    <br>
                    <?= sprintf(__('%s Post Type', 'kk-star-ratings'), '<code>{type}</code>') ?>
                </p>
            </td>
        </tr>

        <!-- Stars -->
        <tr>
            <th scope="row" valign="top">
                <label for="<?= $stars[0] ?>">
                    <?= _x('Stars', 'Label', 'kk-star-ratings'); ?>
                </label>
            </th>
            <td>
                <p>
                    <input type="number" name="<?= $stars[0] ?>" id="<?= $stars[0] ?>" value="<?= $stars[1] ?>" class="regular-text" style="max-width: 4rem; padding-right: 0;">
                </p>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= __('Total number of stars.', 'kk-star-ratings') ?>
                </p>
            </td>
        </tr>

        <!-- Gap -->
        <tr>
            <th scope="row" valign="top">
                <label for="<?= $gap[0] ?>">
                    <?= _x('Gap', 'Label', 'kk-star-ratings'); ?>
                </label>
            </th>
            <td>
                <p>
                    <input type="number" name="<?= $gap[0] ?>" id="<?= $gap[0] ?>" value="<?= $gap[1] ?>" class="regular-text" style="max-width: 4rem; padding-right: 0;">
                </p>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= __('Gap between the stars.', 'kk-star-ratings') ?>
                </p>
            </td>
        </tr>

        <!-- Size -->
        <tr>
            <th scope="row" valign="top">
                <label for="<?= $size[0] ?>">
                    <?= _x('Size', 'Label', 'kk-star-ratings'); ?>
                </label>
            </th>
            <td>
                <p>
                    <input type="number" name="<?= $size[0] ?>" id="<?= $size[0] ?>" value="<?= $size[1] ?>" class="regular-text" style="max-width: 4rem; padding-right: 0;">
                </p>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= __('Size of a single star.', 'kk-star-ratings') ?>
                </p>
            </td>
        </tr>

        <!-- Position -->
        <tr>
            <th scope="row" valign="top">
                <?= _x('Default Position', 'Label', 'kk-star-ratings'); ?>
            </th>
            <td>
                <?php foreach ($positions as $value => $label) : ?>
                    <p>
                        <label>
                            <input type="radio" name="<?= $position[0] ?>" value="<?= $value ?>"<?= ($value ==  $position[1]) ? ' checked="checked"' : ''  ?>>
                            <?= $label ?>
                        </label>
                    </p>
                <?php endforeach ?>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= __('Choose the default position for the auto-embedded star ratings.', 'kk-star-ratings'); ?>
                </p>
            </td>
        </tr>
    </tbody>
</table>
