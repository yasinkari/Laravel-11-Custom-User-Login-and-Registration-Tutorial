@extends('layout.layout')

@section('css')
<style>
          h1,
        h2,
        h3,
        h4,
        h5,
        h6 {}
        a,
        a:hover,
        a:focus,
        a:active {
            text-decoration: none;
            outline: none;
        }
        
        a,
        a:active,
        a:focus {
            color: #333;
            text-decoration: none;
            transition-timing-function: ease-in-out;
            -ms-transition-timing-function: ease-in-out;
            -moz-transition-timing-function: ease-in-out;
            -webkit-transition-timing-function: ease-in-out;
            -o-transition-timing-function: ease-in-out;
            transition-duration: .2s;
            -ms-transition-duration: .2s;
            -moz-transition-duration: .2s;
            -webkit-transition-duration: .2s;
            -o-transition-duration: .2s;
        }
        
        ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        img {
    max-width: 100%;
    height: auto;
}
span, a, a:hover {
    display: inline-block;
    text-decoration: none;
    color: inherit;
}

/*==========================
      history area
===========================*/

.section-title,
.column-title {
  font-size: 36px;
  font-weight: 300;
  color: #101010;
  margin-bottom: 70px;
}

.section-title span,
.column-title span {
  font-weight: 700;
}

.title-small {
  font-size: 30px;
  font-weight: 700;
}

.column-title {
  margin-bottom: 30px;
}

.column-title-large {
  font-size: 48px;
  margin-bottom: 50px;
}

.ts-title {
  font-size: 24px;
  font-weight: 600;
}

.title-light {
  font-weight: 300;
}

.title-small-regular {
  font-weight: 400;
}

.black-color {
  color: #101010 !important;
}

.title-white {
  color: #fff;
}

.title-bg-small {
    font-size: 14px;
    font-weight: 700;
    line-height: 24px;
    margin-bottom: 15px;
    color: #fff;
    background: #101010;
    display: inline-block;
    padding: 3px 18px;
    text-transform: uppercase;
}
.primary-bg {
  background: #e80000;
}
.history-area {
  background: #f7f9fb;
      padding: 100px 0;
    position: relative;
    min-height: 100vh;
}

#history-slid .history-content {
  background: #fff;
  padding: 35px;
  padding-left: 14px;
}

#history-slid .carousel-inner {
  margin-bottom: 45px;
}

#history-slid .carousel-item {
  background: #fff;
}


#history-slid .carousel-indicators {
  position: relative;
  left: 0;
  z-index: 5;
  width: 100%;
  padding-left: 0;
  margin-left: 0;
  text-align: center;
  list-style: none;
  display: flex;
  justify-content: center;
  align-items: center;
}

#history-slid .carousel-indicators:before {
  content: "";
  width: 80%;
  height: 2px;
  position: absolute;
  left: 10%;
  top: 15px;
  background-color: #ddd;
  z-index: -1;
}

#history-slid .carousel-indicators li {
  display: inline-block;
  width: 70px;
  height: 35px;
  line-height: 35px;
  margin: 0 20px;
  text-indent: 0px;
  cursor: pointer;
  color: #101010;
  border: 0px solid #fff;
  border-radius: 0px;
  margin-top: 40px;
  font-weight: 700;
  font-family: 'Open Sans', sans-serif;
  font-size: 16px;
  text-align: center;
  position: relative;
}

#history-slid .carousel-indicators li:before {
  position: absolute;
  top: -30px;
  left: 50%;
  display: inline-block;
  width: 12px;
  height: 12px;
  content: "";
  border-radius: 50%;
  background: #101010;
  margin-left: -6px;
}

#history-slid .carousel-indicators li.active {
  line-height: 35px;
  -webkit-box-shadow: 0px 20px 30px 0px rgba(0, 0, 0, 0.15);
  box-shadow: 0px 20px 30px 0px rgba(0, 0, 0, 0.15);
  color: #e80000;
  background: #fff;
}

#history-slid .carousel-indicators li.active::before {
  background: #e80000;
}

#history-slid .carousel-indicators li.active:after {
  position: absolute;
  top: -34px;
  left: 50%;
  display: inline-block;
  width: 20px;
  height: 20px;
  content: "";
  border-radius: 50%;
  margin-left: -10px;
  border: 1px solid #e80000;
}

#history-slid .carousel-item-next,
#history-slid .carousel-item-prev,
#history-slid .carousel-item.active {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
}

