<?php
/**
 * Enqueue scripts and styles.
 *
 * @package DiveRaid
 */

defined( 'ABSPATH' ) || exit;

function accountClass($classes)
{
  if (is_page('events')) {
    $classes[] = 'woocommerce-account';
  }

  return $classes;
}

add_filter('body_class', 'accountClass');

function contentPostList($postType, $taxonomyArgs = []): void
{
    global $allowedposttags;
    
    $args = [
        'post_type' => $postType,
        'posts_per_page' => 6,
    ];
    
    if (! empty($taxonomyArgs)) {
        $args['tax_query'] = $taxonomyArgs;
    }
    
    $posts = get_posts($args);
    
    if ($posts):
        foreach ($posts as $post) : setup_postdata($post); ?>
            
            <article class="courses__post row">
                <div class="courses__post-image column column--4">
                    <img src="<?= esc_url(has_post_thumbnail($post->ID)  ? get_the_post_thumbnail_url($post->ID) : 'https://placehold.co/600x400?text=Hello+World') ?>" alt="<?= esc_attr($post->post_title) ?>">
                </div>
                <div class="courses__post-details column column--8">
                  <a class="courses__post-details-link" href="<?= esc_url(get_permalink($post->ID)) ?>">
                    <h3 class="courses__post-details-title"><?= esc_attr($post->post_title) ?></h3>
                  </a>
                    <div class="courses__post-details-price">
                        <i class="icon icon-price"></i>
                        <span class="price"><?= esc_attr('£'.get_field('course_detail', $post->ID)['price'].' per session') ?></span>
                    </div>
                    <div class="courses__post-details-description">
                        <?= wp_kses(get_field('excerpt') ?? wp_trim_words($post->post_content), $allowedposttags) ?>
                    </div>
                    <div class="courses__post-details-button">
                        <?php
                          $eventDateTime = '';

                          $eventDate = get_field('event_date', $post->ID);
                          $eventStartTime = get_field('event_start_time', $post->ID);
                          $eventEndTime = get_field('event_end_time', $post->ID);

                          if (isset($eventDate)) {
                            $eventDateTime = $eventDate;
                          }

                          if ($eventStartTime !== '') {
                            $eventDateTime = $eventDate . ' ' . $eventStartTime;
                          }

                          if ($eventStartTime !== '' && $eventEndTime !== '') {
                            $eventDateTime = $eventDate . ' ' . $eventStartTime . ' - ' . $eventEndTime;
                          }
                        ?>
                      <a href="<?= esc_url(get_permalink($post->ID)) ?>" class="dive-events__item-button view-details">View Details <i class="icon icon-arrow-right"></i></a>
                      <a href="#" class="dive-events__item-button book-now"
                           data-post-id="<?= esc_attr($post->ID) ?>"
                           data-event-date="<?= esc_attr($eventDate) ?>"
                           data-event-start-time="<?= esc_attr($eventStartTime) ?>"
                           data-event-end-time="<?= esc_attr($eventEndTime) ?>"
                           data-event-name="<?= esc_attr($post->post_title) ?>">
                            Enroll this Course
                        </a>
                    </div>
                </div>
            </article>
        
        <?php
        endforeach;
    endif;
    wp_reset_postdata();
}

function getPostContentTypes(int $postId): void
{
  ?>
    <div class="row">
      <?php
        // Load dive event types for this event
        $eventTypes = \Inc\Model\DiveEventType::getByPostId($postId);

        if (!empty($eventTypes)) : ?>
          <?php foreach ($eventTypes as $type) : ?>
            <div class="column column--4">
              <div class="event-card">
                <div class="event-card__details">
                  <h3><?php echo esc_html($type['name']); ?></h3>
                  <div class="event-card__price">
                    <i class="icon icon-price"></i> £<?php echo number_format((float) $type['price'], 2); ?>
                  </div>
                </div>
                <div class="event-card__availability">
                  <?php
                    $remaining = (int) $type['capacity'] - (int) $type['booked'];
                    printf(
                        __('%d of %d spots available', 'diveraid-booking'),
                        $remaining,
                        $type['capacity']
                    );
                  ?>
                </div>
                <div class="event-card__button">
                  <?php if ($remaining > 0 && $type['product_id']) : ?>
                    <?php
                    $eventDateTime = '';

                    $eventDate = get_field('event_date', get_the_ID());
                    $eventStartTime = get_field('event_start_time', get_the_ID());
                    $eventEndTime = get_field('event_end_time', get_the_ID());

                    if (isset($eventDate)) {
                      $eventDateTime = $eventDate;
                    }

                    if ($eventStartTime !== '') {
                      $eventDateTime = $eventDate . ' ' . $eventStartTime;
                    }

                    if ($eventStartTime !== '' && $eventEndTime !== '') {
                      $eventDateTime = $eventDate . ' ' . $eventStartTime . ' - ' . $eventEndTime;
                    }
                    ?>
                    <a href="#" class="dive-events__item-button book-now"
                       data-post-id="<?= esc_attr(get_the_ID()) ?>"
                       data-event-date="<?= esc_attr($eventDate) ?>"
                       data-event-start-time="<?= esc_attr($eventStartTime) ?>"
                       data-event-end-time="<?= esc_attr($eventEndTime) ?>"
                       data-event-name="<?= esc_attr(get_the_title()) ?>">
                      <?php esc_html_e('Book Now', 'diveraid-booking'); ?>
                    </a>
                  <?php elseif ($remaining <= 0) : ?>
                    <span class="sold-out"><?php _e('Sold Out', 'diveraid-booking'); ?></span>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php
}