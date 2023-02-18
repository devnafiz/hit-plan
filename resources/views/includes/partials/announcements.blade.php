@isset($announcements)

    @if ($announcements->count())
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-11 col-lg-11 col-sm-12">
                    @foreach ($announcements as $announcement)
                        <x-utils.alert :type="$announcement->type" :dismissable="false" class="pt-1 pb-1 mb-0">
                            <marquee behavior="scroll" direction="left">
                                {{ new \Illuminate\Support\HtmlString($announcement->message) }}</marquee>
                        </x-utils.alert>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

@endisset
