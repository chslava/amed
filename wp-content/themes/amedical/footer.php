
<?php include ("includes/parts/newsletter_subscription.php"); ?>

    <footer>
      <div class="ui container grid">

        <div class="column">

          <nav class="ui text menu">
            <div>
              <?php footer_menu(); ?>
            </div>
          </nav>

          <div class="sub-column">

            <div class="footer-contacts">

              <div class="title">
                <?php the_field('contacts_title','option'); ?>
              </div>

              <div class="item">
                <i class="c-icon icon-place-icon"></i>
                <?php the_field("address_title","option"); ?>: <?php the_field("address","option"); ?>
              </div>

              <div class="item">
                <i class="c-icon icon-phone-icon"></i>
                  <?php the_field('phone_title','option'); ?>:
                    <a href="tel:<?php the_field("phone","option"); ?>">
                      <?php the_field("phone","option"); ?>
                    </a>,
                    <?php if (get_field("phone-2","option")): ?>
                      <a href="tel:<?php the_field("phone-2","option"); ?>">
                        <?php the_field("phone-2","option"); ?>
                      </a>
                  <?php endif; ?>
              </div>

              <div class="item">
                <i class="c-icon icon-mail-icon"></i>
                <?php the_field('email_title','option'); ?>:
                <a href="mailto:<?php the_field("email","option"); ?>">
                  <?php the_field("email","option"); ?>
                </a>
              </div>

            </div>

            <div class="follow-us">

              <div class="title">
                <?php the_field('social_title','option'); ?>
              </div>

              <div class="soc-menu">

                <?php if (get_field("facebook","option")): ?>
                  <a id="facebook-share" class="item" target="_blank" href="<?php the_field("facebook","option"); ?>">
                    <i class="soc-icon icon-facebook-icon"></i>
                  </a>
                <?php endif; ?>

                <?php if (get_field("linkedin","option")): ?>
                  <a id="linkedin-share" class="item" target="_blank" href="<?php the_field("linkedin","option"); ?>">
                    <i class="soc-icon icon-linkedin-icon"></i>
                  </a>
                <?php endif; ?>

              </div>

            </div>

          </div>

        </div>
      </div>

      <div class="copyright">
        <?php the_field("copyright_text","option"); ?>
      </div>

    </footer>

    <?php wp_footer(); ?>
  </body>
</html>
