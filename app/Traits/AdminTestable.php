<?php

namespace App\Traits;

use App\Models\AdminUser;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\TestResponse;

trait AdminTestable
{
    public string $token = '';
    public string $adminNumber = '09931591988';

    public function login()
    {
        $user = User::query()->where('mobile', $this->adminNumber)->first();

        $this->token = $user->createToken($user->name)->plainTextToken;
    }

    protected function getData(string $url): TestResponse
    {
        $this->login();
        return $this->withHeaders(
            [
                "Accept" => "application/json",
                "Authorization" => 'Bearer ' . $this->token

            ]
        )->getJson($url);
    }

    protected function postData(string $url, array $data): TestResponse
    {
        $this->login();
        return $this->withHeaders(
            [
                "Accept" => "application/json",
                "Authorization" => 'Bearer ' . $this->token

            ]
        )->postJson($url, $data);
    }

    protected function deleteData(string $url): TestResponse
    {
        $this->login();

        return $this->withHeaders([

            "Accept" => "application/json",
            "Authorization" => 'Bearer ' . $this->token

        ])->deleteJson($url);
    }

    protected function fakeImage()
    {
        return UploadedFile::fake()->image('test.jpg', 400, 300);
    }

    protected function removeIndex($array, $indexes)
    {
        if (is_array($indexes)) {
            foreach ($indexes as $item) {
                unset($array[$item]);
            }
        } else {
            unset($array[$indexes]);
        }
        return $array;
    }

    protected function assertFileExist($filename): void
    {
        $result = is_file(public_path($filename));
        $this->assertTrue($result);
    }


}
