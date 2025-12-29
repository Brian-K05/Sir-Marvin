@extends('layouts.public')

@section('title', 'About')

@section('content')
<section class="page-header">
    <div class="container">
        <span class="section-label">About</span>
        <h1>Marvin Dominic B. Buena</h1>
        <p class="page-subtitle">Research Consultant & Professional Editor</p>
        <div class="about-achievement-badge">
            <span>With over 5,000++ Commissions since 2018</span>
        </div>
    </div>
</section>

<section class="about-content">
    <div class="container">
        <div class="about-profile-section">
            <div class="about-profile-image">
                <div class="profile-image-wrapper">
                    <img src="{{ asset('images/marvin.jpg') }}" alt="Marvin Dominic B. Buena" class="profile-image">
                </div>
            </div>
        </div>
        
        <div class="about-intro">
            <h2>Excellence in Language and Research</h2>
            <p class="about-description">Marvin Dominic B. Buena is a distinguished academic and professional with a profound dedication to the precision and clarity of written communication. With over 5,000 commissions completed since 2018, he brings a wealth of experience in educational development and innovation.</p>
            
            <div class="background-section">
                <h3>Background of the Editor</h3>
                <p>Learn more about Marvin Dominic B. Buena's academic and professional journey:</p>
                <div class="background-links">
                    <a href="https://www.google.com/search?q=marvin+dominic+b.+buena&oq=&gs_lcrp=EgZjaHJvbWUqBggBEEUYOzIGCAAQRRg5MgYIARBFGDsyBggCEEUYOzINCAMQABiRAhiABBiKBTIMCAQQABhDGIAEGIoFMgYIBRBFGEEyBggGEEUYPDINCAcQABiRAhiABBiKBTIMCAgQABhDGIAEGIoFMgwICRAAGEMYgAQYigUyDAgKEAAYQxiABBiKBTIMCAsQABhDGIAEGIoFMgwIDBAAGEMYgAQYigUyDAgNEAAYQxiABBiKBTIKCA4QABixAxiABNIBCDE5NzBqMGo5qAIOsAIB8QU8kSmwAvgEGvEFPJEpsAL4BBo&client=ms-android-samsung-ss&sourceid=chrome-mobile&ie=UTF-8" target="_blank" rel="noopener noreferrer" class="background-link">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 18.3333C14.6024 18.3333 18.3333 14.6024 18.3333 10C18.3333 5.39763 14.6024 1.66667 10 1.66667C5.39763 1.66667 1.66667 5.39763 1.66667 10C1.66667 14.6024 5.39763 18.3333 10 18.3333Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10 6.66667V10L12.5 12.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Search Me on Google
                    </a>
                    <a href="https://scholar.google.com/citations?user=rpqEofYAAAAJ&hl=en" target="_blank" rel="noopener noreferrer" class="background-link">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19.5C4 18.837 4.263 18.201 4.732 17.732C5.201 17.263 5.837 17 6.5 17H20M4 19.5C4 20.163 4.263 20.799 4.732 21.268C5.201 21.737 5.837 22 6.5 22H20M4 19.5V4.5C4 3.837 4.263 3.201 4.732 2.732C5.201 2.263 5.837 2 6.5 2H20V19.5M20 19.5V22.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Google Scholar Profile
                    </a>
                    <a href="https://www.facebook.com/share/17WznJ5m5T/" target="_blank" rel="noopener noreferrer" class="background-link">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 1.66667C5.39763 1.66667 1.66667 5.39763 1.66667 10C1.66667 14.6024 5.39763 18.3333 10 18.3333C14.6024 18.3333 18.3333 14.6024 18.3333 10C18.3333 5.39763 14.6024 1.66667 10 1.66667ZM11.25 10.8333H9.58333V15H8.33333V10.8333H7.08333V9.58333H8.33333V8.75C8.33333 7.5875 8.92083 7.08333 9.91667 7.08333C10.3125 7.08333 10.625 7.125 10.8333 7.16667V8.33333H10C9.64583 8.33333 9.58333 8.45833 9.58333 8.75V9.58333H10.8333L11.25 10.8333Z" fill="currentColor"/>
                        </svg>
                        Facebook Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Educational Background Section -->
        <div class="credentials-section">
            <div class="section-header-inline">
                <span class="section-label">Education</span>
                <h3>Educational Background</h3>
            </div>
            <div class="education-list">
                <div class="education-item">
                    <div class="education-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 14L16 10L12 6M8 10H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="education-content">
                        <h4>Doctor of Philosophy in English Studies (units)</h4>
                        <p class="education-institution">University of the Philippines</p>
                        <p class="education-period">2021 to Present</p>
                    </div>
                </div>
                <div class="education-item">
                    <div class="education-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="education-content">
                        <h4>Master of Arts in English Language Teaching</h4>
                        <p class="education-institution">Polytechnic University of the Philippines</p>
                        <p class="education-period">Graduated 2019</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Researches Section -->
        <div class="publications-section">
            <div class="section-header-inline">
                <span class="section-label">Research</span>
                <h3>Researches</h3>
            </div>
            <div class="publications-list">
                <div class="publication-item">
                    <div class="publication-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19.5C4 18.837 4.263 18.201 4.732 17.732C5.201 17.263 5.837 17 6.5 17H20M4 19.5C4 20.163 4.263 20.799 4.732 21.268C5.201 21.737 5.837 22 6.5 22H20M4 19.5V4.5C4 3.837 4.263 3.201 4.732 2.732C5.201 2.263 5.837 2 6.5 2H20V19.5M20 19.5V22.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="publication-content">
                        <h4>eLearning for literature instruction</h4>
                        <p class="publication-journal">DALIN Journal, Volume 1 Issue 1 June 2022</p>
                        <p class="publication-issn">ISSN: 2960-3617</p>
                    </div>
                </div>
                <div class="publication-item">
                    <div class="publication-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19.5C4 18.837 4.263 18.201 4.732 17.732C5.201 17.263 5.837 17 6.5 17H20M4 19.5C4 20.163 4.263 20.799 4.732 21.268C5.201 21.737 5.837 22 6.5 22H20M4 19.5V4.5C4 3.837 4.263 3.201 4.732 2.732C5.201 2.263 5.837 2 6.5 2H20V19.5M20 19.5V22.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="publication-content">
                        <h4>Sweet Spots for Qualitative science: Basis for Stem Qualitative Research Policy</h4>
                        <p class="publication-journal">APCOREVCIO CONFERENCE PROCEEDINGS, Vol. 1 issue 1, 2021</p>
                    </div>
                </div>
                <div class="publication-item">
                    <div class="publication-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19.5C4 18.837 4.263 18.201 4.732 17.732C5.201 17.263 5.837 17 6.5 17H20M4 19.5C4 20.163 4.263 20.799 4.732 21.268C5.201 21.737 5.837 22 6.5 22H20M4 19.5V4.5C4 3.837 4.263 3.201 4.732 2.732C5.201 2.263 5.837 2 6.5 2H20V19.5M20 19.5V22.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="publication-content">
                        <h4>Students' Engagement in an Online Classroom: A Case Study on Remediation Classes</h4>
                        <p class="publication-journal">The Educator's Link: Connecting Teachers Around the World, Vol 1 issue 7 August 2021</p>
                        <p class="publication-issn">ISSN: 2782-859X</p>
                    </div>
                </div>
                <div class="publication-item">
                    <div class="publication-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19.5C4 18.837 4.263 18.201 4.732 17.732C5.201 17.263 5.837 17 6.5 17H20M4 19.5C4 20.163 4.263 20.799 4.732 21.268C5.201 21.737 5.837 22 6.5 22H20M4 19.5V4.5C4 3.837 4.263 3.201 4.732 2.732C5.201 2.263 5.837 2 6.5 2H20V19.5M20 19.5V22.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="publication-content">
                        <h4>Moves analysis of the scientific thesis introductions of the Grade 12 STEM students of the University of the East-Caloocan Campus</h4>
                        <p class="publication-journal">Psychology and Education Journal, Vol. 5 Issue No. 4 2021</p>
                        <p class="publication-issn">ISSN: 0033-3077</p>
                    </div>
                </div>
                <div class="publication-item">
                    <div class="publication-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19.5C4 18.837 4.263 18.201 4.732 17.732C5.201 17.263 5.837 17 6.5 17H20M4 19.5C4 20.163 4.263 20.799 4.732 21.268C5.201 21.737 5.837 22 6.5 22H20M4 19.5V4.5C4 3.837 4.263 3.201 4.732 2.732C5.201 2.263 5.837 2 6.5 2H20V19.5M20 19.5V22.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="publication-content">
                        <h4>Semantic Deviations in Jose Garcia Villa's 'Poem 130': A Stylistic Analysis</h4>
                        <p class="publication-journal">Asian Journal for English Language Studies (AJELS) Online Journal, Volume 7, December 2019</p>
                        <p class="publication-issn">ISSN: 2619-7219</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Editorship Section -->
        <div class="editorship-section">
            <div class="section-header-inline">
                <span class="section-label">Editorship</span>
                <h3>Editorship</h3>
            </div>
            <div class="editorship-list">
                <div class="editorship-item">
                    <div class="editorship-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 6.25278V19.2528M12 6.25278C10.8321 5.47686 9.24649 5 7.5 5C5.75351 5 4.16789 5.47686 3 6.25278V19.2528C4.16789 18.4769 5.75351 18 7.5 18C9.24649 18 10.8321 18.4769 12 19.2528M12 6.25278C13.1679 5.47686 14.7535 5 16.5 5C18.2465 5 19.8321 5.47686 21 6.25278V19.2528C19.8321 18.4769 18.2465 18 16.5 18C14.7535 18 13.1679 18.4769 12 19.2528" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="editorship-content">
                        <h4>Law Enforcement Organization and Administration</h4>
                        <p class="editorship-publisher">Chapterhouse Publishing, Inc.</p>
                        <p class="editorship-year">2021</p>
                    </div>
                </div>
                <div class="editorship-item">
                    <div class="editorship-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 6.25278V19.2528M12 6.25278C10.8321 5.47686 9.24649 5 7.5 5C5.75351 5 4.16789 5.47686 3 6.25278V19.2528C4.16789 18.4769 5.75351 18 7.5 18C9.24649 18 10.8321 18.4769 12 19.2528M12 6.25278C13.1679 5.47686 14.7535 5 16.5 5C18.2465 5 19.8321 5.47686 21 6.25278V19.2528C19.8321 18.4769 18.2465 18 16.5 18C14.7535 18 13.1679 18.4769 12 19.2528" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="editorship-content">
                        <h4>Kite Academy English eModules Grades 7-10</h4>
                        <p class="editorship-publisher">C&E Publishing Inc.</p>
                        <p class="editorship-year">2018</p>
                    </div>
                </div>
                <div class="editorship-item">
                    <div class="editorship-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 6.25278V19.2528M12 6.25278C10.8321 5.47686 9.24649 5 7.5 5C5.75351 5 4.16789 5.47686 3 6.25278V19.2528C4.16789 18.4769 5.75351 18 7.5 18C9.24649 18 10.8321 18.4769 12 19.2528M12 6.25278C13.1679 5.47686 14.7535 5 16.5 5C18.2465 5 19.8321 5.47686 21 6.25278V19.2528C19.8321 18.4769 18.2465 18 16.5 18C14.7535 18 13.1679 18.4769 12 19.2528" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="editorship-content">
                        <h4>LEAP e-Assessments Grades 3 to 6</h4>
                        <p class="editorship-publisher">C&E Publishing Inc.</p>
                        <p class="editorship-subjects">Math, Science, English, Filipino, Aralin Panlipunan, Social Studies</p>
                        <p class="editorship-year">2017</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="contact-cta">
            <h3>Ready to Work Together?</h3>
            <p>Contact me to discuss your editing and research needs</p>
            <a href="{{ route('contact') }}" class="btn-primary btn-large">
                <span>Get in Touch</span>
            </a>
        </div>
    </div>
</section>
@endsection

