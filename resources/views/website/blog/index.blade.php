<x-website-layout 
    title="Blog & Insights | Bloc-Infra Construction & Technology"
    description="Read the latest articles, guides, and construction insights from Bloc-Infra. Stay updated with modern building practices, design, and management."
    keywords="construction blog, building guides, design consulting updates, contractor platform insights"
>
    {{-- Page Header --}}
    <div class="container-fluid page-header text-center mb-5">
        <div class="container">
            <h1 class="display-4 text-uppercase mb-3 wow fadeInDown" data-wow-delay="0.2s" style="color:#b3d33c;">
                {{ __('Bloc-Infra Insights') }}
            </h1>
            <p class="lead text-light mb-0 fw-semibold wow fadeInUp" data-wow-delay="0.4s">
                {{ __('Expert commentary, technology trends, and industry perspectives.') }}
            </p>
        </div>
    </div>

    {{-- Filter & Search Panel --}}
    <div class="container mb-5">
        <div class="bg-dark p-4 p-md-5 rounded-4 shadow-sm border border-secondary wow fadeInUp" data-wow-delay="0.1s" style="border-color: rgba(255,255,255,0.08) !important; border-radius: 20px;">
            <form action="{{ route('website.blog.index') }}" method="GET" class="row g-4 align-items-center">
                {{-- Search Bar --}}
                <div class="col-lg-5">
                    <div class="input-group bg-dark border rounded-pill overflow-hidden px-2 py-1" style="border-color: rgba(255,255,255,0.15) !important;">
                        <span class="input-group-text bg-transparent border-0 text-white-50"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-transparent border-0 text-white placeholder-secondary focus-none" style="box-shadow: none;" placeholder="{{ __('Search articles, guides...') }}">
                        @if(request('search') || request('category'))
                            <a href="{{ route('website.blog.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill d-flex align-items-center justify-content-center px-3" style="font-size: 11px;">
                                {{ __('Clear') }}
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Category Pills --}}
                <div class="col-lg-7">
                    <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                        <a href="{{ route('website.blog.index', ['search' => request('search')]) }}" 
                           class="btn btn-sm rounded-pill px-4 py-2 text-uppercase fw-semibold transition-all {{ !request('category') ? 'btn-primary text-dark' : 'btn-outline-light text-white-50' }}"
                           style="{{ !request('category') ? 'background-color:#b3d33c !important; border-color:#b3d33c !important; color:#000 !important;' : 'border-color: rgba(255,255,255,0.15);' }}">
                            {{ __('All Topics') }}
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('website.blog.index', ['category' => $cat, 'search' => request('search')]) }}" 
                               class="btn btn-sm rounded-pill px-4 py-2 text-uppercase fw-semibold transition-all {{ request('category') === $cat ? 'btn-primary text-dark' : 'btn-outline-light text-white-50' }}"
                               style="{{ request('category') === $cat ? 'background-color:#b3d33c !important; border-color:#b3d33c !important; color:#000 !important;' : 'border-color: rgba(255,255,255,0.15);' }}">
                                {{ __($cat) }}
                            </a>
                        @endforeach
                    </div>
                </div>
                
                {{-- Keep category filter if searching --}}
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
            </form>
        </div>
    </div>

    {{-- Blog Grid Section --}}
    <div class="container py-3">
        <div class="row g-4">
            @forelse($blogs as $blog)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="card h-100 border-0 bg-dark shadow-sm overflow-hidden" style="border-radius: 16px; border: 1px solid rgba(255,255,255,0.05) !important;">
                        {{-- Image --}}
                        <div class="position-relative" style="height: 220px; overflow: hidden;">
                            @if($blog->image_url)
                                <img src="{{ $blog->image_url }}" class="w-100 h-100 object-cover" style="transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'" alt="{{ $blog->title }}">
                            @else
                                <div class="w-100 h-100 bg-secondary d-flex align-items-center justify-content-center" style="background-color: #212529 !important;">
                                    <i class="bi bi-journal-text text-white-50 fs-1"></i>
                                </div>
                            @endif
                            
                            {{-- Topic Badge --}}
                            @if($blog->category)
                                <span class="position-absolute top-3 start-3 px-3 py-1 rounded-pill text-dark fw-bold uppercase tracking-wider text-xs font-semibold" style="font-size: 10px; background-color:#b3d33c !important;">
                                    {{ __($blog->category) }}
                                </span>
                            @endif
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body p-4 d-flex flex-column h-100 justify-content-between">
                            <div>
                                <div class="text-white-50 small mb-2">
                                    <i class="bi bi-calendar-event me-2"></i>{{ $blog->published_at ? $blog->published_at->format('M d, Y') : $blog->created_at->format('M d, Y') }}
                                </div>
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
                        <h3>{{ __('No Match Found') }}</h3>
                        <p>{{ __('We could not find any articles matching your search criteria. Try resetting the filters.') }}</p>
                        <a href="{{ route('website.blog.index') }}" class="btn btn-primary rounded-pill px-4 py-2 text-dark font-semibold" style="background-color: #b3d33c; border-color: #b3d33c;">
                            {{ __('Reset Filters') }}
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($blogs->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $blogs->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
    
    <style>
        .hover-teal:hover {
            color: #b3d33c !important;
        }
        .focus-none:focus {
            outline: none !important;
            box-shadow: none !important;
        }
    </style>
</x-website-layout>
