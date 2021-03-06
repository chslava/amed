<section class="subscribe">
    <div class="ui container">
        <!-- <?php print(get_field("newsletter_email_success","option")); ?> -->

        <?php $form = do_shortcode('[mc4wp_form id="252"]'); ?>
        <?php
            $form = strip_tags($form,"<input>,<form>,<script>,<div>");
            $form = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $form);

            $form =str_replace('class="mc4wp-form ','class="mc4wp-form ui form"',$form);
            $form =str_replace('type="email" ','type="email" class="subscribe ui input" placeholder="'.get_field("newsletter_placeholder","option").'" ',$form);
            $form =str_replace('Email address:','<div class="ui centered grid"><div class="title">'.get_field("newsletter_title","option").'</div>',$form);
            $form =str_replace('</form>',' </div></form>',$form);
            $form =str_replace(' type="submit" ',' type="submit" class="ui primary button" value="'.get_field("newsletter_cta_button","option").'" ',$form);
            $form =str_replace(' type="text" ',' type="text" style="display:none;" ',$form);
            $form =str_replace('Given email address is already subscribed, thank you!',get_field("newsletter_email_exists","option"),$form);
            $form =str_replace('Thank you, your sign-up request was successful! Please check your email inbox to confirm.',get_field("newsletter_email_success","option"),$form);
            $form =str_replace('Thank you, your sign-up request was successful!',get_field("newsletter_email_success","option"),$form);

            $form =str_replace('Oops. Something went wrong. Please try again later.',get_field("newsletter_email_spmething_went_wrong","option"),$form);
            $form.= '<div class="mc4wp-response"></div>';

            print($form);
        ?>
    </div>
</section>

