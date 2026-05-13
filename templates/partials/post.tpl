<div class="post_container">
    <div class="img_wrapper">
        <img src="{$post.image}"/>
    </div>
    <p>{$post.title}</p>
    <p>{$post.published_at|date_format:"%d.%m.%Y"}</p>
    <p>{$post.description}</p>
    <a href="/post/{$post.id}">Читать полностью</a>
</div>