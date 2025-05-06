<!DOCTYPE html>
<html>HEY
<head>
    <title><?php bloginfo('name'); ?></title>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/media/favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/assets/media/favicon.png">

    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/style.css">
</head>
<body>

<div class="logo"> 
    <a href="<?php echo home_url(); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/media/twentyfiveandthirty_logo_POS.png" alt="Logo">
    </a>
</div>

<div class="project-list">
    <div class="grid-container top-row mobile-hide">
        <div class="grid-item"><p>Selected Projects</p></div>
        <div class="grid-item"><p>Client</p></div>
        <div class="grid-item"><p>Work</p></div>
    </div>

    <?php
    // Query to fetch parent posts
    $parent_posts = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => -1,
        'post_parent'    => 0
    ]);

    if ($parent_posts->have_posts()) :
        while ($parent_posts->have_posts()) : $parent_posts->the_post();
    ?>
        <div class="grid-container project-row">
            <div class="grid-item project-title">
                <p><?php the_title(); ?></p>
                <?php
                // Fetch and display child posts
                $child_posts = get_children([
                    'post_type'   => 'post',
                    'post_parent' => get_the_ID(),
                    'numberposts' => -1
                ]);

                if (!empty($child_posts)) :
                    ?>
                        <ul class="artist-list">
                            <?php foreach ($child_posts as $child) : ?>
                                <li>
                                    <?php echo esc_html($child->post_title); ?>
                                    <?php
                                    // Display the child post's featured image
                                    $child_thumbnail = get_the_post_thumbnail($child->ID, 'full', ['class' => 'artist-image']);
                                    if ($child_thumbnail) {
                                        echo $child_thumbnail;
                                    }
                                    ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
            </div>
            <div class="grid-item client">
                <p>
                    <?php
                    // Display the first category of the parent post
                    $categories = get_the_category();
                    echo !empty($categories) ? esc_html($categories[0]->name) : 'No category';
                    ?>
                </p>
            </div>
            <div class="grid-item work">
                <?php
                // Display tags for the parent post
                $tags = get_the_tags();
                if (!empty($tags)) {
                    foreach ($tags as $tag) {
                        echo '<p>' . esc_html($tag->name) . '</p>';
                    }
                } else {
                    echo '<p>No tags available</p>';
                }
                ?>
            </div>
            <?php if (has_post_thumbnail()) : ?>
                <div class="featured-image">
                    <?php the_post_thumbnail('full'); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php
        endwhile;
        wp_reset_postdata();
    else :
    ?>
        <p>No projects found.</p>
    <?php endif; ?>
</div>

<footer>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const projectRows = document.querySelectorAll('.project-row');
        gsap.from(projectRows, {
            opacity: 0,
            y: 50,
            duration: 0.3,
            stagger: {
                each: 0.2,
                onComplete: function () {
                    gsap.set(this.targets()[0], { clearProps: 'transform' });
                }
            }
        });
    });
</script>
</body>
</html>