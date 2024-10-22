<!-- Footer Start -->
<footer class="text-center text-lg-start text-white" style="background-color: #097ABA;">
    <div class="container p-4">
  
      <!-- Grid row -->
      <div class="row">
  
        <!-- Grid column -->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">About Us</h5>
          <p>
            We are dedicated to providing the best seafood and maritime news to our customers.
          </p>
        </div>
        <!-- Grid column -->
  
        <!-- Grid column -->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Products</h5>
          <ul class="list-unstyled">
            <li><a href="#" class="text-white">Barang Sewa</a></li>
            <li><a href="#" class="text-white">Seafoods</a></li>
          </ul>
        </div>
        <!-- Grid column -->
  
        <!-- Grid column -->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Links</h5>
          <ul class="list-unstyled">
            <li><a href="#" class="text-white">Dashboard</a></li>
            <li><a href="#" class="text-white">About</a></li>
            <li><a href="#" class="text-white">Berita Tentang Kelautan</a></li>
          </ul>
        </div>
        <!-- Grid column -->
  
        <!-- Grid column -->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Contact Us</h5>
          <ul class="list-unstyled">
            <li><p><i class="fas fa-envelope me-3"></i> fishapp73@gmail.com</p></li>
            <li><p><i class="fas fa-phone me-3"></i> +62 821 3958 7640</p></li>
            <li><p><i class="fas fa-map-marker-alt me-3"></i> Jl. Raya No. 123, Banyuwangi</p></li>
          </ul>

          @if (Auth::check())
@else
<ul class="list-unstyled">
  <a href="{{ route('login_admin') }}">
    <button class="btn btn-warning">Admin?</button>
  </a>
</ul>
@endif
        </div>
        <!-- Grid column -->
  
      </div>
      <!-- Grid row -->
    </div>
  
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2024 FishApp. All Rights Reserved.
    </div>
  </footer>
  <!-- Footer End -->
  