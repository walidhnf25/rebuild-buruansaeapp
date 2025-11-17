@extends('layouts.app')
@section('page_name', 'Berita')
@section('content')
<section class="py-8 bg-gray-50">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ url('/') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-[#DC3545]">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('blog.news') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-[#DC3545] md:ml-2">Berita</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium {{ Request::is('*news/*') ? 'text-red-500':'' }} md:ml-2">Detail Berita</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Blog Content -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Blog Header -->
            <div class="relative">
                <img src="{{ asset($article['image']) }}" alt="{{ $article['title'] }}" class="w-full h-96 object-cover">
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-6">
                    <h1 class="text-lg md:text-3xl md:text-4xl font-bold text-white mb-4">{{ $article['title'] }}</h1>
                </div>
            </div>

            <!-- Blog Body -->
            <div class="p-8">
                <div class="prose max-w-none">
                    <p class="text-gray-700 text-lg leading-relaxed mb-6">
                        {{ $article['content'] }}
                    </p>

                </div>

                <!-- Share Section -->


        </div>

        <!-- Related articless -->

    </div>
</section>

<!-- Footer Section -->
<div class="footer-section bg-gray-800 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="footer-top">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="footer-item">
                    <div class="footer-inner">
                        <div class="footer-logo mb-6">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="Buruan Sae Logo" width="200">
                        </div>
                        <div class="footer-desc">
                            <p class="text-gray-300 leading-relaxed">
                                Buruan Sae adalah sebuah program urban farming terintegrasi yang
                                digalakan oleh Dinas Ketahanan Pangan dan Pertanian (DKPP) Kota Bandung.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="footer-item">
                    <div class="footer-inner">
                        <div class="footer-title mb-6">
                            <h5 class="text-xl font-semibold">Keep In Touch</h5>
                        </div>
                        <div class="footer-body">
                            <ul class="space-y-4">
                                <li class="flex items-start">
                                    <div class="icon mt-1 mr-4 text-[#DC3545]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="details">
                                        <p class="text-gray-300">Jl. Arjuna No.45, Bandung, Jawa Barat, Indonesia</p>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <div class="icon mt-1 mr-4 text-[#DC3545]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <div class="details">
                                        <p class="text-gray-300">022-6015102</p>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <div class="icon mt-1 mr-4 text-[#DC3545]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="details">
                                        <p class="text-gray-300">dispangtan@bandung.go.id</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom border-t border-gray-700 mt-8 pt-8 text-center">
            <p class="text-gray-400">
                Copyright &copy; {{ date('Y') }} <a href="#" class="text-[#DC3545] hover:text-red-400"><span>BURUAN SAE</span></a><br>All Rights Reserved.
            </p>
        </div>
    </div>
</div>

<!-- Scroll to Top Button -->
<a href="#" class="scrollToTop fixed bottom-8 right-8 bg-[#DC3545] text-white p-3 rounded-full shadow-lg hover:bg-red-700 transition duration-300">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
    </svg>
</a>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .prose {
        max-width: none;
    }

    .prose p {
        margin-bottom: 1.5rem;
        line-height: 1.75;
    }
</style>

<script>
    // Scroll to top functionality
    document.querySelector('.scrollToTop').addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Show/hide scroll to top button
    window.addEventListener('scroll', function() {
        const scrollBtn = document.querySelector('.scrollToTop');
        if (window.pageYOffset > 300) {
            scrollBtn.classList.remove('hidden');
        } else {
            scrollBtn.classList.add('hidden');
        }
    });
</script>
@endsection
