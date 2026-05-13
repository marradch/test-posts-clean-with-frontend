{extends file="layout.tpl"}

{block name="title"}
    {$category.title}
{/block}

{block name="content"}
    <a href="/"><- На главную</a>
    <h1>{$category.title}</h1>
    <p>{$category.description}</p>

    <form method="get" class="filter-form">
    <label for="sort">Сортировать по</label>
    <select name="sort" onchange="this.form.submit()">
        <option value="published_at" {if $sort == "published_at"}selected="selected"{/if}>По дате публикации</option>
        <option value="views" {if $sort == "views"}selected="selected"{/if}>По количеству просмотров</option>
    </select>
    </form>

    {if $posts}
        {include file="partials/posts.tpl" posts=$posts}
    {/if}
    <div class="pagination">
    {if $pagesCount > 1}
        {for $i = 1 to $pagesCount}
            <a href="?page={$i}&sort={$sort}" class="{if $i == $currentPage}active{/if}">{$i}</a>
        {/for}
    {/if}
    </div>
{/block}