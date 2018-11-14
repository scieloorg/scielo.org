<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<header>
	<div class="container">
		<div class="menu-lang">
			<ul>
				<li class="info">
					<a href="<?= $about_menu_item['link'] ?>"><?= $about_menu_item['text'] ?></a>
				</li>
				<?php foreach ($available_languages as $available_language) : ?>
				<li>
					<a href="<?= $available_language['link'] ?>"><?= $available_language['language'] ?></a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<h1 class="logo-interno">
			<a href="<?= base_url($language) ?>"></a>
		</h1>
	</div>
</header>