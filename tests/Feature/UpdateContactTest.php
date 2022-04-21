<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Tests\TestCase;

class UpdateContactTest extends TestCase
{
    public function test_name_is_required()
    {
        $user = User::factory()->create();

        $data = [
            'name' => '',
            'email' => $this->faker->email(),
            'contact' => $this->faker->numerify('#########')
        ];

        $contact = Contact::factory()->create();

        $response = $this->actingAs($user)
            ->put(route('contact.update', $contact), $data);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_should_be_string()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 12345,
            'email' => $this->faker->email(),
            'contact' => $this->faker->numerify('#########')
        ];

        $contact = Contact::factory()->create();

        $response = $this->actingAs($user)
            ->put(route('contact.update', $contact), $data);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_should_be_have_at_least_five_letters()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'abcd',
            'email' => $this->faker->email(),
            'contact' => $this->faker->numerify('#########')
        ];

        $contact = Contact::factory()->create();

        $response = $this->actingAs($user)
            ->put(route('contact.update', $contact), $data);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_should_be_have_at_maximum_255_letters()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec nisl rhoncus, hendrerit libero vitae, pretium massa. Morbi eu dui non mauris sollicitudin placerat vitae in lacus. Donec gravida vestibulum semper. Nulla sodales iaculis justo, sit amet in.',
            'email' => $this->faker->email(),
            'contact' => $this->faker->numerify('#########')
        ];

        $contact = Contact::factory()->create();

        $response = $this->actingAs($user)
            ->put(route('contact.update', $contact), $data);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_email_is_required()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'abcde',
            'email' => '',
            'contact' => $this->faker->numerify('#########')
        ];

        $contact = Contact::factory()->create();

        $response = $this->actingAs($user)
            ->put(route('contact.update', $contact), $data);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_email_should_be_valid()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'abcde',
            'email' => 'invalid email',
            'contact' => $this->faker->numerify('#########')
        ];

        $contact = Contact::factory()->create();

        $response = $this->actingAs($user)
            ->put(route('contact.update', $contact), $data);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_email_should_be_unique_among_contact()
    {
        $user = User::factory()->create();

        $contactToConflict = Contact::factory()->create();

        $data = [
            'name' => 'abcde',
            'email' => $contactToConflict->email,
            'contact' => $contactToConflict->contact
        ];

        $contact = Contact::factory()->create();

        $response = $this->actingAs($user)
            ->put(route('contact.update', $contact), $data);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_can_update_contact_with_same_email_and_contact()
    {
        $user = User::factory()->create();

        $contact = Contact::factory()->create();

        $data = [
            'name' => 'abcde',
            'email' => $contact->email,
            'contact' => $contact->contact
        ];

        $response = $this->actingAs($user)
            ->put(route('contact.update', $contact), $data);

        $response->assertSessionHasNoErrors();
    }

    public function test_contact_should_have_9_digits()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'abcde',
            'email' => $this->faker->email(),
            'contact' => $this->faker->numerify('########')
        ];

        $contact = Contact::factory()->create();

        $response = $this->actingAs($user)
            ->put(route('contact.update', $contact), $data);

        $response->assertSessionHasErrors(['contact']);

        $data = [
            'name' => 'abcde',
            'email' => $this->faker->email(),
            'contact' => $this->faker->numerify('##########')
        ];

        $contact = Contact::factory()->create();

        $response = $this->actingAs($user)
            ->put(route('contact.update', $contact), $data);

        $response->assertSessionHasErrors(['contact']);
    }
}
