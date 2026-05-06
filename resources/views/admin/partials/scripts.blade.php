@include('admin.partials.footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- Select2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- Quill JS --}}
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Global Select2 Initializer
        if ($('.select2-init').length > 0) {
            $('.select2-init').select2({
                width: "100%",
                placeholder: "Please select...",
                allowClear: true
            });
        }
        
        // Existing Category Select
        if ($('.category-select').length > 0) {
            $('.category-select').select2({
                placeholder: "Select categories",
                allowClear: true,
                width: "100%"
            });
        }
    });
</script>

<script>
    // Quill Editor Logic
    $(document).ready(function() {
        // Only run if the element exists
        if (document.getElementById('quillEditor')) {
            var toolbarOptions = [
                [{
                    header: [1, 2, 3, false]
                }],
                ["bold", "italic", "underline", "strike"],
                [{
                    color: []
                }, {
                    background: []
                }],
                [{
                    align: []
                }],
                [{
                    list: "ordered"
                }, {
                    list: "bullet"
                }],
                ["blockquote", "code-block"],
                ["link", "image", "video"],
                ["clean"]
            ];

            var quill = new Quill("#quillEditor", {
                theme: "snow",
                modules: {
                    toolbar: toolbarOptions
                }
            });

            // Handle Custom Image/Video handlers
            quill.getModule("toolbar").addHandler("image", function() {
                handleFileUpload("image");
            });
            quill.getModule("toolbar").addHandler("video", function() {
                handleFileUpload("video");
            });

            function handleFileUpload(type) {
                var input = $("<input>").attr("type", "file").attr("accept", type + "/*");
                input.trigger("click");
                input.on("change", function() {
                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var base64 = e.target.result;
                        var range = quill.getSelection(true);
                        quill.insertEmbed(range.index, type, base64);
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Sync with Hidden Inputs on Submit
            $("form").on("submit", function() {
                $("#descriptionInput").val(quill.root.innerHTML);
                $('#proposalInput').val(quill.root.innerHTML);
            });
        }
    });
</script>

@stack('scripts')

