<x-website-layout>

    <style>
        .signup-card-premium {
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            border-radius: 24px !important;
            background: #ffffff;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.03) !important;
            overflow: hidden;
            padding: 40px !important;
        }

        .form-control {
            padding: 14px 20px;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            background-color: #fafbfc;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: #ffffff;
            border-color: #b3d33c;
            box-shadow: 0 0 0 4px rgba(179, 211, 60, 0.12);
        }

        .label-title {
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        /* Tactical Role Switcher */
        .role-selector-btn {
            border: 2px solid rgba(0,0,0,0.08) !important;
            color: #4b5563 !important;
            border-radius: 14px !important;
            background: #ffffff;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        .role-selector-btn i {
            color: #9ca3af;
            transition: all 0.3s ease;
        }

        .btn-check:checked + .role-selector-btn {
            background-color: rgba(179, 211, 60, 0.08) !important;
            border-color: #b3d33c !important;
            color: #000000 !important;
        }

        .btn-check:checked + .role-selector-btn i {
            color: #b3d33c !important;
        }

        .role-selector-btn:hover {
            border-color: rgba(179, 211, 60, 0.3) !important;
            background-color: rgba(179, 211, 60, 0.02) !important;
        }

        /* Contractor fields slide-down animation */
        #contractorFields {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: max-height 0.6s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.5s ease;
        }

        #contractorFields.show {
            max-height: 1200px;
            opacity: 1;
            margin-bottom: 20px;
        }

        /* Categories multiselect option overrides */
        select.form-select[multiple] {
            height: auto;
            min-height: 160px;
            padding: 12px;
            background-color: #fafbfc;
            border-radius: 10px;
            border: 1px solid rgba(0,0,0,0.08);
            font-size: 14px;
            transition: all 0.3s ease;
        }

        select.form-select[multiple]:focus {
            background-color: #ffffff;
            border-color: #b3d33c;
            box-shadow: 0 0 0 4px rgba(179, 211, 60, 0.12);
        }

        select.form-select[multiple] optgroup {
            font-weight: 700;
            color: #374151;
            padding: 6px 0;
        }

        select.form-select[multiple] option {
            padding: 6px 12px;
            border-radius: 6px;
            margin: 2px 0;
            font-weight: 500;
            color: #4b5563;
        }

        small.text-danger {
            display: block;
            margin-top: 3px;
            font-weight: 600;
        }
    </style>

    <div class="container py-5" style="min-height:80vh;">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 signup-card-premium wow fadeInUp">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-uppercase" style="color:#b3d33c; letter-spacing: 1px;">{{ __('Create Your Account') }}</h3>
                        <p class="text-muted small mb-0">{{ __('Register as Contractor or User') }}</p>
                    </div>

                    {{-- Registration Form --}}
                    <form method="POST" action="{{ route('website.register.submit') }}">
                        @csrf

                        {{-- Full Name --}}
                        <div class="mb-3">
                            <label class="label-title mb-1 small">{{ __('Full Name') }}</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control" placeholder="{{ __('Enter full name') }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="label-title mb-1 small">{{ __('Email Address') }}</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control" placeholder="{{ __('Enter email address') }}" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label class="label-title mb-1 small">{{ __('Password') }}</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="{{ __('Create password') }}" required>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-4">
                            <label class="label-title mb-1 small">{{ __('Confirm Password') }}</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="{{ __('Confirm password') }}" required>
                        </div>

                        {{-- Role Selection --}}
                        <div class="mb-4 text-center">
                            <label class="label-title mb-3 d-block small text-uppercase" style="letter-spacing: 0.5px;">{{ __('Register As') }}</label>
                            <div class="d-flex justify-content-center gap-3">
                                <div class="role-select-box flex-fill">
                                    <input type="radio" class="btn-check" name="role" id="contractor"
                                        value="contractor" autocomplete="off"
                                        {{ old('role') === 'contractor' ? 'checked' : '' }}>
                                    <label class="btn role-selector-btn w-100 py-3 d-flex flex-column align-items-center justify-content-center" for="contractor">
                                        <i class="fa-solid fa-helmet-safety mb-2 fs-4"></i>
                                        <span>{{ __('Contractor') }}</span>
                                    </label>
                                </div>
                                <div class="role-select-box flex-fill">
                                    <input type="radio" class="btn-check" name="role" id="user" value="user"
                                        autocomplete="off" {{ old('role', 'user') === 'user' ? 'checked' : '' }}>
                                    <label class="btn role-selector-btn w-100 py-3 d-flex flex-column align-items-center justify-content-center" for="user">
                                        <i class="fa-solid fa-user mb-2 fs-4"></i>
                                        <span>{{ __('User') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Contractor Extra Fields --}}
                        <div id="contractorFields">
                            {{-- Company Name --}}
                            <div class="mb-3">
                                <label class="label-title mb-1 small">{{ __('Company Name') }}</label>
                                <input type="text" name="company_name" value="{{ old('company_name') }}"
                                    class="form-control" placeholder="{{ __('Enter company name') }}">
                                @error('company_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div class="mb-3">
                                <label class="label-title mb-1 small">{{ __('Phone Number') }}</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                    class="form-control" placeholder="{{ __('Enter phone number') }}">
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- City --}}
                            <div class="mb-3">
                                <label class="label-title mb-1 small">{{ __('City') }}</label>
                                <input type="text" name="city" value="{{ old('city') }}"
                                    class="form-control" placeholder="{{ __('Enter city') }}">
                                @error('city')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            @php
                                $parentCategories = \App\Models\Category::query()
                                    ->with([
                                        'subcategories' => function ($q) {
                                            $q->where('is_active', 1)->orderBy('name');
                                        },
                                    ])
                                    ->whereNull('parent_id')
                                    ->where('is_active', 1)
                                    ->orderBy('name')
                                    ->get();
                            @endphp

                            {{-- Contractor Categories (Multiple Select) --}}
                            <div class="mb-3 form-group" id="contractorCategoryField">
                                <label class="label-title mb-1 small">{{ __('Select Categories (Multiple)') }}</label>

                                <select name="categories[]" class="form-select" multiple size="6">
                                    @foreach ($parentCategories as $parent)
                                        @php $children = $parent->subcategories; @endphp

                                        @if ($children->count())
                                            <optgroup label="{{ $parent->name }}">
                                                @foreach ($children as $child)
                                                    <option value="{{ $child->id }}"
                                                        @if (is_array(old('categories')) && in_array($child->id, old('categories'))) selected @endif>
                                                        {{ $child->name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @else
                                            <option value="{{ $parent->id }}"
                                                @if (is_array(old('categories')) && in_array($parent->id, old('categories'))) selected @endif>
                                                {{ $parent->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>

                                <small class="text-muted d-block mt-1">{{ __('Hold CTRL to select multiple.') }}</small>

                                @error('categories')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold text-uppercase shadow-sm mt-3">
                            {{ __('Register') }}
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3" style="border-top: 1px solid rgba(0,0,0,0.03);">
                        <p class="text-muted small mb-1">{{ __('Already have an account?') }}</p>
                        <a href="{{ route('website.login') }}" class="fw-bold text-decoration-none small text-uppercase"
                            style="color:#b3d33c; letter-spacing: 0.5px;">{{ __('Login Here') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contractorRadio = document.getElementById('contractor');
            const userRadio = document.getElementById('user');
            const contractorFields = document.getElementById('contractorFields');

            function toggleContractorFields() {
                if (contractorRadio.checked) {
                    contractorFields.classList.add('show');
                } else {
                    contractorFields.classList.remove('show');
                }
            }

            contractorRadio.addEventListener('change', toggleContractorFields);
            userRadio.addEventListener('change', toggleContractorFields);

            // Ensures that user is selected by default on page load
            if (!contractorRadio.checked && !userRadio.checked) {
                userRadio.checked = true;
            }

            toggleContractorFields();
        });
    </script>

</x-website-layout>
