<?php

namespace App\Services;

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
        $email = $this->userRepository->findFirstWhere('email', $data['email']);
        $documentId = $this->userRepository->findFirstWhere('document_id', $data['document_id']);

        if ($email) {
            $errors = is_null($documentId) ? ['email already in use'] : ['email already in use', 'document already in use'];
            throw new HttpResponseException(response()->json([
                'errors' => $errors
            ], 400));
        }

        return $this->userRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->userRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->userRepository->delete($id);
    }

    public function findFirstWhere($whereColumn, $valueColumn)
    {
        return $this->userRepository->findFirstWhere($whereColumn, $valueColumn);
    }
}
