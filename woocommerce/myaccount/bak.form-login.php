<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

        <?php if( isset( $_GET['action']) && $_GET['action'] == "register") : ?>



                <form method="post" class="login box">

                  <h2 class="headline"><?php _e( 'Sign Up', 'woocommerce' ); ?></h2>

                    <?php do_action( 'woocommerce_register_form_start' ); ?>

                    <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                        <p class="form-row form-row-wide">
                            <label for="reg_username"><?php _e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
                            <input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
                        </p>

                    <?php endif; ?>

                    <p class="form-row form-row-wide">
                        <label for="reg_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
                        <input type="email" class="input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
                    </p>

                    <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                        <p class="form-row form-row-wide">
                            <label for="reg_password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                            <input type="password" class="input-text" name="password" id="reg_password" />
                        </p>

                    <?php endif; ?>

                    <!-- Spam Trap -->
                    <div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

                    <?php do_action( 'woocommerce_register_form' ); ?>
                    <?php do_action( 'register_form' ); ?>

                    <p class="form-row">
                        <?php wp_nonce_field( 'woocommerce-register' ); ?>
                        <input type="submit" class="button" name="register" value="<?php _e( 'Register', 'woocommerce' ); ?>" />
                    </p>
                    <p><a href="<?php echo get_permalink(woocommerce_get_page_id('myaccount')) . '?action=login'; ?>"><?php _e( 'Log In' ); ?></a></p>

                    <?php do_action( 'woocommerce_register_form_end' ); ?>

                </form>


        <?php else : ?>

          <div class="col-xs-12">

                <form method="post" class="login box">

                  <h2 class="headline"><?php _e( 'Login', 'woocommerce' ); ?></h2>

                    <?php do_action( 'woocommerce_login_form_start' ); ?>

                    <p class="form-row form-row-wide">
                        <label for="username"><?php _e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span></label>
                        <input type="text" class="input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
                    </p>
                    <p class="form-row form-row-wide">
                        <label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                        <input class="input-text" type="password" name="password" id="password" />
                    </p>

                    <?php do_action( 'woocommerce_login_form' ); ?>

                    <p class="form-row">
                        <?php wp_nonce_field( 'woocommerce-login' ); ?>
                        <input type="submit" class="button" name="login" value="<?php _e( 'Login', 'woocommerce' ); ?>" />
                        <label for="rememberme" class="inline">
                            <input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
                        </label>
                    </p>
                    <p class="lost_password">
                        <a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
                    </p>

                    <?php do_action( 'woocommerce_login_form_end' ); ?>

                </form>

            <a href="<?php echo get_permalink(woocommerce_get_page_id('myaccount')) . '?action=register'; ?>"><?php _e( 'Register' ); ?></a>

            </div> <!-- end Login Section .col-sm-6 -->

        <?php endif; ?>


<?php endif; ?>