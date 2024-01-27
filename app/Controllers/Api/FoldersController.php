<?php

namespace app\Controllers\Api;

use app\Models\Folder;
use app\Validators\Folders\CreateFolderValidator;
use enums\SQL;
use enums\SQLOrder;

class FoldersController extends BaseApiController
{
    public function index()
    {
        return $this->response(
            body: Folder::where('user_id', '=', authId())
                ->orWhere('user_id', 'IS', SQL::NULL->value)->orderBy([
                    'user_id' => SQLOrder::ASC,
                    'title' => SQLOrder::ASC
                ])->get()
        );
    }

    public function show(int $id)
    {
        $folder = Folder::find($id);
        if ($folder && !is_null($folder->user_id) && $folder->user_id !== authId())
        {
            return $this->response(403, [], [
                'message' => 'This resource is forbidden for you'
            ]);
        }
        return $this->response(body: $folder->toArray());
    }

    public function store()
    {
        $data = array_merge(
            requestBody(),
            ['user_id' => authId()]
        );

        $validator = new CreateFolderValidator();

        if ($validator->validate($data) && $folder = Folder::create($data))
        {
                return $this->response(body: $folder->toArray());
        }


        return $this->response(errors: $validator->getErrors());
    }


    public function update(int $id){
        $folder = Folder::find($id);

        if ($folder && is_null($folder->user_id) && $folder->user_id !== authId()) {
            return $this->response(403, errors: [
                'message' => 'This resource is forbidden for you'
            ]);
        }

        $data = [
            ...requestBody(),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $validator = new CreateFolderValidator();

        if ($validator->validate($data) && $folder = $folder->update($data)) {
            return $this->response(body: $folder->toArray());
        }

        return $this->response(errors: $validator->getErrors());
    }


    public function destroy(int $id)
    {
        $folder = Folder::find($id);

        if ($folder && is_null($folder->user_id) && $folder-> user_id !== authId())
        {
            return $this->response(403, [], ['message' => 'This resource is forbidden for you']);
        }

        $result = Folder::destroy($id);

        if (!$result){
            return $this->response(422, [], ['message' => 'Oops smth went wrong']);
        }

        return $this->response();
    }





}
