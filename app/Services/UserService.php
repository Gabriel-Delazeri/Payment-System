<?php

namespace App\Services;

use App\Helpers\AppHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function all()
    {
        return $this->userRepository->all();
    }

    public function getById($id)
    {
        return $this->userRepository->getById($id);
    }

    public function create(array $data)
    {
        $email = $this->userRepository
            ->where('email', $data['email'])
            ->first();

        $documentId = $this->userRepository
            ->where('document_id', $data['document_id'])
            ->first();

        if ($email || $documentId) {
            $errors = AppHelper::getCreateOrUpdateUserErrors($email, $documentId);
            throw new HttpResponseException(response()->json([
                'errors' => $errors
            ], 400));
        }

        return $this->userRepository
            ->create($data);
    }

    public function update($id, array $data)
    {
        self::checkUserExists($id);

        $email = $this->userRepository
            ->where('email', $data['email'])
            ->whereNotIn('id', [$id])
            ->first();

        $documentId = $this->userRepository
            ->where('document_id', $data['document_id'])
            ->whereNotIn('id', [$id])
            ->first();

        if ($email || $documentId) {
            $errors = AppHelper::getCreateOrUpdateUserErrors($email, $documentId);
            throw new HttpResponseException(response()->json([
                'errors' => $errors
            ], 400));
        }

        $dataUpdate = [
            'email'       => $data['email'],
            'name'        => $data['name'],
            'document_id' => $data['document_id']
        ];

        return $this->userRepository
            ->update($id, $dataUpdate);
    }

    public function delete($id)
    {
        self::checkUserExists($id);

        return $this->userRepository->delete($id);
    }

    public function where($whereColumn, $valueColumn)
    {
        return $this->userRepository->where($whereColumn, $valueColumn);
    }

    public function first()
    {
        return $this->userRepository->first();
    }

    public function whereNotIn($whereColumn, array $notIn)
    {
        return $this->userRepository->whereNotIn($whereColumn, $notIn);
    }

    public function checkUserExists($id)
    {
        $user = $this->userRepository->where('id', $id)->first();

        if (!$user) {
            throw new HttpResponseException(response()->json([
                'errors' => ['user not found'],
            ], 400));
        }
    }
}
