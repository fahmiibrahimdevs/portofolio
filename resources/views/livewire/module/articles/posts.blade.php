<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Posts</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <h3>Table Posts</h3>
                <div class="card-body">
                    <div class="show-entries">
                        <p class="show-entries-show">Show</p>
                        <select wire:model.live="lengthData" id="length-data">
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="250">250</option>
                            <option value="500">500</option>
                        </select>
                        <p class="show-entries-entries">Entries</p>
                    </div>
                    <div class="search-column">
                        <p>Search: </p><input type="search" wire:model.live.debounce.750ms="searchTerm" id="search-data"
                            placeholder="Search here..." class="form-control" value="">
                    </div>
                    <div class="table-responsive tw-max-h-96 no-scrollbar">
                        <table class="tw-w-full tw-table-auto">
                            <thead class="tw-sticky tw-top-0">
                                <tr class="tw-text-gray-700">
                                    <th width="4%" class="text-center">No</th>
                                    <th width="19%">Date</th>
                                    <th width="30%">Title</th>
                                    <th width="25%">Tags</th>
                                    <th>Status</th>
                                    <th class="text-center "><i class="fas fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $row)
                                <tr>
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td class="tw-whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($row->date)->isoFormat('dddd, D MMMM Y') }}</td>
                                    <td class="tw-whitespace-nowrap">
                                        <a target="_BLANK" href="{{ url('/article/' . $row->slug) }}"
                                            class="tw-text-blue-500 tw-no-underline">{{ $row->title }}</a>
                                    </td>
                                    <td class="tw-whitespace-nowrap">
                                        @foreach ($row->getTags()->take(2) as $tags)
                                        <span
                                            class="tw-bg-blue-50 tw-text-xs tw-tracking-wider tw-text-blue-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold">#
                                            {{ $tags->sub_category_name }}</span>
                                        @endforeach

                                        @if ($row->getTags()->count() > 2)
                                        <button id="tags-toggle" data-id="{{ $row->id }}">
                                            <span
                                                class="tw-bg-blue-50 tw-text-xs tw-tracking-wider tw-text-blue-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold">...</span>
                                        </button>
                                        <span id="show-tags-{{ $row->id }}" class="tw-hidden tw-mt-3">
                                            @foreach ($row->getTags()->skip(2) as $tags)
                                            <span
                                                class="tw-bg-blue-50 tw-text-xs tw-tracking-wider tw-text-blue-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold">#
                                                {{ $tags->sub_category_name }}</span>
                                            @endforeach
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->status_publish == 'Draft')
                                        <span
                                            class="tw-bg-red-50 tw-text-xs tw-tracking-wider tw-text-red-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold">{{ $row->status_publish }}</span>
                                        @elseif ($row->status_publish == 'Privated')
                                        <span
                                            class="tw-bg-orange-50 tw-text-xs tw-tracking-wider tw-text-orange-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold">{{ $row->status_publish }}</span>
                                        @else
                                        <span
                                            class="tw-bg-green-50 tw-text-xs tw-tracking-wider tw-text-green-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold">{{ $row->status_publish }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center tw-whitespace-nowrap">
                                        <button wire:click.prevent="edit({{ $row->id }})" class="btn btn-primary"
                                            data-toggle="modal" data-target="#formDataModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click.prevent="deleteConfirm({{ $row->id }})"
                                            class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Not data available in the table</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5 px-3">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
        <button wire:click.prevent="isEditingMode(false)" class="btn-modal" data-toggle="modal" data-backdrop="static"
            data-keyboard="false" data-target="#formDataModal">
            <i class="far fa-plus"></i>
        </button>
    </section>
    <div class="modal fade" wire:ignore.self id="formDataModal" aria-labelledby="formDataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formDataModalLabel">{{ $isEditing ? 'Edit Data' : 'Add Data' }}</h5>
                    <button type="button" wire:click="cancel()" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        @if ($thumbnail)
                        <img src="{{ $thumbnail->temporaryUrl() }}" class="img-thumbnail mb-3" alt="Preview"
                            width="150">
                        @elseif ($isEditing && $dataId)
                        <img src="{{ asset('storage/' . \App\Models\ArticlePost::find($dataId)->thumbnail) }}"
                            class="img-thumbnail mb-3" alt="Current Thumbnail" width="150">
                        @endif
                        <div class="custom-file mb-3">
                            <input type="file" wire:model="thumbnail" id="thumbnail" class="custom-file-input">
                            <label class="custom-file-label" for="thumbnail">Upload Thumbnail...</label>
                            @error('thumbnail')
                            <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="datetime-local" wire:model="date" id="date" class="form-control">
                            @error('date')
                            <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="category_id">Category Name</label>
                                    <div wire:ignore>
                                        <select wire:model="category_id" id="category_id" class="form-control"
                                            wire:key="{{ rand() }}">
                                            <option value="">-- Select Category --</option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category['id'] }}">
                                                {{ $category['category_name'] }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('category_id')
                                    <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="sub_category_id">Sub Category Name</label>
                                    <div wire:ignore>
                                        <select wire:model="sub_category_id" id="sub_category_id" class="form-control"
                                            multiple>
                                            <option value="" disabled>-- Select Sub Category --</option>
                                            @foreach ($subcategories as $subcategory)
                                            <option value="{{ $subcategory['id'] }}" @if (in_array($subcategory['id'],
                                                $sub_category_id)) selected @endif>
                                                {{ $subcategory['sub_category_name'] }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('sub_category_id')
                                    <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" wire:model="title" id="title" class="form-control">
                                    @error('title')
                                    <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" wire:model="slug" id="slug" class="form-control">
                                    @error('slug')
                                    <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="status_publish">Status Publish</label>
                                    <div wire:ignore>
                                        <select wire:model="status_publish" id="status_publish" class="form-control">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="Draft">Draft</option>
                                            <option value="Privated">Privated</option>
                                            <option value="Published">Published</option>
                                        </select>
                                    </div>
                                    @error('status_publish')
                                    <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <div wire:ignore>
                                <textarea wire:model="description" id="description" class="form-control"
                                    style="height: 75px"></textarea>
                            </div>
                            @error('description')
                            <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="fill_content">Fill Content</label>
                            <div wire:ignore>
                                <textarea wire:model="fill_content" id="fill_content" class="form-control"
                                    style="height: 75px"></textarea>
                            </div>
                            @error('fill_content')
                            <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="cancel()" class="btn btn-secondary tw-bg-gray-300"
                            data-dismiss="modal">Close</button>
                        <button type="submit" wire:click.prevent="{{ $isEditing ? 'update()' : 'store()' }}"
                            wire:loading.attr="disabled" class="btn btn-primary tw-bg-blue-500">Save Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('general-css')
<link href="{{ asset('assets/midragon/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/summernote/summernote-lite.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/summernote/summernote-list-styles-bs4.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/katex/katex.min.css') }}">
@endpush

@push('js-libraries')
<script src="{{ asset('/assets/midragon/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/summernote/summernote-lite.min.js') }}"></script>
<script src="{{ asset('assets/summernote/summernote-math.js') }}"></script>
<script src="{{ asset('assets/summernote/summernote-list-styles-bs4.js') }}"></script>
<script src="{{ asset('assets/katex/katex.min.js') }}"></script>
@endpush

@push('scripts')
<script>
    window.addEventListener('initSelect2', event => {
        $(document).ready(function () {
            $('#category_id').select2();
            $('#category_id').on('change', function (e) {
                var data = $('#category_id').select2("val");
                @this.set('category_id', data);
            });

            $('#sub_category_id').select2();
            $('#sub_category_id').on('change', function (e) {
                var data = $('#sub_category_id').select2("val");
                @this.set('sub_category_id', data);
            });

            $('#status_publish').select2();
            $('#status_publish').on('change', function (e) {
                var data = $('#status_publish').select2("val");
                @this.set('status_publish', data);
            });
        });
    })
    window.addEventListener('initSummernote', event => {
        $(document).ready(function () {
            initializeSummernote('#description', 'description');
            initializeSummernote('#fill_content', 'fill_content');
        });
    })
    window.addEventListener('initSelect2SubCategory', event => {
        $(document).ready(function () {
            let subcategories = @this.get('subcategories');
            let idSubCategory = @this.get('sub_category_id');

            let select = $('#sub_category_id');
            select.empty();

            select.append('<option value="" disabled>-- Select Sub Category --</option>');


            subcategories.forEach(function (subcategory) {
                let selected = idSubCategory.includes(subcategory.id.toString()) ? 'selected' :
                    '';
                select.append('<option value="' + subcategory.id + '" ' + selected + '>' +
                    subcategory.sub_category_name + '</option>');
            });

            select.select2();
        });
    })

</script>
<script>
    $(document).ready(function () {
        $(document).on('click', '#tags-toggle', function () {
            var id = $(this).data('id');
            $('#show-tags-' + id).removeClass('tw-hidden').addClass('tw-block');
            $(this).addClass('tw-hidden');
        });
    });

</script>
<script>
    function initializeSummernote(selector, wiremodel) {
        $(selector).summernote('destroy')
        $(selector).summernote({
            height: 50,
            imageAttributes: {
                icon: '<i class="note-icon-pencil"/>',
                removeEmpty: false,
                disableUpload: false
            },
            popover: {
                image: [
                    ['custom', ['imageAttributes']],
                    ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                    ['float', ['floatLeft', 'floatCenter', 'floatRight', 'floatNone']],
                    ['remove', ['removeMedia']]
                ],
            },
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'listStyles', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video', 'math']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            grid: {
                wrapper: "row",
                columns: [
                    "col-md-12",
                    "col-md-6",
                    "col-md-4",
                    "col-md-3",
                    "col-md-24",
                ]
            },
            callbacks: {
                onImageUpload: function (image) {
                    sendFile(image[0], selector);
                },
                onMediaDelete: function (target) {
                    deleteFile(target[0].src)
                },
                onBlur: function () {
                    const contents = $(selector).summernote('code');
                    if (contents === '' || contents === '<br>' || !contents.includes('<p>')) {
                        $(selector).summernote('code', '<p>' + contents + '</p>');
                    }
                    @this.set(wiremodel, contents)
                },
                onPaste: function (e) {
                    e.preventDefault();
                    var clipboardData = (e.originalEvent || e).clipboardData;
                    var text = clipboardData.getData('text/plain');
                    var containsPreHljs = /<pre\s+class="hljs"[^>]*>[^]*?<\/pre>/i.test(text);

                    if (containsPreHljs) {
                        document.execCommand('insertHTML', false, '<p>' + text + '</p>');
                    } else {
                        text = text.replace(/-([a-zA-Z0-9\-_]+)-/g, function (match, p1) {
                            return '<span id="codeselector">' + p1 + '</span>';
                        });
                        document.execCommand('insertHTML', false, '<p>' + text + '</p>');
                    }
                },
                onInit: function () {
                    let currentContent = @this.get(wiremodel);
                    if (!currentContent) {
                        currentContent = '<p>Teks</p>'; // Paragraf default kosong
                    }
                    @this.set(wiremodel, currentContent)
                    $(selector).summernote('code', currentContent);
                }
            },
            icons: {
                grid: "bi bi-grid-3x2"
            },
        });
    }

</script>
<script>
    function sendFile(file, editor, welEditable) {
        token = "{{ csrf_token() }}"
        data = new FormData();
        data.append("file", file);
        data.append('_token', token);
        $('#loading-image-summernote').show();
        $(editor).summernote('disable');
        $.ajax({
            data: data,
            type: "POST",
            url: "{{ url('/summernote/file/upload') }}",
            cache: false,
            contentType: false,
            processData: false,
            success: function (url) {
                console.log(url);
                if (url['status'] == "success") {
                    $(editor).summernote('enable');
                    $('#loading-image-summernote').hide();
                    $(editor).summernote('editor.saveRange');
                    $(editor).summernote('editor.restoreRange');
                    $(editor).summernote('editor.focus');
                    $(editor).summernote('editor.insertImage', url['image_url']);
                }
                $("img").addClass("img-fluid");
            },
            error: function (data) {
                console.log(data)
                $(editor).summernote('enable');
                $('#loading-image-summernote').hide();
            }
        });
    }

    function deleteFile(target) {
        token = "{{ csrf_token() }}"
        data = new FormData();
        data.append("target", target);
        data.append('_token', token);
        $('#loading-image-summernote').show();
        $('.summernote').summernote('disable');
        $.ajax({
            data: data,
            type: "POST",
            url: "{{ url('/summernote/file/delete') }}",
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                console.log(result)
                if (result['status'] == "success") {
                    $('.summernote').summernote('enable');
                    $('#loading-image-summernote').hide();
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Gambar berhasil dihapus.',
                        icon: 'success',
                    })
                }
            },
            error: function (data) {
                console.log(data)
                $('.summernote').summernote('enable');
                $('#loading-image-summernote').hide();
            }
        });
    }

</script>
@endpush
