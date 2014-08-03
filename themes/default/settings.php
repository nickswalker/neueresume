<?php

$sectionFormat = '
<section class="{{Type}} {{Title}}">
	<div class="left">
		<h2>{{Title}}</h2>
	</div>
	<div class="right">
		{{SectionContent}}
	</div>
</section>
';

$highlightListItemFormat = '
<article>
	<hgroup>
		<h2 >{{Title}}</h2><a class="ion-link"href="{{Link}}"><a class="ion-image" href="{{ImagePath}}"></a>
		<h3>{{SubTitle}}</h3>
		<h4>{{Date}}</h4>
	</hgroup>
	<p>{{Text}}</p>
</article>
';

return array(
	'theme' => array(
		'sectionFormat' => $sectionFormat,
		'highlightListItemFormat' => $highlightListItemFormat
	),
	'advanced' => array(
		'debug' => false
	)
);