<x-admin-layout>
    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Blogs Management</h2>
            <p class="text-slate-500 text-sm mt-0.5">Create, edit, and organize SEO-optimized blog posts</p>
        </div>

        <a href="{{ route('admin.blogs.create') }}"
            class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm shadow-teal-100 transition-all duration-200 transform hover:-translate-y-0.5">
            <i class="fa-solid fa-plus text-xs"></i> Add New Blog
        </a>
    </div>

    {{-- ALERTS --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            class="fixed top-5 right-5 z-[60] bg-emerald-600 text-white px-5 py-4 rounded-xl shadow-xl flex items-center gap-3 transition-all duration-500 transform translate-y-0">
            <div class="bg-white/20 w-8 h-8 rounded-full flex items-center justify-center shrink-0">
                <i class="fa-solid fa-check"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs uppercase tracking-wider">Success</h4>
                <p class="text-xs text-emerald-50 mt-0.5">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="ml-4 text-emerald-200 hover:text-white transition-colors shrink-0">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
    @endif

    {{-- BLOG TABLE --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 w-24">Image</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Title</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 w-48">Slug</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 w-36 text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 w-44">Published At</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 w-24 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($blogs as $blog)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                @if($blog->image)
                                    <img src="{{ asset('storage/' . $blog->image) }}" class="w-12 h-12 object-cover rounded-lg border border-slate-100" alt="Thumbnail">
                                @else
                                    <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400">
                                        <i class="fa-solid fa-image text-sm"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-800 text-sm block leading-normal">{{ $blog->title }}</span>
                                <span class="text-xs text-slate-400 mt-1 block">Created {{ $blog->created_at->format('M d, Y') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <code class="text-xs font-semibold bg-slate-50 text-slate-500 px-2 py-1 rounded border border-slate-100/50">{{ $blog->slug }}</code>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($blog->is_published)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-wider">
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-bold bg-slate-50 text-slate-400 border border-slate-200 uppercase tracking-wider">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">
                                {{ $blog->published_at ? $blog->published_at->format('M d, Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="relative flex items-center justify-end gap-1.5" x-data="{ open: false }">
                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-teal-600 hover:bg-slate-100 transition-all">
                                        <i class="fa-solid fa-pen-to-square text-sm"></i>
                                    </a>
                                    <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog post?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-slate-100 transition-all">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <i class="fa-solid fa-newspaper text-3xl text-slate-300"></i>
                                    <p class="text-sm">No blog posts found. Get started by creating your first post!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($blogs->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $blogs->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
