<div style="font-family: 'Trebuchet MS', sans-serif;">
    <div class="tw-ml-10"></div>
    <div class="tw-flex-grow tw-container tw-max-w-2xl tw-mx-auto lg:tw-mt-[-35px] tw-px-4 lg:tw-px-0">
        <p class="tw-text-sm tw-font-semibold">
            @if ($status_publish == 'Draft')
                <span class="tw-text-red-500 tw-tracking-wide">{{ $status_publish }}</span>
            @elseif ($status_publish == 'Privated')
                <span class="tw-text-blue-400 tw-tracking-wide">{{ $status_publish }}</span>
            @else
                <span class="tw-text-yellow-500 tw-tracking-wide">{{ $status_publish }}</span>
            @endif
            · <span
                class="tw-text-gray-400 tw-tracking-wide">{{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }}</span>
        </p>

        <div class="tw-mt-5" id="isi-catatan">
            <h1 class="tw-text-4xl tw-font-bold tw-text-white">{{ $title }}</h1>
            <div class="tw-mt-3">
                <span
                    class="tw-p-1 tw-tracking-normal tw-leading-loose tw-text-slate-100">{!! $description !!}</span>
            </div>
            <div class="tw-mt-5 tw-text-gray-100 tw-tracking-wide tw-leading-loose">
                <span class="!tw-tracking-normal">{!! $fill_content !!}</span>
            </div>
        </div>
    </div>
</div>