<?php
namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UniqueGlobally implements ValidationRule
{
    protected ?Model $model = null;

    /**
     * Create a new rule instance.
     *
     * @param ?Model $model The model being updated (null for creates)
     */
    protected string $column;

    /**
     * Create a new rule instance.
     *
     * @param string $column The column to check for uniqueness
     * @param ?Model $model The model being updated (null for creates)
     */
    public function __construct(string $column, ?Model $model = null)
    {
        $this->column = $column;
        $this->model  = $model;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            return;
        }

        if ($this->model && $this->model->{$this->column} === $value) {
            return;
        }

        if (
            DB::table('doctors')->where($this->column, $value)->exists() ||
            DB::table('nurses')->where($this->column, $value)->exists() ||
            DB::table('receptionists')->where($this->column, $value)->exists()
        ) {
            $fail('The ' . $attribute . ' has already been taken.');
        }
    }
}
