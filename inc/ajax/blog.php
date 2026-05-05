<?php
/**
 * Load more blog posts via AJAX
 */
function load_more_posts_ajax(): void
{
    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $posts_per_page = isset($_POST['posts_per_page']) ? (int)$_POST['posts_per_page'] : 6;
    
    $args = [
        'post_type' => 'post',
        'posts_per_page' => $posts_per_page,
        'post_status' => 'publish',
        'order' => 'DESC',
        'paged' => $page,
    ];
    
    $posts_query = new WP_Query($args);
    $html = '';
    
    if ($posts_query->have_posts()) {
        while ($posts_query->have_posts()) {
            $posts_query->the_post();
            
            ob_start();
            ?>
            <div class="column column--4 stretch-column">
                <div class="post-item">
                    <div class="post-item__image">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?= esc_url(get_the_post_thumbnail_url()) ?>" alt="<?= esc_attr(get_the_title()) ?>">
                        <?php endif; ?>
                    </div>
                    <div class="post-item__content">
                        <h2><?= esc_html(get_the_title()) ?></h2>
                        <div class="post-item__sub-content">
                            <div class="author">
                                <i class="icon icon-author"></i> <?= esc_html(get_the_author()) ?>
                            </div>
                            <div class="date">
                                <i class="icon icon-calendar-blue"></i> Published on: <?= esc_html(get_the_date('d/M/Y')) ?>
                            </div>
                        </div>
                        <div class="post-item__excerpt">
                            <?= esc_html(wp_trim_words(get_the_content(), 50)) ?>
                        </div>
                        <div class="post-item__button">
                            <a href="<?= esc_url(get_permalink()) ?>" class="btn">
                                Read More <i class="icon icon-arrow-right-orange"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $html .= ob_get_clean();
        }
    }
    
    wp_reset_postdata();
    
    $has_more = $page < $posts_query->max_num_pages;
    
    wp_send_json_success([
        'html' => $html,
        'has_more' => $has_more,
        'current_page' => $page,
        'max_pages' => $posts_query->max_num_pages,
    ]);
}

add_action('wp_ajax_load_more_posts', 'load_more_posts_ajax');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts_ajax');
