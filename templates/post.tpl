{extends file="layout.tpl"}

{block name="title"}
    {$postData.title}
{/block}

{block name="content"}
    <a href="/"><- На главную</a>
    <h1>{$postData.title}</h1>
    <p>{$postData.published_at|date_format:"%d.%m.%Y"}</p>
    <p>Категории:&nbsp;
        {foreach $postData.categories as $category}
            <a href="/category/{$category.id}">{$category.title}</a>
        {/foreach}
    </p>
    <div class="img_wrapper">
        <img src="{$postData.image}"/>
    </div>
    <p>{$postData.description}</p>
    <p>{$postData.content}</p>
    {if $postData.similar}
        <h2>Похожие</h2>
        {include file="partials/posts.tpl" posts=$postData.similar}
    {/if}
{/block}