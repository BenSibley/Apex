<?php do_action( 'main_bottom' ); ?>
</section> <!-- .main -->

<?php get_sidebar( 'primary' ); ?>

<footer id="site-footer" class="site-footer" role="contentinfo">
	<?php do_action( 'footer_top' ); ?>
	<div class="design-credit">
        <span>
            <?php
            $footer_text = sprintf( __( '<a href="%1$s">%2$s WordPress Theme</a> by Compete Themes', 'apex' ), 'https://www.competethemes.com/apex/', wp_get_theme( get_template() ) );
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