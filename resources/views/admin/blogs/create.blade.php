<x-admin-layout>
    {{-- PAGE HEADER --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.blogs.index') }}" class="w-10 h-10 bg-white border border-slate-100 rounded-xl flex items-center justify-center text-slate-400 hover:text-teal-600 shadow-sm transition-all">
            <i class="fa-solid fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Create Blog Post</h2>
            <p class="text-slate-500 text-sm mt-0.5">Publish a new SEO-optimized article on the website</p>
        </div>
    </div>

    {{-- FORM --}}
    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content Section (2/3 width) --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Title <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                            class="w-full bg-slate-50 border border-slate-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 rounded-xl px-4 py-3 text-sm transition-all outline-none"
                            placeholder="Enter blog post title">
                        @error('title') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Slug (URL Keyword - Optional)</label>
                        <input type="text" name="slug" value="{{ old('slug') }}"
                            class="w-full bg-slate-50 border border-slate-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 rounded-xl px-4 py-3 text-sm transition-all outline-none"
                            placeholder="e.g. how-to-build-a-house (auto-generates if left blank)">
                        @error('slug') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Content <span class="text-rose-500">*</span></label>
                        <textarea id="blog-content" name="content" rows="12"
                            class="w-full bg-slate-50 border border-slate-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 rounded-xl px-4 py-3 text-sm transition-all outline-none"
                            placeholder="Write your article body content here...">{{ old('content') }}</textarea>
                        @error('content') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Sidebar Meta & Settings Section (1/3 width) --}}
            <div class="space-y-6">
                {{-- Publishing Settings --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3">Publishing Status</h3>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-sm font-semibold text-slate-700 block">Status</span>
                            <span class="text-xs text-slate-400">Make this post public immediately</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-teal-600"></div>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Category <span class="text-rose-500">*</span></label>
                        <select name="category" required class="w-full bg-slate-50 border border-slate-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 rounded-xl px-4 py-3 text-sm transition-all outline-none">
                            <option value="">Select Category</option>
                            <option value="Construction" {{ old('category') == 'Construction' ? 'selected' : '' }}>Construction</option>
                            <option value="Real Estate" {{ old('category') == 'Real Estate' ? 'selected' : '' }}>Real Estate</option>
                            <option value="Infrastructure" {{ old('category') == 'Infrastructure' ? 'selected' : '' }}>Infrastructure</option>
                            <option value="Project Management" {{ old('category') == 'Project Management' ? 'selected' : '' }}>Project Management</option>
                        </select>
                        @error('category') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Featured Image</label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer">
                        @error('image') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- SEO Settings --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3">SEO Optimization</h3>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title') }}"
                            class="w-full bg-slate-50 border border-slate-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 rounded-xl px-4 py-3 text-sm transition-all outline-none"
                            placeholder="Default is title">
                        @error('meta_title') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Meta Description</label>
                        <textarea name="meta_description" rows="4"
                            class="w-full bg-slate-50 border border-slate-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 rounded-xl px-4 py-3 text-sm transition-all outline-none"
                            placeholder="Recommended length: 150-160 characters">{{ old('meta_description') }}</textarea>
                        @error('meta_description') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Meta Keywords</label>
                        <input type="text" name="meta_keywords" value="{{ old('meta_keywords') }}"
                            class="w-full bg-slate-50 border border-slate-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 rounded-xl px-4 py-3 text-sm transition-all outline-none"
                            placeholder="e.g. contracting, architecture, Kanpur">
                        @error('meta_keywords') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 text-center bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold py-3.5 rounded-xl shadow-sm shadow-teal-100 transition-all duration-200">
                        Create Post
                    </button>
                    <a href="{{ route('admin.blogs.index') }}" class="flex-1 text-center bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold py-3.5 rounded-xl transition-all duration-200">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#blog-content',
            height: 450,
            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
            toolbar: 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            branding: false,
            promotion: false,
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            }
        });
    </script>
    @endpush
</x-admin-layout>
