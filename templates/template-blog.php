<?php
/**
 * Template Name: Blog Template
 *
 * @package DiveRaid
 */

global $allowedposttags;


$blog = get_field('blog');
$blogTitle = $blog['title'];
$blogSubTitle = $blog['sub_title'];
get_header();
?>

    <section class="blog-section section-content">
      <div class="container">
        <div class="section-content">
          <h2 class="section-title"><?= esc_attr($blogTitle) ?></h2>
          <h3 class="sub-title"><?= esc_attr($blogSubTitle) ?></h3>
        </div>

        <div class="blog-section__posts">
          <div class="row">
            <?php
              $args = [
                  'post_type' => 'post',
                  'posts_per_page' => 6,
                  'post_status' => 'publish',
                  'order' => 'DESC',
              ];
              $posts = get_posts($args);

              if ($posts):
                foreach ($posts as $post) : setup_postdata($post); ?>

                  <div class="column column--4">
                    <div class="post-item">
                      <div class="post-item__image">
                        <?php if (has_post_thumbnail($post->ID)) : ?>
                          <img src="<?= esc_url(get_the_post_thumbnail_url($post->ID)) ?>" alt="">
                        <?php endif; ?>
                      </div>
                      <div class="post-item__content">
                        <h2><?= esc_attr($post->post_title) ?></h2>
                        <div class="post-item__sub-content">
                          <div class="author">
                            <i class="icon icon-author"></i> <?= esc_attr(get_the_author()) ?>
                          </div>
                          <div class="date">
                            <i class="icon icon-calendar-blue"></i> Published on: <?= esc_attr(get_the_date('d/M/Y')) ?>
                          </div>
                        </div>
                        <div class="post-item__excerpt">
                          <?= esc_attr(wp_trim_words(get_the_content(), 50)) ?>
                        </div>
                        <div class="post-item__button">
                          <a href="<?= esc_url(get_permalink($post->ID)) ?>" class="btn btn--primary">
                            Read More <i class="icon icon-arrow-right-orange"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>

                <?php
                endforeach;
              endif;
              wp_reset_postdata();
            ?>
          </div>
        </div>
      </div>
    </section>

<?php
get_footer();
