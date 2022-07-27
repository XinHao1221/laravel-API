<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\BulkStoreInvoiceRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get how many item per page (Default is 10)
        $itemPerPage = $request->query('per_page') ?? 10;

        // SQL Query 
        $customers = Customer::query();

        // Filter data
        if (!empty($request->name)) {
            $customers = $customers->where('name', 'like', '%' . $request->name . '%');
        }

        // Return the result as JSON
        return new CustomerCollection($customers->paginate($itemPerPage));
    }

    public function customerFilter(Customer $customers, Request $request)
    {
        // Filter name


        return $customers;
    }

    public function bulkStore(BulkStoreInvoiceRequest $request)
    {
        // Talk out postalCode from $request
        $bulk = collect($request->all())->map(function ($arr) {
            return Arr::except($arr, ['postalCode']);
        });

        // Perform bulk insert
        Customer::insert($bulk->toArray());

        return response()->json([
            "data" => "Record insert successfully."
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        // Get current logged in user's id
        $userId = Auth::user()->id;

        // Add user_id into request
        $request["user_id"] = $userId;

        // Store the newly created customer record
        return new CustomerResource(Customer::create(array_merge($request->all())));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        // Delete customer with provided id
        $customer->delete();

        // Return success message
        return response()->json([
            "message" => "Customer deleted successfully!"
        ]);
    }
}
