<?php

namespace App\Modules\Mortgage\Repositories;

use App\Modules\Mortgage\Models\Loan;

class MortgageRepository
{
    protected $loanModel;

    public function __construct(Loan $loanModel)
    {
        $this->loanModel = $loanModel;
    }
    public function getAll(array $filters = [])
    {
        $query = Loan::query();
        return $query->get();
    }
    public function create(array $loanData)
    {
        return $this->loanModel->create($loanData);
    }
    public function findOrFail(string $id): Loan
    {
        return $this->loanModel->findOrFail($id);
    }


}