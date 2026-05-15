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

function formatDateWithOrdinal($dateStr): string
{
  $timestamp = strtotime($dateStr);
  $day = (int) date('j', $timestamp);

  $suffix = 'th';
  if (!in_array($day % 100, [11, 12, 13])) {
    switch ($day % 10) {
      case 1: $suffix = 'st'; break;
      case 2: $suffix = 'nd'; break;
      case 3: $suffix = 'rd'; break;
    }
  }

  return $day . $suffix;
}

function formatEventDate($startDateStr, $endDateStr = ''): string
{
  $startTimestamp = strtotime($startDateStr);
  $startDay = formatDateWithOrdinal($startDateStr);
  $startMonth = date('F', $startTimestamp);
  $startYear = date('Y', $startTimestamp);

  if (empty($endDateStr)) {
    return $startDay . ' ' . $startMonth . ' ' . $startYear;
  }

  $endTimestamp = strtotime($endDateStr);
  $endDay = formatDateWithOrdinal($endDateStr);
  $endMonth = date('F', $endTimestamp);
  $endYear = date('Y', $endTimestamp);

  // Same month and year: "21st - 24th May 2026"
  if ($startMonth === $endMonth && $startYear === $endYear) {
    return $startDay . ' - ' . $endDay . ' ' . $endMonth . ' ' . $endYear;
  }

  // Different month: "30th May 2026 - 3rd June 2026"
  return $startDay . ' ' . $startMonth . ' ' . $startYear . ' - ' . $endDay . ' ' . $endMonth . ' ' . $endYear;
}

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

  /**
   * Only for Crossover page `template-crossover.php`
   *
   * @param array $array
   * @param bool $isSwiper
   * @return void
   */
function getMiddleContentPosts(array $array, bool $isSwiper = false): void
{
  foreach ($array as $key => $post): ?>
    <?php
    $gridType = $post['grid_type'];
    $column = match ($gridType) {
      'col_2' => 'column--6',
      'col_3' => 'column--4',
      default => 'column--12',
    };
    ?>
    <div class="<?= esc_attr($isSwiper ? 'swiper-slide' : 'column stretch-column '.$column) ?>">
      <div class="crossover-content__wrap">
        <div class="crossover-content__wrap-image" style="background-image: url(<?= esc_attr($post['image']) ?>)"></div>
        <div class="background-filter black light"></div>
        <div class="crossover-content__wrap-detail">
          <h4><?= wp_kses_post($post['title']) ?></h4>
          <div class="crossover-content__wrap-detail__description">
            <?= wp_kses_post($post['description']) ?>
          </div>
          <?php if ($post['button_url'] !== null && $post['button_title'] !== null): ?>
          <div class="crossover-content__wrap-detail__button">
            <a href="<?= esc_url($post['button_url']) ?>">
              <?= esc_attr($post['button_title']) ?>
              <i class="icon icon-arrow-right"></i>
            </a>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

  <?php endforeach;
}

/**
 * Only for Front page
 *
 * @param array $array
 * @param bool $swiper
 * @return void
 */
function getFrontPageContentPosts(mixed $array, bool $swiper = false): void
{
  foreach ($array as $post) : setup_postdata($post); ?>
    <article class="site-blog__post  <?= esc_attr($swiper ? 'swiper-slide' : '') ?>">
      <div class="site-blog__post-image">
        <img src="<?= esc_url(get_the_post_thumbnail_url($post->ID)) ?>" alt="<?= esc_attr(get_the_title($post->ID)) ?>">
      </div>
      <h3 class="site-blog__post-title"><?= esc_attr(get_the_title($post->ID)) ?></h3>
      <div class="site-blog__post-description">
        <?= wp_kses_post(get_the_excerpt($post->ID)) ?>
      </div>
      <div class="site-blog__post-button">
        <a href="<?= esc_url(get_permalink($post->ID)) ?>">
          Read more
          <i class="icon icon-arrow-right-orange"></i>
        </a>
      </div>
    </article>
  <?php
  endforeach;
}

