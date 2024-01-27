<?php

namespace App\Models;

use Core\Model;

class Note extends Model
{
    protected static string|null $tableName = 'notes';

    public int $user_id, $folder_id;
    public bool $pinned, $completed;
    public string $title, $created_at, $updated_at;
    public string|null $content;
}