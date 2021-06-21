<footer class="footer-area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-6 col-sm-6">
                <div class="single-footer-widget">
                    <h6>Tentang Kami</h6>
                    <p>
                        Anrimusthi Badminton Centre Kuningan merupakan perusahaan yang bergerak di bidang olahraga badminton. Anrimusthi Badminton Centre bisa disebut pelayanan sewa tempat badminton pertama yang ada di kuningan
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="single-footer-widget">
                    <h6>Paket</h6>
                    <p>Silahkan pilih paket yang sesuai</p>
                    <div class="" id="mc_embed_signup">
                        <ul>
                        @foreach($paket_ as $row)
                            <li><a href="{{ route('paket.detail', $row->hashid) }}" style="color: gray;">{{ $row->nama }}</a></li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="single-footer-widget">
                    <h6>Follow Kami</h6>
                    <p>Kunjungi Media Sosial</p>
                    <div class="footer-social d-flex align-items-center">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
            <p class="footer-text m-0">Anrimusthi Badminton Centre Kuningan</p>
        </div>
    </div>
</footer>