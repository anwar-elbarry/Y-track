<template>
  <navbar />
  <section id="about" class="flex flex-col relative min-h-[759px] w-full overflow-hidden pt-4 pb-[71px] px-20 max-md:max-w-full max-md:px-5">
        <img
          src="/images/heroimg.png"
          alt="Hero background"
          class="absolute h-full w-full object-cover z-[-1] inset-0"
        />
        <div class="flex justify-center items-center lg:flex-nowrap flex-wrap mt-10 w-full">
        
          <div class="relative flex w-126 max-w-full flex-col items-stretch mt-41 max-md:mt-10">
          <div class="flex w-full max-w-[507px] flex-col items-stretch text-[#061C3D] max-md:max-w-full">
            <div class="bg-[#FFE9BD] gap-2 text-3 font-medium text-center uppercase tracking-[0.11px] leading-none px-4 py-2 rounded-[66.667px] w-fit">
              Welcome to Y-TRACK
            </div>
            <h1 class="text-5xl font-bold leading-17 tracking-[-0.96px] mt-4 max-md:max-w-full max-md:text-[40px] max-md:leading-[49px]">
              Simplify Your Finance
              <br />
              with Y-track
            </h1>
          </div>
          <p class="text-[#061C3D] text-base font-normal leading-5 mt-7 max-md:max-w-full">
            The all-in-one financial management platform designed for freelancers
          </p>
          <div class="flex gap-3 text-base font-bold capitalize leading-[48px] mt-7">
            <button class="self-stretch bg-[rgba(255,165,2,1)] gap-2 text-white px-5 rounded-[10px] max-md:px-5">
              Get Started
            </button>
            <button class="justify-center items-center bg-gray-100 flex gap-2 text-orange-400 px-5 rounded-[10px] max-md:px-5">
              <i class="fa-solid fa-book self-stretch" style=" color:orange ;display: flex; align-items: center;;"></i>
              <span class="self-stretch my-auto">See Document</span>
            </button>
          </div>
          </div>
          <img
            src="/images/avatar.png"
            alt="Hero background"
            class="w-fit object-cover inset-0"
          />
        </div>
        
        <div class="relative flex items-center  gap-2 text-24 text-black font-medium leading-normal justify-center h-10 mt-10 max-md:mt-10">
        
        <a href="#features">
        <i class="fa-solid fa-computer-mouse" ></i>  
        <i class="fa-solid fa-down-long"></i>
        </a>
        </div>
      </section>
    <!-- Features Section -->
    <section id="features" class="flex w-full flex-col items-stretch justify-center max-md:max-w-full">
      <div class="flex w-full flex-col items-center text-[#061C3D] text-center justify-center max-md:max-w-full">
        <h2 class="text-[37px] font-bold leading-10 tracking-[-0.75px] w-[880px] max-md:max-w-full">
          Y-Track
          <br>
          Your Smart Finance Manager
        </h2>
        <p class="text-[13px] font-normal leading-[19px] w-[432px] mt-[21px] max-md:max-w-full">
          Track & optimize your financial journey effortlessly, Manage
          transactions, monitor expenses, and achieve your financial goals with
          ease.
        </p>
      </div>
      <div class="cards flex w-full flex-col items-center justify-center mt-12 max-md:mt-6">
        <!-- Feature cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 w-full max-w-6xl px-4">
          <!-- Expense Tracking -->
          <div class="card bg-white flex flex-col items-center p-6 rounded-[10.667px] text-center shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="iconcover bg-[#F0E9E2] flex items-center justify-center w-[51px] h-[51px] p-[13px] rounded-[5.333px]">
              <v-icon name="fa-wallet" class="cardIcon text-orange-500"/>
            </div>
            <div class="mt-4">
              <h3 class="text-[#061C3D] text-xl font-medium leading-[1.4]">
                Expense Tracking
              </h3>
              <p class="text-[#42526B] text-base font-normal leading-6 mt-2">
                Monitor where your money goes with real-time expense tracking.
              </p>
            </div>
          </div>
  
          <!-- Income Management -->
          <div class="card bg-white flex flex-col items-center p-6 rounded-[10.667px] text-center shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="iconcover bg-[#F0E9E2] flex items-center justify-center w-[51px] h-[51px] p-[13px] rounded-[5.333px]">
              <v-icon name="bi-cash-coin" scale="1.5" class="cardIcon text-orange-500"/>
            </div>
            <div class="mt-4">
              <h3 class="text-[#061C3D] text-xl font-medium leading-[1.4]">
                Income Management
              </h3>
              <p class="text-[#42526B] text-base font-normal leading-6 mt-2">
                Keep an eye on all your income sources in one place.
              </p>
            </div>
          </div>
  
          <!-- Recurring Bills -->
          <div class="card bg-white flex flex-col items-center p-6 rounded-[10.667px] text-center shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="iconcover bg-[#F0E9E2] flex items-center justify-center w-[51px] h-[51px] p-[13px] rounded-[5.333px]">
              <v-icon name="bi-calendar-check-fill" scale="1.5" class="cardIcon text-orange-500"/>

            </div>
            <div class="mt-4">
              <h3 class="text-[#061C3D] text-xl font-medium leading-[1.4]">
                Recurring Bills
              </h3>
              <p class="text-[#42526B] text-base font-normal leading-6 mt-2">
                Automate and track your monthly and yearly bills easily.
              </p>
            </div>
          </div>
  
          <!-- Financial Reports -->
          <div class="card bg-white flex flex-col items-center p-6 rounded-[10.667px] text-center shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="iconcover bg-[#F0E9E2] flex items-center justify-center w-[51px] h-[51px] p-[13px] rounded-[5.333px]">
              <v-icon name="ri-line-chart-line" scale="1.5" class="cardIcon text-orange-500"/>
            </div>
            <div class="mt-4">
              <h3 class="text-[#061C3D] text-xl font-medium leading-[1.4]">
                Financial Reports
              </h3>
              <p class="text-[#42526B] text-base font-normal leading-6 mt-2">
                Generate detailed reports for better financial analysis.
              </p>
            </div>
          </div>
  
          <!-- Goal Planning -->
          <div class="card bg-white flex flex-col items-center p-6 rounded-[10.667px] text-center shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="iconcover bg-[#F0E9E2] flex items-center justify-center w-[51px] h-[51px] p-[13px] rounded-[5.333px]">
              <v-icon name="gi-on-target" scale="1.5" class="cardIcon text-orange-500"/>
            </div>
            <div class="mt-4">
              <h3 class="text-[#061C3D] text-xl font-medium leading-[1.4]">
                Goal Planning
              </h3>
              <p class="text-[#42526B] text-base font-normal leading-6 mt-2">
                Set financial goals and stay on track to achieve them.
              </p>
            </div>
          </div>
  
          <!-- Invoice Generator -->
          <div class="card bg-white flex flex-col items-center p-6 rounded-[10.667px] text-center shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="iconcover bg-[#F0E9E2] flex items-center justify-center w-[51px] h-[51px] p-[13px] rounded-[5.333px]">
              <v-icon name="ri-file-text-fill" scale="1.5" class="cardIcon text-orange-500"/>
            </div>
            <div class="mt-4">
              <h3 class="text-[#061C3D] text-xl font-medium leading-[1.4]">
                Invoice Generator
              </h3>
              <p class="text-[#42526B] text-base font-normal leading-6 mt-2">
                Create and manage professional invoices quickly.
              </p>
            </div>
          </div>
        </div>
      </div>
      </section>
  <!-- testimonial section -->
      <section id="testimonial" class="flex w-full items-center gap-[40px_91px] justify-center flex-wrap mt-28 max-md:max-w-full max-md:mt-10">
      <div class="self-stretch flex min-w-60 flex-col items-stretch w-[432px] my-auto max-md:max-w-full">
        <h2 class="text-[#061C3D] text-[37px] font-bold leading-10 tracking-[-0.75px] max-md:max-w-full">
          What our client says
          <br />
          about our application.
        </h2>
        <div class="shadow-[2px_0px_0px_0px_#0B63E5_inset] bg-white max-w-full w-[432px] text-base text-[#061C3D] font-normal leading-[21px] mt-8 pl-4">
          <p>"This guy is true professional and very experienced in migration and server configuration. He was able to complete my order in time and as per agreed scope. Highly recommend!"</p>
          <div class="flex min-h-8 w-8 mt-3"></div>
        </div>
        <div class="flex gap-3 mt-8">
          <button
            class="items-center justify-center bg-[#F0F5FF] flex gap-1 w-[43px] h-[42px] pl-3 pr-2.5 py-3 rounded hover:bg-orange-500">
            <v-icon name="bi-arrow-left"/>
          </button>
          <button
            class="items-center justify-center bg-[#F0F5FF] flex gap-1 w-[43px] h-[43px] p-3 rounded hover:bg-orange-500">
            <v-icon name="bi-arrow-right"/>
          </button>
        </div>
      </div>
      <img
        src="/images/client.png"
        alt="Client testimonial"
        class="aspect-[1] object-contain w-[357px] self-stretch min-w-60 my-auto rounded-2xl"
      />
    </section>
    <section id="contact" class="flex flex-col items-center w-full py-16 px-4">
    <!-- Header -->
    <div class="max-w-lg text-center mb-12">
      <h2 class="text-4xl font-bold tracking-tight text-[#061C3D] mb-4 md:text-5xl">
        Have a question? Get in touch!
      </h2>
      <p class="text-sm text-[#061C3D]">
        Need help with your finances? Want to optimize your financial management? Feel free to reach out to us!
      </p>
    </div>
    
    <!-- Contact Container -->
    <div class="w-full max-w-4xl rounded-2xl shadow-lg overflow-hidden">
      <div class="flex flex-col md:flex-row">
        <!-- Left Side - Contact Info -->
        <div class="bg-[#E15606] text-white p-8 md:p-12 md:w-2/5">
          <h3 class="text-2xl font-bold mb-6">Get in touch</h3>
          
          <!-- Contact Details -->
          <div class="space-y-4 mb-12">
            <!-- Email -->
            <div class="flex items-center gap-3">
              <div class="bg-white bg-opacity-10 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
              </div>
              <div>
                <p class="text-xs font-medium uppercase opacity-50">Email us</p>
                <p class="text-sm">support@ytrack.com</p>
              </div>
            </div>
            
            <!-- Phone -->
            <div class="flex items-center gap-3">
              <div class="bg-white bg-opacity-10 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
              </div>
              <div>
                <p class="text-xs font-medium uppercase opacity-50">Phone number</p>
                <p class="text-sm">+1-202-555-0138</p>
              </div>
            </div>
            
            <!-- Address -->
            <div class="flex items-center gap-3">
              <div class="bg-white bg-opacity-10 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
              <div>
                <p class="text-xs">901 N Pitt Str., Suite 170<br />Marrakech, Morocco</p>
              </div>
            </div>
          </div>
          
          <!-- Social Media -->
          <div>
            <p class="flex items-center text-xs font-medium mb-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
              </svg>
              Connect with us:
            </p>
            <div class="flex gap-2">
              <a href="#" class="bg-white p-2 rounded w-8 h-8 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#E15606]" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                </svg>
              </a>
              <a href="#" class="bg-white bg-opacity-10 p-2 rounded w-8 h-8 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                </svg>
              </a>
              <a href="#" class="bg-white bg-opacity-10 p-2 rounded w-8 h-8 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                </svg>
              </a>
              <a href="#" class="bg-white bg-opacity-10 p-2 rounded w-8 h-8 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" />
                </svg>
              </a>
            </div>
          </div>
        </div>
        
        <!-- Right Side - Contact Form -->
        <div class="bg-white p-8 md:p-12 md:w-3/5">
          <form class="space-y-4" action="#" method="post">
            <div>
              <label for="name" class="block text-sm text-[#061C3D] mb-1">Name</label>
              <input id="name" name="name" type="text" placeholder="Full name" 
                     class="w-full px-3 py-2 text-base text-[#838E9E] border border-[#E6E8EC] rounded focus:outline-none focus:ring-1 focus:ring-[#E15606]" />
            </div>
            
            <div>
              <label for="email" class="block text-sm text-[#061C3D] mb-1">Email</label>
              <input id="email" name="email" type="email" placeholder="Email address" 
                     class="w-full px-3 py-2 text-base text-[#838E9E] border border-[#E6E8EC] rounded focus:outline-none focus:ring-1 focus:ring-[#E15606]" />
            </div>
            
            <div>
              <label for="subject" class="block text-sm text-[#061C3D] mb-1">Subject</label>
              <input id="subject" name="subject" type="text" placeholder="Subject" 
                     class="w-full px-3 py-2 text-base text-[#838E9E] border border-[#E6E8EC] rounded focus:outline-none focus:ring-1 focus:ring-[#E15606]" />
            </div>
            
            <div>
              <label for="profession" class="block text-sm text-[#061C3D] mb-1">Profession/Business Type</label>
              <input id="profession" name="profession" type="text" placeholder="Web Developer"
                     class="w-full px-3 py-2 text-base text-[#838E9E] border border-[#E6E8EC] rounded focus:outline-none focus:ring-1 focus:ring-[#E15606]" />
            </div>
            
            <div>
              <label for="message" class="block text-sm text-[#061C3D] mb-1">Message</label>
              <textarea id="message" name="message" placeholder="Tell us about your project..." rows="4"
                        class="w-full px-3 py-2 text-base text-[#838E9E] border border-[#E6E8EC] rounded focus:outline-none focus:ring-1 focus:ring-[#E15606]"></textarea>
            </div>
            
            <button type="submit" 
                    class="bg-black text-white font-bold px-6 py-3 rounded mt-6 hover:bg-[#E15606] transition-colors">
              Send Message
            </button>
          </form>

          
        </div>
      </div>
    </div>
  </section>
  </template>

<script>
export default {
  name : 'Home'
}
</script>