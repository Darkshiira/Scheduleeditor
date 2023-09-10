
<div class="schedule">
    <?php
    $weekarray = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday');
    foreach ($weekarray as $value) {
        ?>
        <div class=WD-con>
            <?php
            $the_query = new WP_Query(
                array(
                    'post_type' => 'schedule_content',
                    'posts_per_page' => -1,
                    'orderby' => 'schedule_starttime',
                    'order' => 'asc',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'schedule_weekday',
                            'field' => 'slug',
                            'terms' => $value,
                        )
                    )
                )
            );

            while ($the_query->have_posts()):
                $the_query->the_post();
                ?>
                <div class="schedule-entry">
                    <?php the_title();
                    /*Add boxes, use if to change order*/
                    $lesson_name = get_the_terms($the_query->ID, 'schedule_subject')[0]->name;
                    $weekday_name = get_the_terms($the_query->ID, 'schedule_weekday')[0]->name;
                    $start_time = get_the_terms($the_query->ID, 'schedule_starttime')[0]->name;
                    $end_time = get_the_terms($the_query->ID, 'schedule_endtime')[0]->name;


                    // Display the taxonomy name if previous and current post term name don't match
                    include(plugin_dir_path(__FILE__) . 'schedule-content-template.php');
                    ?>
                </div>
                <?php
            endwhile;
            ?>
            </div>
            <?php


    }
    ?>

    </div>