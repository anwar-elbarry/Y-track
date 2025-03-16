
@section('navbar')
<div class="absolut fixed z-50 flex justify-center items-center w-full h-fit">
<nav class="bg-white border self-center flex justify-between min-h-14 w-full max-w-[940px] gap-2.5 overflow-hidden px-5 rounded-[11px] border-[rgba(0,0,0,0.1)] border-solid max-md:max-w-full max-md:px-5 mt-4 mx-42">
    <div class="flex items-center justify-center">
    <img
    src="{{ asset('images/Y-TRACK_dark.svg') }}"
    alt="Y-track logo"
    class="aspect-[2.71] object-contain w-18 self-stretch"
  />
    </div>

  <div class="flex min-w-60 flex-col items-center text-[13px] text-black font-semibold tracking-[1.18px] leading-none justify-center w-[421px] pl-[13px] py-[11px] max-md:max-w-full">
    <div class="flex items-center gap-[35px]">
      <a
        href="#"
        class="self-stretch  whitespace-nowrap  p-2"
      >
        Home
      </a>
      <a
        href="#"
        class="self-stretch  whitespace-nowrap  p-2"
      >
        About
      </a>
      <a
        href="#"
        class="self-stretch  whitespace-nowrap  p-2"
      >
        Features
      </a>
      <a href="#" class="self-stretch   p-2">
        Contact us
      </a>
    </div>
  </div>
  <div class="flex items-center gap-4 text-xs font-bold text-center uppercase leading-none px-2 py-[11px]">
    <button class="self-stretch border-orange-500 border min-h-[34px] gap-0.5 text-orange-500 whitespace-nowrap w-[68px]  pl-3 pr-[11px] py-[13px] rounded-md border-solid">
      Sign Up
    </button>
    <button class="self-stretch bg-orange-500 min-h-[34px] gap-0.5 text-gray-800 w-[68px]  p-[13px] rounded-md">
      Sign In
    </button>
  </div>
</nav>
</div>
@endsection
