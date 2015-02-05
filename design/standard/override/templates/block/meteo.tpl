{cache-block expiry=7200}
{def $content=$block.valid_nodes[0].data_map.meteo.content}
{if $content}
{if $block.name}<h2 class="hide block-title">{$block.name|wash()}</h2>{else}<h2 class="hide">Meteo</h2>{/if}

<div class="block-type-meteo block-{$block.view}">
	<div class="square-box-soft-gray meteo-content">

		<div class="columns-three">
			<div class="col-1-2">
		
				<div class="col-1">
					<div class="col-content">
					<h3>{$content.Oggi.Data}</h3>
					<div class="image"><img src="{$content.Oggi.iconaS}" alt="{$content.Oggi.desciconaS}" title="{$content.Oggi.desciconaS}" /></div>
					<div class="gradi">{$content.Oggi.TempMaxValle}&deg;C</div>

					</div>
				</div>
				<div class="col-2">
					<div class="col-content">

					<h3>{$content.Domani.Data}</h3>
					<div class="image"><img src="{$content.Domani.iconaS12}" alt="{$content.Domani.desciconaS12}" title="{$content.Domani.desciconaS12}" /></div>
					<div class="gradi"> {$content.Domani.TempMinValle}&deg;C / {$content.Domani.TempMaxValle}&deg;C</div>

					</div>
				</div>
			</div>
			
			<div class="col-3">
				<div class="col-content">

				<h3>{$content.DopoDomani.Data}</h3>
				<div class="image"><img src="{$content.DopoDomani.iconaS12}" alt="{$content.DopoDomani.desciconaS12}" title="{$content.DopoDomani.desciconaS12}" /></div>
				<div class="gradi">  {$content.DopoDomani.TempMinValle}&deg;C / {$content.DopoDomani.TempMaxValle}&deg;C</div>

				</div>
			</div>						
		
		</div>
		<div class="il-cielo-domani">
{*
		<h3>Per domani &egrave; previsto:</h3>
		<p>{$content.Domani.CieloDesc|wash()} Probabilit&agrave; di precipitazioni: {$content.Domani.PrecipProb|wash()}</p>
*}
		</div>
		<div class="border-content"><a class="arrows" title="Vai a Meteo Trentino" href="http://www.meteotrentino.it/bollettini/today/generale_it.aspx?ID=7"><span class="arrows-blue-r">Meteo Trentino </span></a></div>
	</div>
</div>
{/if}
{/cache-block}
