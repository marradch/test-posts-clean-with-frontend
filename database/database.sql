CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT
);

CREATE TABLE posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(500),
    title VARCHAR(255) NOT NULL,
    description TEXT,
    content LONGTEXT NOT NULL,
    views INT UNSIGNED DEFAULT 0,
    published_at TIMESTAMP
);

CREATE TABLE post_category (
    post_id INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,

    PRIMARY KEY (post_id, category_id),

    CONSTRAINT fk_post_category_post
        FOREIGN KEY (post_id)
            REFERENCES posts(id)
            ON DELETE CASCADE
            ON UPDATE CASCADE,

    CONSTRAINT fk_post_category_category
        FOREIGN KEY (category_id)
            REFERENCES categories(id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
);