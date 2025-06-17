<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Project</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <h3>Table Project</h3>
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
                    <div class="search-column tw-mb-2">
                        <p>Search: </p><input type="search" wire:model.live.debounce.750ms="searchTerm" id="search-data"
                            placeholder="Search here..." class="form-control" value="">
                    </div>
                </div>
            </div>
            <div class="tw-px-10">
                <div
                    class="tw-flex tw-mt-[-5px] tw-overscroll-x-auto tw-overflow-x-auto tw-whitespace-nowrap tw-space-x-2 hide-scrollbar">
                    @foreach ($categories as $category)
                    <button
                        class="badge badge-white tw-shadow-md tw-shadow-gray-300 tw-text-sm tw-mb-5">{{ $category['category_name'] }}</button>
                    @endforeach
                </div>
            </div>
            <div class="tw-grid tw-grid-cols-5 tw-gap-x-3 tw-gap-y-2 tw-mb-5">
                @foreach ($data as $row)
                <a href="{{ url('/project/' . $row->slug) }}" target="_BLANK"
                    class="!tw-no-underline tw-bg-white tw-rounded-lg tw-shadow-md tw-shadow-gray-300 tw-flex tw-flex-col">
                    <div class="tw-px-3 tw-pt-3">
                        <img class="tw-rounded-lg"
                            src="{{ $row->thumbnail == '-' ? asset('images/default-image.jpg') : asset('storage/'.$row->thumbnail) }}"
                            alt="">
                    </div>
                    <div
                        class="tw-flex tw-flex-col tw-justify-center tw-items-center tw-text-center tw-text-black tw-tracking-tight tw-px-2.5 tw-mb-3 tw-flex-grow">
                        <p class="tw-mt-2">{{ Str::limit($row->title, 50, '...') }}</p>
                        <span class="badge tw-bg-blue-100 tw-text-blue-400 tw-mt-2">{{ $row->sub_category_name }}</span>
                    </div>
                    <div class="tw-flex tw-items-center tw-m-3 tw-mt-auto">
                        <p class="tw-text-gray-600 tw-tracking-normal">
                            {{ \Carbon\Carbon::parse($row->date)->format('d/m/Y') }}</p>
                        <div class="tw-ml-auto">
                            <button wire:click.prevent="edit({{ $row->id }})" class="btn btn-sm btn-info"
                                data-toggle="modal" data-target="#formDataModal"><i class="fas fa-edit"></i></button>
                            <button wire:click.prevent="deleteConfirm({{ $row->id }})" class="btn btn-sm btn-danger"><i
                                    class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </a>

                @endforeach
            </div>
            <div class="card">
                <div class="mt-1 px-3">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
        <button wire:click.prevent="isEditingMode(false)" class="btn-modal" data-toggle="modal" data-backdrop="static"
            data-keyboard="false" data-target="#formDataModal">
            <i class="far fa-plus"></i>
        </button>
    </section>
    <div class="modal fade" wire:ignore.self id="formDataModal" aria-labelledby="formDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formDataModalLabel">{{ $isEditing ? 'Edit Data' : 'Add Data' }}</h5>
                    <button type="button" wire:click="cancel()" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-tabs1-tab" data-toggle="tab"
                                    data-target="#nav-tabs1" type="button" role="tab" aria-controls="nav-tabs1"
                                    aria-selected="true" wire:ignore.self>Basic</button>
                                <button class="nav-link" id="nav-tabs2-tab" data-toggle="tab"
                                    data-target="#nav-tabs2" type="button" role="tab" aria-controls="nav-tabs2"
                                    aria-selected="false" wire:ignore.self>Advanced</button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-tabs1" role="tabpanel"
                                aria-labelledby="nav-tabs1-tab" wire:ignore.self>
                                @if ($thumbnail)
                                    <img src="{{ $thumbnail->temporaryUrl() }}" class="img-thumbnail mb-3" alt="Preview"
                                        width="150">
                                @elseif ($isEditing && $dataId)
                                    <img src="{{ asset('storage/' . \App\Models\Project::find($dataId)->thumbnail) }}"
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
                                    <div class="col-lg-4">
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
                                    <div class="col-lg-4">
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
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" wire:model="title" id="title" class="form-control">
                                            @error('title')
                                            <small class='text-danger'>{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input type="text" wire:model="price" id="price" class="form-control">
                                            @error('price')
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
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="version">Version</label>
                                            <input type="text" wire:model="version" id="version" class="form-control">
                                            @error('version')
                                            <small class='text-danger'>{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="link_demo">Link Demo</label>
                                            <input type="text" wire:model="link_demo" id="link_demo" class="form-control">
                                            @error('link_demo')
                                            <small class='text-danger'>{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="link_github">Link Github</label>
                                            <input type="text" wire:model="link_github" id="link_github" class="form-control">
                                            @error('link_github')
                                            <small class='text-danger'>{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-tabs2" role="tabpanel"
                                aria-labelledby="nav-tabs2-tab" wire:ignore.self>
                                {{-- <pre>{{ json_encode($images, JSON_PRETTY_PRINT) }}</pre> --}}
                                <div class="form-group">
                                    <label for="images">Upload Images</label>
                                    <input type="file" wire:model="images" id="images" class="form-control" multiple>
                                    @error('images.*')
                                    <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </div>
                                {{-- <pre>{{ json_encode($tag_id, JSON_PRETTY_PRINT) }}</pre> --}}
                                <div class="form-group">
                                    <label for="tag_id">Tag Name</label>
                                    <div wire:ignore>
                                        <select wire:model="tag_id" id="tag_id" class="form-control"
                                            wire:key="{{ rand() }}" multiple>
                                            <option value="">-- Select Tag --</option>
                                            @foreach ($tags as $tag)
                                            <option value="{{ $tag['id'] }}">
                                                {{ $tag['tag_name'] }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('tag_id')
                                    <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </div>
                                <button class="btn btn-primary tw-float-right mb-3" wire:click.prevent="addText">Add Text</button>
                                {{-- <pre>{{ json_encode($text, JSON_PRETTY_PRINT) }}</pre> --}}
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="tw-text-center" width="7%">No</th>
                                            <th>Left Text</th>
                                            <th>Right Text</th>
                                            <th width="10%" class="tw-text-center"><i class="fas fa-cogs"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($text as $index => $tex)
                                        <tr>
                                            <td class="tw-text-center">{{ $loop->iteration }}</td>
                                            <td><input type="text" wire:model="text.{{ $index }}.left_text"  class="form-control"></td>
                                            <td><input type="text" wire:model="text.{{ $index }}.right_text" class="form-control"></td>
                                            <td class="tw-text-center"><button class="btn btn-danger" wire:click.prevent="removeText({{ $index }})"><i class="fas fa-trash"></i></button></td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No data available</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
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

            $('#tag_id').select2();
            $('#tag_id').on('change', function (e) {
                var data = $('#tag_id').select2("val");
                @this.set('tag_id', data);
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
                        text = text.replace(/<([a-z]+)([^>]*)>/gi, function (match, p1, p2) {
                            return '<code>&lt;' + p1 + p2 + '&gt;</code>';
                        });
                        text = text.replace(/-([^\s]+?)-/g, function (match, p1) {
                            return '<span id="codeselector">' + p1 + '</span>';
                        });
                        text = text.replace(/-([^-]+?)-/g, function (match, p1) {
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
