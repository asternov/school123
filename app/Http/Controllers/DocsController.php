<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Class DocsController
 * @package App\Http\Controllers\DevTools
 */
class DocsController extends Controller
{
    /**
     * Get swagger file content
     *
     * @return string
     */
    public function file() : string
    {
        return file_get_contents(base_path('docs/swagger.yaml'));
    }

    /**
     * Render view with docs
     *
     * @return View
     */
    public function docsForm() : View
    {
        return view('dev_tools.docs_form');
    }
}
