<?php /* Template Name: my custom page */

get_header(); ?>
<style type="text/css">
	.cvf_pag_loading {padding: 20px;}
.cvf-universal-pagination ul {margin: 0; padding: 0;}
.cvf-universal-pagination ul li {display: inline; margin: 3px; padding: 4px 8px; background: #FFF; color: black; }
.cvf-universal-pagination ul li.active:hover {cursor: pointer; background: #1E8CBE; color: white; }
.cvf-universal-pagination ul li.inactive {background: #7E7E7E;}
.cvf-universal-pagination ul li.selected {background: #1E8CBE; color: white;}
</style>
<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php $issues = get_all_issues(); 
				//print_me($issues);
			?>
			<form id="filter-entity-form">
				<div class="form-group">
				<label for="entity_name">Entity</label>
				<input type="text" name="entity_name" id="entity_name" class="form-control" value="">
			</div>
			<div class="form-group">
				 <label for="issue-type-id">Issue Type</label>
				<select class="form-control" name="issue_type" id="issue-type-id">
					<option value="">Select issue type</option>
					<?php foreach ($issues as $key => $row) {
						?>
					<option value="<?php echo trim($row->issue_type); ?>"> <?php echo $row->issue_type; ?></option>
						<?php

					} ?>
				</select>
			</div>
				 <button type="submit" id="filter-entity" class="btn btn-default">Go!</button>
			</form>

		<div class = "cvf_pag_loading">
            <div class = "cvf_universal_container">
                <div class="cvf-universal-content">
                	<?php do_action('load_data'); ?>
                </div>
            </div>
        </div>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();?>



