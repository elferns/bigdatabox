<?php

namespace App\Providers;

use Form;
use Illuminate\Support\ServiceProvider;

class FormMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Form::macro('selectOptions', function($name, $options = [], $selected = null, $attributes = [], $disabled = []){

            $html = '<select name="' . $name . '"';
            foreach ($attributes as $attribute => $value)
            {
                $html .= ' ' . $attribute . '="' . $value . '"';
            }
            $html .= '>';

            foreach ($options as $value => $text)
            {
                $html .= '<option value="' . $value . '"' .
                    ($value == $selected ? ' selected="selected"' : '') .
                    (in_array($value, $disabled) ? ' disabled="disabled"' : '') . '>' .
                    $text . '</option>';
            }

            $html .= '</select>';

            return $html;

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
