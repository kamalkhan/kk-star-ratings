<?php
    $grs = $get('grs');
    $sd = $get('sd');
?>

<table class="form-table" role="presentation">
    <tbody>

        <!-- Status -->
        <tr>
            <th scope="row" valign="top">
                <label for="<?= $grs[0] ?>"><?= _x('Status', 'Label', 'kk-star-ratings') ?></label>
            </th>
            <td>
                <label>
                    <input type="checkbox" name="<?= $grs[0] ?>" id="<?= $grs[0] ?>" value="1"<?= $grs[1] ? ' checked="checked"' : ''  ?>>
                    <?= _x('Enable', 'Label', 'kk-star-ratings') ?>
                </label>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= __('Enable/disable rich snippets.', 'kk-star-ratings') ?>
                </p>
            </td>
        </tr>

        <!-- Structured Data -->
        <tr>
            <th scope="row" valign="top">
                <label for="<?= $sd[0] ?>">
                    <?= _x('Content', 'Label', 'kk-star-ratings'); ?>
                </label>
            </th>
            <td>
                <p>
                    <textarea type="text" name="<?= $sd[0] ?>" id="<?= $sd[0] ?>" rows="12" placeholder="ld+json" class="regular-text" style="font-family: monospace;"><?= trim($sd[1]) ?></textarea>
                </p>
                <p class="description" style="max-width: 22rem; margin-top: .75rem;">
                    <?= __('Provide the ld+json structure.', 'kk-star-ratings') ?>
                    <br><br>
                    <?= __('The following variables are available:', 'kk-star-ratings') ?>
                    <br>
                    <?= sprintf(_x('%s Post title', 'Label', 'kk-star-ratings'), '<code>{title}</code>') ?>
                    <br>
                    <?= sprintf(_x('%s Average ratings', 'Label', 'kk-star-ratings'), '<code>{score}</code>') ?>
                    <br>
                    <?= sprintf(_x('%s Number of votes casted', 'Label', 'kk-star-ratings'), '<code>{count}</code>') ?>
                    <br>
                    <?= sprintf(_x('%s Total amount of stars', 'Label', 'kk-star-ratings'), '<code>{best}&nbsp;</code>') ?>
                </p>
            </td>
        </tr>

    </tbody>
</table>
