<form action="http://feedburner.google.com/fb/a/mailverify" class="yeti-form-single" method="post" target="popupwindow"
      onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $fb_id; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
    <div class="yeti-form-wrapper">
        <input type="text" name="email" class="subscribe_email"
               placeholder="<?php _e('enter your email address', 'yetithemes'); ?>"/>
        <input type="hidden" value="<?php echo $fb_id; ?>" name="uri"/>
        <input type="hidden" value="<?php echo get_bloginfo('name'); ?>" name="title"/>
        <input type="hidden" name="loc" value="en_US"/>
        <button class="fa fa-paper-plane" type="submit" title="Subscribe"><i class="fa fa-paper-plane-o"></i></button>
    </div><!-- .yeti-form-wrapper -->
</form>