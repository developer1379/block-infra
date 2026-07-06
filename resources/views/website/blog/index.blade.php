<x-website-layout 
    title="Blog & Insights | Bloc-Infra Construction & Technology"
    description="Read the latest articles, guides, and construction insights from Bloc-Infra. Stay updated with modern building practices, design, and management."
    keywords="construction blog, building guides, design consulting updates, contractor platform insights"
>
    {{-- Page Header --}}
    <div class="container-fluid page-header text-center mb-5">
        <div class="container">
            <h1 class="display-4 text-uppercase mb-3 wow fadeInDown" data-wow-delay="0.2s" style="color:#b3d33c;">
                {{ __('Bloc-Infra Blog') }}
            </h1>
            <p class="lead text-light mb-0 fw-semibold wow fadeInUp" data-wow-delay="0.4s">
                {{ __('Latest insights, trends, and expert guides in construction & engineering.') }}
            </p>
        </div>
    </div>

    {{-- Blog Grid Section --}}
    <div class="container py-5">
        <div class="row g-4">
            @forelse($blogs as $blog)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="card h-100 border-0 bg-dark shadow-sm overflow-hidden" style="border-radius: 16px;">
                        {{-- Image --}}
                        <div class="position-relative" style="height: 220px; overflow: hidden;">
                            @if($blog->image)
                                <img src="{{ asset('storage/' . $blog->image) }}" class="w-100 h-100 object-cover" style="transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'" alt="{{ $blog->title }}">
                            @else
                                <div class="w-100 h-100 bg-secondary d-flex align-items-center justify-content-center" style="background-color: #212529 !important;">
                                    <i class="bi bi-journal-text text-white-50 fs-1"></i>
                                </div>
                            @endif
                            <span class="position-absolute top-3 start-3 px-3 py-1 rounded-pill bg-primary text-dark fw-bold uppercase tracking-wider text-xs font-semibold" style="font-size: 11px; background-color:#b3d33c !important;">
                                {{ $blog->published_at ? $blog->published_at->format('M d, Y') : $blog->created_at->format('M d, Y') }}
                            </span>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body p-4 d-flex flex-column h-100 justify-content-between">
                            <div>
                                <h4 class="card-title fw-bold mb-3">
                                    <a href="{{ route('website.blog.show', $blog->slug) }}" class="text-white text-decoration-none hover-teal" style="font-size: 18px; line-height: 1.4;">
                                        {{ Str::limit($blog->title, 60) }}
                                    </a>
                                </h4>
                                <p class="text-white-50 small mb-4 lh-relaxed">
                                    {{ Str::limit(strip_tags($blog->content), 120) }}
                                </p>
                            </div>
                            
                            <a href="{{ route('website.blog.show', $blog->slug) }}" class="btn btn-sm btn-outline-light rounded-pill px-4 align-self-start mt-auto" style="border-color: rgba(255,255,255,0.2);">
                                {{ __('Read More') }} <i class="fa-solid fa-arrow-right ms-1 text-xs" style="font-size: 10px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 py-5 text-center text-white-50">
                    <div class="d-flex flex-column align-items-center gap-3">
                        <i class="bi bi-journal-x fs-1 text-white-50"></i>
                        <h3>{{ __('No Blog Posts Yet') }}</h3>
                        <p>{{ __('We are currently working on writing new expert guides and building insights. Stay tuned!') }}</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($blogs->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $blogs->links() }}
            </div>
        @endif
    </div>
</x-website-layout>
