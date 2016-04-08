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
        Form::macro('selectAngular', function($name, $options = [], $selected = null, $sel_attr = []){

            $angular_init = ($selected != null) ? "ng-init=\"" . $sel_attr['ng-model'] . "='".$selected."'\"" : "";

            $html = '<select name="' . $name . '" ' . $angular_init;
            foreach ($sel_attr as $sel_key => $value)
            {
                $html .= ' ' . $sel_key .' ="' . $value . '"';
            }
            $html .= '>';

            if(isset($sel_attr['placeholder']))
                $html .= "<option ng-selected=\"" . $sel_attr['ng-model'] . " == ''\"
                          value='' >" .$sel_attr['placeholder']. "</option>";

            foreach ($options as $option_key => $value)
            {
                $html .= "<option ng-selected=\"" . $sel_attr['ng-model'] . " == '" . $option_key . "'\"
                          value='" . $option_key . "'>" . $value ."</option>";
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
