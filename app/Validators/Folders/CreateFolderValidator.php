<?php

namespace app\Validators\Folders;

use app\Models\Folder;
use app\Validators\BaseValidator;

class CreateFolderValidator extends BaseValidator
{
    protected array $rules = [
        'title' => '/[\w\d\s\(\)\-]{3,}/i',
    ];

    protected array $errors = [
        'title' => 'Title should contain characters, numbers and _-() symbols and has length more than 2 symbols',
    ];

    protected array $skip = ['user_id', 'update_at'];

    protected function checkOnDuplicateTitle( string $title): bool
    {
       $result = !Folder::where('user_id', '=', authId())->andWhere('title', '=', $title)->exists();

    }

    public function validate(array $fields = []): bool
    {
        $result = [
            parent::validate($fields)
        ];
        return !in_array(false, $result);
    }

}