</style>
@endsection

@section('content')
<section class="history-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <p class="title-bg-small wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="300ms">About us</p>
          <h3 class="section-title wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="400ms">Our
            <span>History</span></h3>
        </div>
        <!-- end col -->
      </div>
      <!-- end row -->
      <div class="row">
        <div class="col-lg-12">
          <div id="history-slid" class="carousel slide" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
              <div class="carousel-item row">
                <div class="col-lg-6 col-md-12 pl-0">
                  <div class="history-img">
                    <img class="img-fluid" src="https://i.ibb.co/CKNmhMX/blog1.jpg" alt="Humble Beginnings" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-12 pr-0">
                  <div class="history-content">
                    <p class="title-bg-small primary-bg wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="500ms">2018</p>
                    <h2 class="column-title wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="700ms">Humble <span>Beginnings</span></h2>
                    <p>The story of Nillconcept began in 2018 as a small home-based business selling tudung (headscarves). With a focus on clean designs, quality materials, and personal customer service, the brand slowly built trust within its community.</p>
                    <p>Every piece was packed by hand, marketed through social media, and delivered with care. These early steps taught the brand the value of consistency, simplicity, and connection.</p>
                  </div>
                </div>
              </div>
              
              <div class="carousel-item row">
                <div class="col-lg-6 col-md-12 pl-0">
                  <div class="history-img">
                    <img class="img-fluid" src="https://i.ibb.co/m5yGbdR/blog2.jpg" alt="Testing the Waters" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-12 pr-0">
                  <div class="history-content">
                    <p class="title-bg-small primary-bg wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="500ms">2019</p>
                    <h2 class="column-title wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="700ms">Testing the <span>Waters</span></h2>
                    <p>In 2019, the business started to experiment beyond tudung. The founder began exploring the idea of creating menswear, particularly Baju Melayu, that was clean, well-fitted, and different from the usual market offerings.</p>
                    <p>Samples were made, feedback was collected, and a small group of early supporters helped shape the direction. It was a quiet year of trial and error—laying the foundation for what would soon become Nillconcept.</p>
                  </div>
                </div>
              </div>
              
              <div class="carousel-item row">
                <div class="col-lg-6 col-md-12 pl-0">
                  <div class="history-img">
                    <img class="img-fluid" src="https://i.ibb.co/YXV3zmh/blog3.jpg" alt="The Birth of Nillconcept" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-12 pr-0">
                  <div class="history-content">
                    <p class="title-bg-small primary-bg wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="500ms">2020</p>
                    <h2 class="column-title wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="700ms">The Birth of <span>Nillconcept</span></h2>
                    <p>2020 marked the official birth of Nillconcept, a brand with a clear vision: to elevate traditional menswear with modern, minimalist design. The first full collection of Baju Melayu was prepared—but just as plans were forming, the COVID-19 pandemic brought everything to a sudden halt.</p>
                    <p>Launches were postponed, events were canceled, and uncertainty filled the air. Still, behind the scenes, the brand continued refining its identity and preparing for a stronger comeback.</p>
                  </div>
                </div>
              </div>
              
              <div class="carousel-item row active">
                <div class="col-lg-6 col-md-12 pl-0">
                  <div class="history-img">
                    <img class="img-fluid" src="https://i.ibb.co/CKNmhMX/blog1.jpg" alt="A Quiet Comeback" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-12 pr-0">
                  <div class="history-content">
                    <p class="title-bg-small primary-bg wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="500ms">2021</p>
                    <h2 class="column-title wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="700ms">A Quiet <span>Comeback</span></h2>
                    <p>After a year of pause, 2021 became the year of return. Nillconcept reintroduced its pieces with improved cuts, better materials, and a sharper visual direction. The Raya season marked a turning point, as customers began to notice the brand's distinct identity—elegant, modern, and rooted in tradition.</p>
                    <p>This quiet comeback proved that patience and purpose always pay off.</p>
                  </div>
                </div>
              </div>
              
              <div class="carousel-item row">
                <div class="col-lg-6 col-md-12 pl-0">
                  <div class="history-img">
                    <img class="img-fluid" src="https://i.ibb.co/m5yGbdR/blog2.jpg" alt="Embracing Community" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-12 pr-0">
                  <div class="history-content">
                    <p class="title-bg-small primary-bg wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="500ms">2022</p>
                    <h2 class="column-title wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="700ms">Embracing <span>Community</span></h2>
                    <p>In 2022, Nillconcept stepped out from behind the screen and into real spaces. The brand took part in festive pop-ups, collaborated with local creators, and built relationships with returning customers. Each sale wasn't just a transaction—it was a connection.</p>
                    <p>The feedback and interaction helped the brand evolve, while the values of slow fashion and mindful design remained at the core.</p>
                  </div>
                </div>
              </div>
              
              <div class="carousel-item row">
                <div class="col-lg-6 col-md-12 pl-0">
                  <div class="history-img">
                    <img class="img-fluid" src="https://i.ibb.co/YXV3zmh/blog3.jpg" alt="Creative Growth" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-12 pr-0">
                  <div class="history-content">
                    <p class="title-bg-small primary-bg wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="500ms">2023</p>
                    <h2 class="column-title wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="700ms">Creative <span>Growth</span></h2>
                    <p>2023 became a year of creativity. The team explored new silhouettes, richer textures, and limited capsule collections. Nillconcept started to shape its own visual language—blending culture, architecture, and fashion. Social media content evolved into storytelling, and each campaign carried deeper meaning.</p>
                    <p>The brand was no longer just selling clothing—it was building an identity.</p>
                  </div>
                </div>
              </div>
              
              <div class="carousel-item row">
                <div class="col-lg-6 col-md-12 pl-0">
                  <div class="history-img">
                    <img class="img-fluid" src="https://i.ibb.co/CKNmhMX/blog1.jpg" alt="Strength in Simplicity" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-12 pr-0">
                  <div class="history-content">
                    <p class="title-bg-small primary-bg wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="500ms">2024</p>
                    <h2 class="column-title wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="700ms">Strength in <span>Simplicity</span></h2>
                    <p>In 2024, Nillconcept focused on improving every detail, from production to packaging. Systems were refined, sizing was made more inclusive, and the team worked closely with tailors and suppliers to ensure long-term quality.</p>
                    <p>The pieces became wardrobe staples—timeless, comfortable, and beautiful in their simplicity. The brand solidified its position as a trusted name for modern traditionalwear.</p>
                  </div>
                </div>
              </div>
              
              <div class="carousel-item row">
                <div class="col-lg-6 col-md-12 pl-0">
                  <div class="history-img">
                    <img class="img-fluid" src="https://i.ibb.co/m5yGbdR/blog2.jpg" alt="Looking Forward" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-12 pr-0">
                  <div class="history-content">
                    <p class="title-bg-small primary-bg wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="500ms">2025</p>
                    <h2 class="column-title wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="700ms">Looking <span>Forward</span></h2>
                    <p>Now in 2025, Nillconcept continues to grow while staying true to its roots. With plans to expand custom sizing, explore collaborations, and introduce new design categories, the brand is entering a new chapter.</p>
                    <p>What started as a small tudung business in 2018 is now a respected name in modern Malay menswear. Through every year, one thing has remained the same—Nillconcept designs not just for occasions, but for people, stories, and lasting meaning.</p>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Indicators -->
            <ol class="carousel-indicators text-center">
              <li data-target="#history-slid" data-slide-to="0">2018</li>
              <li data-target="#history-slid" data-slide-to="1">2019</li>
              <li data-target="#history-slid" data-slide-to="2">2020</li>
              <li data-target="#history-slid" data-slide-to="3" class="active">2021</li>
              <li data-target="#history-slid" data-slide-to="4">2022</li>
              <li data-target="#history-slid" data-slide-to="5">2023</li>
              <li data-target="#history-slid" data-slide-to="6">2024</li>
              <li data-target="#history-slid" data-slide-to="7">2025</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Initialize Bootstrap carousel
  $('#history-slid').carousel({
    interval: false,
    pause: true
  });
  
  // Handle indicator clicks
  $('.carousel-indicators li').click(function() {
    var slideIndex = $(this).data('slide-to');
    $('#history-slid').carousel(slideIndex);
    
    // Update active class
    $('.carousel-indicators li').removeClass('active');
    $(this).addClass('active');
  });
  
  // Update indicators when carousel slides
  $('#history-slid').on('slid.bs.carousel', function() {
    var index = $('.carousel-item.active').index();
    $('.carousel-indicators li').removeClass('active');
    $('.carousel-indicators li[data-slide-to="' + index + '"]').addClass('active');
  });
});
</script>
@endpush
