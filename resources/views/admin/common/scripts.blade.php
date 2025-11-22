<script src="{{ asset('admin/vendor/global/global.min.js') }}"></script>
<script src="{{ asset('admin/js/quixnav-init.js') }}"></script>
<script src="{{ asset('admin/js/custom.min.js') }}"></script>

<script src="{{ asset('admin/vendor/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('admin/vendor/morris/morris.min.js') }}"></script>
<script src="{{ asset('admin/vendor/chart.js/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('admin/vendor/owl-carousel/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('admin/js/dashboard/dashboard-1.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

{{-- SweetAlert Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('.category-select').select2({
            placeholder: "Select categories",
            allowClear: true,
            width: "100%"
        });
    });
</script>


<script>
    $(document).ready(function() {

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

        quill.getModule("toolbar").addHandler("image", function() {
            handleFileUpload("image");
        });

        quill.getModule("toolbar").addHandler("video", function() {
            handleFileUpload("video");
        });

        function handleFileUpload(type) {
            var input = $("<input>")
                .attr("type", "file")
                .attr("accept", type + "/*");

            input.trigger("click");

            input.on("change", function() {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                    var base64 = e.target.result;
                    var range = quill.getSelection(true);

                    if (type === "image") {
                        quill.insertEmbed(range.index, "image", base64);
                    } else {
                        quill.insertEmbed(range.index, "video", base64);
                    }
                };

                reader.readAsDataURL(file);
            });
        }

        $("form").on("submit", function() {
            $("#descriptionInput").val(quill.root.innerHTML);
            $('#proposalInput').val(quill.root.innerHTML);
        });

    });
</script>


@stack('scripts')
