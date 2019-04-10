<?php
namespace App\Http\Requests;
use App\Rules\ValidatePassword;
use Illuminate\Foundation\Http\FormRequest;
class UpdatePassword extends FormRequest
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
            'current_password' => ['required', 'min:5', new ValidatePassword(auth()->user())],
            'new_password' => 'required|min:5',
            'confirmation_password' => 'required_with:new_password|same:new_password|min:5'
        ];
    }
}
