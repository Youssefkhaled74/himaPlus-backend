@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.verify_account') ?? 'Verify Account' }} - HemaPulse</title>
@endsection

@section('css')
    {{-- Tailwind CDN with preflight disabled (scoped to this page only) --}}
    <script>
        tailwind = { config: { corePlugins: { preflight: false } } }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .footer{display:none;}

        /* IMPORTANT: don't touch navbar/header */
        header, nav { visibility: visible !important; opacity: 1 !important; }

        .hp-card{
            border-radius:18px;
            background:#fff;
            box-shadow:0 12px 30px rgba(0,0,0,.06);
            border:1px solid #eef2f7;
        }

        .otp-input{
            width:54px;height:54px;
            border-radius:12px;
            border:1px solid #dbe3ee;
            text-align:center;
            font-size:18px;
            outline:none;
            background:#fff;
        }
        .otp-input:focus{
            border-color:#0ea5a4;
            box-shadow:0 0 0 5px rgba(14,165,164,.16);
        }

        .hp-btn-gradient{
            background: linear-gradient(90deg, #0b3b8f 0%, #0ea5a4 100%);
            color:white;
            border-radius:14px;
            padding:14px 18px;
            font-weight:700;
        }
        .hp-btn-gradient:disabled{
            opacity:.55;
            cursor:not-allowed;
        }
    </style>
@endsection

@section('content')
<main class="min-h-[calc(100vh-80px)] py-12">
    <div class="mx-auto max-w-6xl px-4">
        <div class="mx-auto w-full max-w-3xl hp-card">
            <div class="px-10 py-12 text-center">

                <h3 class="text-2xl font-extrabold text-gray-900">
                    {{ __('profile.verify_account') ?? 'Verify Your Account' }}
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    {{ __('profile.verification_code_sent') ?? 'A verification code has been sent to your email.' }}
                </p>

                <div class="mt-6 text-left">
                    @include('flash::message')

                    @if ($errors->any())
                        <div class="mb-4 rounded-xl border border-red-100 bg-red-50 p-4"
                             style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};">
                            <ul class="list-disc pl-5" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                                @foreach ($errors->all() as $error)
                                    <li class="text-sm text-red-700">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <form id="verifyForm" method="POST" action="{{ route('vendor/account-check', $user->id) }}" class="mt-2">
                    @csrf

                    {{-- real value --}}
                    <input type="hidden" name="code" id="code" value="">

                    {{-- OTP 4 digits --}}
                    <div class="mt-8 flex items-center justify-center gap-4" dir="ltr">
                        @for ($i = 0; $i < 4; $i++)
                            <input type="text"
                                   inputmode="numeric"
                                   maxlength="1"
                                   class="otp-input"
                                   data-otp="{{ $i }}"
                                   aria-label="OTP digit {{ $i+1 }}">
                        @endfor
                    </div>

                    <div class="mt-5 flex items-center justify-between text-sm text-gray-500">
                        <form method="POST" action="{{ route('vendor/regenerate-code', $user->id) }}" style="display:inline;">
                            @csrf
                            <button id="resendBtn" type="submit" class="font-semibold text-gray-600 hover:text-teal-600" style="background:none; border:none; padding:0; cursor:pointer;">
                                {{ __('profile.resend_code') ?? 'Resend Code' }}
                            </button>
                        </form>

                        <div class="font-semibold text-gray-400">
                            <span id="timerText">03:00</span>
                        </div>
                    </div>

                    <button id="verifyBtn" class="hp-btn-gradient mt-8 w-full" type="submit" disabled>
                        {{ __('profile.verify') ?? 'Verify Account' }}
                    </button>
                </form>

            </div>
        </div>
    </div>
</main>

<script>
(function(){
    const inputs = Array.from(document.querySelectorAll('.otp-input'));
    const codeHidden = document.getElementById('code');
    const verifyBtn = document.getElementById('verifyBtn');

    // timer 03:00
    let seconds = 180;
    const timerText = document.getElementById('timerText');
    function renderTimer(){
        const m = String(Math.floor(seconds / 60)).padStart(2,'0');
        const s = String(seconds % 60).padStart(2,'0');
        timerText.textContent = `${m}:${s}`;
    }
    renderTimer();
    setInterval(() => {
        if(seconds > 0){ seconds--; renderTimer(); }
    }, 1000);

    function updateCode(){
        const code = inputs.map(i => i.value).join('');
        codeHidden.value = code;
        // Enable button only when all 4 digits are filled
        const allFilled = inputs.every(i => i.value.length === 1);
        verifyBtn.disabled = !allFilled;
    }

    function focusInput(idx){
        if(inputs[idx]) inputs[idx].focus();
    }

    inputs.forEach((input, idx) => {
        input.addEventListener('input', () => {
            input.value = input.value.replace(/[^0-9]/g,'').slice(0,1);
            if(input.value && idx < inputs.length - 1) focusInput(idx + 1);
            updateCode();
        });

        input.addEventListener('keydown', (e) => {
            if(e.key === 'Backspace'){
                if(!input.value && idx > 0){
                    inputs[idx - 1].value = '';
                    focusInput(idx - 1);
                    e.preventDefault();
                }
                setTimeout(updateCode, 0);
            }
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasted = (e.clipboardData.getData('text') || '').replace(/[^0-9]/g,'').slice(0, inputs.length);
            pasted.split('').forEach((ch, i) => { inputs[i].value = ch; });
            focusInput(Math.min(pasted.length, inputs.length - 1));
            updateCode();
        });
    });

    focusInput(0);
    updateCode();
})();
</script>
@endsection
