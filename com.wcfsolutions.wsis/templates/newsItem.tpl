<h2 class="headline">{$newsItem->title}</h2>
<p class="author">{$newsItem->username} ({@$newsItem->time|time})</p>
<p class="newsItem">{if $themeModule->displayType == 'full'}{@$newsItem->text}{else}{@$newsItem->teaser}{/if}</p>