<?php
if (!defined('ABSPATH')) exit;
?>

<div class="wrap">
    <h1>Realtime AI Post Sync</h1>

    <form method="post" action="options.php">
        <?php settings_fields('wprts'); ?>

        <h2>Mode</h2>
        <label>
            <input type="radio" name="wprts_mode" value="host"
                <?php checked($mode,'host'); ?>>
            Host
        </label>

        <label style="margin-left:20px;">
            <input type="radio" name="wprts_mode" value="target"
                <?php checked($mode,'target'); ?>>
            Target
        </label>

        <hr>

        <!-- HOST SETTINGS -->
        <div id="host-settings">
            <h2>Host Settings</h2>

            <table class="widefat striped">
                <thead>
                    <tr>
                        <th>Target URL</th>
                        <th>Authentication Key</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="targets-wrapper">

                <?php foreach($targets as $i => $row): ?>
                    <tr>
                        <td>
                            <input type="url"
                                   name="wprts_targets[<?php echo $i;?>][url]"
                                   value="<?php echo esc_attr($row['url']); ?>"
                                   required
                                   style="width:100%;">
                        </td>
                        <td>
                            <input type="text"
                                   value="<?php echo esc_attr($row['key']); ?>"
                                   readonly
                                   style="width:100%;background:#f3f3f3;">
                            <input type="hidden"
                                   name="wprts_targets[<?php echo $i;?>][key]"
                                   value="<?php echo esc_attr($row['key']); ?>">
                        </td>
                        <td>
                            <button type="button"
                                    class="button remove"
                                    data-key="<?php echo $i;?>">
                                Remove
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>

            <br>
            <button type="button" class="button button-primary" id="add-row">
                + Add New Target
            </button>
        </div>

        <!-- TARGET SETTINGS -->
        <div id="target-settings">
            <h2>Target Settings</h2>

            <p>
                <label><strong>Authentication Key</strong></label><br>
                <input type="text"
                       name="wprts_target_key"
                       value="<?php echo esc_attr(get_option('wprts_target_key')); ?>"
                       style="width:400px;">
            </p>

            <p>
                <label><strong>Translation Language</strong></label><br>
                <select name="wprts_language">
                    <option value="French" <?php selected(get_option('wprts_language'),'French'); ?>>French</option>
                    <option value="Spanish" <?php selected(get_option('wprts_language'),'Spanish'); ?>>Spanish</option>
                    <option value="Hindi" <?php selected(get_option('wprts_language'),'Hindi'); ?>>Hindi</option>
                </select>
            </p>

            <p>
                <label><strong>ChatGPT API Key</strong></label><br>
                <input type="password"
                       name="wprts_openai_key"
                       value="<?php echo esc_attr(get_option('wprts_openai_key')); ?>"
                       style="width:400px;">
            </p>
        </div>

        <?php submit_button(); ?>
    </form>
</div>
