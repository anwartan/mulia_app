<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mode'=>'required',
            'po_no'=>'required_if:mode,EDIT',
            'purchase_date'=>'date',
            'description'=>'max:255',
            'status'=>'',
            'items'=>'required|array|min:1'
        ];
    }
}
