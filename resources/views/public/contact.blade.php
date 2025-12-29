@extends('layouts.public')

@section('title', 'Contact')

@section('content')
<section class="page-header">
    <div class="container">
        <h1>Contact Us</h1>
        <p class="page-subtitle">We're here to help with all your questions and concerns</p>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <!-- Introduction/Guide Section -->
        <div class="contact-intro" style="max-width: 800px; margin: 0 auto 3rem; text-align: center;">
            <div class="info-box" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2.5rem; border-radius: 16px; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);">
                <h2 style="color: white; margin-bottom: 1rem; font-size: 1.75rem;">Need Help? We're Just a Message Away!</h2>
                <p style="font-size: 1.1rem; line-height: 1.7; margin-bottom: 0; opacity: 0.95;">
                    Have questions about our services, pricing, or need assistance with your submission? 
                    We're here to help! Reach out to us through Messenger or give us a call. 
                    Our team is ready to assist you with any concerns or inquiries.
                </p>
            </div>
        </div>

        <!-- Contact Methods Grid -->
        <div class="contact-methods-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; max-width: 900px; margin: 0 auto;">
            <!-- Messenger Card -->
            <div class="contact-method-card" style="background: white; border-radius: 16px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 2px solid transparent;">
                <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #0084ff 0%, #0066cc 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 4px 15px rgba(0, 132, 255, 0.3);">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.15 2 11.25C2 14.13 3.42 16.7 5.57 18.22L4.82 21.22C4.65 21.75 5.12 22.18 5.62 21.97L9.16 20.53C9.96 20.68 10.78 20.75 11.62 20.75H12C17.52 20.75 22 16.6 22 11.5C22 6.4 17.52 2.25 12 2.25V2ZM12 19.25H11.5C10.8 19.25 10.12 19.18 9.46 19.05L9.25 19L5.97 20.25L6.64 17.7L6.43 17.55C4.5 16.18 3.25 13.95 3.25 11.5C3.25 7.35 7.18 4 12 4C16.82 4 20.75 7.35 20.75 11.5C20.75 15.65 16.82 19 12 19V19.25Z" fill="white"/>
                        <path d="M12 6.75C9.1 6.75 6.75 8.86 6.75 11.5C6.75 12.68 7.18 13.75 7.9 14.55L7.25 17.25L10.15 16.15C10.85 16.35 11.6 16.45 12.35 16.45C15.25 16.45 17.6 14.34 17.6 11.7C17.6 9.06 15.25 6.95 12.35 6.95H12V6.75Z" fill="white"/>
                    </svg>
                </div>
                <h3 style="text-align: center; margin-bottom: 0.75rem; color: var(--deep-navy); font-size: 1.5rem;">Message Us on Messenger</h3>
                <p style="text-align: center; color: var(--warm-gray); margin-bottom: 1.5rem; line-height: 1.6;">
                    For quick responses and easy communication, send us a message on Facebook Messenger. 
                    We typically respond within a few hours.
                </p>
                <a href="https://www.facebook.com/acadresearchconsultant/" target="_blank" rel="noopener noreferrer" 
                   class="contact-btn-messenger" 
                   style="display: flex; align-items: center; justify-content: center; gap: 0.75rem; background: linear-gradient(135deg, #0084ff 0%, #0066cc 100%); color: white; padding: 1rem 2rem; border-radius: 12px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0, 132, 255, 0.3);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.15 2 11.25C2 14.13 3.42 16.7 5.57 18.22L4.82 21.22C4.65 21.75 5.12 22.18 5.62 21.97L9.16 20.53C9.96 20.68 10.78 20.75 11.62 20.75H12C17.52 20.75 22 16.6 22 11.5C22 6.4 17.52 2.25 12 2.25V2Z" fill="white"/>
                    </svg>
                    Open Messenger
                </a>
            </div>

            <!-- Phone Card -->
            <div class="contact-method-card" style="background: white; border-radius: 16px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 2px solid transparent;">
                <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #059669 0%, #047857 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.62 10.79C8.06 13.62 10.38 15.94 13.21 17.38L15.41 15.18C15.69 14.9 16.08 14.82 16.43 14.93C17.55 15.3 18.75 15.5 20 15.5C20.55 15.5 21 15.95 21 16.5V20C21 20.55 20.55 21 20 21C10.61 21 3 13.39 3 4C3 3.45 3.45 3 4 3H7.5C8.05 3 8.5 3.45 8.5 4C8.5 5.25 8.7 6.45 9.07 7.57C9.18 7.92 9.1 8.31 8.82 8.59L6.62 10.79Z" fill="white"/>
                    </svg>
                </div>
                <h3 style="text-align: center; margin-bottom: 0.75rem; color: var(--deep-navy); font-size: 1.5rem;">Call Us Directly</h3>
                <p style="text-align: center; color: var(--warm-gray); margin-bottom: 1.5rem; line-height: 1.6;">
                    Prefer to speak with us? Give us a call during business hours. 
                    We're happy to answer your questions over the phone.
                </p>
                <a href="tel:09223549524" 
                   class="contact-btn-phone" 
                   style="display: flex; align-items: center; justify-content: center; gap: 0.75rem; background: linear-gradient(135deg, #059669 0%, #047857 100%); color: white; padding: 1rem 2rem; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 1.1rem; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.62 10.79C8.06 13.62 10.38 15.94 13.21 17.38L15.41 15.18C15.69 14.9 16.08 14.82 16.43 14.93C17.55 15.3 18.75 15.5 20 15.5C20.55 15.5 21 15.95 21 16.5V20C21 20.55 20.55 21 20 21C10.61 21 3 13.39 3 4C3 3.45 3.45 3 4 3H7.5C8.05 3 8.5 3.45 8.5 4C8.5 5.25 8.7 6.45 9.07 7.57C9.18 7.92 9.1 8.31 8.82 8.59L6.62 10.79Z" fill="white"/>
                    </svg>
                    09223549524
                </a>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="contact-additional-info" style="max-width: 800px; margin: 3rem auto 0; padding: 2rem; background: var(--off-white); border-radius: 16px; border-left: 4px solid var(--primary-blue);">
            <h3 style="color: var(--deep-navy); margin-bottom: 1rem; font-size: 1.25rem;">What Can We Help You With?</h3>
            <ul style="list-style: none; padding: 0; margin: 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <li style="display: flex; align-items: flex-start; gap: 0.75rem;">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink: 0; margin-top: 0.25rem; color: var(--primary-blue);">
                        <path d="M10 18C14.4183 18 18 14.4183 18 10C18 5.58172 14.4183 2 10 2C5.58172 2 2 5.58172 2 10C2 14.4183 5.58172 18 10 18Z" stroke="currentColor" stroke-width="2"/>
                        <path d="M7 10L9 12L13 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span style="color: var(--charcoal);">Service inquiries and pricing</span>
                </li>
                <li style="display: flex; align-items: flex-start; gap: 0.75rem;">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink: 0; margin-top: 0.25rem; color: var(--primary-blue);">
                        <path d="M10 18C14.4183 18 18 14.4183 18 10C18 5.58172 14.4183 2 10 2C5.58172 2 2 5.58172 2 10C2 14.4183 5.58172 18 10 18Z" stroke="currentColor" stroke-width="2"/>
                        <path d="M7 10L9 12L13 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span style="color: var(--charcoal);">Submission status updates</span>
                </li>
                <li style="display: flex; align-items: flex-start; gap: 0.75rem;">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink: 0; margin-top: 0.25rem; color: var(--primary-blue);">
                        <path d="M10 18C14.4183 18 18 14.4183 18 10C18 5.58172 14.4183 2 10 2C5.58172 2 2 5.58172 2 10C2 14.4183 5.58172 18 10 18Z" stroke="currentColor" stroke-width="2"/>
                        <path d="M7 10L9 12L13 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span style="color: var(--charcoal);">Payment and billing questions</span>
                </li>
                <li style="display: flex; align-items: flex-start; gap: 0.75rem;">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink: 0; margin-top: 0.25rem; color: var(--primary-blue);">
                        <path d="M10 18C14.4183 18 18 14.4183 18 10C18 5.58172 14.4183 2 10 2C5.58172 2 2 5.58172 2 10C2 14.4183 5.58172 18 10 18Z" stroke="currentColor" stroke-width="2"/>
                        <path d="M7 10L9 12L13 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span style="color: var(--charcoal);">Technical support and assistance</span>
                </li>
            </ul>
        </div>
    </div>
</section>

<style>
.contact-method-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    border-color: var(--primary-blue);
}

.contact-btn-messenger:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 132, 255, 0.4);
}

.contact-btn-phone:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
}

@media (max-width: 768px) {
    .contact-methods-grid {
        grid-template-columns: 1fr;
    }
    
    .contact-intro .info-box {
        padding: 2rem 1.5rem;
    }
    
    .contact-method-card {
        padding: 2rem 1.5rem;
    }
}
</style>
@endsection

