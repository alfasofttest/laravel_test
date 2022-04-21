<?php

namespace App\Rules;

use App\Models\Contact;
use Illuminate\Contracts\Validation\Rule;

class UniqueEmailContact implements Rule
{
    private ?Contact $ignore;
    private array $secondArg;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $secondArg, ?Contact $ignore = null)
    {
        $this->ignore = $ignore;
        $this->secondArg = $secondArg;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !Contact::query()->where([
            [$attribute, '=', $value],
            $this->secondArg
        ])->when($this->ignore, function ($query) {
            return $query->where('id', '<>', $this->ignore->id);
        })->count();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Can't have contact with same email and contact number.";
    }
}
