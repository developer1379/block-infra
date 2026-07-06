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

    {{-- Main Blog Section --}}
    <div class="container py-4">
        <div class="row g-5">
            {{-- Left column: Blog Post, Comments & Comment Form (2/3 width) --}}
            <div class="col-lg-8">
                {{-- Featured Image --}}
                @if($blog->image_url)
                    <div class="mb-5 rounded-3 overflow-hidden shadow-sm" style="max-height: 480px;">
                        <img src="{{ $blog->image_url }}" class="w-100 h-100 object-cover" alt="{{ $blog->title }}">
                    </div>
                @endif

                {{-- Post Content --}}
                <div class="lh-lg article-body mb-5" style="font-size: 16.5px; text-align: justify; word-wrap: break-word; color: #2d3748;">
                    {!! $blog->content !!}
                </div>

                {{-- Back Redirect --}}
                <div class="pt-4 pb-5 d-flex justify-content-between align-items-center" style="border-top: 1px solid rgba(0,0,0,0.08);">
                    <a href="{{ route('website.blog.index') }}" class="btn btn-outline-dark rounded-pill px-4" style="border-color: rgba(0,0,0,0.15); font-weight: 600;">
                        <i class="fa-solid fa-arrow-left me-2 text-xs" style="font-size: 11px;"></i> {{ __('Back to Blog') }}
                    </a>
                </div>

                {{-- Comments Section --}}
                <div id="comments-section" class="mt-5 pt-4 border-top">
                    <h3 class="fw-bold mb-4 text-uppercase text-dark" style="font-size: 20px; letter-spacing: 0.5px;">
                        {{ __('Comments') }} ({{ $blog->comments->count() }})
                    </h3>

                    @if(session('comment_success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert" style="background-color: #d1e7dd; color: #0f5132;">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('comment_success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Comments List --}}
                    <div class="comments-list mb-5 space-y-4">
                        @forelse($blog->comments as $comment)
                            <div class="card border-0 bg-white shadow-sm p-4 mb-4 rounded-3" style="border: 1px solid rgba(0,0,0,0.05) !important;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="fw-bold text-dark mb-0" style="font-size: 15px;">{{ $comment->name }}</h5>
                                    <small class="text-muted" style="font-size: 11px;">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="text-secondary small mb-2 lh-relaxed" style="font-size: 13.5px; white-space: pre-line;">{{ $comment->comment }}</p>

                                {{-- Reply Action Button --}}
                                <button onclick="toggleReplyForm({{ $comment->id }})" class="btn btn-sm btn-link text-decoration-none p-0 text-start font-bold text-xs" style="color: #b3d33c; font-weight: 700;">
                                    <i class="bi bi-reply-fill"></i> {{ __('Reply') }}
                                </button>

                                {{-- Inline Reply Form --}}
                                <div id="reply-form-{{ $comment->id }}" class="mt-4 p-3 bg-light rounded-3 border" style="display: none; border-color: rgba(0,0,0,0.08) !important;">
                                    <form action="{{ route('website.blog.comments.store', $blog->slug) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <input type="text" name="name" class="form-control form-control-sm border-0 bg-white" placeholder="{{ __('Your Name') }}" required style="font-size: 12px; height: 38px; border-radius: 8px;">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="email" name="email" class="form-control form-control-sm border-0 bg-white" placeholder="{{ __('Your Email') }}" required style="font-size: 12px; height: 38px; border-radius: 8px;">
                                            </div>
                                            <div class="col-12">
                                                <textarea name="comment" rows="2" class="form-control form-control-sm border-0 bg-white" placeholder="{{ __('Reply to this comment...') }}" required style="font-size: 12px; border-radius: 8px;"></textarea>
                                            </div>
                                            <div class="col-12 text-end">
                                                <button type="submit" class="btn btn-sm text-dark font-bold px-3 py-2" style="background-color: #b3d33c; border-radius: 8px; font-weight: 700; font-size: 12px; border: none;">
                                                    {{ __('Submit Reply') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                {{-- Nested Replies --}}
                                @if($comment->replies->isNotEmpty())
                                    <div class="mt-4 pl-4 border-start border-secondary-subtle">
                                        @foreach($comment->replies as $reply)
                                            <div class="bg-light p-3 rounded-3 mb-2" style="border: 1px solid rgba(0,0,0,0.03) !important;">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 13.5px;">{{ $reply->name }}</h6>
                                                    <small class="text-muted" style="font-size: 10px;">{{ $reply->created_at->diffForHumans() }}</small>
                                                </div>
                                                <p class="text-secondary small mb-0" style="font-size: 13px; white-space: pre-line;">{{ $reply->comment }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-muted small py-3">{{ __('No comments yet. Be the first to share your thoughts!') }}</p>
                        @endforelse
                    </div>

                    {{-- Guest Post Comment Form --}}
                    <div class="card border-0 bg-white shadow-sm p-4 rounded-3 mb-5" style="border: 1px solid rgba(0,0,0,0.05) !important;">
                        <h4 class="fw-bold text-dark mb-4" style="font-size: 17px; letter-spacing: 0.5px;">
                            {{ __('Leave a Comment') }}
                        </h4>
                        <form action="{{ route('website.blog.comments.store', $blog->slug) }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold text-secondary">{{ __('Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="{{ __('Your Name') }}" required style="border-radius: 8px; border: 1px solid rgba(0,0,0,0.1); padding: 10px 14px; font-size: 13px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold text-secondary">{{ __('Email') }} <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="{{ __('Your Email') }}" required style="border-radius: 8px; border: 1px solid rgba(0,0,0,0.1); padding: 10px 14px; font-size: 13px;">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-semibold text-secondary">{{ __('Comment') }} <span class="text-danger">*</span></label>
                                    <textarea name="comment" rows="5" class="form-control" placeholder="{{ __('Share your thoughts or ask a question...') }}" required style="border-radius: 8px; border: 1px solid rgba(0,0,0,0.1); padding: 10px 14px; font-size: 13px;"></textarea>
                                </div>
                                <div class="col-12 text-start mt-4">
                                    <button type="submit" class="btn text-dark font-bold px-4 py-2.5 text-uppercase" style="background-color: #b3d33c; border-radius: 30px; font-weight: 700; font-size: 13px; border: none; letter-spacing: 0.5px;">
                                        {{ __('Post Comment') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Right Column: Table of Contents (1/3 width) --}}
            <div class="col-lg-4">
                <div id="toc-container" class="position-sticky bg-white p-4 rounded-3 shadow-sm border" style="top: 100px; border-color: rgba(0,0,0,0.06) !important; border-radius: 16px;">
                    <h5 class="fw-bold mb-3 text-uppercase text-dark" style="font-size: 14px; letter-spacing: 0.5px; border-bottom: 2px solid #b3d33c; pb-2 inline-block;">
                        {{ __('Table of Contents') }}
                    </h5>
                    <ul id="toc-list" class="list-unstyled mb-0" style="max-height: 400px; overflow-y: auto;">
                        {{-- Populated dynamically --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Suggested Reads Section --}}
    @if($suggestions->isNotEmpty())
        <div class="container-fluid bg-light py-5 mt-5 border-top">
            <div class="container">
                <h3 class="text-uppercase fw-bold text-center mb-5 text-dark" style="letter-spacing: 1px; font-size: 24px;">
                    {{ __('Suggested Reads') }}
                </h3>
                <div class="row g-4">
                    @foreach($suggestions as $suggested)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 border-0 bg-dark shadow-sm overflow-hidden" style="border-radius: 12px; border: 1px solid rgba(255,255,255,0.05) !important;">
                                <div class="position-relative" style="height: 180px; overflow: hidden;">
                                    @if($suggested->image_url)
                                        <img src="{{ $suggested->image_url }}" class="w-100 h-100 object-cover" alt="{{ $suggested->title }}">
                                    @else
                                        <div class="w-100 h-100 bg-secondary d-flex align-items-center justify-content-center" style="background-color: #212529 !important;">
                                            <i class="bi bi-journal-text text-white-50 fs-2"></i>
                                        </div>
                                    @endif
                                    @if($suggested->category)
                                        <span class="position-absolute top-3 start-3 px-2.5 py-0.5 rounded-pill text-dark fw-bold uppercase text-xs" style="font-size: 9px; background-color:#b3d33c !important;">
                                            {{ __($suggested->category) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="card-body p-4 d-flex flex-column justify-content-between">
                                    <div>
                                        <h5 class="fw-bold mb-2">
                                            <a href="{{ route('website.blog.show', $suggested->slug) }}" class="text-white text-decoration-none hover-teal" style="font-size: 15px; line-height: 1.4;">
                                                {{ Str::limit($suggested->title, 50) }}
                                            </a>
                                        </h5>
                                        <p class="text-white-50 small mb-3">
                                            {{ Str::limit(strip_tags($suggested->content), 80) }}
                                        </p>
                                    </div>
                                    <a href="{{ route('website.blog.show', $suggested->slug) }}" class="text-decoration-none small fw-bold" style="color: #b3d33c;">
                                        {{ __('Read Article') }} <i class="bi bi-chevron-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <style>
        .hover-teal:hover {
            color: #b3d33c !important;
        }
    </style>

    @push('scripts')
    <script>
        // Toggle comment reply inputs
        function toggleReplyForm(commentId) {
            const form = document.getElementById('reply-form-' + commentId);
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }

        // Generate client-side Table of Contents
        document.addEventListener('DOMContentLoaded', function () {
            const articleBody = document.querySelector('.article-body');
            const tocList = document.getElementById('toc-list');
            
            if (!articleBody || !tocList) return;
            
            const headings = articleBody.querySelectorAll('h1, h2, h3, h4');
            
            if (headings.length === 0) {
                document.getElementById('toc-container').style.display = 'none';
                return;
            }
            
            headings.forEach((heading, index) => {
                const id = 'heading-' + index;
                heading.setAttribute('id', id);
                
                const li = document.createElement('li');
                li.className = 'mb-2.5';
                
                let indent = '0px';
                if (heading.tagName === 'H3') indent = '12px';
                if (heading.tagName === 'H4') indent = '24px';
                li.style.paddingLeft = indent;
                
                const a = document.createElement('a');
                a.href = '#' + id;
                a.textContent = heading.textContent;
                a.className = 'text-decoration-none text-muted hover-teal small';
                a.style.fontSize = '12.5px';
                a.style.fontWeight = '500';
                a.style.transition = 'color 0.2s ease';
                
                li.appendChild(a);
                tocList.appendChild(li);
            });
            
            const tocLinks = tocList.querySelectorAll('a');
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -40% 0px',
                threshold: 1.0
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const id = entry.target.getAttribute('id');
                        tocLinks.forEach(link => {
                            if (link.getAttribute('href') === '#' + id) {
                                link.style.color = '#b3d33c';
                                link.style.fontWeight = '700';
                            } else {
                                link.style.color = '#6c757d';
                                link.style.fontWeight = '500';
                            }
                        });
                    }
                });
            }, observerOptions);
            
            headings.forEach(heading => observer.observe(heading));
        });
    </script>
    @endpush
</x-website-layout>
