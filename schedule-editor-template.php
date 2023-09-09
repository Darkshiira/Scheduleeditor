<?php

//$custom_query = new WP_Query($args);

$args = array(
    'post_type' => 'schedule_content',
    'posts_per_page' => -1,
);

$loop = new WP_Query($args);

?>
    <div class="shedule">
            <div class="weekday">Monday</div>
            <div class="weekday">Tuesday</div>
            <div class="weekday">Wednesday</div>
            <div class="weekday">Thursday</div>
            <div class="weekday">Friday</div>

        </div>
<?php
while ($loop->have_posts()) {
    $loop->the_post();
    ?>
    
    <div class="schedule-entry">
        <?php the_title();
        $lesson_name = get_the_terms($loop->ID, 'schedule_subject')[0]->name;
        $weekday_name = get_the_terms($loop->ID, 'schedule_weekday')[0]->name;
        $start_time = get_the_terms($loop->ID, 'schedule_starttime')[0]->name;
        $end_time = get_the_terms($loop->ID, 'schedule_endtime')[0]->name;


        // Display the taxonomy name if previous and current post term name don't match

            echo '<h4>' . $lesson_name . '</h4>'; // Add styling and tags to suite your needs
            echo '<p class=schedule-time><span class=schedule-heading>Tid: </span>' . $start_time .' - '. $end_time . '</p>'; // Add styling and tags to suite your needs
        ?>



    </div>

    <?php
}
?>

