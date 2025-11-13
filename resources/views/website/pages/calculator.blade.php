<x-layout.app-layout>

    <style>
        .calc-box {
            border-radius: 12px;
            background: #ffffff;
            border: none;
            transition: all 0.2s ease-in-out;
        }

        .calc-box:hover {
            transform: translateY(-2px);
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.08);
        }

        .calc-header {
            background: #f8f9fa !important;
            border-bottom: 2px solid #b3d33c;
        }

        .result-box {
            background: #f9fafb;
            border-radius: 10px;
            border: 1px dashed #b3d33c;
            padding: 15px;
        }

        .label-title {
            font-weight: 600;
            color: #333;
        }

        .btn-theme {
            background-color: #b3d33c;
            color: #000;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
        }

        .btn-theme:hover {
            background-color: #a1c22d;
            color: #000;
            transform: translateY(-1px);
        }

        .select2-container .select2-selection--single {
            height: 40px !important;
            padding: 6px !important;
            border: 1px solid #ced4da !important;
            border-radius: 6px !important;
        }
    </style>


    {{-- PAGE HEADER --}}
    <section class="bg-dark text-center py-6 mb-5">
        <div class="container">
            <h1 class="display-5 fw-bold text-uppercase mb-2" style="color:#b3d33c;">
                Construction Cost Calculator
            </h1>
            <p class="lead text-light fw-medium mb-0">Select a category and work to calculate cost professionally</p>
        </div>
    </section>

    <div class="container mb-5">

        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- CALCULATOR CARD --}}<div class="calc-wrapper">

                    <div class="card calc-box shadow-sm mb-4">
                        <div class="card-header calc-header py-3">
                            <h5 class="fw-bold mb-0">
                                <i class="fa-solid fa-calculator me-2" style="color:#b3d33c;"></i>
                                Calculate Your Work Cost
                            </h5>
                        </div>

                        <div class="card-body">

                            {{-- CATEGORY --}}
                            <div class="mb-3">
                                <label class="label-title mb-1">Select Category <span
                                        class="text-danger">*</span></label>
                                <select id="categorySelect" class="form-control select2">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- WORK --}}
                            <div class="mb-3">
                                <label class="label-title mb-1">Select Work <span class="text-danger">*</span></label>
                                <select id="workSelect" class="form-control select2">
                                    <option value="">Select Work</option>
                                    @foreach ($works as $work)
                                        <option value="{{ $work->id }}" data-category="{{ $work->category_id }}"
                                            data-lmin="{{ $work->labor_min }}" data-lmax="{{ $work->labor_max }}"
                                            data-mmin="{{ $work->labor_material_min }}"
                                            data-mmax="{{ $work->labor_material_max }}"
                                            data-unit="{{ $work->unit->symbol ?? $work->unit_label }}">
                                            {{ $work->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- ROW WITH INPUT + UNIT FIELD --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="label-title mb-1">Enter Quantity</label>
                                    <input type="number" id="qty" class="form-control" placeholder="e.g., 100"
                                        min="1">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="label-title mb-1">Custom Unit (Optional)</label>
                                    <input type="text" id="customUnit" class="form-control"
                                        placeholder="e.g., sqft, rft">
                                </div>
                            </div>

                            {{-- SUBMIT BUTTON --}}
                            <div class="text-end mt-3">
                                <button id="calculateBtn" class="btn btn-theme px-4">
                                    <i class="fa-solid fa-check me-1"></i> Calculate
                                </button>
                            </div>

                        </div>
                    </div>
                </div>


                {{-- RESULT CARD --}}
                <div id="resultCard" class="card shadow-sm border-0 d-none">
                    <div class="card-header bg-white py-2 border-0">
                        <h5 class="fw-bold mb-0">
                            <i class="fa-solid fa-receipt me-2" style="color:#b3d33c;"></i>
                            Estimated Cost
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="result-box mb-3">
                            <strong class="d-block">Work:</strong>
                            <span id="rWork" class="fw-semibold"></span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="result-box">
                                    <h6 class="fw-bold mb-1">Labor Cost</h6>
                                    <p class="mb-0">₹<span id="laborRange"></span></p>
                                    <p class="small text-muted mb-0">Total: ₹<span id="laborTotal"></span></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="result-box">
                                    <h6 class="fw-bold mb-1">Labor + Material</h6>
                                    <p class="mb-0">₹<span id="materialRange"></span></p>
                                    <p class="small text-muted mb-0">Total: ₹<span id="materialTotal"></span></p>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5 class="fw-bold">Final Estimated Cost:</h5>
                        <h2 class="fw-bold" style="color:#b3d33c;">₹<span id="finalCost"></span></h2>

                    </div>
                </div>

            </div>
        </div>

    </div>

</x-layout.app-layout>
