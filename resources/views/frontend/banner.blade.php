{{-- Banner --}}
    <div class="bg-cover">
    <img src="{{asset('frontend/img/banner.jpg')}}" alt="" />
    </div>
    <!-- end bg-cover -->
    <!-- begin container -->
    <div class="container">
        <h3>Lacak Status Laundry Kamu Disini...</h3>
        <div class="input-group m-b-20">
            <form action="{{url('pencarian-laundry')}}" method="GET">
                <input type="text" class="form-control input-lg" name="cari" id="search_status" placeholder="Contoh : TR0392928" required />
            </form>
            <span class="input-group-btn">
                <button type="submit" class="btn btn-lg" id="search-btn"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </div>
{{-- End Header --}}
