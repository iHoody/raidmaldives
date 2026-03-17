<?php
/**
 * Template Name: Blog Template
 *
 * @package DiveRaid
 */

global $allowedposttags;

get_header();
?>
    
    <div class="site-content">
        <?php
        $args = [
            'post_type' => 'post',
            'posts_per_page' => 8,
            'post_status' => 'publish',
        ];
        $posts = get_posts($args);
        
        if ($posts):
            foreach ($posts as $post) : setup_postdata($post); ?>
            
            <div class="post-item">
                <?= esc_attr($post->post_title) ?>
            </div>
        
        <?php
            endforeach;
        endif;
        wp_reset_postdata();
        ?>
    </div>

<?php
get_footer();
