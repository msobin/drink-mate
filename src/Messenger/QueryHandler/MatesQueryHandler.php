<?php

declare(strict_types=1);

namespace App\Messenger\QueryHandler;

use App\Entity\Mate;
use App\Messenger\Query\GetMateQuery;
use App\Messenger\Query\GetNearByQuery;
use App\Repository\MateRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class MatesQueryHandler
{
    public function __construct(private MateRepository $mateRepository)
    {
    }

    #[AsMessageHandler]
    public function getMates(GetMateQuery $query): Mate
    {
        return $this->mateRepository->findOneBy(['id' => $query->uuid->toString(), 'status' => Mate::STATUS_ACTIVE]);
    }

    #[AsMessageHandler]
    public function getNearBy(GetNearByQuery $query): array
    {
        return $this->mateRepository->findNearBy($query->mate, $query->distance);
    }
}
