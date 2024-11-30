<div>
    <div class="tw-container tw-max-w-7xl tw-mx-auto lg:tw-mt-[-35px] tw-px-4 lg:tw-px-0">
        <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-4 tw-gap-x-4">
            <div class="tw-hidden lg:tw-block">
                <div
                    class="tw-bg-gradient-to-tl tw-from-[#010022] tw-to-slate-950 tw-rounded-xl tw-shadow tw-shadow-slate-900 tw-p-4">
                    <div class="tw-bg-slate-800 tw-py-4 tw-text-center tw-rounded-t-xl tw-text-base">
                        Kategori
                    </div>
                    <div class="tw-mt-5 tw-px-4 tw-space-y-3 tw-text-gray-50 tw-text-base">
                        @foreach ($project_categories as $category_id => $categories)
                        <a href="#" wire:click.prevent="changeCategoryId({{ $category_id }})"><i
                                class="fas fa-tag tw-text-cyan-300"></i>
                            <span
                                class="tw-ml-0 hover:tw-text-cyan-300">{{ $categories->first()->category_name }}</span>
                        </a>
                        <ul class="tw-ml-[-18px] tw-text-gray-300">
                            @if ($category_id == $this->category_id)
                            @foreach ($categories as $category)
                            @if ($category->sub_category_id)
                            <li
                                class="tw-mb-2 {{ $sub_category_id == $category->sub_category_id ? 'tw-text-yellow-300' : '' }}">
                                <a href="#"
                                    wire:click.prevent="changeSubCategoryId({{ $category->sub_category_id }})">{{ $category->sub_category_name }}</a>
                            </li>
                            @endif
                            @endforeach
                            @endif
                        </ul>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Sidebar -->
            <div id="overlay-project" class="tw-fixed tw-inset-0 tw-bg-black tw-opacity-50 tw-hidden tw-z-40"></div>
            <div
                class="sidebar-project bg-slate-900 tw-w-64 lg:tw-hidden md:tw-hidden no-scrollbar tw-overflow-y-scroll tw-bg-gray-950 tw-h-screen tw-fixed tw-inset-y-0 tw-left-0 tw-transform -tw-translate-x-full tw-transition tw-duration-200 tw-ease-in-out md:tw-relative md:tw-translate-x-0 tw-z-50">
                <!-- logo -->
                <div class="tw-px-4 tw-pt-4 tw-flex tw-justify-center">
                    <a href="#" class="tw-flex tw-space-x-2">
                        <img src="{{ asset('icons/MIDRAGON.png') }}" class="tw-w-5 tw-h-5">
                        <span class="tw-font-extrabold tw-uppercase tw-tracking-widest">MIDRAGON</span>
                    </a>
                </div>

                <!-- nav -->
                <nav>
                    <div
                        class="tw-bg-gradient-to-tl tw-from-[#010022] tw-to-slate-950 tw-rounded-xl tw-shadow tw-shadow-slate-900 tw-p-4">
                        <div class="tw-bg-slate-800 tw-py-4 tw-text-center tw-rounded-t-xl tw-text-base">
                            Kategori
                        </div>
                        <div class="tw-mt-5 tw-px-4 tw-space-y-3 tw-text-gray-50 tw-text-base">
                            @foreach ($project_categories as $category_id => $categories)
                            <a href="#" wire:click.prevent="changeCategoryId({{ $category_id }})"><i
                                    class="fas fa-tag tw-text-cyan-300"></i>
                                <span
                                    class="tw-ml-0 hover:tw-text-cyan-300">{{ $categories->first()->category_name }}</span>
                            </a>
                            <ul class="tw-ml-[-18px] tw-text-gray-300">
                                @if ($category_id == $this->category_id)
                                @foreach ($categories as $category)
                                @if ($category->sub_category_id)
                                <li
                                    class="tw-mb-2 {{ $sub_category_id == $category->sub_category_id ? 'tw-text-yellow-300' : '' }}">
                                    <a href="#"
                                        wire:click.prevent="changeSubCategoryId({{ $category->sub_category_id }})">{{ $category->sub_category_name }}</a>
                                </li>
                                @endif
                                @endforeach
                                @endif
                            </ul>
                            @endforeach
                        </div>
                    </div>
                    <div class="tw-my-12">
                    </div>
                </nav>
            </div>

            <div class="tw-col-span-3 tw-text-slate-200">
                <div class="tw-block lg:tw-flex tw-justify-between tw-text-center lg:tw-text-left">
                    <p class="tw-font-bold tw-text-xl tw-text-cyan-300">Kategori Project Terbaru</p>
                    <div class="tw-flex tw-justify-center">
                        <input type="search"
                            class="tw-bg-slate-900 tw-rounded-full tw-border tw-border-cyan-300 tw-px-4 tw-mt-5 lg:tw-mt-0"
                            placeholder="Cari..." wire:model.live.debounce.750ms="searchTerm">
                        <button
                            class="filter-button tw-bg-slate-900 tw-text-cyan-300 tw-font-semibold tw-border tw-border-cyan-300 tw-px-4 tw-rounded-full tw-block lg:tw-hidden tw-ml-3 tw-h-12 tw-mt-5">Filter</button>
                    </div>
                </div>
                <p class="tw-mt-3 tw-text-base">Download berbagai source code dan script web lengkap untuk mendukung
                    proyekmu, mulai dari aplikasi hingga fitur custom.</p>
                <hr class="tw-mt-3 tw-border tw-border-slate-800">
                <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-3 tw-gap-x-4 tw-gap-y-4 tw-mt-5">
                    @forelse ($projects as $project)
                    <div wire:key="{{ rand() }}"
                        class="tw-bg-gradient-to-tl tw-from-[#010022] tw-to-slate-900 tw-rounded-xl tw-shadow tw-shadow-slate-900 tw-flex tw-flex-col">
                        <div class="tw-p-4">
                            <img src="{{ asset('storage/'. $project->thumbnail) }}" class="tw-rounded-xl" alt="">
                        </div>
                        <hr class="tw-border-dashed tw-border-slate-800 tw-border-[1.5px]">
                        <div class="tw-p-4 tw-text-center tw-flex tw-flex-col tw-flex-grow">
                            <p class="tw-font-medium tw-text-base tw-tracking-wide">{{ $project->title }}</p>
                            <p class="tw-mt-3">
                                <span
                                    class="tw-bg-gray-700 tw-px-4 tw-py-1 tw-rounded-full tw-text-sm">{{ $project->sub_category_name }}</span>
                            </p>
                        </div>
                        <hr class="tw-border-slate-800 lg:tw-border-slate-900">
                        <div class="tw-p-4 tw-flex tw-mt-auto tw-justify-between">
                            <p class="tw-font-semibold tw-text-cyan-300 tw-text-lg">Rp{{ $project->price }}</p>
                            <a href="{{ url('/project/'.$project->slug) }}"
                                class="tw-bg-transparent tw-border tw-border-cyan-300 tw-px-4 tw-py-1 tw-rounded-full tw-text-sm tw-tracking-wide">Detail</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="tw-mt-5">
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('links')
    <link rel="stylesheet" href="{{ asset('/assets/stisla/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/stisla/css/style.css') }}">
    @endpush

    @push('scripts')
    <script>
        const filterBtn = document.querySelector(".filter-button");
        const sidebarProject = document.querySelector(".sidebar-project");
        const overlayProject = document.querySelector("#overlay-project");

        filterBtn.addEventListener("click", () => {
            sidebarProject.classList.toggle("-tw-translate-x-full");
            overlayProject.classList.toggle("tw-hidden");
            body.classList.toggle("tw-overflow-hidden");
            if (!sidebarProject.classList.contains("-tw-translate-x-full")) {
                overlayProject.classList.remove("tw-hidden");
                body.classList.add("tw-overflow-hidden");
            } else {
                overlayProject.classList.add("tw-hidden");
                body.classList.remove("tw-overflow-hidden");
            }
        });

        overlayProject.addEventListener("click", () => {
            sidebarProject.classList.add("-tw-translate-x-full");
            overlayProject.classList.add("tw-hidden");
            body.classList.remove("tw-overflow-hidden");
        });

    </script>
    <script>
        window.addEventListener('removeOverlay', event => {
            sidebarProject.classList.add("-tw-translate-x-full");
            overlayProject.classList.add("tw-hidden");
            body.classList.remove("tw-overflow-hidden");
        })

    </script>
    @endpush
