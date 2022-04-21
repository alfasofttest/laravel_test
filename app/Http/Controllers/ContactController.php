<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContact;
use App\Http\Requests\UpdateContact;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::query()
            ->select([
                'id',
                'name',
                'contact',
                'email',
                'created_at'
            ])->get();

        return view('index', [
            'contacts' => $contacts
        ]);
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function store(StoreContact $request): RedirectResponse
    {
        $data = $request->validated();

        if (Contact::query()->create($data)) {
            toastSuccess('Contact created successfully.');
        } else {
            toastError('Error creating contact.');
        }

        return redirect()->route('index');
    }

    public function show(Contact $contact)
    {
        return view('contacts.show', [
            'contact' => $contact
        ]);
    }

    public function edit(Contact $contact)
    {
        return view('contacts.edit', [
            'contact' => $contact
        ]);
    }

    public function update(UpdateContact $request, Contact $contact): RedirectResponse
    {
        $data = $request->validated();

        if ($contact->update($data)) {
            toastSuccess('Contact updated successfully.');
        } else {
            toastError('Error updating Contact.');
        }

        return redirect()->route('index');
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        if ($contact->delete()) {
            toastSuccess('Contact deleted successfully.');
        } else {
            toastError('Error deleting contact');
        }

        return redirect()->route('index');
    }
}
