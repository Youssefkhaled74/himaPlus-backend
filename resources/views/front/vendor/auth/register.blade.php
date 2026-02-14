@extends('layouts.front.home')

@section('title')
    <title>{{ __('nav.register') }} | HemaPulse</title>
@endsection

@section('css')
    {{-- Tailwind CDN with preflight disabled (scoped to this page only) --}}
    <script>
        tailwind = { config: { corePlugins: { preflight: false } } }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .footer{display:none;}

        /* Dropzone look like screenshot */
        .hp-dropzone{
            border:1px dashed #dfe6ef;
            border-radius:14px;
            background:#fff;
            padding:26px 18px 22px;
            text-align:center;
        }
        .hp-upload-circle{
            width:46px;height:46px;border-radius:999px;
            display:flex;align-items:center;justify-content:center;
            background: linear-gradient(180deg,#11c5b6,#0ea5a4);
            box-shadow: 0 10px 22px rgba(14,165,164,.25);
            margin:-46px auto 10px;
        }
        .hp-drop-hint{
            font-size:12px;
            color:#9aa3af;
        }
        .hp-drop-link{
            font-size:14px;
            font-weight:600;
            color:#2563eb;
            cursor:pointer;
            text-decoration:none;
        }
        .hp-drop-link:hover{ text-decoration:underline; }

        /* Inputs consistent */
        .hp-label{margin-bottom:8px; display:block; font-size:14px; font-weight:700; color:#111827;}
        .hp-req{color:#ef4444;}
        .hp-input{
            width:100%;
            border:1px solid #e5e7eb;
            border-radius:12px;
            padding:12px 14px;
            font-size:14px;
            outline:none;
            background:#fff;
        }
        .hp-input:focus{
            border-color:#0ea5a4;
            box-shadow:0 0 0 4px rgba(14,165,164,.15);
        }
        .hp-select{height:46px;}
        .hp-card{
            border-radius:18px;
            background:#fff;
            box-shadow:0 12px 30px rgba(0,0,0,.06);
        }
        .hp-btn-disabled{
            background:#e5e7eb !important;
            color:#9ca3af !important;
            cursor:not-allowed;
        }
    </style>
@endsection

@section('content')
<main class="min-h-[calc(100vh-80px)] py-10">
    <div class="mx-auto max-w-6xl px-4">
        <div class="mx-auto w-full max-w-xl hp-card">
            <div class="px-8 py-10">

                {{-- Tabs --}}
                <div class="mb-8 flex items-center justify-center gap-10">
                    <a href="{{ route('vendor/login') }}"
                       class="pb-2 text-sm font-semibold text-gray-400 hover:text-gray-600">
                        {{ __('nav.login') ?? 'Login' }}
                    </a>

                    <a href="{{ route('vendor/register/form') }}"
                       class="border-b-2 border-teal-500 pb-2 text-sm font-semibold text-teal-600">
                        {{ __('nav.register') ?? 'Register' }}
                    </a>
                </div>

                @include('flash::message')

                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-red-100 bg-red-50 p-4"
                         style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};">
                        <ul class="list-disc pl-5" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm text-red-700">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="registerForm"
                      method="POST"
                      action="{{ route('vendor/register/store') }}"
                      enctype="multipart/form-data"
                      class="space-y-5">
                    @csrf

                    {{-- User Type --}}
                    <div>
                        <label class="hp-label">
                            User Type Selector <span class="hp-req">*</span>
                        </label>

                        <select name="user_type" id="userType" required class="hp-input hp-select">
                            <option value="" disabled {{ old('user_type') ? '' : 'selected' }}>Select Account Type</option>
                            <option value="1" {{ old('user_type') == 1 ? 'selected' : '' }}>User</option>
                            <option value="2" {{ old('user_type') == 2 ? 'selected' : '' }}>Vendor</option>
                        </select>
                    </div>

                    {{-- Vendor Fields --}}
                    <div id="vendorFields" class="hidden space-y-5">

                        <div>
                            <label class="hp-label">Supplier Name <span class="hp-req">*</span></label>
                            <input name="name" value="{{ old('name') }}"
                                   data-required-vendor="1"
                                   placeholder="e.g., SaudiMed Co."
                                   class="hp-input">
                        </div>

                        <div>
                            <label class="hp-label">IBAN <span class="hp-req">*</span></label>
                            <input name="iban" value="{{ old('iban') }}"
                                   data-required-vendor="1"
                                   placeholder="Enter IBAN"
                                   class="hp-input">
                        </div>

                        <div>
                            <label class="hp-label">CR Number <span class="hp-req">*</span></label>
                            <input name="cr_number" value="{{ old('cr_number') }}"
                                   data-required-vendor="1"
                                   placeholder="Enter CR number"
                                   class="hp-input">
                        </div>

                        <div>
                            <label class="hp-label">Tax Number <span class="text-xs font-medium text-gray-400">(Optional)</span></label>
                            <input name="tax_number" value="{{ old('tax_number') }}"
                                   placeholder="Enter tax number"
                                   class="hp-input">
                        </div>

                        <div>
                            <label class="hp-label">Location <span class="hp-req">*</span></label>
                            <input name="location" value="{{ old('location') }}"
                                   data-required-vendor="1"
                                   placeholder="Enter location"
                                   class="hp-input">
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="hp-label">Phone Number <span class="hp-req">*</span></label>

                        <div class="flex overflow-hidden rounded-xl border border-gray-200 bg-white"
                             style="box-shadow:0 0 0 0 rgba(0,0,0,0);">
                            <div class="flex items-center gap-2 bg-gray-50 px-4 text-sm text-gray-600 border-r border-gray-200">
                                <span class="inline-flex h-4 w-6 items-center justify-center rounded-sm bg-green-600 text-[9px] font-bold text-white">SA</span>
                                <span>+966</span>
                                <span class="text-gray-400">▼</span>
                            </div>
                            <input name="mobile" value="{{ old('mobile') }}" required
                                   placeholder="xxxxxxxxx"
                                   class="w-full px-4 py-3 text-sm outline-none"
                                   onfocus="this.parentElement.style.boxShadow='0 0 0 4px rgba(14,165,164,.15)'; this.parentElement.style.borderColor='#0ea5a4';"
                                   onblur="this.parentElement.style.boxShadow='none'; this.parentElement.style.borderColor='#e5e7eb';">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="hp-label">Email <span class="hp-req">*</span></label>
                        <input name="email" type="email" value="{{ old('email') }}" required
                               placeholder="Enter your email"
                               class="hp-input">
                    </div>

                    {{-- Upload CR Document (Vendor) --}}
                    <div id="vendorUpload" class="hidden">
                        <label class="hp-label">Upload CR Document <span class="hp-req">*</span></label>

                        <div class="hp-dropzone">
                            <input name="cr_file_document" type="file" class="hidden" id="crDocInput" accept="image/*,.pdf">

                            <div class="hp-upload-circle">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 16V4" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M7 9L12 4L17 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>

                            {{-- clickable link like UI --}}
                            <a id="crDocLink" class="hp-drop-link">Choose file to upload</a>

                            <div class="mt-2 hp-drop-hint">Upload CR Certificate (PDF / Image)</div>

                            <div id="crDocName" class="mt-3 hidden text-xs font-semibold text-teal-600"></div>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="hp-label">Password <span class="hp-req">*</span></label>
                        <div class="relative">
                            <input name="password" id="password" type="password" required
                                   placeholder="Enter your password"
                                   class="hp-input pr-20">
                            <button type="button" data-toggle="password"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg px-3 py-1 text-xs font-semibold text-gray-500 hover:bg-gray-100">
                                Show
                            </button>
                        </div>
                    </div>

                    {{-- Confirm --}}
                    <div>
                        <label class="hp-label">Confirm Password <span class="hp-req">*</span></label>
                        <div class="relative">
                            <input name="password_confirmation" id="password_confirmation" type="password" required
                                   placeholder="Re-enter your password"
                                   class="hp-input pr-20">
                            <button type="button" data-toggle="password_confirmation"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg px-3 py-1 text-xs font-semibold text-gray-500 hover:bg-gray-100">
                                Show
                            </button>
                        </div>
                    </div>

                    {{-- Terms --}}
                    <div class="flex items-start gap-3 pt-1">
                        <input class="mt-1 h-4 w-4 rounded border-gray-300 text-teal-600 focus:ring-teal-200"
                               type="checkbox" name="terms" id="terms" value="1" required>
                        <label class="text-sm text-gray-600" for="terms">
                            I agree to <a href="#" class="font-semibold text-teal-600 hover:underline">Terms</a>
                            &amp; <a href="#" class="font-semibold text-teal-600 hover:underline">Privacy Policy</a>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button id="submitBtn" type="submit" disabled
                            class="w-full rounded-2xl px-4 py-4 text-sm font-semibold hp-btn-disabled">
                        Sign Up
                    </button>
                </form>

            </div>
        </div>
    </div>
</main>

<script>
(function(){
    const userType = document.getElementById('userType');
    const vendorFields = document.getElementById('vendorFields');
    const vendorUpload = document.getElementById('vendorUpload');

    const crDocInput = document.getElementById('crDocInput');
    const crDocName = document.getElementById('crDocName');
    const crDocLink = document.getElementById('crDocLink');

    const form = document.getElementById('registerForm');
    const submitBtn = document.getElementById('submitBtn');
    const terms = document.getElementById('terms');

    const vendorRequired = () => Array.from(form.querySelectorAll('[data-required-vendor="1"]'));

    function setVendorMode(isVendor){
        vendorFields.classList.toggle('hidden', !isVendor);
        vendorUpload.classList.toggle('hidden', !isVendor);

        vendorRequired().forEach(el => el.required = !!isVendor);
        if (crDocInput) crDocInput.required = !!isVendor;

        validate();
    }

    function setSubmit(ok){
        submitBtn.disabled = !ok;
        if(ok){
            submitBtn.className = 'w-full rounded-2xl bg-teal-600 px-4 py-4 text-sm font-semibold text-white hover:bg-teal-700';
        }else{
            submitBtn.className = 'w-full rounded-2xl px-4 py-4 text-sm font-semibold hp-btn-disabled';
        }
    }

    function validate(){
        const isVendor = userType.value === '2';
        let ok = true;

        ['user_type','mobile','email','password','password_confirmation'].forEach(name=>{
            const el = form.querySelector(`[name="${name}"]`);
            if (!el || !el.value.trim()) ok = false;
        });

        if(isVendor){
            vendorRequired().forEach(el=>{
                if(!el.value.trim()) ok = false;
            });
            if(!crDocInput.files || crDocInput.files.length === 0) ok = false;
        }

        if(!terms.checked) ok = false;

        setSubmit(ok);
    }

    userType.addEventListener('change', () => setVendorMode(userType.value === '2'));
    form.addEventListener('input', validate);
    form.addEventListener('change', validate);

    // clickable "Choose file to upload"
    if(crDocLink && crDocInput){
        crDocLink.addEventListener('click', (e)=>{
            e.preventDefault();
            crDocInput.click();
        });
    }

    if(crDocInput){
        crDocInput.addEventListener('change', ()=>{
            if(crDocInput.files.length){
                crDocName.textContent = '✓ ' + crDocInput.files[0].name;
                crDocName.classList.remove('hidden');
            }else{
                crDocName.classList.add('hidden');
            }
            validate();
        });
    }

    document.querySelectorAll('[data-toggle]').forEach(btn=>{
        btn.addEventListener('click', (e)=>{
            e.preventDefault();
            const target = btn.getAttribute('data-toggle');
            const input = document.getElementById(target);
            if(!input) return;

            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            btn.textContent = isPassword ? 'Hide' : 'Show';
        });
    });

    setVendorMode(userType.value === '2');
})();
</script>
@endsection
