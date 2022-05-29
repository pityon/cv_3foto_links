<div class="cv_3foto_links py-3">
    <div class="row">
        {foreach from=$cv_3foto_blocks item=$block}
            {if $block.image}
                <div class="col-md-4 item">
                    <div class="position-relative">
                        <div class="cv_3foto_links-bg" style="background-image: url('{$cv_3foto_upload_dir}{$block.image}')"></div>
                        <div class="cv_3foto_links-content px-2 py-3 p-lg-3">
                            <div class="cv_3foto_links-top">
                                <div>
                                    <h2 class="mb-2">{$block.title}&nbsp;</h2>
                                    {$block.desc nofilter}
                                </div>
                            </div>
                            {if $block.url}
                                <div class="cv_3foto_links-bottom">
                                    <a href="{$block.url}" class="btn cv_3foto_links-btn fx-01">{l s='Zobacz' mod='cv_3foto_links'}</a>
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
            {/if}
        {/foreach}
    </div>
</div>