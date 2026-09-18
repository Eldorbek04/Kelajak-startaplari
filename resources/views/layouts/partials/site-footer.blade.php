<footer class="footer-style1 space-top">
    <button type="button" id="scrollTopBtn" aria-label="Yuqoriga">
        <img src="{{ asset('assets/images/icon/check1-3.svg') }}" alt="">
    </button>
    <div class="footer-top">
        <div class="carousel-container">
            <div class="widget-area">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="footer-widget footer-links">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="link-widget" data-aos="fade-up" data-aos-duration="900" data-aos-delay="300">
                                        <h3 class="widget-title">Tanlov</h3>
                                        <ul class="footer-link">
                                            <li><a href="{{ url('/#yo-nalishlar') }}">Yo‘nalishlar</a></li>
                                            <li><a href="{{ url('/#qadamlar') }}">Qanday qatnashish</a></li>
                                            <li><a href="{{ route('project.submit.form') }}">Ariza topshirish</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="link-widget" data-aos="fade-up" data-aos-duration="900" data-aos-delay="400">
                                        <h3 class="widget-title">Platforma</h3>
                                        <ul class="footer-link">
                                            <li><a href="{{ url('/') }}">Bosh sahifa</a></li>
                                            <li><a href="{{ url('/#savollar') }}">Tez-tez beriladigan savollar</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="link-widget" data-aos="fade-up" data-aos-duration="900" data-aos-delay="500">
                                        <h3 class="widget-title">Yordam</h3>
                                        <ul class="footer-link">
                                            <li><a href="mailto:info@example.com">Aloqa</a></li>
                                            <li><a href="{{ url('/#savollar') }}">Qo‘llanma</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="footer-widget" data-aos="fade-up" data-aos-duration="900" data-aos-delay="600">
                            <div class="form-widget">
                                <h3 class="title">Yangiliklardan xabardor bo‘ling</h3>
                                <p>Tanlov yangiliklari va muddatlari haqida xabar olish uchun email qoldiring</p>
                                <form class="footer-form" action="#" method="get" onsubmit="return false;">
                                    <input type="email" name="email" placeholder="Email manzilingiz" autocomplete="email">
                                    <button type="submit">
                                        <img src="{{ asset('assets/images/icon/check1-3.svg') }}" alt="">
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="carousel-container">
            <div class="footer-box" data-aos="fade-up" data-aos-duration="900" data-aos-delay="200">
                <div class="copyright-area">
                    <p>Kelajak Startuplari Tanlovi, {{ date('Y') }} © Barcha huquqlar himoyalangan</p>
                </div>
                <ul class="terms-list" data-aos="fade-up" data-aos-duration="900" data-aos-delay="300">
                    <li><a href="#">Foydalanish shartlari</a></li>
                    <li><a href="#">Maxfiylik siyosati</a></li>
                    <!-- <li><a href="https://t.me/rayimjonov_eldorbek">Rayimjonov Eldorbek</a></li> -->
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- 
                ===================================================
                11.09.2026 Rayimjonov Eldorbek tomonidan yaratildi
                ===================================================
-->