<?php
/* General */

$this->settings['general']['theme'] = 'default';

/* Theme Formatting Defaults */

$this->settings['theme']['sectionFormat'] = '
<section class="{{Type}} {{Title}}">
	<div class="left">
		<h2>{{Title}}</h2>
	</div>
	<div class="right">
		{{SectionContent}}
	</div>
</section>
';
$this->settings['theme']['listItemFormat'] = '
<li >{{Text}}</li>
';
$this->settings['theme']['detailListItemFormat'] = '
<article>
	<hgroup>
		<h2>{{Title}}</h2><a class="icon-link" href="{{Link}}"></a>
		<h3>{{SubTitle}}</h3>
		<h4>{{Date}}</h4>
	</hgroup>
	<p>{{Text}}</p>
</article>
';
$this->settings['theme']['highlightListItemFormat'] = '
<article >
	<hgroup>
		<h2 >{{Title}}</h2><a class="icon-link"href="{{Link}}"><a class="icon-picture" href="{{ImagePath}}"></a>
		<h3>{{SubTitle}}</h3>
		<h4>{{Date}}</h4>
	</hgroup>
	<p>{{Text}}</p>
</article>
';
$this->settings['theme']['groupedListGroupFormat'] ="
	<h3>{{Title}}</h3>
		<ul>{{Group}}</ul>
		";
$this->settings['theme']['groupedListItemFormat'] = '
	<li><span>{{Title}}</span><a class="icon-link .btn button"href="{{Link}}"></a> <time>{{Date}}</time></li>
';
/* Advanced */

$this->settings['advanced']['debug_mode'] = false;
$this->settings['advanced']['debug_show_all'] = false;


?>