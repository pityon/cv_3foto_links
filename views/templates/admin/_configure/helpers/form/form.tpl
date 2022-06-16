{*
 * 2007-2020 PrestaShop.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}

{extends file="helpers/form/form.tpl"}
{block name="field"}
	{if $input.type == 'file_preview'}
		<div class="col-lg-8">

			{block name="input"}
				<div class="form-group">
					<div class="col-sm-9">
						{if isset($input['thumbnail']) && $input['thumbnail'] != ''}
							<img src="{$image_baseurl}{$input['thumbnail']}" class="img-thumbnail" />
						{/if}
						<input id="{$input.name}" type="file" name="{$input.name}" class="hide">
						<div class="dummyfile input-group">
							<span class="input-group-addon"><i class="icon-file"></i></span>
							<input id="{$input.name}-name" type="text" name="{$input.name}" readonly="">
							<span class="input-group-btn">
								<button id="{$input.name}-selectbutton" type="button" name="submitAddAttachments" class="btn btn-default">
									<i class="icon-folder-open"></i> {l s='Choose a file' d='Admin.Actions'}			
								</button>
							</span>
						</div>
					</div>
				</div>

				<script>
					$(document).ready(function(){
						$('#{$input.name}-selectbutton').click(function(e){
							$('#{$input.name}').trigger('click');
						});
						$('#{$input.name}').change(function(e){
							var val = $(this).val();
							var file = val.split(/[\\/]/);
							$('#{$input.name}-name').val(file[file.length-1]);
						});
					});
				</script>
			{/block}

			{block name="description"}
				{if isset($input.desc) && !empty($input.desc)}
					<p class="help-block">
						{if is_array($input.desc)}
							{foreach $input.desc as $p}
								{if is_array($p)}
									<span id="{$p.id}">{$p.text}</span><br />
								{else}
									{$p}<br />
								{/if}
							{/foreach}
						{else}
							{$input.desc}
						{/if}
					</p>
				{/if}
			{/block}

		</div>
		
	{else}
		{$smarty.block.parent}
	{/if}
{/block}
