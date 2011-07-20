<h2>{$newsItem->title}</h2>

<div class="newsItem">
	<p class="author">{$newsItem->username} ({@$newsItem->time|time})</p>
	<p class="text">{if $themeModule->displayType == 'full'}{@$newsItem->text}{else}{@$newsItem->teaser}{/if}</p>
</div>