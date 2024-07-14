<?php

declare(strict_types=1);

namespace App\AuthContext\Application\User\Query\GeneratePasswordGrantClientAccessTokenQuery;

use App\AuthContext\Domain\User\UserId;
use App\AuthContext\Domain\User\UserRepositoryInterface;

class GeneratePasswordGrantClientAccessTokenQueryHandler
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(GeneratePasswordGrantClientAccessTokenQuery $command): GeneratePasswordGrantClientAccessTokenQueryResponse
    {
        return new GeneratePasswordGrantClientAccessTokenQueryResponse(
            $this->userRepository->createToken(new UserId($command->getUserId()), null)
        );
    }
}