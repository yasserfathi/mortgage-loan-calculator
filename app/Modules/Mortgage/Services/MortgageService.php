<?php

namespace App\Modules\Mortgage\Services;

use App\Modules\Mortgage\Models\Loan;
use App\Modules\Mortgage\Repositories\MortgageRepository;

class MortgageService
{
    public function __construct(
        private MortgageRepository $mortgageRepository
    ) {}
    
    public function list(array $filters = [])
    {
        return $this->mortgageRepository->getAll($filters);
    }
    
    public function create(array $data): Loan
    {
        $expense = $this->mortgageRepository->create($data);
        return $expense;
    }

    public function find(string $id): Loan
    {
        return $this->mortgageRepository->findOrFail($id);
    }
}