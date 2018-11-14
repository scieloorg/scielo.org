<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<form class="form-inline">
    <div class="form-group form-group-pagination">
		<label for="limit"><?= lang('journals_page_limit') ?></label>
		<select name="limit" id="limit" class="form-control journals-limit">
			<option value="50"  <?php if ($this->input->get('limit', true) == 50) : ?>selected<?php endif ?>>50</option>
			<option value="100" <?php if ($this->input->get('limit', true) == 100) : ?>selected<?php endif ?>>100</option>
			<option value="200" <?php if ($this->input->get('limit', true) == 200) : ?>selected<?php endif ?>>200</option>
		</select>
		<label for="limit"><?= lang('journals_items_by_page') ?></label>
    </div>
</form>
