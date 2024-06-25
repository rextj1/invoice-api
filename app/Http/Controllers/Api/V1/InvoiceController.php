<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\InvoiceFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\InvoiceCollection;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // this class is initialize for use here
        // or can be initialize by a constructor as shown above
        // Apply filters if necessary
        // Apply filters if necessary
        $filter = new InvoiceFilter();
        $queryItems = $filter->transform($request);

        // Create a query builder instance
        $query = Invoice::with('customer');

        // Apply filters to the query
        if (count($queryItems) == 0) {
            $query->where($queryItems);
        }

        // Paginate the results
        $invoices = $query->paginate();

        // Return the paginated collection with appended query parameters
        return new InvoiceCollection($invoices->appends($request->query()));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
