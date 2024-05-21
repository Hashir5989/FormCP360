<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use App\Models\FormSubmission;

class PublicFormController extends Controller
{

    public function index() {
        $forms = Form::all();
        return view('public_form.form-list', compact('forms'));
    }

    public function show($id)
    {
        $form = Form::find($id);
        if(!$form) {
            return redirect()->back()->with('success', 'No form found with the provided ID.');
        }
        return view('public_form.show', compact('form'));
    }

    public function store(Request $request, $id)
    {
        $formData = $request->except('_token');

        $formattedData = [];

        foreach ($formData as $fieldName => $fieldValue) {
            $formattedData[$fieldName] = [
                'label' => $fieldName,
                'value' => $fieldValue,
            ];
        }

        $formSubmission = FormSubmission::create([
            'form_id' => $id,
            'data' => json_encode($formattedData)
        ]);

        return redirect()->back()->with('success', 'Form submitted successfully.');
    }
}
