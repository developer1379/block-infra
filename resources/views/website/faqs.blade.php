<x-website-layout>

    <div class="container-fluid bg-dark text-center py-6 mb-5">
        <h1 class="display-5 text-uppercase fw-bold" style="color:#b3d33c;">{{ __('FAQs') }}</h1>
        <p class="text-white-50">{{ __('Your Questions — Answered by Bloc Infra Experts') }}</p>
    </div>

    <div class="container py-5">
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
                <div class="accordion-item mb-3 border border-dark rounded">
                    <h2 class="accordion-header" id="heading{{ $key }}">
                        <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $key }}" aria-expanded="false"
                            aria-controls="collapse{{ $key }}">
                            {{ $item['q'] }}
                        </button>
                    </h2>
                    <div id="collapse{{ $key }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $key }}"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-secondary">{{ $item['a'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</x-website-layout>
