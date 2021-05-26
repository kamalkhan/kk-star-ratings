<table class="form-table" role="presentation">
    <tbody>

        <!-- Status -->
        <tr>
            <th scope="row" valign="top">
                <label for="kksr_enable"><?= _x('Status', 'Label', 'kk-star-ratings'); ?></label>
            </th>
            <td>
                <label>
                    <input type="checkbox" name="kksr_enable" id="kksr_enable" value="1"
                    <?= (is_array($old) ? ($old['kksr_enable'] ?? false) : get_option('kksr_enable')) ? ' checked="checked"' : ''  ?>>
                    <?= _x('Active', 'Label', 'kk-star-ratings'); ?>
                </label>
                <p class="description" style="margin-top: .75rem;">
                    <?= __('Globally activate/deactivate the star ratings.', 'kk-star-ratings'); ?>
                </p>
            </td>
        </tr>

        <!-- Strategies -->
        <tr>
            <th scope="row" valign="top">
                <?= _x('Strategies', 'Label', 'kk-star-ratings'); ?></label>
            </th>
            <td>
                <?php $strategies = (array) (is_array($old) ? ($old['kksr_strategies'] ?? null) : get_option('kksr_strategies')) ?>
                <p>
                <label>
                    <input type="checkbox" name="kksr_strategies[]" value="archives"
                    <?= (in_array('archives', $strategies)) ? ' checked="checked"' : ''  ?>>
                    <?= _x('Allow voting in archives', 'Label', 'kk-star-ratings'); ?>
                </label>
                </p>
                <p>
                <label>
                    <input type="checkbox" name="kksr_strategies[]" value="guests"
                    <?= (in_array('guests', $strategies)) ? ' checked="checked"' : ''  ?>>
                    <?= _x('Allow guests to vote', 'Label', 'kk-star-ratings'); ?>
                </label>
                </p>
                <p>
                <label>
                    <input type="checkbox" name="kksr_strategies[]" value="unique"
                    <?= (in_array('unique', $strategies)) ? ' checked="checked"' : ''  ?>>
                    <?= _x('Unique votes (based on IP Address)', 'Label', 'kk-star-ratings'); ?>
                </label>
                </p>
                <p class="description" style="margin-top: .75rem;">
                    <?= __('Select the voting strategies.', 'kk-star-ratings'); ?>
                </p>
            </td>
        </tr>
    </tbody>
</table>
