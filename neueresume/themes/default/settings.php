<?php
/* Specific Theme Settings */

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
		<h2>{{Title}}</h2><a class="ion-link" href="{{Link}}"></a>
		<h3>{{SubTitle}}</h3>
		<h4>{{Date}}</h4>
	</hgroup>
	<p>{{Text}}</p>
</article>
';
$this->settings['theme']['highlightListItemFormat'] = '
<article >
	<hgroup>
		<h2 >{{Title}}</h2><a class="icon-link"href="{{Link}}"><a class="icon-image" href="{{ImagePath}}"></a>
		<h3>{{SubTitle}}</h3>
		<h4>{{Date}}</h4>
	</hgroup>
	<p>{{Text}}</p>
</article>
';
?>