/**
 * Only for the Course of the Month page
 *
 * @param array $array
 * @param bool $swiper
 * @return void
 */
function getTrainingPostList(array $array, bool $swiper = false): void
{
  if ($array) : ?>
    <?php foreach ($array as $post) : ?>
      <article class="posts__wrap row  <?= esc_attr($swiper ? 'swiper-slide' : '') ?>">
        <div class="posts__wrap-image column column--4">
          <img src="<?= esc_url($post['image']) ?>" alt="<?= esc_attr($post['title']) ?>">
        </div>
        <div class="posts__wrap-details column column--8">
          <h3 class="posts__wrap-details-title"><?= esc_attr($post['title']) ?></h3>
          <div class="posts__wrap-details-sub-title">
            <span class="sub-title"><?= esc_attr($post['sub_title']) ?></span>
          </div>
          <div class="posts__wrap-details-description">
            <?= wp_kses_post($post['description']) ?>
          </div>
          <div class="posts__wrap-details-button">
            <a href="<?= esc_url($post['button_link']) ?>">
              <?= esc_attr($post['button']) ?> <i class="icon icon-arrow-right"></i>
            </a>
          </div>
        </div>
      </article>
    <?php endforeach;
  endif;
}

/**
 * @param mixed $posts
 * @param bool $swiper
 * @return void
 */
function getDiveCentrePosts(mixed $posts, bool $swiper = false): void
{
  if ($posts) :
    foreach ($posts as $post) : setup_postdata($post); ?>
      <article class="divers__wrap row <?= esc_attr($swiper ? 'swiper-slide' : '') ?>">
        <div class="divers__wrap-image column column--4">
          <?php if (has_post_thumbnail($post->ID)) : ?>
            <img src="<?= esc_url(get_the_post_thumbnail_url($post->ID)) ?>" alt="<?= esc_attr($post->post_title) ?>">
          <?php endif; ?>
        </div>
        <div class="divers__wrap-details column column--8">
          <h3 class="divers__wrap-details-title"><?= esc_attr($post->post_title) ?></h3>
          <div class="divers__wrap-details-description">
            <?= wp_kses_post($post->post_content) ?>
          </div>
          <div class="divers__wrap-details-contacts">
            <?php if (get_field('website_url', $post->ID) !== null && get_field('website_url', $post->ID) !== ''): ?>
              <a href="<?= esc_url(get_field('website_url', $post->ID)) ?>">
                <i class="icon icon-website"></i>
              </a>
            <?php endif; ?>
            <?php if (get_field('email', $post->ID) !== null && get_field('email', $post->ID) !== ''): ?>
              <a href="<?= wp_kses_post('mailto:'.get_field('email', $post->ID)) ?>">
                <i class="icon icon-email-gray"></i>
              </a>
            <?php endif; ?>
            <?php if (get_field('facebook_url', $post->ID) !== null && get_field('facebook_url', $post->ID) !== ''): ?>
              <a href="<?= esc_url(get_field('facebook_url', $post->ID)) ?>">
                <i class="icon icon-facebook-gray"></i>
              </a>
            <?php endif; ?>
            <?php if (get_field('instagram_url', $post->ID) !== null && get_field('instagram_url', $post->ID) !== ''): ?>
              <a href="<?= esc_url(get_field('instagram_url', $post->ID)) ?>">
                <i class="icon icon-instagram-gray"></i>
              </a>
            <?php endif; ?>
          </div>
          <div class="divers__wrap-details-button">
            <a href="<?= esc_url(get_permalink($post->ID)) ?>">
              See more <i class="icon icon-arrow-right"></i>
            </a>
          </div>
        </div>
      </article>
    <?php endforeach;
    wp_reset_postdata();
  endif;
}
