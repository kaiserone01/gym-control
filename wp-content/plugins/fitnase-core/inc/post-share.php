<?php

function fitnase_post_share(){

    global $post;

	$post_title   = htmlspecialchars( urlencode( html_entity_decode( esc_attr( get_the_title() ), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
    $post_id    = get_the_ID();
    $post_url   = get_permalink( $post_id );

    ?>

    <div class="share-this-post">
        <h6 class="share-post-title"><?php echo esc_html__('You can share this post!', 'fitnase-core');?></h6>
        <ul class="social-icons ep-list-style">
            <li>
                <a href="https://www.facebook.com/sharer.php?u=<?php echo rawurlencode( esc_url( $post_url  ) ); ?>"  rel="external" target="_blank" class="fb-share">
                    <i class="fab fa-facebook-f"></i><span class="share-site-name"><?php echo esc_html__('Facebook', 'fitnase-core');?></span>
                </a>
            </li>

            <li>
                <a href="https://twitter.com/share?text=<?php echo wp_strip_all_tags( $post_title ); ?>&amp;url=<?php echo rawurlencode( esc_url( $post_url  ) ); ?>" rel="external" target="_blank" class="twitter-share">
                    <i class="fab fa-twitter"></i><span class="share-site-name"><?php echo esc_html__('Twitter', 'fitnase-core');?></span>
                </a>
            </li>

            <li>
                <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo rawurlencode( esc_url( $post_url  ) ); ?>&amp;title=<?php echo wp_strip_all_tags( $post_title ); ?>&amp;summary=<?php echo urlencode( wp_trim_words( strip_shortcodes( get_the_content( $post_id ) ), 40 ) ); ?>&amp;source=<?php echo esc_url( home_url( '/' ) ); ?>"  rel="external" target="_blank" class="linkedin-share">
                    <i class="fab fa-linkedin-in"></i><span class="share-site-name"><?php echo esc_html__('Linkedin', 'fitnase-core');?></span>
                </a>
            </li>

            <li>
                <a href="https://www.pinterest.com/pin/create/button/?url=<?php echo rawurlencode( esc_url( $post_url  ) ); ?>&amp;media=<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post_id ) ); ?>&amp;description=<?php echo urlencode( wp_trim_words( strip_shortcodes( get_the_content( $post_id ) ), 40 ) ); ?>"  rel="external" target="_blank" class="pinterest-share">
                    <i class="fab fa-pinterest"></i>
                </a>
            </li>

            <li>
                <a href="mailto:?subject=<?php echo wp_strip_all_tags($post_title);?>&amp;body=<?php echo esc_url($post_url);?>" rel="external" target="_blank" class="email-share">
                    <i class="fas fa-envelope"></i>
                </a>
            </li>

            <li>
                <a href="#" rel="external" target="_blank" class="print-button">
                    <i class="fas fa-print"></i>
                </a>
            </li>
        </ul>
    </div>

<?php } ?>