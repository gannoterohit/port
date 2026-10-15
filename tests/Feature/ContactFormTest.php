<?php

namespace Tests\Feature;

use App\Mail\EnquiryConfirmation;
use App\Mail\EnquiryNotification;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_contact_page_returns_successful_response(): void
    {
        $response = $this->get(route('contact'));

        $response->assertStatus(200);
    }

    public function test_contact_form_submission_creates_enquiry(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.submit'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'This is a test message from the contact form.',
            'subject' => 'Test Subject',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('enquiries', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'status' => 'new',
        ]);
    }

    public function test_contact_form_stores_freelance_qualification_fields(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.submit'), [
            'name' => 'Sarah Client',
            'email' => 'sarah@startup.com',
            'phone' => '+91 9988776655',
            'project_type' => 'Custom Web App (Laravel / Full-Stack)',
            'budget_range' => '₹1,00,000 - ₹2,50,000 (~$1,200 - $3,000)',
            'timeline' => '1 - 4 weeks',
            'message' => 'Need a custom inventory management system with role-based access.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('enquiries', [
            'name' => 'Sarah Client',
            'email' => 'sarah@startup.com',
            'project_type' => 'Custom Web App (Laravel / Full-Stack)',
            'budget_range' => '₹1,00,000 - ₹2,50,000 (~$1,200 - $3,000)',
            'timeline' => '1 - 4 weeks',
            'status' => 'new',
        ]);
    }

    public function test_contact_form_validates_required_fields(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => '',
            'email' => 'not-an-email',
            'message' => 'short',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
    }

    public function test_contact_form_sends_admin_notification_email(): void
    {
        Mail::fake();

        $this->post(route('contact.submit'), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'message' => 'I would like to know more about your services.',
        ]);

        Mail::assertSent(EnquiryNotification::class, function ($mail) {
            return $mail->hasTo(Setting::get('contact_email', 'hello@example.com'));
        });
    }

    public function test_contact_form_sends_enquiry_confirmation_email(): void
    {
        Mail::fake();

        $this->post(route('contact.submit'), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'message' => 'I would like to know more about your services.',
        ]);

        Mail::assertSent(EnquiryConfirmation::class, function ($mail) {
            return $mail->hasTo('jane@example.com');
        });
    }
}
