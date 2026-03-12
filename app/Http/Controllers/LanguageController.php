<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Switch the application locale and redirect back.
     *
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch(string $locale)
    {
        $supported = ['id', 'en'];

        if (in_array($locale, $supported)) {
            session(['locale' => $locale]);
        }

        return redirect()->back();
    }
}
