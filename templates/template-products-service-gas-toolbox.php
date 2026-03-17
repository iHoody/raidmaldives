<?php
/**
 * Template Name: Products and Services - Toolbox Template
 *
 * @package DiveRaid
 */

global $allowedposttags;

$banner = get_field('banner');
$bannerBackground = $banner['background_image'];
$bannerTitle = $banner['title'];
$bannerSubTitle = $banner['sub_title'];

$middleContent = get_field('middle_content');
$youtube = $middleContent['youtube'];
$youtubeTitle = $youtube['title'];
$youtubeSubTitle = $youtube['sub_title'];
$youtubeLink = $youtube['youtube_url'];

$resources = $middleContent['resources'];
$resourcesTitle = $resources['title'];
$resourcesList = $resources['downloadable_content'];

$onlineTools = $middleContent['online_tools'];
$onlineToolsTitle = $onlineTools['title'];
$onlineToolsList = $onlineTools['tools'];
get_header();
?>
    
    <div class="site-content">
        
        <section class="products-services-banner site-banner" style="background-image: url('<?= esc_attr($bannerBackground) ?>');">
            <div class="container site-banner__container products-services-container">
                <div class="site-information">
                    <h1 class="banner-title"><?= esc_attr($bannerTitle) ?></h1>
                    <p class="banner-description"><?= esc_attr($bannerSubTitle) ?></p>
                </div>
            </div>
        </section>
        
        <section class="resources products-services-section">
            <div class="container">
                
                <div class="row">
                    <div class="column column--12">
                        
                        <div class="resources__content products-services__content">
                            
                            <div class="resources__content-youtube">
                                <a href="<?= esc_url($youtubeLink ?? '#') ?>">
                                    <div class="resources__content-youtube-details">
                                        <div class="image">
                                            <span class="icon icon-youtube"></span>
                                        </div>
                                        <div class="details">
                                            <h3 class="title"><?= esc_attr($youtubeTitle) ?></h3>
                                            <p class="sub-title"><?= esc_attr($youtubeSubTitle) ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="resources__title-header">
                                <div class="header--content">
                                    <span class="title-icon downloadable-tools"></span>
                                    <h3><?= esc_attr($resourcesTitle) ?></h3>
                                    <?php $totalCount = count($resourcesList); ?>
                                    <p><?= esc_attr($totalCount) ?> <?= esc_attr($totalCount > 1 ? 'files' : 'file') ?></p>
                                </div>
                            </div>
                            
                            <div class="resources__downloadable">
                                <div class="row">
                                    <?php if ($resourcesList) : ?>
                                        <?php foreach ($resourcesList as $resource) : ?>
                                            <div class="column column--4">
                                                <div class="resources__downloadable-item">
                                                    <div class="resources__downloadable-item__header">
                                                        <div class="header-icon"></div>
                                                        <div class="header-category <?= esc_attr(strtolower($resource['categories'])) ?>">
                                                            <h5><?= esc_attr(ucfirst($resource['categories'])) ?></h5>
                                                        </div>
                                                    </div>
                                                    <div class="resources__downloadable-item__content">
                                                        <h3><?= esc_attr($resource['title']) ?></h3>
                                                        <p><?= esc_attr($resource['sub_title']) ?></p>
                                                    </div>
                                                    <div class="resources__downloadable-item__footer">
                                                        <?php
                                                            $downloadLink = $resource['file_upload'];
                                                            if ($downloadLink) {
                                                                $downloadLink = $resource['external_downloadable_file_url'];
                                                            }
                                                        ?>
                                                        <a href="<?= esc_url($resource['file_upload']) ?>" class="resources__downloadable-item-link" download>
                                                            <i class="icon icon-download-white"></i>
                                                            Download
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="resources__title-header">
                                <div class="header--content">
                                    <span class="title-icon online-tools"></span>
                                    <h3><?= esc_attr($onlineToolsTitle) ?></h3>
                                    <?php $totalToolsCount = count($onlineToolsList); ?>
                                    <p><?= esc_attr($totalToolsCount) ?> <?= esc_attr($totalToolsCount > 1 ? 'files' : 'file') ?></p>
                                </div>
                            </div>
                            
                            <div class="resources__online-tools">
                                <div class="row">
                                    <?php if ($onlineToolsList) : ?>
                                        <?php foreach ($onlineToolsList as $item) : ?>
                                            <div class="column column--4">
                                                <div class="resources__online-tools-item">
                                                    <div class="resources__online-tools-item__icon">
                                                        <div class="header-icon">
                                                          <img src="<?= esc_attr($item['image']) ?>" alt="<?= esc_attr($item['title']) ?>">
                                                        </div>
                                                    </div>
                                                    <div class="resources__online-tools-item__content">
                                                        <h3><?= esc_attr($item['title']) ?></h3>
                                                        <p><?= esc_attr($item['sub_title']) ?></p>
                                                    </div>
                                                    <div class="resources__online-tools-item__link">
                                                        <a href="<?= esc_url($item['url']) ?>" class="resources__online-tools-item-link">
                                                            <i class="icon icon-link"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                </div>
            
            </div>
        </section>
    
    </div>

<?php
get_footer();
