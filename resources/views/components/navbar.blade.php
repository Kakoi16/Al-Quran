{{-- components/navbar.blade.php --}}
<header class="bg-white shadow-sm absolute top-0 left-0 w-full z-50">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div>
            <a href="/">
                <svg width="80" height="32" viewBox="0 0 80 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M63.36 10.92h3.33V21h-3.33v-4.3c0-1.85-1.2-2.8-2.93-2.8-1.87 0-3.13 1.02-3.13 2.8v4.3h-3.32V10.92h3.32v1.5c.6-.98 1.8-1.7 3.4-1.7 2.13 0 2.65 1.5 2.65 4.3v-.02Z" fill="#635BFF"></path>
                    <path d="M51.1 10.72c-2.34 0-4.24 1.83-4.24 4.38 0 2.5 1.9 4.37 4.24 4.37 1.33 0 2.4-.48 3.1-1.3l-2-1.33c-.4.45-.9.7-1.4.7-.73 0-1.27-.5-1.27-1.43h5.75c.03-2.9-1.8-4.4-3.98-4.4Zm-1.13 3.4c.1-1 .7-1.7 1.5-1.7.77 0 1.35.6 1.42 1.7h-2.92Z" fill="#635BFF"></path>
                    <path d="M43.2 10.92h3.33V12.6c.6-.9 1.7-1.88 3.5-1.88.07 0 .13 0 .2.02l-.6 3.2c-.1-.02-.2-.02-.3-.02-1.3 0-2.35.8-2.8 1.9v5.18h-3.33V10.92Z" fill="#635BFF"></path>
                    <path d="M37.35 10.92h3.33v10.08h-3.33V10.92Z" fill="#635BFF"></path>
                    <path d="M29.93 10.72c-2.34 0-4.24 1.83-4.24 4.38 0 2.5 1.9 4.37 4.24 4.37 2.33 0 4.23-1.87 4.23-4.37 0-2.55-1.9-4.38-4.23-4.38Zm0 7.35c-1.27 0-2.17-1.2-2.17-2.97 0-1.78.9-2.98 2.17-2.98 1.27 0 2.17 1.2 2.17 2.98 0 1.77-.9 2.97-2.17 2.97Z" fill="#635BFF"></path>
                    <path d="M0 32h14.74v-7.25H4.2V7.5h14.7V0H0v32Z" fill="#635BFF"></path>
                </svg>
            </a>
        </div>
        <div class="hidden md:flex items-center space-x-8">
            <a href="#" class="text-slate-600 hover:text-slate-900 font-medium">Products</a>
            <a href="#" class="text-slate-600 hover:text-slate-900 font-medium">Solution</a>
            <a href="#" class="text-slate-600 hover:text-slate-900 font-medium">Developers</a>
            <a href="#" class="text-slate-600 hover:text-slate-900 font-medium">Pricing</a>
        </div>
        <div class="flex items-center gap-4">
            <button class="bg-indigo-100 text-indigo-700 font-semibold px-5 py-2 rounded-full hover:bg-indigo-200 transition-colors">Sign in</button>
            <ion-icon onclick="onToggleMenu(this)" name="menu" class="text-3xl cursor-pointer md:hidden"></ion-icon>
        </div>
    </nav>
    
    <div class="nav-links md:hidden bg-white absolute top-[-400%] left-0 w-full transition-all duration-500 ease-in-out py-4">
        <ul class="flex flex-col items-center gap-4">
            <li><a class="hover:text-indigo-600" href="#">Products</a></li>
            <li><a class="hover:text-indigo-600" href="#">Solution</a></li>
            <li><a class="hover:text-indigo-600" href="#">Developers</a></li>
            <li><a class="hover:text-indigo-600" href="#">Pricing</a></li>
        </ul>
    </div>
</header>

<script>
    const navLinks = document.querySelector('.nav-links');
    function onToggleMenu(e) {
        e.name = e.name === 'menu' ? 'close' : 'menu';
        navLinks.classList.toggle('top-[100%]'); // Animasi menu turun dari atas
    }
</script>