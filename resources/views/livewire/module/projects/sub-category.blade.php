<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Sub Category</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <h3>Table Sub Category</h3>
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
                    <div class="table-responsive tw-max-h-96">
                        <table class="tw-table-auto">
                            <thead class="tw-sticky tw-top-0">
                                <tr class="tw-text-gray-700">
                                    <th width="15%" class="tw-whitespace-nowrap">Category</th>
                                    <th>Sub Category</th>
                                    <th>Description</th>
                                    <th class="text-center"><i class="fas fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data->groupBy('category_name') as $row)
                                <tr>
                                    <td class="text-left tw-font-bold">{{ $row[0]['category_name'] }}</td>
                                    <td colspan="3"></td>
                                </tr>
                                @foreach ($row as $item)
                                <tr>
                                    <td class="text-center"></td>
                                    <td>{{ $item['sub_category_name'] }}</td>
                                    <td>{{ $item['description'] }}</td>
                                    <td class="text-center">
                                        <button wire:click.prevent="edit({{ $item['id'] }})" class="btn btn-primary"
                                            data-toggle="modal" data-target="#formDataModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click.prevent="deleteConfirm({{ $item['id'] }})"
                                            class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Not data available in the table</td>
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
                        <div class="form-group">
                            <label for="category_id">Category Name</label>
                            <select wire:model="category_id" id="category_id" class="form-control">
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sub_category_name">Sub Category Name</label>
                            <input type="text" wire:model="sub_category_name" id="sub_category_name"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea wire:model="description" id="description" class="form-control"
                                style="height: 100px"></textarea>
                        </div>
                        <input type="hidden" wire:model='image'>
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
@endpush

@push('js-libraries')
<script src="{{ asset('/assets/midragon/select2/select2.full.min.js') }}"></script>
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
        });
    })

</script>
@endpush
