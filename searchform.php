<?php
/**
 * default search form
 */

global $___bs4_search_form_count;
if (!isset($___bs4_search_form_count)) $___bs4_search_form_count = 0;
$___bs4_search_form_count += 1;

?>
<form method="get" id="search-form-<?= $___bs4_search_form_count ?>"
	action="<?= esc_url(home_url('/')) ?>" class="form search-from">
	<div class="form-group row search-inputs">
		<label for="s" class="col-sm-2 form-control-label search-label">Search for</label>
		<div class="col-sm-10 search-input-div">
			<input type="search" name="s" class="form-control search-input"
				placeholder="Search &hellip;" value="<?= get_search_query() ?>"
				autosave="search-<?= $___bs4_search_form_count ?>"  autocorrect="on">
		</div>
	</div>
	<div class="form-group row search-buttons">
		<div class="offset-sm-2 col-sm-10 search-button-div">
			<button type="submit" class="btn btn-primary search-button"><?php
			bs4_i('search', '<span class="hidden-sm-down">', ' </span>'); ?>Search</button>
		</div>
	</div>
</form>
