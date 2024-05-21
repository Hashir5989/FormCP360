<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use App\Jobs\SendFormCreatedNotification;

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::all();
        return view('forms.index', compact('forms'));
    }

    public function create()
    {
        return view('forms.create');
    }

    public function store(Request $request)
    {
        $formName = $request->input('name');
        $fieldData = $request->input('fields');
        $fields = [];
        foreach ($fieldData as $fieldIndex => $field) {
            // Extract data for the current field
            $label = $field['label'][0] ?? '';
            $name = $field['name'][0] ?? '';
            $type = $field['type'][0] ?? '';
            $options = $field['options'][0] ?? '';
            if (!empty($label) && !empty($name)) {
                $fields[] = [
                    'name' => $name,
                    'type' => $type,
                    'label' => $label,
                    'options' => $options,
                ];
            }
        }
        $form = Form::create([
            'name' => $formName,
            'fields' => json_encode($fields), 
        ]);
    
        return redirect()->route('forms.index');
    }

    public function edit($id)
    {
        $form = Form::find($id);
        return view('forms.edit', compact('form'));
    }

    public function update(Request $request, $id)
    {
        $form = Form::find($id);
        $form->update($request->all());
        return redirect()->route('forms.index');
    }

    public function destroy($id)
    {
        Form::destroy($id);
        return redirect()->route('forms.index');
    }
}
