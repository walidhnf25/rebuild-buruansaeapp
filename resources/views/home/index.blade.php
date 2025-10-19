@extends('layouts.app')

@section('page_name', 'HOME')
@section('content')
@include('layouts.header')
<div style="max-width: 2048px; margin:auto;">
  <div class="banner banner-pad-1 bg_img">
    <div class="container">
      <div class="banner-content">
          <div class="banner-title">BURUAN SAE</div>
          <div class="banner-desc">Urban Farming yang Terintegrasi</div>
          <a href="#about" class="lab-btn"><span>Discover </span></a>
      </div>
  </div>
</div>

<section id="about" class="agricul-farm-section padding-tb bg_img_1 bg_img ">
  <div class="container">
      <div class="section-wrapper">
              <div class="col-lg-12 col-12 wow fadeInUp" data-wow-delay="0.4s">
                  <div class="farm-right">
                      <div class="section-header text-center">
                          <h2 class="title-about">What is<br><span style="color: #2f589b;">BURUAN SAE</span> <span style="color: #ce254a;">?</span></h2>
                          <p>Buruan Sae is an integrated urban farming program promoted by the Food and Agriculture Security Department (DKPP) of Bandung City, which is aimed at overcoming the inequality of food problems in Bandung City. through utilizing the yard or existing land through gardening to meet the family's own food needs.</p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>

<section class="feature-section padding-tb">
  <div class="shape-feature d-none d-xl-block"></div>
  <div class="container">
    <div class="section-header wow fadeInUp" data-wow-delay="0.3s">
      <h2>Buruan Sae's Sectors</h2>
    </div>
    <div class="section-wrapper">
      <div class="row justify-content-center">

        <!-- Vegetable -->
        <div class="col-xl-6 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.4s">
          <div class="feature-item">
            <div class="feature-inner">
              <div class="feature-thumb">
                <img src="assets/images/vegetable.png" alt="Vegetable" width="120">
              </div>
              <div class="feature-content">
                <a href="/vegetable?sector=sayur"><h5>Vegetable</h5></a>
              </div>
            </div>
          </div>
        </div>

        <!-- Tanaman Obat -->
        <div class="col-xl-6 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.7s">
          <div class="feature-item">
            <div class="feature-inner">
              <div class="feature-thumb">
                <img src="assets/images/herbplant.png" alt="Tanaman Obat" width="100">
              </div>
              <div class="feature-content">
                <a href="/medicalplant?sector=tanaman_obat"><h5>Tanaman Obat</h5></a>
              </div>
            </div>
          </div>
        </div>

        <!-- Fruit -->
        <div class="col-xl-6 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.5s">
          <div class="feature-item">
            <div class="feature-inner">
              <div class="feature-thumb">
                <img src="assets/images/fruit.png" alt="Fruit" width="115">
              </div>
              <div class="feature-content">
                <a href="/fruit?sector=buah"><h5>Fruit</h5></a>
              </div>
            </div>
          </div>
        </div>

        <!-- Ternak -->
        <div class="col-xl-6 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.7s">
          <div class="feature-item">
            <div class="feature-inner">
              <div class="feature-thumb">
                <img src="assets/images/animal.png" alt="Ternak" width="125">
              </div>
              <div class="feature-content">
                <a href="/livestock?sector=ternak"><h5>Ternak</h5></a>
              </div>
            </div>
          </div>
        </div>

        <!-- Ikan -->
        <div class="col-xl-6 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.6s">
          <div class="feature-item">
            <div class="feature-inner">
              <div class="feature-thumb">
                <img src="assets/images/fish.png" alt="Ikan" width="120">
              </div>
              <div class="feature-content">
                <a href="/fish?sector=ikan"><h5>Ikan</h5></a>
              </div>
            </div>
          </div>
        </div>

        <!-- Olahan Hasil -->
        <div class="col-xl-6 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.7s">
          <div class="feature-item">
            <div class="feature-inner">
              <div class="feature-thumb">
                <img src="assets/images/result.png" alt="Olahan Hasil" width="130">
              </div>
              <div class="feature-content">
                <a href="#"><h5>Olahan Hasil</h5></a>
              </div>
            </div>
          </div>
        </div>

        <!-- Pengolahan Sampah -->
        <div class="col-xl-6 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.7s">
          <div class="feature-item">
            <div class="feature-inner">
              <div class="feature-thumb">
                <img src="assets/images/compost.png" alt="Pengolahan Sampah" width="130">
              </div>
              <div class="feature-content">
                <a href="#"><h5>Pengolahan Sampah</h5></a>
              </div>
            </div>
          </div>
        </div>

        <!-- Pembibitan -->
        <div class="col-xl-6 col-md-6 col-6 wow fadeInUp" data-wow-delay="0.7s">
          <div class="feature-item">
            <div class="feature-inner">
              <div class="feature-thumb">
                <img src="assets/images/nursery.png" alt="Pembibitan" width="120">
              </div>
              <div class="feature-content">
                <a href="#"><h5>Pembibitan</h5></a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<section class="about-us bg_img_1 bg_img padding-tb">
  <div class="shape-about d-none d-xl-block"></div>
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-12">

        <!-- Section Header -->
        <div class="section-header text-start wow fadeInUp" data-wow-delay="0.3s">
          <h2>Tagline Kami</h2>
          <p>
            Melalui program ini Pemkot Bandung berharap bahwa masyarakat dapat belajar untuk 
            memproduksi bahan pangannya sendiri, sehingga makanan yang dikonsumsi dapat lebih 
            sehat, alami, serta ekonomis.
          </p>
        </div>

        <!-- Section Content -->
        <div class="section-wrapper">

          <!-- Sehat -->
          <div class="about-item wow fadeInUp" data-wow-delay="0.4s">
            <div class="about-inner">
              <div class="about-thumb">
                <img src="assets/images/tagline/1.png" alt="Sehat">
              </div>
              <div class="about-content">
                <a href="#"><h5>SEHAT</h5></a>
                <p>
                  Bahan pangan tersebut dikelola sendiri langsung oleh masyarakat sehingga terjaga 
                  prosesnya dan tidak banyak menggunakan pestisida kimia.
                </p>
              </div>
            </div>
          </div>

          <!-- Alami -->
          <div class="about-item wow fadeInUp" data-wow-delay="0.5s">
            <div class="about-inner">
              <div class="about-thumb">
                <img src="assets/images/tagline/2.png" alt="Alami">
              </div>
              <div class="about-content">
                <a href="#"><h5>ALAMI</h5></a>
                <p>
                  Produk langsung dari alam dan diolah dengan media pupuk serta pestisida alami.
                </p>
              </div>
            </div>
          </div>

          <!-- Ekonomis -->
          <div class="about-item wow fadeInUp" data-wow-delay="0.6s">
            <div class="about-inner">
              <div class="about-thumb">
                <img src="assets/images/tagline/3.png" alt="Ekonomis">
              </div>
              <div class="about-content">
                <a href="#"><h5>EKONOMIS</h5></a>
                <p>
                  Mampu menghasilkan bahan pangan yang bisa dikonsumsi sendiri atau dijual 
                  dalam jumlah mikro.
                </p>
              </div>
            </div>
          </div>

        </div><!-- /.section-wrapper -->

      </div>
    </div>
  </div>
