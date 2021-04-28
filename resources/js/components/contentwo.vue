<template>
  <div>
    <h3 class="text-center" style="color: black;">Mengapa Kami ?</h3>
    <hr>
    <div class="row">
      <div class="col-md-3 promo">
        <div class="panel panel-forum">
          <div class="panel-heading">
              <h4 class="panel-title" style="font-weight:bold; color:black; font-size:15px">
                  Order Online
              </h4>
          </div>
          <img :src="'frontend/img/order.png'" style="width: 100%; max-height:230px; min-height:230px" alt="">
        </div>
      </div>

      <div class="col-md-3 shadow-lg">
        <div class="panel panel-forum tips">
          <div class="panel-heading">
              <h4 class="panel-title" style="font-weight:bold; color:black; font-size:15px">
                  Profesional
              </h4>
          </div>
          <img :src="'frontend/img/profesional.png'" style="width: 100%; max-height:230px; min-height:230px" alt="">
        </div>
      </div>

      <div class="col-md-3 shadow-lg">
        <div class="panel panel-forum tips">
          <div class="panel-heading">
              <h4 class="panel-title" style="font-weight:bold; color:black; font-size:15px">
                  Terpercaya
              </h4>
          </div>
          <img :src="'frontend/img/terpercaya.png'" style="width: 100%; max-height:230px; min-height:230px" alt="">
        </div>
      </div>

      <div class="col-md-3 shadow-lg">
        <div class="panel panel-forum tips">
          <div class="panel-heading">
              <h4 class="panel-title" style="font-weight:bold; color:black; font-size:15px">
                  Bergaransi
              </h4>
          </div>
          <img :src="'frontend/img/garansi.png'" style="width: 100%; max-height:230px; min-height:230px" alt="">
        </div>
      </div>
    </div>
  </div>
</template>