<?php

namespace Ilnurshax\Era\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class FilenameLength implements Rule
{

    protected $error;

    /**
     * @var int|null
     */
    private $min;
    /**
     * @var int|null
     */
    private $max;

    /**
     * Create a new rule instance.
     *
     * @param int|null $min
     * @param int|null $max
     */
    public function __construct(int $min = 1, int $max = 150)
    {
        $this->min = $min;
        $this->max = $max;
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
            if (!empty($this->min) && mb_strlen($value->getClientOriginalName()) < $this->min) {
                $this->error = trans('validation.filename.min', ['min' => $this->min]);

                return false;
            }

            if (!empty($this->max) && mb_strlen($value->getClientOriginalName()) > $this->max) {
                $this->error = trans('validation.filename.max', ['max' => $this->max]);

                return false;
            }

            return true;
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
        return $this->error;
    }
}
