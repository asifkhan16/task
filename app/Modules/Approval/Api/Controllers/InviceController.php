<?php

namespace App\Modules\Approval\Api\Controllers;

use Illuminate\Http\Request;
use App\Domain\Enums\StatusEnum;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Modules\Invoices\Infrastructure\Models\Company;
use App\Modules\Invoices\Infrastructure\Models\Invoice;
use App\Modules\Invoices\Infrastructure\Models\Product;
use App\Modules\Invoices\Infrastructure\Models\InvoiceProductLine;

class InviceController extends Controller
{
    public function index(){
        $data['invices'] = Invoice::with('company','invice_products.product')
                    ->get();
        return SuccessResponse($data);
    }

    public function approve_invoice(Request $request){
        $validator =  Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return ErrorResponse($validator->errors()->first());

        $invoice = Invoice::where('id',$request->id)->first();

        if(!$invoice)
            return ErrorResponse('Invoice not found.');
        
        if($invoice->status == StatusEnum::APPROVED){
            return ErrorResponse('Your Invoice is already approved.');
        }
        if($invoice->status == StatusEnum::DRAFT){
            return ErrorResponse('Your Invoice is draft.');
        }
        if($invoice->status == StatusEnum::REJECTED){
            return ErrorResponse('Your Invoice is already rejected you can not approve it.');
        }

        $invoice->update([
            'status' => StatusEnum::APPROVED
        ]);

        return SuccessResponse('Your invoice has been approved successfully.');
    }
    public function reject_invoice(Request $request){
        $validator =  Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails())
            return ErrorResponse($validator->errors()->first());

        $invoice = Invoice::where('id',$request->id)->first();

        
        if(!$invoice)
            return ErrorResponse('Invoice not found.');
        
        if($invoice->status == StatusEnum::REJECTED){
            return ErrorResponse('Your Invoice is already rejected.');
        }

        if($invoice->status == StatusEnum::APPROVED){
            return ErrorResponse('Your Invoice is already approved you can not reject it.');
        }

        if($invoice->status == StatusEnum::DRAFT){
            return ErrorResponse('Your Invoice is draft.');
        }
        

        $invoice->update([
            'status' => StatusEnum::REJECTED
        ]);

        return SuccessResponse('Your invoice has been rejected successfully..');
    }
}
