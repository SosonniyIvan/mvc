-- CREATE TABLE IF NOT EXISTS shared_notes (
--     id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
--     user_id INT UNSIGNED NOT NULL,
--     note_id INT UNSIGNED NOT NULL,
--
--     FOREIGN KEY (user_id) REFERENCES users(id),
--     FOREIGN KEY (note_id) REFERENCES notes(id)
-- );

CREATE TABLE IF NOT EXISTS folders (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNSIGNED DEFAULT null,
    title VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT NOW(),
    updated_at DATETIME DEFAULT NOW(),

    FOREIGN KEY (user_id) REFERENCES users(id)
);