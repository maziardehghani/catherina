<?php

namespace App\Repositories\User;

use App\Models\UserInfoTitle;
use App\Models\UserInfoValue;
use App\Repositories\Repository;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class UserRepository extends Repository
{
    public function __construct()
    {
        $this->model = User::query();
        $this->paginate = 20;
    }

    public function getByMobile($mobile)
    {
        return $this->model->where('mobile', $mobile)->first();
    }

    public function store(array|object $data): object
    {
        return $this->model->create($data->only([
            'name',
            'family',
            'email',
            'mobile',
            'password',
            'status_id',
            'type',
            'bio',
            'is_private_investor',
            'is_sejami',
        ]));
    }


    public function update(Model $model, array|object $data): bool
    {
        return $model->update($data->only([
            'name',
            'family',
            'email',
            'mobile',
            'password',
            'status_id',
            'type',
            'bio',
            'is_private_investor',
            'is_sejami'
        ]));
    }

    public function storeSejamInfos($data, $user): void
    {
        foreach ($data as $key => $item) {

            $userInfoTitle = UserInfoTitle::query()->where('title', $key)->first();

            // refuse to insert sejam data if it is null
            if (is_null($userInfoTitle) || is_null($item)) {
                continue;
            }

            $this->storeUserValues($user, $userInfoTitle, $item);

        }

    }


    public function deleteSejamInfos($user): void
    {
        $user->userInfos()->delete();
    }


    private function storeUserValues($user, $userInfoTitle, $item): void
    {
        UserInfoValue::query()->updateOrCreate([
            'user_id' => $user->id,
            'user_info_title_id' => $userInfoTitle->id,
        ], [
            'user_id' => $user->id,
            'user_info_title_id' => $userInfoTitle->id,
            'value' => $item,
        ]);
    }


    public function getLegalUsers()
    {
        return $this->model->whereType('legal')->get();
    }

    public function getExpertUsers()
    {
        return User::permission('management')->get();
    }
}
