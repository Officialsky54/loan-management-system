<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;

class EmailTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $templates = EmailTemplate::paginate(15);
        return view('admin.email-templates.index', ['templates' => $templates]);
    }

    public function edit(EmailTemplate $template)
    {
        return view('admin.email-templates.edit', ['template' => $template]);
    }

    public function update(Request $request, EmailTemplate $template)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'signature' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $template->update($request->only('subject', 'body', 'signature', 'is_active'));

        return redirect()->route('admin.email-templates.index')
            ->with('success', 'Email template updated successfully!');
    }

    public function preview(EmailTemplate $template)
    {
        return view('admin.email-templates.preview', ['template' => $template]);
    }
}
