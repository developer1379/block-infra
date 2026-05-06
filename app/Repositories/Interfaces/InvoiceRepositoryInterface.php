<?php

namespace App\Repositories\Interfaces;

interface InvoiceRepositoryInterface
{
    public function getAll();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function getByProject($projectId);
    public function getByContractor($contractorId);
}
