<?php do_action( 'main_bottom' ); ?>
</section> <!-- .main -->

<?php get_sidebar( 'primary' ); ?>

<footer class="site-footer" role="contentinfo">
	<?php do_action( 'footer_top' ); ?>
    <div class="design-credit">
        <span>
            <?php
                $site_url = 'https://www.competethemes.com/apex/';
                $footer_text = sprintf( __( '<a href="%s">Apex WordPress Theme</a> by Compete Themes', 'apex' ), esc_url( $site_url ) );
                $footer_text = apply_filters( 'ct_apex_footer_text', $footer_text );
                echo wp_kses_post( $footer_text );
            ?>
        </span>
    </div>
</footer>
</div>
</div><!-- .overflow-container -->

<?php do_action( 'body_bottom' ); ?>

<?php wp_footer(); ?>

</body>
</html>