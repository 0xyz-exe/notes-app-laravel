<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string|max:50000',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'is_pinned' => 'sometimes|boolean',
            'is_archived' => 'sometimes|boolean',
        ];
    }
}
