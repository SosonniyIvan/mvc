<?php

namespace app\Validators\Notes;

use app\Models\Folder;
use App\Models\Note;
use app\Validators\BaseValidator;
use enums\SQL;

class Base extends BaseValidator
{
    protected array $skip = [
        'user_id',
        'update_at',
        'pinned',
        'completed'
    ];

    public function validateBooleanValue(array $fields, string $key): bool
    {
        if (empty($fields[$key])){
            return true;
        }

        $result = is_bool($fields[$key]) || $fields[$key] === 1;

        if (!$result){
            $this->setError($key, "'$key' should be boolean");
        }

        return $result;
    }

    public function validateFolderId(array $fields, bool $isrequired = true)
    {
        if (empty($fields['folder_id']) && !$isrequired){
            return true;
        }

        return
            Folder::where('id', '=', $fields['folder_id'])
            ->startCondition()->andWhere('user_id', '=', authId())
            ->orWhere('user_id', SQL::IS_OPERATOR->value, SQL::NULL->value)->endCondition()->exists();
    }

    public function checkTitleOnDuplication(string $title, int $folder_id, int $user_id): bool
    {
        $result = Note::where('title', '=', $title)->andWhere('user_id', '=', $user_id)->andWhere('$folder_id', '=', $folder_id)
            ->exists();

        if ($result){
            $this->setError('title', 'Title with the same name already exists in this directory');
        }

        return $result;
    }
}
