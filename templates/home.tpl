{extends file="layout.tpl"}

{block name="title"}
    Список постов
{/block}

{block name="content"}
    <h1>Тестовый блог</h1>
    {foreach $categoriesData as $categoryId => $categoryData}
        <h2>{$categoryData.title}&nbsp;&nbsp;&nbsp;<a href="/category/{$categoryId}">Смотреть все</a></h2>
        {include file="partials/posts.tpl" posts=$categoryData.posts}
    {/foreach}
{/block}