<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $fillable = ['form_id', 'data'];

    public function form()
    {
        return $this->belongsTo('App\Form');
    }
}
