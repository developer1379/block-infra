<x-website-layout>

    <style>
        .accordion-button {
            padding: 22px 28px;
            font-size: 16px;
            background-color: #ffffff;
            color: #111827;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            border-bottom: 1px solid rgba(0, 0, 0, 0.02);
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(179, 211, 60, 0.2);
        }

        .accordion-button:not(.collapsed) {
            background-color: rgba(179, 211, 60, 0.05) !important;
            color: #000000 !important;
            border-left: 4px solid #b3d33c;
            box-shadow: 0 4px 12px rgba(179, 211, 60, 0.08);
        }
        
        .accordion-item {
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            border-radius: 14px !important;
            overflow: hidden;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.01);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .accordion-item:hover {
            box-shadow: 0 10px 25px rgba(0,0,0,0.04);
            border-color: rgba(179, 211, 60, 0.2) !important;
        }

        .accordion-body {
            font-size: 15px;
            color: #4b5563;
            line-height: 1.7;
            background-color: #f9fafb;
            padding: 24px 28px;
        }

        .help-card {
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.02);
            padding: 40px 30px !important;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .help-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.06);
            border-color: rgba(179, 211, 60, 0.3);
        }
        .help-icon-wrap {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            background: rgba(179, 211, 60, 0.08);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            color: #b3d33c;
            transition: all 0.3s ease;
        }
        .help-card:hover .help-icon-wrap {
            background: #b3d33c;
            color: #000000;
            transform: scale(1.05);
        }
    </style>

    {{-- Page Header --}}
    <div class="container-fluid page-header text-center mb-5">
        <div class="container">
            <h1 class="display-4 text-uppercase mb-3 wow fadeInDown" data-wow-delay="0.2s" style="color:#b3d33c;">
                {{ __('FAQs') }}
            </h1>
            <p class="lead text-light mb-0 fw-semibold wow fadeInUp" data-wow-delay="0.4s">
                {{ __('Your Questions — Answered by Bloc Infra Experts') }}
            </p>
        </div>
    </div>

    <div class="container py-5">
        <div class="row g-5">
            
            {{-- HELP CARD (Left Column) --}}
            <div class="col-lg-4 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="card help-card text-center">
                    <div class="help-icon-wrap">
                        <i class="bi bi-question-circle-fill fs-1"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-3">{{ __('Still have questions?') }}</h5>
                    <p class="text-muted small px-2 mb-4">
                        {{ __('If you cannot find answer to your query in our FAQs, you can reach out directly to our engineering coordinators.') }}
                    </p>
                    <a href="{{ route('website.contact') }}" class="btn btn-primary w-100 py-3 rounded-pill fw-bold text-uppercase">
                        <i class="bi bi-chat-left-text me-2"></i> {{ __('Ask Our Experts') }}
                    </a>
                </div>
            </div>

            {{-- ACCORDION (Right Column) --}}
            <div class="col-lg-8 wow fadeInRight" data-wow-delay="0.4s">
                <div class="accordion" id="faqAccordion">
                    @php
                        $faqs = [
                            ['q' => __('What services does Bloc Infra provide?'), 'a' => __('We offer end-to-end construction, infrastructure, design, and project management solutions.')],
                            ['q' => __('How can I get a quote for my project?'), 'a' => __('Simply visit our Contact page or use the Request Demo option to get started.')],
                            ['q' => __('Does Bloc Infra take government or private projects?'), 'a' => __('Yes, we handle both government and private infrastructure projects.')],
                            ['q' => __('Where is Bloc Infra located?'), 'a' => __('Our office is at Flat No. 202, Plot No. 674, Vishambhar Sadan, Vikas Nagar, Kanpur.')]
                        ];
                    @endphp

                    @foreach ($faqs as $key => $item)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $key }}">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $key }}" aria-expanded="false"
                                    aria-controls="collapse{{ $key }}">
                                    {{ $item['q'] }}
                                </button>
                            </h2>
                            <div id="collapse{{ $key }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $key }}"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    {{ $item['a'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</x-website-layout>
