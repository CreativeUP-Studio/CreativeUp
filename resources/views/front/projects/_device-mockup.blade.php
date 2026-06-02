@php
    $device = $device ?? 'none';
    if (!request()->routeIs('projects.show')) {
        $device = 'none';
    }
    $displayUrl = $displayUrl ?? 'localhost';
    $title = $title ?? 'Proyecto';
@endphp

@if($device === 'macbook')
    <div class="apple-macbook-front">
        <div class="mac-lid">
            <div class="mac-notch"><div class="mac-camera"></div></div>
            <div class="mac-screen">
                <div class="mac-browser">
                    <div class="mac-browser-dots"></div>
                    <div class="mac-browser-url">
                        <i class="fa-solid fa-lock" style="font-size:8px; margin-right:5px; color:#888;"></i>
                        {{ $displayUrl }}
                    </div>
                    <div style="width:40px;"></div>
                </div>
                <img src="{{ $image }}" alt="{{ $title }}" loading="lazy" decoding="async">
            </div>
        </div>
        <div class="mac-keyboard-base">
            <div class="mac-foot mac-foot--left"></div>
            <div class="mac-foot mac-foot--right"></div>
        </div>
    </div>
@elseif($device === 'iphone')
    <div class="project-mockup-wrapper mockup-iphone" style="padding: 0; width: 100%; height: 100%;">
        <div class="iphone-device">
            <div class="iphone-bezel">
                <div class="iphone-screen">
                    <div class="iphone-island"></div>
                    <div class="iphone-screen-img">
                        <img src="{{ $image }}" alt="{{ $title }}" loading="lazy" decoding="async">
                    </div>
                </div>
            </div>
            <div class="iphone-button volume-up"></div>
            <div class="iphone-button volume-down"></div>
            <div class="iphone-button power"></div>
        </div>
    </div>
@elseif($device === 'ipad')
    <div class="project-mockup-wrapper mockup-ipad" style="padding: 0; width: 100%; height: 100%;">
        <div class="ipad-device">
            <div class="ipad-bezel">
                <div class="ipad-screen">
                    <div class="ipad-screen-img">
                        <img src="{{ $image }}" alt="{{ $title }}" loading="lazy" decoding="async">
                    </div>
                </div>
            </div>
            <div class="ipad-button power"></div>
        </div>
    </div>
@elseif($device === 'safari')
    <div class="browser-mockup">
        <div class="safari-header-bar">
            <div class="safari-dots"><span></span><span></span><span></span></div>
            <div class="safari-address">
                <i class="fa-solid fa-lock" style="font-size:7px; color:#696e79;"></i>
                {{ $displayUrl }}
            </div>
        </div>
        <img src="{{ $image }}" alt="{{ $title }}" loading="lazy" decoding="async">
    </div>
@else
    <div class="pshow-mockup pshow-mockup--none">
        <img src="{{ $image }}" alt="{{ $title }}" loading="lazy" decoding="async">
    </div>
@endif
