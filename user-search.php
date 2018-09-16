<?php

/*=======================
Show WordPress Users List with Default & meta query filter + Pagination.
========================*/

// Pagination vars
$current_page = get_query_var('paged') ? (int) get_query_var('paged') : 1;

$users_per_page = 5; // RAISE THIS AFTER TESTING ;)

$search_keyword = '';
$language = '';
$status = '';

$args = array(
    'number' => $users_per_page, // How many per page
    'role'      => 'um_guide',
    'paged' => $current_page,
    'search'         => '*'.$search_keyword.'*',
    'search_columns' => array(
        'user_login',
        'user_nicename',
        'user_email',
        'user_url',
        'display_name',
    ),
        'meta_query' => array(
        'relation' => 'AND',
        array(
            'key'     => 'languages',
            'value'   => $language,
            'compare' => 'LIKE'
        ),
		array(
            'key'     => 'account_status',
            'value'   => $status,
            'compare' => '='
        )
    )    

);



$users = new WP_User_Query( $args );

$total_users = $users->get_total(); // How many users we have in total (beyond the current page)
$num_pages = ceil($total_users / $users_per_page); // How many pages of users we will need

if ( $users->get_results() ) foreach( $users->get_results() as $_user_list )  {

//  Users information will be here.....

}

     



/*=======================
This pagination will be 

Previous Page - Next Page
========================*/


if ( $current_page > 1 ) {
    echo '<a href="'. add_query_arg(array('paged' => $current_page-1)) .'">Previous Page</a>';
}

 // Next page
if ( $current_page < $num_pages ) {
     echo '<a href="'. add_query_arg(array('paged' => $current_page+1)) .'">Next Page</a>';
}




/*=======================
This pagination will be 

1 2 3 ..5 Next
========================*/

$base = get_permalink() . '?' . remove_query_arg('p', $query_string) . '%_%';

echo paginate_links( array(
    'base' => $base, // the base URL, including query arg
    'format' => '&paged=%#%', // this defines the query parameter that will be used, in this case "p"
    'prev_text' => __('&laquo; Previous'), // text for previous page
    'next_text' => __('Next &raquo;'), // text for next page
    'total' => $num_pages, // the total number of pages we have
    'current' => $current_page, // the current page
    'end_size' => 1,
    'mid_size' => 5,
));


?>