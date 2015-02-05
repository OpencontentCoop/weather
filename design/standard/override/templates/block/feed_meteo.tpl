{cache-block expiry=7200}

{def $content=$valid_nodes[0].data_map.meteo.content}

{$content|attribute(show,2)}
<h2 class="block-title">{$block.name|wash()}</h2>

<div class="block-type-meteo block-{$block.view}">

{if $res.error}

<div class="square-box-soft-gray meteo-content">


<div class="columns-three">
	<div class="col-1-2">
	<div class="col-1">
	<div class="col-content">
	
	<h4>Gioved&igrave;</h4>
	<div class="attribute-image"></div>
	<div class="gradi">5&deg;C</div>

	</div>
	</div>
	<div class="col-2">
	<div class="col-content">

	<h4>Venerd&igrave;</h4>
	<div class="attribute-image"></div>
	<div class="gradi">6&deg;C</div>	

	</div>
	</div>
	</div>
	<div class="col-3">
	<div class="col-content">

	<h4>Sabato</h4>
	<div class="attribute-image"></div>
	<div class="gradi">7&deg;C</div>	

	</div>
	</div>
	</div>


</div>

{else}

<div class="block-type-feed-reader">
    <h2>
        <a href="{$res.links[0]}" title="{$res.title|wash()}">{$res.title|wash()}</a>
    </h2>

{foreach $res.items as $item}
    <div>
        <a href="{$item.links[0]}" title="{$item.title|wash()}">{$item.title|wash()}</a>
    </div>
{/foreach}

</div>
{/if}

</div>
{/cache-block}
