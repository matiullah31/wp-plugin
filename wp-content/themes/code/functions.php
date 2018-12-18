<?php 


/* custom page code start */
function my_custom_page(){
global $wpdb;
// this adds the prefix which is set by the user upon instillation of wordpress
$table_name1 = "entity_table";
$table_name2 = "issue_type";
// this will get the data from your table
$sql= "select entity.*, issue.* from {$table_name1} as entity inner join {$table_name2} as issue on entity.id =	 issue.entity_id";
$retrieve_data = $wpdb->get_results($sql);
//print_me($retrieve_data);
return $retrieve_data;

}

function get_all_issues(){
global $wpdb;
// this adds the prefix which is set by the user upon instillation of wordpress
$table_name = "issue_type";
// this will get the data from your table
$sql= "select DISTINCT(issue_type) from {$table_name}";
$retrieve_data = $wpdb->get_results($sql);
//print_me($retrieve_data);
return $retrieve_data;

}

add_action('wp_footer', 'my_action_javascript' ); // Write our JS below here

function my_action_javascript() { 
 $ajaxurl = admin_url( 'admin-ajax.php' );
?>
	
<script type="text/javascript">	
 
 var ajax_url = '<?php echo $ajaxurl; ?>';

jQuery(document).ready(function($) {
	$("body").on('click','#filter-entity',function(){
		var entity_name = $('#entity_name').val();
		var issue_type = $('#issue-type-id').val();

		var data = {
			'action': 'my_action',
			'data': {entity_name: entity_name, issue_type: issue_type, page:1},
		};
		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
		$.post(ajax_url, data, function(response) {
			 $(".cvf_universal_container").html(response);
		});

	});

	    function my_custom_page_record(page){
        // Start the transition
        $(".cvf_pag_loading").fadeIn().css('background','#ccc');
        var entity_name = '';
        var issue_type = '';
        // Data to receive from our server
        // the value in 'action' is the key that will be identified by the 'wp_ajax_' hook 
        var data = {
            'data': {page: page,entity_name: entity_name, issue_type: issue_type},
            'action': "my_action"
        };

        // Send the data
        $.post(ajax_url, data, function(response) {
            // If successful Append the data into our html container
            $(".cvf_universal_container").html(response);
            // End the transition
            $(".cvf_pag_loading").css({'background':'none', 'transition':'all 1s ease-out'});
        });
    }
    	   // Load page 1 as the default
        // my_custom_page_record(1);
             // Handle the clicks
        $('body').on('click','.cvf_universal_container .cvf-universal-pagination li.active',function(){
            var page = $(this).attr('p');
            my_custom_page_record(page);

        });

});


</script>
 <?php
}

add_action( 'wp_ajax_my_action', 'my_action' );

add_action( 'wp_ajax_nopriv_my_action', 'my_action' ); 

function my_action() {

    global $wpdb;
    // Set default variables
    $output = '';
    if(isset($_POST['data'])){
    	$data = $_POST['data'];
        // Sanitize the received page   
        $page = isset($data['page'])?sanitize_text_field($data['page']):1;
        $entity_name = sanitize_text_field($data['entity_name']);
        $issue_type  = sanitize_text_field($data['issue_type']);
        // Set the table where we will be querying data
        $page -= 1;
        // Set the number of results to display
        $per_page = 3;
        $start = $page * $per_page;

        $table_name1 = "entity_table";
		$table_name2 = "issue_type";

         $condition = '';
         if(!empty($entity_name) && !empty($issue_type)){

	        $sql= "select entity.*, issue.* from {$table_name1} as entity inner join {$table_name2} as issue on entity.id =	 issue.entity_id where entity.entity_name like = %s and issue.issue_type like %s LIMIT %d, %d";
	        $all_records = $wpdb->get_results($wpdb->prepare($sql,'%'.$wpdb->esc_like($entity_name).'%','%'.$wpdb->esc_like($issue_type).'%', $start, $per_page ) );
	        $count = $wpdb->get_var($wpdb->prepare("select count(entity.id) from {$table_name1} as entity inner join {$table_name2} as issue on entity.id = issue.entity_id where entity.entity_name like %s and issue.issue_type like %s", '%'.$wpdb->esc_like($entity_name).'%','%'.$wpdb->esc_like($issue_type).'%'));

         }elseif(!empty($entity_name)){

	        $sql= "select entity.*, issue.* from {$table_name1} as entity inner join {$table_name2} as issue on entity.id =	 issue.entity_id where entity.entity_name like %s LIMIT %d, %d";
	        $all_records = $wpdb->get_results($wpdb->prepare($sql,'%'.$wpdb->esc_like($entity_name).'%', $start, $per_page ) );
	        $count = $wpdb->get_var($wpdb->prepare("select count(entity.id) from {$table_name1} as entity inner join {$table_name2} as issue on entity.id = issue.entity_id where entity.entity_name like %s", '%'.$wpdb->esc_like($entity_name).'%',$issue_type ) );

         }elseif(!empty($issue_type)){

         	 $sql= "select entity.*, issue.* from {$table_name1} as entity inner join {$table_name2} as issue on entity.id = issue.entity_id where issue.issue_type like %s LIMIT %d, %d";
	        $all_records = $wpdb->get_results($wpdb->prepare($sql,'%'.$wpdb->esc_like($issue_type).'%', $start, $per_page ) );
	        $count = $wpdb->get_var($wpdb->prepare("select count(entity.id) from {$table_name1} as entity inner join {$table_name2} as issue on entity.id = issue.entity_id where issue.issue_type like %s",'%'.$wpdb->esc_like($issue_type).'%' ) );


         }else {
        $sql= "select entity.*, issue.* from {$table_name1} as entity inner join {$table_name2} as issue on entity.id =	 issue.entity_id LIMIT %d, %d";
        $all_records = $wpdb->get_results($wpdb->prepare($sql, $start, $per_page ) );
        $count = $wpdb->get_var($wpdb->prepare("select count(entity.id) from {$table_name1} as entity inner join {$table_name2} as issue on entity.id = issue.entity_id", array() ) );
         }
       
        
         $output = dynamic_html_table($all_records);

         ajax_pagination($page,$count,$per_page,$cur_page,$output);

    }
    // Always exit to avoid further execution
    exit();
}

