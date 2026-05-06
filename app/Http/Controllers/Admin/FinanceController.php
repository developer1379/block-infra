<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\InvoiceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FinanceController extends Controller
{
    protected $invoices;

    public function __construct(InvoiceRepositoryInterface $invoices)
    {
        $this->invoices = $invoices;
    }

    public function index()
    {
        try {
            $invoices = $this->invoices->getAll();
            return view('admin.finance.index', compact('invoices'));
        } catch (\Exception $e) {
            Log::error('Admin Finance Index Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load financial data.');
        }
    }

    public function show($id)
    {
        try {
            $invoice = $this->invoices->find($id);
            return view('admin.finance.show', compact('invoice'));
        } catch (\Exception $e) {
            return back()->with('error', 'Invoice not found.');
        }
    }

    public function create() { return abort(404); }
    public function store(Request $request) { return abort(404); }
    public function edit($id) { return abort(404); }
    public function update(Request $request, $id) { return abort(404); }
    public function destroy($id) { return abort(404); }
}
