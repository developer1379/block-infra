<?php

namespace App\Repositories;

use App\Models\Invoice;
use App\Repositories\Interfaces\InvoiceRepositoryInterface;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function getAll()
    {
        return Invoice::latest()->get();
    }

    public function find($id)
    {
        return Invoice::findOrFail($id);
    }

    public function create(array $data)
    {
        return Invoice::create($data);
    }

    public function update($id, array $data)
    {
        $invoice = $this->find($id);
        $invoice->update($data);
        return $invoice;
    }

    public function getByProject($projectId)
    {
        return Invoice::where('project_id', $projectId)->latest()->get();
    }

    public function getByContractor($contractorId)
    {
        return Invoice::where('contractor_id', $contractorId)->latest()->get();
    }
}