</section>

<div class="sponsor-section padding-tb" style="background-color: #a9bfd7;">
  <div class="container">
    <div class="section-wrapper wow fadeInUp" data-wow-delay="0.4s">
      <div class="sponsor-slider">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="sponsor-item">
              <div class="sponsor-thumb">
                <a href="#"><img src="assets/images/sponsor/dkpp.png" alt="sponsor"></a>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="sponsor-item">
              <div class="sponsor-thumb">
                <a href="#"><img src="assets/images/sponsor/bandungo.png" alt="sponsor"></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="footer-section padding-tb">
  <div class="container">
    <div class="footer-top">
      <div class="row">
        <div class="col-xl-12 col-md-6 col-12">
          <div class="footer-item">
            <div class="footer-inner">
              <div class="footer-logo">
                <img src="assets/images/logo.png" alt="Buruan Sae Logo" width="200">
              </div>
              <div class="footer-desc">
                <p>
                  Buruan Sae adalah sebuah program urban farming terintegrasi yang 
                  digalakan oleh Dinas Ketahanan Pangan dan Pertanian (DKPP) Kota Bandung.
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-12 col-md-6 col-12">
          <div class="footer-item footer-addtess">
            <div class="footer-inner">
              <div class="footer-title">
                <h5>Keep In Touch</h5>
              </div>
              <div class="footer-body">
                <ul class="agri-ul">
                  <li>
                    <div class="icon">
                      <i class="icofont-google-map"></i>
                    </div>
                    <div class="details">
                      <p>Jl. Arjuna No.45, Bandung, Jawa Barat, Indonesia</p>
                    </div>
                  </li>
                  <li>
                    <div class="icon">
                      <i class="icofont-phone"></i>
                    </div>
                    <div class="details">
                      <p>022-6015102</p>
                    </div>
                  </li>
                  <li>
                    <div class="icon">
                      <i class="icofont-envelope"></i>
                    </div>
                    <div class="details">
                      <p>dispangtan@bandung.go.id</p>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>Copyright &copy; {{ date('Y') }}<a href="#" target="_blank"><span>BURUAN SAE</span></a><br>All Rights Reserved.
    </div>
  </div>
</div>
  <a href="#" class="scrollToTop"><i class="icofont-swoosh-up"></i><span class="pluse_1"></span><span class="pluse_2"></span></a>
</div>

<div class="row mt-4 d-none">
  <div class="col-lg-12">
    <div id="kecamatan-cards" class="row"></div>
  </div>
</div>
@endsection
