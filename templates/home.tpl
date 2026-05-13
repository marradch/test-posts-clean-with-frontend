<!DOCTYPE html>
<html>
<head>
    <title>Тестовый блог</title>
</head>
<body>

<h1>Тестовый блог</h1>
{foreach $categoriesData as $categoryId => $categoryData}
    <h2>{$categoryData.title}&nbsp;&nbsp;&nbsp;<a href="/category/{$categoryId}">Смотреть все</a></h2>
    <div class="category_posts">
        {foreach $categoryData.posts as $post}
            <div class="post_container">
                <div class="img_wrapper">
                    <img src="{$post.image}"/>
                </div>
                <p>{$post.title}</p>
                <p>{$post.published_at}</p>
                <p>{$post.description}</p>
                <a href="/post/{$post.id}">Читать полностью</a>
            </div>
        {/foreach}
    </div>
{/foreach}

</body>
</html>