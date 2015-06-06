<?php hybrid_do_atomic( 'main_bottom' ); ?>
</section> <!-- .main -->

<?php get_sidebar( 'primary' ); ?>

<footer class="site-footer" role="contentinfo">
	<?php hybrid_do_atomic( 'footer_top' ); ?>
    <div class="design-credit">
        <span>
            <?php
                $site_url = 'https://www.competethemes.com/apex/';
                $footer_text = sprintf( __( '<a href="%s">Apex WordPress Theme</a> by Compete Themes', 'apex' ), esc_url( $site_url ) );
                $footer_text = apply_filters( 'ct_apex_footer_text', $footer_text );
                echo $footer_text;
            ?>
        </span>
    </div>
</footer>
</div>
</div><!-- .overflow-container -->

<?php hybrid_do_atomic( 'body_bottom' ); ?>

<?php wp_footer(); ?>

</body>
</html>