function ajax_pagination($page,$count,$per_page,$cur_page,$output){
		//$page = $page;
        $cur_page = $page+1;
        //$page -= 1;
        // Set the number of results to display
        //$per_page = $per_page;
        $previous_btn = true;
        $next_btn = true;
        $first_btn = true;
        $last_btn = true;
        //$start = $page;
         // Optional, wrap the output into a container
       // $output = '';
        $output = "<div class='cvf-universal-content'>" . $output . "</div><br class = 'clear' />";

        $no_of_paginations = ceil($count / $per_page);

        if ($cur_page >= 7) {
            $start_loop = $cur_page - 3;
            if ($no_of_paginations > $cur_page + 3)
                $end_loop = $cur_page + 3;
            else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
                $start_loop = $no_of_paginations - 6;
                $end_loop = $no_of_paginations;
            } else {
                $end_loop = $no_of_paginations;
            }
        } else {
            $start_loop = 1;
            if ($no_of_paginations > 7)
                $end_loop = 7;
            else
                $end_loop = $no_of_paginations;
        }
        $pag_container = '';
        // Pagination Buttons logic     
        $pag_container .= "
        <div class='cvf-universal-pagination'>
            <ul>";

        if ($first_btn && $cur_page > 1) {
            $pag_container .= "<li p='1' class='active'>First</li>";
        } else if ($first_btn) {
            $pag_container .= "<li p='1' class='inactive'>First</li>";
        }

        if ($previous_btn && $cur_page > 1) {
            $pre = $cur_page - 1;
            $pag_container .= "<li p='$pre' class='active'>Previous</li>";
        } else if ($previous_btn) {
            $pag_container .= "<li class='inactive'>Previous</li>";
        }
        for ($i = $start_loop; $i <= $end_loop; $i++) {

            if ($cur_page == $i)
                $pag_container .= "<li p='$i' class = 'selected' >{$i}</li>";
            else
                $pag_container .= "<li p='$i' class='active'>{$i}</li>";
        }

        if ($next_btn && $cur_page < $no_of_paginations) {
            $nex = $cur_page + 1;
            $pag_container .= "<li p='$nex' class='active'>Next</li>";
        } else if ($next_btn) {
            $pag_container .= "<li class='inactive'>Next</li>";
        }

        if ($last_btn && $cur_page < $no_of_paginations) {
            $pag_container .= "<li p='$no_of_paginations' class='active'>Last</li>";
        } else if ($last_btn) {
            $pag_container .= "<li p='$no_of_paginations' class='inactive'>Last</li>";
        }

        $pag_container = $pag_container . "
            </ul>
        </div>";

        // We echo the final output
        echo 
        '<div class = "cvf-pagination-content">' . $output . '</div>' . 
        '<div class = "cvf-pagination-nav">' . $pag_container . '</div>';


}
function dynamic_html_table($data){
	
		$output = '';
	    $output .= '<table class="table table-bordered">';
		$output .=  '<thead>';
		$output .=  '<tr>';
		$output .=  '<th>Entity Name</th>';
		$output .=  '<th>Entity Address</th>';
		$output .=  '<th>Issue type</th>';
		$output .=  '</tr>';
		$output .=  '</thead>';
		$output .=  '<tbody>';
		if($data){
			foreach($data as $row): 
			$output .=  '<tr>';
			$output .=  '<td>'.$row->entity_name.'</td>';
			$output .=  '<td>'.$row->entity_address.'</td>';
			$output .=  '<td>'.$row->issue_type.'</td>';
			$output .=  '</tr>';
			 endforeach;
			 }else {
		$output .='<tr><td colspan="3" style="text-align:center;"> Record Not Found!</td></tr>';
			 }
		$output .=  '</tbody>';
		$output .=  '</table>';
		return $output;
	
}
function get_my_custom_first_page(){

		 global $wpdb;
    // Set default variables

    	$output = '';
        // Sanitize the received page   
        $page = 1;
        $entity_name = '';
        $issue_type  = '';
        $page -= 1;
        // Set the number of results to display
        $per_page = 3;
        $start = $page * $per_page;

        // Set the table where we will be querying data
        $table_name1 = "entity_table";
		$table_name2 = "issue_type";

     
        $all_records = $wpdb->get_results($wpdb->prepare("select entity.*, issue.* from {$table_name1} as entity inner join {$table_name2} as issue on entity.id = issue.entity_id LIMIT %d, %d", $start, $per_page ) );
        $count = $wpdb->get_var($wpdb->prepare("select count(entity.id) from {$table_name1} as entity inner join {$table_name2} as issue on entity.id = issue.entity_id", array() ) );
       
        
		$output = dynamic_html_table($all_records);
           
  		ajax_pagination($page,$count,$per_page,$cur_page,$output);

   
	
}
/* custom page code end*/