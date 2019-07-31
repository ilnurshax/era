<?php

namespace Ilnurshax\Era\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class FileExtension implements Rule
{

    /**
     * @var array
     */
    private $extensions;

    /**
     * Create a new rule instance.
     *
     * @param string $extensions
     */
    public function __construct(string $extensions = 'doc,docx,rtf,pdf,ods,odt,jpg,jpeg,rar,7z,zip')
    {
        $this->extensions = explode(',', $extensions);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  UploadedFile $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            if (in_array($value->getClientOriginalExtension(), $this->extensions)) {
                return true;
            }

            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.extensions', [
            'values' => implode(', ', $this->extensions),
        ]);
    }
}
