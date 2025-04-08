@section('navbar')
<div class="fixed z-50 flex justify-center items-center w-full h-fit">
  <nav class="bg-white border self-center flex justify-between min-h-14 w-full max-w-[940px] gap-2.5 px-5 rounded-[11px] border-[rgba(0,0,0,0.1)] border-solid max-md:max-w-full max-md:px-3 mt-4 mx-4 md:mx-42">
    <div class="flex items-center justify-center">
      <img
        src="{{ asset('images/Y-TRACK_dark.svg') }}"
        alt="Y-track logo"
        class="aspect-[2.71] object-contain w-18 self-stretch"
      />
    </div>

  <!-- Desktop Navigation -->
<div class="hidden md:flex md:flex-row items-center text-[13px] text-black font-semibold tracking-[1.18px] leading-none justify-center gap-[35px] py-[11px]">
  <a href="{{ route('home') }}" class="whitespace-nowrap p-2">Home</a>
  <a href="#about" class="whitespace-nowrap p-2">About</a>
  <a href="#features" class="whitespace-nowrap p-2">Features</a>
  <a href="#testimonial" class="whitespace-nowrap p-2">Testimonial</a>
  <a href="#contact" class="p-2">Contact us</a>
</div>

    <!-- Desktop Buttons -->
    <div class="hidden md:flex items-center gap-4 text-xs font-bold text-center  uppercase leading-none px-2 py-[11px]">
      <a href="/auth" class="flex items-center justify-center border-orange-500 border min-h-[34px] gap-0.5 text-orange-500 whitespace-nowrap w-[68px] rounded-md border-solid">
        Sign Up
      </a>
      <a href="/auth" class="flex items-center justify-center bg-orange-500 min-h-[34px] gap-0.5 text-gray-800 w-[68px] rounded-md">
        Sign In
      </a>
    </div>

    <!-- Mobile Burger Button -->
    <div class="md:hidden flex items-center">
      <button id="mobile-menu-button" class="p-2 focus:outline-none">
        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>
  </nav>

  <!-- Mobile Menu Dropdown -->
  <div id="mobile-menu" class="fixed top-16 left-0 right-0 bg-white border border-[rgba(0,0,0,0.1)] border-solid transition-all shadow-md hidden z-50 mx-4">
    <div class="flex flex-col text-[13px] text-black font-semibold tracking-[1.18px]">
      <a href="#" class="p-4 border-b border-gray-100 hover:bg-gray-50">Home</a>
      <a href="#" class="p-4 border-b border-gray-100 hover:bg-gray-50">About</a>
      <a href="#" class="p-4 border-b border-gray-100 hover:bg-gray-50">Features</a>
      <a href="#" class="p-4 border-b border-gray-100 hover:bg-gray-50">Contact us</a>
    </div>
    <div class="flex justify-center gap-4 p-4">
      <button class="border-orange-500 border text-orange-500 whitespace-nowrap px-4 py-2 rounded-md border-solid text-xs font-bold uppercase">
        Sign Up
      </button>
      <button class="bg-orange-500 text-gray-800 px-4 py-2 rounded-md text-xs font-bold uppercase">
        Sign In
      </button>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    mobileMenuButton.addEventListener('click', function() {
      mobileMenu.classList.toggle('hidden');
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
      const isClickInside = mobileMenuButton.contains(event.target) || mobileMenu.contains(event.target);
      if (!isClickInside && !mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.add('hidden');
      }
    });
  });
</script>
@endsection