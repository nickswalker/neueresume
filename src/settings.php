<?php

$sectionFormat = '<section class="{{Type}} {{Title}}">
	<div class="left">
		<h2>{{Title}}</h2>
	</div>
	<div class="right">
		{{SectionContent}}
	</div>
</section>
';
$listItemFormat = '
<li >{{Text}}</li>
';

$detailListItemFormat = '
<li title="{{Text}}"><span>{{Title}}</span><a class="icon-link .btn button"href="{{Link}}"></a> <time>{{Date}}</time></li>
';

$highlightListItemFormat = '
<article>
	<hgroup>
		<h2 >{{Title}}</h2><a class="icon-link"href="{{Link}}"><a class="icon-picture" href="{{ImagePath}}"></a>
		<h3>{{SubTitle}}</h3>
		<h4>{{Date}}</h4>
	</hgroup>
	<p>{{Text}}</p>
</article>
';

$groupedListGroupFormat ="
	<h3>{{Title}}</h3>
		<ul>{{Group}}</ul>
		";


return array(
    'general' => array(
    	'theme' => null
    ),
    'theme' => array(
    
    	'sectionFormat' => $sectionFormat,
    	'listItemFormat' => $listItemFormat,
    	'detailListItemFormat' => $detailListItemFormat,
    	'highlightListItemFormat' => $highlightListItemFormat,
    	'groupedListGroupFormat' => $groupedListGroupFormat

    ),

	'advanced' => array(
		'debug' => 'false'
	)

);