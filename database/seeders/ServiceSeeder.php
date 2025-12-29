<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // ₱100 Services
            [
                'name' => 'Mini/Small Research Tasks',
                'description' => 'Quick research assistance for small-scale projects and tasks. Perfect for students and professionals who need help with specific research components or quick fact-checking.',
                'price' => 100.00,
                'initial_payment_percentage' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Humanize (AI Reduction)',
                'description' => 'Transform AI-generated content into natural, human-written text. We help reduce AI detection and improve the authenticity of your documents while maintaining the original meaning.',
                'price' => 100.00,
                'initial_payment_percentage' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Inhouse Experts (Business, IT, Medicine)',
                'description' => 'Access to our team of specialized experts in Business, IT, and Medicine for consultation and guidance on your projects. Get professional insights from industry experts.',
                'price' => 100.00,
                'initial_payment_percentage' => 50,
                'is_active' => true,
            ],
            // ₱500 Services (with Certificate)
            [
                'name' => 'Grammarian (Promo)',
                'description' => 'Comprehensive grammar checking and correction ensuring clarity, precision, and academic standards. Includes a certificate of completion. Our grammar validation service meticulously reviews your document for grammatical errors, syntax issues, punctuation mistakes, and style inconsistencies.',
                'price' => 500.00,
                'initial_payment_percentage' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Validation',
                'description' => 'Professional validation service to verify and authenticate your research data, methodology, and findings. Includes certificate of validation upon completion.',
                'price' => 500.00,
                'initial_payment_percentage' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'One-time Consultation',
                'description' => 'Expert one-on-one consultation session to discuss your research needs, methodology, or academic writing challenges. Receive personalized guidance and recommendations. Certificate included.',
                'price' => 500.00,
                'initial_payment_percentage' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Research Instrument',
                'description' => 'Professional development and validation of research instruments including questionnaires, surveys, and data collection tools. Includes certificate of instrument validation.',
                'price' => 500.00,
                'initial_payment_percentage' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Paraphrasing (Similarity/Plagiarism Reduction)',
                'description' => 'Professional paraphrasing services to reduce similarity and plagiarism while maintaining original meaning and enhancing clarity. Includes certificate of originality.',
                'price' => 500.00,
                'initial_payment_percentage' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Thematic Analysis',
                'description' => 'Expert analysis of themes, patterns, and underlying meanings in academic and literary texts. Our thematic analysis service provides deep insights into the conceptual framework and thematic structure of your work. Certificate included.',
                'price' => 500.00,
                'initial_payment_percentage' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Methodology',
                'description' => 'Guidance on research design, methodology selection, and methodological rigor in academic writing. We help you develop robust research methodologies that meet academic standards. Certificate of methodology validation included.',
                'price' => 500.00,
                'initial_payment_percentage' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Summary, Conclusion, and Recommendations',
                'description' => 'Professional writing of summary, conclusion, and recommendations sections for your research. Ensures coherence, clarity, and academic standards. Certificate included.',
                'price' => 500.00,
                'initial_payment_percentage' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Statistical Analysis (with inhouse statistician)',
                'description' => 'Comprehensive statistical analysis performed by our in-house statistician. Includes data analysis, interpretation, and presentation of results. Certificate of statistical validation included.',
                'price' => 500.00,
                'initial_payment_percentage' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Inhouse Experts (Business, IT, Medicine, Psychology)',
                'description' => 'Access to our team of specialized experts in Business, IT, Medicine, and Psychology for comprehensive consultation and project guidance. Certificate of expert consultation included.',
                'price' => 500.00,
                'initial_payment_percentage' => 50,
                'is_active' => true,
            ],
            // Premium Services (existing higher-priced services)
            [
                'name' => 'Grammar Validation',
                'description' => 'Comprehensive grammar checking and correction ensuring clarity, precision, and academic standards. Our grammar validation service meticulously reviews your document for grammatical errors, syntax issues, punctuation mistakes, and style inconsistencies.',
                'price' => 5000.00,
                'initial_payment_percentage' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Paraphrasing',
                'description' => 'Professional paraphrasing services maintaining original meaning while enhancing clarity and academic tone. We help you express your ideas more effectively while preserving the integrity of your original content.',
                'price' => 6000.00,
                'initial_payment_percentage' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Thematic Analysis',
                'description' => 'Expert analysis of themes, patterns, and underlying meanings in academic and literary texts. Our thematic analysis service provides deep insights into the conceptual framework and thematic structure of your work.',
                'price' => 8000.00,
                'initial_payment_percentage' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Methodology Assistance',
                'description' => 'Guidance on research design, methodology selection, and methodological rigor in academic writing. We help you develop robust research methodologies that meet academic standards and enhance the credibility of your work.',
                'price' => 10000.00,
                'initial_payment_percentage' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Research Consultancy',
                'description' => 'Comprehensive research support from conceptualization to publication-ready manuscripts. Our research consultancy provides end-to-end support for your academic research projects, including literature review, data analysis guidance, and manuscript preparation.',
                'price' => 15000.00,
                'initial_payment_percentage' => 50,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            // Check if service already exists to avoid duplicates
            $existing = Service::where('name', $service['name'])->first();
            if (!$existing) {
                Service::create($service);
            }
        }
    }
}
