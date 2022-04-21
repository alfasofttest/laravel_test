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

        $contact = Contact::query()->create($data);

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContact $request, Contact $contact)
    {
        $data = $request->validated();

        if ($contact->update($data)) {
            toastSuccess('Contact updated successfully.');
        } else {
            toastError('Error updating Contact.');
        }

        return redirect()->route('index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
