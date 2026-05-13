{extends file="layout.tpl"}

{block name="title"}
    {$category.title}
{/block}

{block name="content"}
    <a href="/"><- На главную</a>
    <h1>{$category.title}</h1>
    <p>{$category.description}</p>
    {if $posts}
        {include file="partials/posts.tpl" posts=$posts}
    {/if}
{/block}