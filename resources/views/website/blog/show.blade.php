<x-website-layout 
    title="{{ $blog->meta_title ?: $blog->title . ' | Bloc-Infra Blog' }}"
    description="{{ $blog->meta_description ?: Str::limit(strip_tags($blog->content), 155) }}"
    keywords="{{ $blog->meta_keywords ?: 'Kanpur construction, Bloc-Infra post' }}"
>
    {{-- Page Header --}}
    <div class="container-fluid page-header text-center mb-5">
        <div class="container">
            <h1 class="display-4 text-uppercase mb-3 wow fadeInDown" data-wow-delay="0.2s" style="color:#b3d33c; font-size: 32px; line-height: 1.3;">
                {{ $blog->title }}
            </h1>
            <p class="lead text-light mb-0 fw-semibold wow fadeInUp" data-wow-delay="0.4s" style="font-size: 14px; letter-spacing: 0.5px;">
                <i class="bi bi-calendar-event me-2" style="color:#b3d33c;"></i>
                {{ $blog->published_at ? $blog->published_at->format('F d, Y') : $blog->created_at->format('F d, Y') }}
                <span class="mx-3 text-muted">|</span>
                <i class="bi bi-person me-2" style="color:#b3d33c;"></i>
                {{ __('By Admin') }}
            </p>
        </div>
    </div>

    {{-- Blog Body Section --}}
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                {{-- Featured Image --}}
                @if($blog->image_url)
                    <div class="mb-5 rounded-3 overflow-hidden shadow" style="max-height: 480px;">
                        <img src="{{ $blog->image_url }}" class="w-100 h-100 object-cover" alt="{{ $blog->title }}">
                    </div>
                @endif

                {{-- Post Content --}}
                <div class="text-white-50 lh-lg article-body mb-5" style="font-size: 16px; text-align: justify; word-wrap: break-word;">
                    {!! $blog->content !!}
                </div>

                {{-- Back Redirect --}}
                <div class="border-top border-secondary pt-4 d-flex justify-content-between align-items-center">
                    <a href="{{ route('website.blog.index') }}" class="btn btn-outline-light rounded-pill px-4" style="border-color: rgba(255,255,255,0.15);">
                        <i class="fa-solid fa-arrow-left me-2 text-xs" style="font-size: 11px;"></i> {{ __('Back to Blog') }}
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-website-layout>
