<div>

    <div class="tw-container tw-max-w-5xl tw-mx-auto lg:tw-mt-[-35px] tw-px-4 lg:tw-px-0">
        <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-2">
            <div>
                <!-- <img src="{{ asset('images/default-image.jpg') }}" class="tw-rounded-xl"> -->
                <img src="{{ asset('storage/'. $data->thumbnail) }}" class="tw-rounded-xl tw-shadow-md tw-shadow-black">
            </div>
            <div class="tw-ml-0 lg:tw-ml-8">
                <p class="tw-text-xl tw-text-cyan-300 tw-text-center lg:tw-text-left tw-mt-5 lg:tw-mt-0">
                    {{ $data->title }}</p>
                    <div class="tw-mt-5">&nbsp;</div>
                <!-- <p class="tw-mt-5 tw-font-bold tw-text-3xl">Rp{{ $data->price }}</p> -->
                <div class="tw-mt-5">
                    <p class="tw-mt-4 tw-text-gray-400">Kategori: <b
                            class="tw-text-white">{{ $data->category_name }}</b></p>
                    <p class="tw-mt-4 tw-text-gray-400">Versi: <b class="tw-text-white">{{ $data->version }}</b></p>
                    <p class="tw-mt-4 tw-text-gray-400">Update: <b
                            class="tw-text-white">{{ \Carbon\Carbon::parse($data->updated_at)->translatedFormat('d M Y') }}</b>
                    </p>
                    <p class="tw-mt-4 tw-text-gray-400">Author: <b class="tw-text-white">{{ $data->name }}</b></p>
                </div>
                <div class="tw-flex tw-space-x-2 tw-mt-5">
                    <a href="{{ $data->link_github }}" target="_BLANK" class="tw-px-3 tw-py-1 tw-rounded-full tw-text-sm tw-border tw-border-cyan-300">
                        <i class="fab fa-github" style="margin-right: 5px;"></i>
                        Github
                    </a>
                    <a href="{{ $data->link_demo }}" target="_BLANK"
                        class="tw-bg-cyan-300 tw-text-black tw-px-3 tw-py-1 tw-rounded-full tw-text-sm tw-font-semibold">
                        <i class="far fa-eye" style="margin-right: 5px;"></i>
                        Demo
                    </a>
                </div>
            </div>
        </div>
        <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-3 tw-gap-x-4 tw-mt-10 lg:tw-mt-5">
            <div class="tw-col-span-2 tw-justify-center">
                <div
                    class="tw-flex tw-flex-wrap tw-bg-transparent lg:tw-bg-slate-900 tw-shadow-md tw-shadow-black tw-p-0 lg:tw-p-5 tw-rounded-xl">
                    @foreach ($project_image as $image)
                    <a href="{{ asset('storage/'.$image->image) }}" data-lightbox="roadtrip">
                        <img src="{{ asset('storage/'.$image->image) }}"
                            class="tw-rounded-lg tw-object-contain tw-h-14 tw-ml-3 tw-mb-3" />
                    </a>
                    @endforeach
                </div>

                <div
                    class="tw-bg-transparent lg:tw-bg-slate-900 tw-shadow-md tw-shadow-black tw-text-gray-50 tw-leading-relaxed tw-p-0 lg:tw-p-5 tw-rounded-xl tw-mt-5 tw-tracking-normal tw-text-[15.4px]">
                    {!! $data->description !!}
                </div>
            </div>
            <div class="tw-mt-10 lg:tw-mt-0">
                <div
                    class="tw-bg-transparent lg:tw-bg-slate-900 tw-shadow-md tw-shadow-black tw-p-0 lg:tw-p-5 tw-rounded-xl">
                    <div class="tw-bg-slate-800 tw-rounded-t-lg tw-py-4">
                        <p class="tw-text-center tw-text-cyan-300">Detail Project</p>
                    </div>
                    <table class="tw-table-auto">
                        <thead>
                            <tr>
                                <td
                                    class="tw-py-3 tw-bg-transparent tw-border-b tw-border-slate-700 tw-text-white tw-font-normal tw-text-sm tw-normal-case tw-text-left tw-tracking-wide">
                                    Kategori</td>
                                <td
                                    class="tw-py-3 tw-bg-transparent tw-border-b tw-border-slate-700 tw-text-white tw-font-normal tw-text-sm tw-normal-case tw-text-right tw-tracking-wide">
                                    {{ $data->category_name }}
                                </td>
                            </tr>
                            @foreach ($project_detail as $detail)
                            <tr>
                                <td
                                    class="tw-py-3 tw-bg-transparent tw-border-b tw-border-slate-700 tw-text-white tw-font-normal tw-text-sm tw-normal-case tw-text-left tw-tracking-wide">
                                    {{ $detail->left_text }}</td>
                                <td
                                    class="tw-py-3 tw-bg-transparent tw-border-b tw-border-slate-700 tw-text-white tw-font-normal tw-text-sm tw-normal-case tw-text-right tw-tracking-wide">
                                    {{ $detail->right_text }}
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td
                                    class="tw-py-3 tw-bg-transparent tw-border-b tw-border-slate-700 tw-text-white tw-font-normal tw-text-sm tw-normal-case tw-text-left tw-tracking-wide">
                                    Versi</td>
                                <td
                                    class="tw-py-3 tw-bg-transparent tw-border-b tw-border-slate-700 tw-text-white tw-font-normal tw-text-sm tw-normal-case tw-text-right tw-tracking-wide">
                                    {{ $data->version }}
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="tw-py-3 tw-bg-transparent tw-border-b tw-border-slate-700 tw-text-white tw-font-normal tw-text-sm tw-normal-case tw-text-left tw-tracking-wide">
                                    Rilis</td>
                                <td
                                    class="tw-py-3 tw-bg-transparent tw-border-b tw-border-slate-700 tw-text-white tw-font-normal tw-text-sm tw-normal-case tw-text-right tw-tracking-wide">
                                    {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d M Y') }}
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="tw-py-3 tw-bg-transparent tw-border-b tw-border-slate-700 tw-text-white tw-font-normal tw-text-sm tw-normal-case tw-text-left tw-tracking-wide">
                                    Diposting</td>
                                <td
                                    class="tw-py-3 tw-bg-transparent tw-border-b tw-border-slate-700 tw-text-white tw-font-normal tw-text-sm tw-normal-case tw-text-right tw-tracking-wide">
                                    {{ \Carbon\Carbon::parse($data->updated_at)->translatedFormat('d M Y') }}
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="tw-py-3 tw-bg-transparent tw-border-b tw-border-slate-700 tw-text-white tw-font-normal tw-text-sm tw-normal-case tw-text-left tw-tracking-wide">
                                    Update</td>
                                <td
                                    class="tw-py-3 tw-bg-transparent tw-border-b tw-border-slate-700 tw-text-white tw-font-normal tw-text-sm tw-normal-case tw-text-right tw-tracking-wide">
                                    {{ \Carbon\Carbon::parse($data->updated_at)->translatedFormat('d M Y') }}
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="tw-py-3 tw-bg-transparent tw-border-b tw-border-slate-700 tw-text-white tw-font-normal tw-text-sm tw-normal-case tw-text-left tw-tracking-wide">
                                    Author</td>
                                <td
                                    class="tw-py-3 tw-bg-transparent tw-border-b tw-border-slate-700 tw-text-white tw-font-normal tw-text-sm tw-normal-case tw-text-right tw-tracking-wide">
                                    {{ $data->name }}
                                </td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        })

    </script>
</div>
