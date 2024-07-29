@props(['id', 'maxWidth', 'formAction' => false])

<div class="z-[100] bg-white border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 ">
    @if($formAction)
        <form wire:submit.prevent="{{ $formAction }}">
            @csrf
    @endif
            <div class="p-4 sm:px-6 sm:py-4 border-b border-gray-600">
                @if(isset($title))
                    <h3 class="text-lg leading-6 font-medium">
                        {{ $title }}
                    </h3>
                @endif
            </div>
            <div class="px-4 sm:p-6">
                <div class="space-y-6">
                    @if(isset($content))
                        {{ $content }}
                    @endif
                </div>
            </div>
            @if(isset($buttons))
                <div class="px-4 pb-5">
                    <div class="text-right">

                            {{ $buttons }}
                    </div>
                </div>
            @endif
        @if($formAction)
        </form>
    @endif
</div>
