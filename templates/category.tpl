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
    <div class="pagination">
    {if $pagesCount > 1}
        {for $i = 1 to $pagesCount}
            <a href="?page={$i}" class="{if $i == $currentPage}active{/if}">{$i}</a>
        {/for}
    {/if}
    </div>
{/block}