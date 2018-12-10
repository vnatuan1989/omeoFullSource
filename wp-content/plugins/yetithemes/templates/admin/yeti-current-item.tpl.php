<div class="yeti-item col-2">
    <h2 style="margin-top: 0">Description</h2>
    <div class="description-toggle-content">
        <?php echo wp_kses_post($_current_item['description']); ?>
        <span class="description-toggle-action"><i class="fa fa-angle-double-down"
                                                   aria-hidden="true"></i> <?php esc_html_e('Show more description', 'yetithemes'); ?></span>
    </div>
</div>
<div class="yeti-item col-2">

    <section class="yeti-section">
        <img src="<?php echo esc_url($_current_item['previews']['landscape_preview']['landscape_url']); ?>"
             alt="<?php echo esc_attr($_current_item['name']) ?>">
        <header>
            <a href="<?php echo esc_url($_current_item['url']) ?>"
               target="_blank"><?php echo esc_html($_current_item['name']) ?></a>
        </header>
        <table class="nth_status_table widefat" cellspacing="0" border="0">
            <tbody>
            <tr>
                <td data-export-label="Category">Category</td>
                <td class="help">&nbsp;</td>
                <td><?php echo esc_attr($_current_item['classification']) ?></td>
            </tr>
            <tr data-export-label="Author">
                <td>Author</td>
                <td class="help">&nbsp;</td>
                <td>
                    <a href="<?php echo esc_url($_current_item['author_url']); ?>"><?php echo esc_html($_current_item['author_username']) ?></a>
                </td>
            </tr>
            <tr>
                <td data-export-label="Category">Latest Update</td>
                <td class="help">&nbsp;</td>
                <td><?php echo gmdate('d M Y', strtotime($_current_item['updated_at'])); ?></td>
            </tr>
            <tr>
                <td data-export-label="Category">Created</td>
                <td class="help">&nbsp;</td>
                <td><?php echo gmdate('d M Y', strtotime($_current_item['published_at'])); ?></td>
            </tr>
            <?php
            $_attributes_display = array('compatible-browsers', 'compatible-software', 'compatible-with', 'themeforest-files-included');
            foreach ($_current_item['attributes'] as $attribute) :
                if (!in_array($attribute['name'], $_attributes_display)) continue;
                ?>
                <tr>
                    <td><?php echo esc_html($attribute['label']) ?></td>
                    <td class="help">&nbsp;</td>
                    <td>
                        <?php
                        if (is_array($attribute['value'])) echo esc_html(implode(', ', $attribute['value']));
                        else echo esc_html($attribute['value'])
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr data-export-label="Tags">
                <td>Tags</td>
                <td class="help">&nbsp;</td>
                <td>
                    <?php echo esc_html(implode(', ', $_current_item['tags'])) ?>
                </td>
            </tr>

            </tbody>
        </table>
    </section>
</div>
