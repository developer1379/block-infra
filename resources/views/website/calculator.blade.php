<x-website-layout 
    title="Construction Cost Calculator | Estimate Your Project Budget" 
    description="Calculate your building construction costs instantly. Estimate material, labor, and structure costs for your project using our smart calculator." 
    keywords="construction cost calculator, project budget estimator, building material cost, house construction calculator"
>

    <style>
        .calc-box {
            border-radius: 16px;
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.06);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04) !important;
        }

        .calc-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08) !important;
        }

        .calc-header {
            background: #ffffff !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            padding: 20px 24px !important;
        }

        .label-title {
            font-weight: 600;
            color: #374151;
            font-size: 14px;
        }

        .btn-theme {
            background-color: #b3d33c;
            color: #000;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 4px 12px rgba(179, 211, 60, 0.2);
        }

        .btn-theme:hover {
            background-color: #a1c22d;
            color: #000;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(179, 211, 60, 0.35);
        }

        .input-group-text {
            background-color: #f3f4f6;
            color: #4b5563;
            border-color: #ced4da;
        }

        .result-card-premium {
            border-radius: 16px;
            border: 1px solid rgba(179, 211, 60, 0.2) !important;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(179, 211, 60, 0.05) !important;
            overflow: hidden;
        }

        .result-header {
            background: rgba(179, 211, 60, 0.06);
            border-bottom: 1px solid rgba(179, 211, 60, 0.15);
            padding: 16px 24px !important;
        }

        .receipt-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px dashed rgba(0, 0, 0, 0.06);
        }

        .receipt-line:last-child {
            border-bottom: none;
        }

        .receipt-label {
            color: #6b7280;
            font-size: 14px;
        }

        .receipt-val {
            font-weight: 600;
            color: #111827;
        }

        .cost-box-dark {
            background-color: #0b0f19;
            color: #ffffff;
            border-radius: 12px;
            padding: 24px;
        }

        .comparison-bar-container {
            height: 10px;
            background-color: #e5e7eb;
            border-radius: 5px;
            overflow: hidden;
            display: flex;
        }

        .comparison-bar-labor {
            background-color: #4b5563;
            height: 100%;
        }

        .comparison-bar-material {
            background-color: #b3d33c;
            height: 100%;
        }
    </style>

    {{-- PAGE HEADER --}}
    <section class="bg-dark text-center py-6 mb-5">
        <div class="container">
            <h1 class="display-5 fw-bold text-uppercase mb-2" style="color:#b3d33c;">
                {{ __('Construction Cost Calculator') }}
            </h1>
            <p class="lead text-light fw-medium mb-0">{{ __('Estimate labor, material, and final construction costs dynamically') }}</p>
        </div>
    </section>

    <div class="container mb-5">
        <div class="row justify-content-center g-4">
            
            {{-- INPUT FORM CARD --}}
            <div class="col-lg-6">
                <div class="card calc-box shadow-sm mb-4">
                    <div class="card-header calc-header">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="fa-solid fa-sliders me-2" style="color:#b3d33c;"></i>
                            {{ __('Cost Parameters') }}
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        {{-- CATEGORY --}}
                        <div class="mb-4">
                            <label class="label-title mb-2">{{ __('Select Project Category') }} <span class="text-danger">*</span></label>
                            <select id="categorySelect" class="form-control select2">
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ __($cat->name) }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- WORK --}}
                        <div class="mb-4">
                            <label class="label-title mb-2">{{ __('Select Work Item') }} <span class="text-danger">*</span></label>
                            <select id="workSelect" class="form-control select2">
                                <option value="">{{ __('Select Work') }}</option>
                                @foreach ($works as $work)
                                    <option value="{{ $work->id }}" data-category="{{ $work->category_id }}"
                                        data-lmin="{{ $work->labor_min }}" data-lmax="{{ $work->labor_max }}"
                                        data-mmin="{{ $work->labor_material_min }}"
                                        data-mmax="{{ $work->labor_material_max }}"
                                        data-unit="{{ $work->unit->symbol ?? $work->unit_label }}">
                                        {{ __($work->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- QUANTITY FIELD WITH DYNAMIC UNIT ADDON --}}
                        <div class="mb-4">
                            <label class="label-title mb-2">{{ __('Enter Quantity') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" id="qty" class="form-control" placeholder="{{ __('e.g., 100') }}" min="1">
                                <span class="input-group-text fw-bold" id="qty-unit-badge" style="min-width: 80px; justify-content: center;">-</span>
                            </div>
                            <small class="text-muted d-block mt-1" style="font-size: 11px;">
                                <i class="fa-solid fa-circle-info me-1"></i>
                                {{ __('Quantity input units switch dynamically based on the selected work.') }}
                            </small>
                        </div>

                        {{-- BUTTON ACTIONS --}}
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <button id="resetBtn" class="btn btn-outline-secondary px-3" type="button">
                                <i class="fa-solid fa-rotate-left me-1"></i> {{ __('Reset') }}
                            </button>
                            <button id="calculateBtn" class="btn btn-theme px-4" type="button">
                                <i class="fa-solid fa-check-double me-1"></i> {{ __('Calculate') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DYNAMIC OUTPUT PREVIEW CARD --}}
            <div class="col-lg-6">
                
                {{-- PLACEHOLDER CARD WHEN NO DATA YET --}}
                <div id="resultPlaceholder" class="card calc-box shadow-sm text-center p-5 h-100 d-flex flex-column justify-content-center align-items-center">
                    <div class="mb-4">
                        <i class="fa-solid fa-calculator fa-4x text-muted opacity-25"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">{{ __('Waiting for Inputs') }}</h5>
                    <p class="text-muted small px-3">
                        {{ __('Choose a category, specific work type, and enter quantity to instantly view cost breakdown and budget recommendations.') }}
                    </p>
                </div>

                {{-- RESULT CARD --}}
                <div id="resultCard" class="card result-card-premium border-0 d-none h-100">
                    <div class="card-header result-header">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="fa-solid fa-receipt me-2" style="color:#b3d33c;"></i>
                            {{ __('Cost Assessment Summary') }}
                        </h5>
                    </div>

                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            {{-- Target Work Header --}}
                            <div class="mb-4 pb-3 border-bottom">
                                <span class="badge text-dark mb-1" style="background: rgba(179, 211, 60, 0.15);">{{ __('Selected Work') }}</span>
                                <h4 id="rWork" class="fw-bold text-dark mb-0"></h4>
                            </div>

                            {{-- Detailed Line Breakdowns --}}
                            <div class="mb-4">
                                <div class="receipt-line">
                                    <span class="receipt-label">{{ __('Work Quantity') }}</span>
                                    <span class="receipt-val"><span id="rQty"></span> <span class="text-muted" id="rUnit"></span></span>
                                </div>
                                <div class="receipt-line">
                                    <span class="receipt-label">{{ __('Labor Unit Cost Range') }}</span>
                                    <span class="receipt-val">₹<span id="laborRange"></span></span>
                                </div>
                                <div class="receipt-line">
                                    <span class="receipt-label">{{ __('Labor + Material Unit Cost Range') }}</span>
                                    <span class="receipt-val">₹<span id="materialRange"></span></span>
                                </div>
                            </div>

                            {{-- Subtotals --}}
                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <div class="p-3 bg-light rounded shadow-sm border-start border-secondary border-3">
                                        <small class="text-muted d-block uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">{{ __('Total Labor Cost') }}</small>
                                        <strong class="text-dark fs-5">₹<span id="laborTotal"></span></strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-light rounded shadow-sm border-start border-3" style="border-color: #b3d33c !important;">
                                        <small class="text-muted d-block uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">{{ __('Labor + Material Total') }}</small>
                                        <strong class="text-dark fs-5">₹<span id="materialTotal"></span></strong>
                                    </div>
                                </div>
                            </div>

                            {{-- Comparison Progress Bar --}}
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1 small text-muted">
                                    <span>{{ __('Labor Ratio (Base)') }}</span>
                                    <span>{{ __('Material & Logistics Ratio') }}</span>
                                </div>
                                <div class="comparison-bar-container">
                                    <div class="comparison-bar-labor" style="width: 40%;"></div>
                                    <div class="comparison-bar-material" style="width: 60%;"></div>
                                </div>
                            </div>
                        </div>

                        {{-- final estimate box --}}
                        <div class="cost-box-dark text-center mt-3">
                            <h6 class="text-muted mb-2 text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 11px;">{{ __('Total Budget Recommendation') }}</h6>
                            <h1 class="fw-bold text-primary mb-2">₹<span id="finalCost"></span></h1>
                            <p class="small mb-0 text-white-50">
                                <i class="fa-solid fa-circle-check text-primary me-1"></i>
                                {{ __('Includes standard service charges, logistics, and material estimates.') }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-website-layout>
