<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThreadRequest extends FormRequest
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
            'channel_id' => 'required|exists:channels,id',
            'title'      => 'required',
            'body'       => 'required'
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'channel_id.required' => 'The channel is required!',
            'channel_id.exists'   => 'The channel does not exist!',
            'title.required'      => 'The title is required!',
            'body.required'       => 'The body is required!',
        ];
    }
}
