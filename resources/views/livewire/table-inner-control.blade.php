@php
    $permanentlyUnavailable = ! $table->available;
    $avatar = $this->getCurrentUserAvatar();
    $percentage = $this->getPercentage();
    $fulfilled = $this->getIsCurrentReservationFulfilled();
    $empty = $this->currentReservation === null;
@endphp

<div
    wire:poll
    @class([
        'p-2 text-white transition-transform rounded-md  flex flex-col transition-all cursor-pointer',
        'bg-gradient-to-tr from-gray-200/60 to-gray-400 cursor-default ' => $permanentlyUnavailable,
        'bg-gradient-to-tr from-emerald-500/80 to-sky-600/80 bg-sky-500/60 shadow-2xl hover:to-sky-700/80 ring-white/10 ring' => ! $permanentlyUnavailable && ! $empty && ! $fulfilled,
        'bg-green-400/50 ring-white/10 ring hover:bg-green-400/60' => ! $permanentlyUnavailable && ! $empty && $fulfilled,
        'bg-gray-600/80 ring-black/30 ring' => ! $permanentlyUnavailable && $empty
    ])
    style="
        width: {{ $table->dimensions->width }}px;
        height: {{ $table->dimensions->height }}px;
    "
>
    @if ($permanentlyUnavailable)
    <div class="flex items-center justify-center h-full">
        {{--  --}}
    </div>
    @else
        <div class="flex items-center justify-between">
            <span class="text-sm font-bold uppercase">
                {{ $table->label }}
            </span>
        </div>
        @if($this->currentUser)
            <span class="flex mt-auto">
                {{ $this->currentReservation->end_at->diffInMinutes(now()) }} minutes
            </span>
            <img class="absolute w-8 h-8 rounded-full cursor-pointer -top-5 -right-5 md:w-10 md:h-10 ring-2 ring-primary-600" src="{{ $avatar }}" alt="avatar">
            <div class="absolute bottom-0 left-0 z-10 h-1 bg-white/80" style="width: {{ $percentage }}%"></div>
        @else
            <span class="flex flex-col mt-auto">
                @if ($this->soonestReservation)
                    <span class="text-sm">{{ $this->soonestReservation?->user->name }}</span>
                    <span class="text-sm">{{ $this->soonestReservation?->start_at->format('H:i (d. m. Y)')}}</span>
                @endif
            </span>
        @endif
    @endif
</div>
